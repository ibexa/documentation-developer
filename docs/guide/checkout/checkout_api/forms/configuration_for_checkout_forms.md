# Configuration for checkout forms [[% include 'snippets/commerce_badge.md' %]]

You can use generic configuration for checkout forms to override the forms and form logic for your project.

`Ibexa\Platform\Commerce\Checkout\ModelFormConfig` is the class managing the configuration.

You configure the checkout forms in `ezcommerce-checkout/src/bundle/Resources/config/checkout_parameters.yaml`.

You can modify this configuration to override e.g. the form type, form service or templates.

!!! note

    If you change the form model class, you should also override the form type,
    templates and form service, because the logic may have changed.

## Other configuration values

`ezcommerce-checkout/src/bundle/Resources/config/checkout_parameters.yaml` contains the settings for forms and preferred choices.
The choices for the delivery address depend on the user status.

!!! tip

    You can override the shipping and payment method configuration
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
