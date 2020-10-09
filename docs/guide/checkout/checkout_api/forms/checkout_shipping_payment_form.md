# Shipping payment form

## Model Class

`CheckoutShippingPayment` (`Siso\Bundle\CheckoutBundle\Form\CheckoutShippingPayment`)
extends `AbstractFormEntity` and implements `CheckoutAddressInterface`.

## Fields

|Name|Description|Assertions|
|--- |--- |--- |
|shippingMethod|method of the shipping|String</br>Not blank|
|paymentMethod|method of the payment|String</br>Not blank|
|forceStep|True if user wants to force to next step with event errors|Boolean|

## Configuration

The parameters are set in the [Configuration for Checkout Forms](configuration_for_checkout_forms.md).

## Form Type

`Siso\Bundle\CheckoutBundle\Form\Type\CheckoutShippingPaymentType`
(service ID: `siso_checkout.form_entity.checkout_shipping_payment_type`)
implements the setup for this form.

This class is defined as a service to take advantage from `TransService`.

!!! note

    The scope of this service is set to `prototype`.
    A new instance of `CheckoutShippingPaymentType` is created every time this service is called.

## Templates

|               |           |
| ------------- | --------- |
| Main template | `vendor/silversolutions/silver.e-shop/src/Silversolutions/Bundle/EshopBundle/Resources/views/Checkout/checkout_shipping_payment.html.twig` |

### Select value configuration

You can set other configuration values in [Configuration for checkout forms](configuration_for_checkout_forms.md).
