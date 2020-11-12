# Payment

Payment in [[= product_name_com =]] depends on the [JMSPaymentCoreBundle.](http://jmsyst.com/bundles/JMSPaymentCoreBundle)

!!! note

    If `JMSPaymentCoreBundle` is not installed due to composer dependencies,
    [install it manually.](http://jmsyst.com/bundles/JMSPaymentCoreBundle/master/installation)
    
The following payment providers are available out of the box:

|Payment provider|Code used in Basket|
|--- |--- |
|Invoice|`invoice`|
|[PayPal Express](paypal.md)|`paypal_express_checkout`|

## Activating payment options

Individual payment options / payment methods are implemented in Symfony bundles.
As soon as they are registered in the kernel, they are displayed in the checkout payment form.
The respective options are registered in the checkout form by a DIC compiler pass and must fulfill some requirements:

- The bundle must define a form type service
- The form type must define the `payment.method_form_type` tag
- The form type must define the `form.type` tag with an alias attribute that is used as text in the payment choice.

The compiler pass is defined in the checkout bundle: `Siso\Bundle\CheckoutBundle\DependencyInjection\Compiler\PaymentMethodsPass`
