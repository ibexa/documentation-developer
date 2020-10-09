# Configuration for checkout forms

You can use generic configuration for checkout forms to override the forms and form logic for your project.

`Siso\Bundle\CheckoutBundle\Model\FormConfig` is the class managing the configuration.

The checkout forms are configured in `vendor/silversolutions/silver.e-shop/src/Siso/Bundle/CheckoutBundle/Resources/config/checkout.yml`.

``` yaml
parameters:
    checkoutForms:
        invoice:
            modelClass: Siso\Bundle\CheckoutBundle\Form\CheckoutInvoiceAddress
            typeService: siso_checkout.form_entity.checkout_invoice_address_type
            #typeClass:
            template: SilversolutionsEshopBundle:Checkout:checkout_invoice_address.html.twig
            templateSidebar: SilversolutionsEshopBundle:Checkout:sidebar_invoice_address.html.twig
            invalidMessage: error_message_checkout_invoice_address
            validMessage: success_message_checkout_invoice_address
            service: siso_checkout.checkout_form.invoice_address
        delivery:
            modelClass: Siso\Bundle\CheckoutBundle\Form\CheckoutDeliveryAddress
            typeService: siso_checkout.form_entity.checkout_delivery_address_type
            #typeClass:
            template: SilversolutionsEshopBundle:Checkout:checkout_delivery_address.html.twig
            templateSidebar: SilversolutionsEshopBundle:Checkout:sidebar_delivery_address.html.twig
            invalidMessage: error_message_checkout_delivery_address
            validMessage: success_message_checkout_delivery_address
            service: siso_checkout.checkout_form.delivery_address
        shippingPayment:
            modelClass: Siso\Bundle\CheckoutBundle\Form\CheckoutShippingPayment
            typeService: siso_checkout.form_entity.checkout_shipping_payment_type
            #typeClass:
            template: SilversolutionsEshopBundle:Checkout:checkout_shipping_payment.html.twig
            invalidMessage: error_message_checkout_shipping_payment
            validMessage: success_message_checkout_shipping_payment
            service: siso_checkout.checkout_form.shipping_payment
        summary:
            modelClass: Siso\Bundle\CheckoutBundle\Form\CheckoutSummary
            typeService: siso_checkout.form_entity.checkout_summary_type
            #typeClass:
            template: SilversolutionsEshopBundle:Checkout:checkout_summary.html.twig
            templateSidebar: SilversolutionsEshopBundle:Checkout:sidebar_summary.html.twig
            invalidMessage: error_message_checkout_summary
            validMessage: success_message_checkout_summary
            service: siso_checkout.checkout_form.summary
```

You can modify this configuration to override e.g. the form type, form service or templates.

!!! note

    If you change the form model class, you should also override the form type,
    templates and form service, because the logic may have changed.

## Other configuration values

`vendor/silversolutions/silver.e-shop/src/Siso/Bundle/CheckoutBundle/Resources/config/checkout.yml`
contains settings for forms and preferred choices.
The choices for the delivery address depend on the user status.

``` yaml
parameters:
    ses_forms.checkout_values:
        deliveryAddressStatusCustomerNr:
            sameAsInvoice: use_invoice_as_delivery
            new: new_delivery
            existing: existing_delivery
        deliveryAddressStatusAnonymous:
            sameAsInvoice: use_invoice_as_delivery
            new: new_delivery
        deliveryAddressStatusNoCustomerNr:
            sameAsInvoice: use_invoice_as_delivery
            new: new_delivery
        shippingMethods:
            standardMail: standard_mail
            mail: mail
            expressDelivery: express_delivery
        paymentMethods:
            paypal: paypal
            invoice: invoice
            creditCard: credit_card

    ses_forms.checkout_preferred_choices:
        preferred_delivery_address_status_no_customer_nr: new
        preferred_delivery_address_status_anonymous: new
        preferred_delivery_address_status_customer_nr: sameAsInvoice
        preferred_shipping_method: standardMail
        preferred_payment_method: creditCard
```

!!! tip

    You can also override the shipping and payment method configuration
    by implementing a [Pre-form-checkout event](../checkout_events.md) that stores the values in the `dataMap`.

!!! caution

    The value of the preferred choice and the index of the choice must match.

    For example:

    ``` yaml
    ses_forms.checkout_values:
        deliveryAddressStatusCustomerNr:
            sameAsInvoice: use_invoice_as_delivery
            new: new_delivery existing:
            existing_delivery

    ses_forms.checkout_preferred_choices:
        preferred_delivery_address_status_customer_nr: sameAsInvoice
    ```
