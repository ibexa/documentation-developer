---
edition: commerce
---

# Local orders

If the shop is not connected to an ERP system, the customer can still follow the order process
and create a local order that generates an invoice PDF and sends it by mail.

The order is stored locally in the shop.

## Configuring local orders

By default, the shop sends the order after the checkout process to ERP.
But you can also disable using ERP and use the local order process instead.

To do this, disable sending the order to ERP:

``` yaml
parameters:
    siso_local_order_management.default.send_order_to_erp: false
```

To avoid sending the order to ERP, the `LocalOrderRequiredException` exception is thrown that interrupts the default process (sending to ERP).
The message and the order are logged as failed.

The shop then reacts like an ERP system, confirms the order and returns an order ID.

The response has the same structure as the response returned from ERP, so no additional changes in the template are required.

Additionally, the system sends a copy of the confirmation email to the owner of the shop.
You define shop owner details as a parameter in the configuration.

``` yaml
siso_core.default.ses_swiftmailer:
    mailSender: noreply@silversolutions.de
    mailReceiver: noreply@silversolutions.de
    # ...
    shopOwnerMailReceiver: noreply@silversolutions.de
```

## Email templates

Local order [confirmation emails](order_confirmation.md) are based on the standard order confirmation email templates:
`checkout/Email/order_confirmation.txt.twig` and `checkout/Email/order_confirmation.html.twig`

## PDF invoice

At the end of the local checkout process, the shop generates and stores invoice data, and generates a PDF with the invoice information.
Then this information is sent by email.

The PDF is created using [`wkhtmltopdf`](http://wkhtmltopdf.org).
You must install the latest stable version of`wkhtmltopdf` on the server.

You can configure the path where `wkhtmltopdf` is located in `LocalOrderManagementBundle/Resources/config/local_order_management.yml`:

``` yaml
siso_local_order_management.default.wkhtmltopdf_server_path: '/usr/bin/wkhtmltopdf'
```

The PDF content (and the header and/or footer) is stored as HTML and removed directly after usage.

The first part of the PDF filename is translatable (`common.invoice_`) and the second part consists of a prefix and the invoice number.

### Invoice header and footer

By default, the invoice PDF contains one header at the beginning and one footer at the end of the document.

You can also configure the header and footer to be placed on each PDF page:

``` yaml
siso_local_order_management.default.generate_footer_for_pdf: true
siso_local_order_management.default.generate_header_for_pdf: true
```

In this case, the header and/or footer are generated using these separate templates:

- `src/Silversolutions/Bundle/EshopBundle/Resources/views/Invoice/header.html.twig`
- `src/Silversolutions/Bundle/EshopBundle/Resources/views/Invoice/footer.html.twig`
