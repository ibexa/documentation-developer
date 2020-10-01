# Local order process

If the shop is not connected to an ERP system, the customer can still follow the order process
and create a local order that generates an invoice PDF and sends it by mail.

The order is stored locally in the shop.

## Generating local orders

By default the shop sends the order after the checkout process to ERP.
But there is also the possibility to disable the usage of ERP and use the local order process instead.

To do this, disable sending the order to ERP in `LocalOrderManagementBundle/Resources/config/local_order_management.yml`:

``` yaml
#set this to true in core and override this in the parameters.yml to false
siso_local_order_management.default.send_order_to_erp: true
siso_local_order_management.default.shop_owner_customer_number: 10000
```

This option uses event listeners.

## `onRequestEvent` and `onExceptionMessage`

To avoid sending the order to ERP, an exception is thrown that interrupts the default process (sending to ERP).

The order is not sent if:

- The message request is the "Order message".
- Order sending is disabled in the configuration.
- The order does not contain a specific customer number, in this case the customer number of the shop owner (this is connected with order splitting function).

If these conditions are fulfilled, the `LocalOrderRequiredException` exception is thrown and the order is not sent to ERP.

Due to an exception during the ERP communication, the message and the order occur in the respective logs as failed.

In `LocalOrderManagementBundle/Resources/config/services.xml`:

``` xml
<!-- Listener to listen on the request event and throw an exception in order to interuppt the process -->
<service id="siso_local_order_management.send_order_listener" class="%siso_local_order_management.send_order_listener.class%">
    <argument type="service" id="ezpublish.config.resolver"/>
    <tag name="kernel.event_listener"  event="silver_eshop.request_message" method="onRequestEvent" />
</service>
```

In order to return a valid response to the previous (checkout) process,
the `onExceptionMessage` event listener reacts to the `LocalOrderRequiredException`.

When the `LocalOrderRequiredException` is thrown, the listener `onExceptionMessage` gets the exception and creates the valid Response Document filled with local data (orders).
In other words, the shop reacts like an ERP system, confirms the order and returns an order ID.

The response has the same structure as a response returned from ERP, so no additional changes in the template are required.

At the same time it also generates and stores invoice data, and generates a PDF with the invoice information.
Then this information is sent by email.

``` xml
<service id="siso_local_order_management.confirmation_listener" class="%siso_local_order_management.confirmation_listener.class%" lazy="true">
    <argument type="service" id="silver_basket.basket_repository" />
    <argument type="service" id="siso_tools.mailer_helper" />
    <argument type="service" id="ezpublish.config.resolver"/>
    <argument type="service" id="siso_local_order_management.invoice_service" />
    <argument type="service" id="doctrine.orm.entity_manager" />
        <call method="setMailSettings">
            <argument>$ses_swiftmailer;siso_core$</argument>
        </call>
    <tag name="kernel.event_listener"  event="silver_eshop.exception_message" method="onExceptionMessage" />
</service>
```

## Generating invoice data (new entity)

To store the invoice in the database Doctrine is used. There is a new entity with the invoice information.

### Step 1. New invoice entity

??? note "`LocalOrderManagementBundle/Entity/Invoice.php`"

    ``` php
    <?php

    namespace Siso\Bundle\LocalOrderManagementBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;

    /**
     * Invoice
     *
     * @ORM\Table(name="ses_invoice")
     * @ORM\Entity(repositoryClass="Siso\Bundle\LocalOrderManagementBundle\Entity\InvoiceRepository")
     */
    class Invoice
    {
        /**
         * @var integer
         *
         * @ORM\Column(name="id", type="integer")
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="AUTO")
         *
         */
        private $invoiceId;

        /**
         * @var integer
         *
         * @ORM\Column(name="invoice_number", type="integer")
         */
        private $invoiceNumber;

        /**
         * @var string
         *
         * @ORM\Column(name="invoice_prefix", type="string", length=255, nullable=true)
         */
        private $invoicePrefix;

        /**
         * @var integer
         *
         * @ORM\Column(name="basket_id", type="integer")
         */
        private $basketId;

        /**
         * @var string
         *
         * @ORM\Column(name="shop_id", type="string", length=255, nullable=true)
         */
        private $shopId;
        /**
         * Get invoiceId
         *
         * @return integer
         */
        public function getInvoiceId()
        {
            return $this->invoiceId;
        }

        /**
         * Set invoiceNumber
         *
         * @param integer $invoiceNumber
         *
         * @return Invoice
         */
        public function setInvoiceNumber($invoiceNumber)
        {
            $this->invoiceNumber = $invoiceNumber;

            return $this;
        }

        /**
         * Get invoiceNumber
         *
         * @return integer
         */
        public function getInvoiceNumber()
        {
            return $this->invoiceNumber;
        }

        /**
         * Set invoicePrefix
         *
         * @param string $invoicePrefix
         *
         * @return Invoice
         */
        public function setInvoicePrefix($invoicePrefix)
        {
            $this->invoicePrefix = $invoicePrefix;

            return $this;
        }

        /**
         * Get invoicePrefix
         *
         * @return string
         */
        public function getInvoicePrefix()
        {
            return $this->invoicePrefix;
        }

        /**
         * Set basketId
         *
         * @param integer $basketId
         *
         * @return Invoice
         */
        public function setBasketId($basketId)
        {
            $this->basketId = $basketId;

            return $this;
        }

        /**
         * Get basketId
         *
         * @return integer
         */
        public function getBasketId()
        {
            return $this->basketId;
        }

        /**
         * Set shopId
         *
         * @param string $shopId
         *
         * @return Invoice
         */
        public function setShopId($shopId)
        {
            $this->shopId = $shopId;

            return $this;
        }

        /**
         * Get shopId
         *
         * @return string
         */
        public function getShopId()
        {
            return $this->shopId;
        }
    }
    ```

### Step 2. New repository to work with the invoice

``` xml
<!-- repository service, it is an implementation of the invoice_repository -->
<service id="siso_local_order_management.invoice_repository" class="%siso_local_order_management.invoice_repository.class%">
    <factory service="doctrine.orm.entity_manager" method="getRepository"/>
    <argument type="string">SisoLocalOrderManagementBundle:Invoice</argument>
</service>
```

Generating the invoice entity uses the following data:

- Invoice number: if there is already any entry in the database it takes the last invoice number and increases it by one. Otherwise, if the database is empty, it gets the invoice number from the configuration.
- Invoice prefix: from the configuration, per SiteAccess
- Basket ID
- Shop ID: from the configuration (important in multishop context)  

In `LocalOrderManagementBundle/Resources/config/local_order_management.yml`:

``` yaml
# Generate the invoice number for the local orders in multishops with no ERP
siso_local_order_management.default.invoice_number:
    start: 10000
    prefix: 'RE'
```

In `EshopBundle/Resources/config/silver.eshop.yml`:

``` yaml
#ShopID that is stored in the database
siso_core.default.shop_id: 'MAIN'
```

## Generating invoice PDF and sending it by email

At the end of the process the invoice with all the required information is created and stored in the database.
The invoice is in PDF format, and is sent also as attachment by email.

To generate the PDF a tool called [`wkhtmltopdf`](http://wkhtmltopdf.org) is used,
this tool has to be installed on the server, usinge the last stable version.

The `wkhtmltopdf` tool needs only a URL with a valid HTML and the path where the PDF is going to be generated.

``` 
Use: wkhtmltopdf [URL] [Path.pdf]
e.g: wkhtmltopdf http://harmony-dev.silver-eshop test.pdf
```

### Path of `wkhtmltopdf` configuration

You can configure the path where `wkhtmltopdf` is located in `LocalOrderManagementBundle/Resources/config/local_order_management.yml`:

``` 
siso_local_order_management.default.wkhtmltopdf_server_path: '/usr/bin/wkhtmltopdf'
```

### Enabling/disabling footer and header generation

Usually the invoice PDF contains one header at the beginning and one footer at the end of the document.

You can also set the header and footer to be placed on each PDF page:

``` yaml
siso_local_order_management.default.generate_footer_for_pdf: true
siso_local_order_management.default.generate_header_for_pdf: true
```

In this case the header and/or footer is generated using these separate templates:

- `src/Silversolutions/Bundle/EshopBundle/Resources/views/Invoice/header.html.twig`
- `src/Silversolutions/Bundle/EshopBundle/Resources/views/Invoice/footer.html.twig`

These templates can be used directly or as a base for overriding. 

### PDF creation

The PDF content (and the header and/or footer) is stored as HTML and directly removed after usage.

??? note "`Siso/Bundle/LocalOrderManagementBundle/Service/InvoiceService.php`"

    ``` php
    public function generateInvoicePdf($invoiceNumber)
    {
    ...
    //Create the path to store the generated pdf
    $invoiceTmpPath = $this->configResolver->getParameter(
        'invoice_pdf_tmp_path',
        'siso_local_order_management'
    );
    $invoiceParameters = $this->configResolver->getParameter(
        'invoice_number',
        'siso_local_order_management'
    );
    //In some environments is required to the full path of the tool install in the server
    $wkhtmltopdfPath = $this->configResolver->getParameter(
        'wkhtmltopdf_server_path',
        'siso_local_order_management'
    );

    $invoicePrefix = isset($invoiceParameters['prefix']) ? $invoiceParameters['prefix'] : '';
    $pdfName = $this->transService->translate('common.invoice_') . $invoicePrefix . $invoiceNumber . '.pdf';
    $pdfPath =  $invoiceTmpPath . $pdfName;
    $footerCommandPart = '';
    $headerCommandPart = '';

    if ($generateFooter && !empty($footerPathHtmlFile)) {
        $footerCommandPart = ' --footer-html '.$footerPathHtmlFile;
    }
    if ($generateHeader && !empty($headerPathHtmlFile)) {
        $headerCommandPart = ' --header-html '.$headerPathHtmlFile;
    }

    $command = $wkhtmltopdfPath.$footerCommandPart.$headerCommandPart.' '.$invoicePathHtmlFile.' '.$pdfPath;

    //Used Process component to execute the command line
    /** @var Process $process */
    $process = new Process(sprintf($command));
    $process->run();
    ...
    }
    ```

The first part of name of the PDF is translatable (`common.invoice_`) and the second part consist of a prefix and the invoice number.

Once the PDF is generated and the order is stored in the database it is attached to the email that is sent after the order confirmation.

### Send emails with attachments

The PDF is attached to the email generated in the order process.

Additionally, the system sends copy of the email to the owner of the shop. The shop owner is defined as a parameter in the configuration (defined per SiteAccess).

``` yaml
siso_core.default.ses_swiftmailer:
    mailSender: noreply@silversolutions.de
    mailReceiver: noreply@silversolutions.de
    ...
    shopOwnerMailReceiver: noreply@silversolutions.de
```

### Emails

All these emails are based on the standard order confirmation email templates:
`SilversolutionsEshopBundle:Checkout/Email:order_confirmation.txt.twig` and `SilversolutionsEshopBundle:Checkout/Email:order_confirmation.html.twig`

#### Buyer

`vendor/silversolutions/silver.e-shop/src/Siso/Bundle/LocalOrderManagementBundle/EventListener/OrderConfirmationListener.php`:

```
$recipientBuyer = $basket->getConfirmationEmail();
...
if (!empty($recipientBuyer)) {
 $this->sendMailToRecipient($recipientBuyer, $basket, $invoice, $invoicePdfPath);
}
```

#### Sales contact person

The Sales contact person receives a copy of the buyer email with only a few differences
if the variable `is_sales_contact` is set to true.

This email is sent only with the following configuration:

``` yaml
#possible mode: config or customer
siso_checkout.default.order_confirmation.sales_email_mode: customer
siso_checkout.default.order_confirmation.sales_email_address:
```

In: `Siso/Bundle/LocalOrderManagementBundle/EventListener/OrderConfirmationListener.php`:

``` php
$recipientSalesContact = $basket->getSalesConfirmationEmail();
...
if (!empty($recipientSalesContact)) {
    $isShopOwner = false;
    $isSalesContact = true;
    $this->sendMailToRecipient($recipientSalesContact, $basket, $invoice, $invoicePdfPath, $isShopOwner, $isSalesContact);
}
```

#### Owner of the shop

Owner of the shop also receives a copy of the email that is sent to the buyer.
A special message and subject are set for it.

- `shop_owner_mail_subject` (Set in the email configuration)
- `email_shop_owner_intro_text` (TextModule inside the backend)

This applies when the variable `is_shop_owner` is set to true.

`Siso/Bundle/LocalOrderManagementBundle/EventListener/OrderConfirmationListener.php`:

``` php
$emailAddresses = $this->configResolver
 ->getParameter('ses_swiftmailer', 'siso_core');
 
$shopOwnerMailReceiver = isset($emailAddresses['shopOwnerMailReceiver'])
 ? $emailAddresses['shopOwnerMailReceiver'] : null;
...
if (!empty($shopOwnerMailReceiver)) {
 $isShopOwner = true;
 $this->sendMailToRecipient($shopOwnerMailReceiver, $basket, $invoice, $invoicePdfPath, $isShopOwner);
}
```

!!! note

    See [Local orders](../../../order_history/order_history_features/orderhistory_local_orders.md)
