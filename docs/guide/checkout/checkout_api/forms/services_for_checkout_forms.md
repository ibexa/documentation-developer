# Services for checkout forms [[% include 'snippets/commerce_badge.md' %]]

## CheckoutFormServiceInterface

`CheckoutFormServiceInterface` (`Silversolutions\Bundle\EshopBundle\Service\CheckoutFormServiceInterface`)
is an interface for checkout forms that defines a common way to prefill the form and store the data in basket.

|Method|Parameters|Usage|
|--- |--- |--- |
|`storeFormDataInBasket`|`FormEntityInterface $form`</br>`Basket $basket`|Used to persist the form data in basket|
|`prefillForm`|`FormEntityInterface $form`</br>`Basket $basket`|Used to prefill the form with data|

## CheckoutSummaryFormServiceInterface

`CheckoutSummaryFormServiceInterface` (`Silversolutions\Bundle\EshopBundle\Service\CheckoutSummaryFormServiceInterface`)
is an interface for checkout summary forms that handles getting the user confirmation email.

|Method|Parameters|Usage|
|--- |--- |--- |
|`getCustomerEmailForOrderConfirmation`|`Basket $basket`|Gets the user confirmation email|
|`getSalesEmailForOrderConfirmation`|`Basket $basket`|Gets the confirmation email address for the sales contact|


## CheckoutAddressFormServiceInterface

`CheckoutAddressFormServiceInterface` (`Silversolutions\Bundle\EshopBundle\Service\CheckoutAddressFormServiceInterface`)
is an interface for checkout forms that handles addresses and defines a way to convert form data into a party and back.

|Method|Parameters|Usage|
|--- |--- |--- |
|`convertFormDataToParty`|`CheckoutAddressInterface $form`|Converts the form data into a party|
|`convertPartyToFormData`|`Party $party`</br>`CheckoutAddressInterface $form = null`|Converts party data into the form|

## DeliveryAddressCheckoutFormService

`DeliveryAddressCheckoutFormService` (`Siso\Bundle\CheckoutBundle\Service\DeliveryAddressCheckoutFormService`)
implements the logic for the `CheckoutDeliveryAddress` form.
You assign this service to the `CheckoutDeliveryAddress` form in the [configuration](configuration_for_checkout_forms.md).

This service implements both [`CheckoutFormServiceInterface`](#checkoutformserviceinterface) and [`CheckoutAddressFormServiceInterface`](#checkoutaddressformserviceinterface).

The service ID is `siso_checkout.checkout_form.delivery_address`.

## InvoiceAddressCheckoutFormService

`InvoiceAddressCheckoutFormService` (`Siso\Bundle\CheckoutBundle\Service\InvoiceAddressCheckoutFormService`)
implements the logic for the `CheckoutInvoiceAddress` form.
You assign this service to the `CheckoutInvoiceAddress` form in the [configuration](configuration_for_checkout_forms.md).

This service implements both [`CheckoutFormServiceInterface`](#checkoutformserviceinterface) and [`CheckoutAddressFormServiceInterface`](#checkoutaddressformserviceinterface)

The service ID is `siso_checkout.checkout_form.invoice_address`.

## ShippingPaymentCheckoutFormService

`ShippingPaymentCheckoutFormService` (`Siso\Bundle\CheckoutBundle\Service\ShippingPaymentCheckoutFormService`) implements the logic for the `CheckoutShippingPayment` form.
You assign this service to the `CheckoutShippingPayment` form in the [configuration](configuration_for_checkout_forms.md).

This service implements [`CheckoutFormServiceInterface`](#checkoutformserviceinterface).

The service ID is `siso_checkout.checkout_form.shipping_payment`.

## SummaryCheckoutFormService

`SummaryCheckoutFormService` (`Siso\Bundle\CheckoutBundle\Service\SummaryCheckoutFormService`) implements the logic for the `CheckoutSummary` form.
You assign this service to the `CheckoutSummary` form in the [configuration](configuration_for_checkout_forms.md).

This service implements [`CheckoutFormServiceInterface`](#checkoutformserviceinterface) and  [`CheckoutSummaryFormServiceInterface`](#checkoutsummaryformserviceinterface).

The service ID is `siso_checkout.checkout_form.summary`.

### Comment limit

In the summary, there is a comment field that the user can fill in.

By default, the comment box does not have a limit, but you can set a limit in configuration:

``` yaml
parameters:
    siso_checkout.default.checkout_form_summary_max_length: 30
```

The mapping of the request order should be modified to unlimit the number of characters
in `EshopBundle/Resources/mapping/wc3-nav/xsl/include/request.order.xsl`.
