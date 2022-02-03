# Services for checkout forms

## CheckoutFormServiceInterface

`CheckoutFormServiceInterface` (`Ibexa\Contracts\Commerce\Checkout\CheckoutFormServiceInterface`)
is an interface for checkout forms that defines a common way to prefill the form and store the data in basket.

|Method|Parameters|Usage|
|--- |--- |--- |
|`storeFormDataInBasket`|`FormEntityInterface $form`</br>`Basket $basket`|Used to persist the form data in basket|
|`prefillForm`|`FormEntityInterface $form`</br>`Basket $basket`|Used to prefill the form with data|

## CheckoutSummaryFormServiceInterface

`CheckoutSummaryFormServiceInterface` (`Ibexa\Contracts\Commerce\Checkout\CheckoutSummaryFormServiceInterface`)
is an interface for checkout summary forms that handles getting the user confirmation email.

|Method|Parameters|Usage|
|--- |--- |--- |
|`getCustomerEmailForOrderConfirmation`|`Basket $basket`|Gets the user confirmation email|
|`getSalesEmailForOrderConfirmation`|`Basket $basket`|Gets the confirmation email address for the sales contact|


## CheckoutAddressFormServiceInterface

`CheckoutAddressFormServiceInterface` (`Ibexa\Contracts\Commerce\Checkout\CheckoutAddressFormServiceInterface`)
is an interface for checkout forms that handles addresses and defines a way to convert form data into a party and back.

|Method|Parameters|Usage|
|--- |--- |--- |
|`convertFormDataToParty`|`CheckoutAddressInterface $form`|Converts the form data into a party|
|`convertPartyToFormData`|`Party $party`</br>`CheckoutAddressInterface $form = null`|Converts party data into the form|

## DeliveryAddressCheckoutFormService

`DeliveryAddressCheckoutFormService` (`Ibexa\Commerce\Checkout\Service\DeliveryAddressCheckoutFormService`)
implements the logic for the `CheckoutDeliveryAddress` form.
You assign this service to the `CheckoutDeliveryAddress` form in the [configuration](configuration_for_checkout_forms.md).

This service implements both [`CheckoutFormServiceInterface`](#checkoutformserviceinterface) and [`CheckoutAddressFormServiceInterface`](#checkoutaddressformserviceinterface).

The service ID is `Ibexa\Commerce\Checkout\Service\DeliveryAddressCheckoutFormService`.

## InvoiceAddressCheckoutFormService

`InvoiceAddressCheckoutFormService` (`Ibexa\Commerce\Checkout\Service\InvoiceAddressCheckoutFormService`)
implements the logic for the `CheckoutInvoiceAddress` form.
You assign this service to the `CheckoutInvoiceAddress` form in the [configuration](configuration_for_checkout_forms.md).

This service implements both [`CheckoutFormServiceInterface`](#checkoutformserviceinterface) and [`CheckoutAddressFormServiceInterface`](#checkoutaddressformserviceinterface)

The service ID is `Ibexa\Commerce\Checkout\Service\InvoiceAddressCheckoutFormService`.

## ShippingPaymentCheckoutFormService

`ShippingPaymentCheckoutFormService` (`Ibexa\Commerce\Checkout\Service\ShippingPaymentCheckoutFormService`) implements the logic for the `CheckoutShippingPayment` form.
You assign this service to the `CheckoutShippingPayment` form in the [configuration](configuration_for_checkout_forms.md).

This service implements [`CheckoutFormServiceInterface`](#checkoutformserviceinterface).

The service ID is `Ibexa\Commerce\Checkout\Service\ShippingPaymentCheckoutFormService`.

## SummaryCheckoutFormService

`SummaryCheckoutFormService` (`Ibexa\Commerce\Checkout\Service\SummaryCheckoutFormService`) implements the logic for the `CheckoutSummary` form.
You assign this service to the `CheckoutSummary` form in the [configuration](configuration_for_checkout_forms.md).

This service implements [`CheckoutFormServiceInterface`](#checkoutformserviceinterface) and  [`CheckoutSummaryFormServiceInterface`](#checkoutsummaryformserviceinterface).

The service ID is `Ibexa\Commerce\Checkout\Service\SummaryCheckoutFormService`.

### Comment limit

In the summary, there is a comment field that the user can fill in.

By default, the comment box does not have a limit, but you can set a limit in configuration:

``` yaml
parameters:
    ibexa.commerce.site_access.config.checkout.default.checkout_form_summary_max_length: 30
```

The mapping of the request order should be modified to unlimit the number of characters
in `Eshop/Resources/mapping/wc3-nav/xsl/include/request.order.xsl`.
