---
description: Configure the default checkouts process and build custom ones.
edition: commerce
---

# Configure checkout

When you work with your Commerce implementation, you can review and modify 
the checkout configuration.

!!! note "Permissions" 

    When you modify the workflow configuration, make sure you properly set user [permissions](permission_use_cases.md#commerce) to the checkout component.

## Checkout workflow

Checkout workflow relies on [Symfony Workflow](http://symfony.com/doc/5.4/components/workflow.html).
Each transition represents a separate checkout step. 

By default, the checkout process is configured to render each step based on a separate 
set of libraries and templates.
Each checkout step is handled by a controller that you configure in workflow metadata.

Custom workflow implementations are defined under the `framework.workflows` key, 
and they must support the `Ibexa\Contracts\Checkout\Value\CheckoutInterface`. 
The default fallback workflow is `ibexa_checkout`, which is prepended at bundle level.
The `checkout.workflow` parameter is repository-aware.

To customize your configuration, place it in a YAML file, under the `framework.workflows.<your_workflow_name>` key, and reference it with `ibexa.repositories.<your_repository>.checkout.workflow: your_workflow_name`. 
The system can then identify which of your configured workflows handles the checkout process.

!!! note 

    When you modify or create a controller, to ensure that no user data is lost, extend the `Ibexa\Bundle\Checkout\Controller\AbstractStep` controller and call the `advance()` method.

Each step configuration includes the following settings:

- `controller` - A mandatory setting pointing to a library that governs the behavior of the process. The controller contains all the required business logic and submits the whole step, so that a transition can happen.
- `next_step` - An optional name of the next workflow transition. If not provided, the next workflow-enabled transition is processed.
- `label` - An optional name of the step that can be displayed in the Twig helper.
- `translation_domain` - A optional setting that defines the domain for a site with translated content. By default it is set to `checkout`.

### Default checkout workflow configuration

The default checkout workflow configuration looks as follows. `ibexa_checkout` key is used by default, you can replace it with your custom workflow identifier if needed.

``` yaml
[[= include_file('code_samples/front/shop/checkout/config/packages/ibexa.yaml')=]]
```

## Configure shipping and payment methods

You can define the shipping and payment methods.
Under `ibexa.repositories.<repository_name>.checkout`, create entries that resemble 
the following example.
If you do not set a value for the `workflow` key, `ibexa_checkout` is used by default.

``` yaml 
ibexa:
    repositories:
        <repository_name>:
            checkout: 
            workflow: <workflow_name>
                shipping_methods:
                    courier:
                        name: "Courier"
                        translation_domain: "checkout" #optional, all shipping/payment methods use this one by default
                    parcel_machine:
                        name: "Parcel machine"
                    self_pickup:
                        name: "Self pickup"
                    express_delivery:
                        name: "Express delivery"
                payment_methods:
                    credit_card:
                        name: "Credit card"
                    paypal:
                        name: "Paypal"
                    money_transfer:
                        name: "Money transfer"
```

## Shipping and billing address field format configuration 

In your implementation, you may need to create custom format configurations 
for the shipping or billing address fields, for example, to use different address 
formats based on the buyer's geographical location.

Field formats for the billing and shipping addresses comply with the [FieldType Address](addressfield.md#formats) specification and can be controlled with the `billing_address_format` and `shipping_address_format` flags, respectively.
They fall back to `billing` and `shipping` predefined formats by default:

- `billing` is part of the `ibexa/corporate-accounts` repository 
- `shipping` is part of the `ibexa/checkout` bundle's default configuration 

To modify address formats you create custom ones.

### Define custom Address Field Type formats 

To create custom Address Field Type formats to be used in checkout, make the following changes in the project configuration files. 

First, define custom format configuration keys for `billing_address_format` and `shipping_address_format`:

``` yaml 
ibexa:
    repositories:
        <repository_name>:
            checkout:
                #coming from Corporate Account, "billing" by default
                billing_address_format: <custom_billing_fieldtype_address_format> 
                #coming from Corporate Account, "shipping" by default 
                shipping_address_format: <custom_shipping_fieldtype_address_format> 
                #used in registration, uses given shipping/billing addresses to pre-populate address forms in select_address checkout step, "customer" by default
                customer_content_type: <your_ct_identifier_for_customer> 
```

Then, define custom address formats, which, for example, do not include the `locality` field:

``` yaml 
ibexa_field_type_address:
    formats:
        <custom_shipping_fieldtype_address_format>:
            country:
                default:
                    - region
                    - street
                    - postal_code
                    - email
                    - phone_number
                    
        <custom_billing_fieldtype_address_format>:
            country:
                default:
                    - region
                    - street
                    - postal_code
                    - email
                    - phone_number
```
