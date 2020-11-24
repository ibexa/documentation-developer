# Shipping payment form [[% include 'snippets/commerce_badge.md' %]]

## Model Class

`CheckoutShippingPayment` (`Ibexa\Platform\Commerce\Checkout\Form\CheckoutShippingPayment`)
extends `AbstractFormEntity` and implements `CheckoutAddressInterface`.

## Fields

|Name|Description|Assertions|
|--- |--- |--- |
|`shippingMethod`|Method for shipping|String</br>Not blank|
|`paymentMethod`|Method for payment|String</br>Not blank|
|`forceStep`|`true` if the user wants to force moving to the next step with event errors|Boolean|

## Configuration

You set the parameters in the [configuration for checkout forms](configuration_for_checkout_forms.md).

## Form Type

`Ibexa\Platform\Commerce\Checkout\Form\Type\CheckoutShippingPaymentType`
(service ID: `siso_checkout.form_entity.checkout_shipping_payment_type`)
implements the setup for this form.

This class is defined as a service to take advantage from `TransService`.

!!! note

    The scope of this service is set to `prototype`.
    A new instance of `CheckoutShippingPaymentType` is created every time this service is called.

## Templates

|               |           |
| ------------- | --------- |
| Main template | `EshopBundle/Resources/views/Checkout/checkout_shipping_payment.html.twig` |
