# Simple checkout

This is an alternative checkout implementation with only one step involved.

## Configuring a simple checkout

Replace the `CheckoutController` with the `SimpleCheckoutController` in `routing.yml`:

``` yaml hl_lines="3"
 path:  /checkout
 defaults:
    _controller: SisoCheckoutBundle:SimpleCheckout:index
    breadcrumb_path: silversolutions_basket_show/siso_checkout_homepage
    breadcrumb_names: Shopping basket/Checkout
```

Replace `checkout.js` with `simple_checkout.js` in `pagelayout.html.twig`:

``` html+twig hl_lines="2"
{% javascripts
'bundles/silversolutionseshop/js/phalanx/hoplite/checkout/simple_checkout.js'
%}
```

In `checkout.yml`:

``` yaml hl_lines="6 12 14 15 19"
checkoutForms:
    invoice:
        modelClass: Siso\Bundle\CheckoutBundle\Form\CheckoutInvoiceAddress
        #typeService: siso_checkout.form_entity.checkout_invoice_address_type
        typeClass: Siso\Bundle\CheckoutBundle\Form\Type\CheckoutInvoiceAddressType
        template: SilversolutionsEshopBundle:Checkout/simple:checkout_invoice_address.html.twig
        templateSidebar: SilversolutionsEshopBundle:Checkout:sidebar_invoice_address.html.twig
        invalidMessage: error_message_checkout_invoice_address
        validMessage: success_message_checkout_invoice_address
        service: siso_checkout.checkout_form.invoice_address
    delivery:
        modelClass: Siso\Bundle\CheckoutBundle\Form\SimpleCheckoutDeliveryAddress
        #typeService: siso_checkout.form_entity.checkout_delivery_address_type
        typeClass: Siso\Bundle\CheckoutBundle\Form\Type\SimpleCheckoutDeliveryAddressType
        template: SilversolutionsEshopBundle:Checkout/simple:checkout_delivery_address.html.twig
        templateSidebar: SilversolutionsEshopBundle:Checkout:sidebar_delivery_address.html.twig
        invalidMessage: error_message_checkout_delivery_address
        validMessage: success_message_checkout_delivery_address
        service: siso_checkout.simple_checkout_delivery_address_form_service
    shippingPayment:
        modelClass: Siso\Bundle\CheckoutBundle\Form\CheckoutShippingPayment
        #typeService: siso_checkout.form_entity.checkout_shipping_payment_type
        typeClass: Siso\Bundle\CheckoutBundle\Form\Type\CheckoutShippingPaymentType
        template: SilversolutionsEshopBundle:Checkout:checkout_shipping_payment.html.twig
        invalidMessage: error_message_checkout_shipping_payment
        validMessage: success_message_checkout_shipping_payment
        service: siso_checkout.checkout_form.shipping_payment
    summary:
        modelClass: Siso\Bundle\CheckoutBundle\Form\CheckoutSummary
        #typeService: siso_checkout.form_entity.checkout_summary_type
        typeClass: Siso\Bundle\CheckoutBundle\Form\Type\CheckoutSummaryType
        template: SilversolutionsEshopBundle:Checkout:checkout_summary.html.twig
        templateSidebar: SilversolutionsEshopBundle:Checkout:sidebar_summary.html.twig
        invalidMessage: error_message_checkout_summary
        validMessage: success_message_checkout_summary
        service: siso_checkout.checkout_form.summary
```
