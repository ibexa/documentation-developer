---
description: Configure the default checkouts process and build custom ones.
edition: commerce
---

# Configure checkout

When you work with your Commerce implementation, you can review and modify 
the checkout configuration.

!!! note "Permissions" 

    When you modufy the workflow configuration, make sure you properly set user [permissions](../permission_use_cases.md#commerce) to the checkout component.

## Checkout workflow

Checkout workflow is configured like other [workflows](../../content_management/workflow/workflow.md) where each 
transition represents a separate checkout step. 

By default, the checkout process is configured to render each stage based on a separate 
set of libraries and templates.
Each checkout step is handled by a controller that you configure in workflow metadata.

Custom workflow implementations are defined under the `framework.workflows` key, 
and they must support the `Ibexa\Contracts\Checkout\Value\CheckoutInterface`. 
The default fallback workflow is `ibexa_checkout`, which is prepended at bundle level.
The `checkout.workflow` parameter is repository-aware.

To customize your configuration, place it in a YAML file, under the `framework.workflows.<your_workflow_name>` key, and reference it with `ibexa.repositories.<your_repository>.checkout.workflow: your_workflow_name`. 
The system can then identify which of your configured workflows handles the checkout process.

!!! note 

    When you modify or create a controller, to ensure that no user-data is lost, extend the `Ibexa\Bundle\Checkout\Controller\AbstractStep` controller and call the `advance()` method.

Each step configuration includes the following settings:

- `controller` - A mandatory setting pointing to a library that governs the bahavior of the process. It contains all the required business logic and submits the whole step, so that a transition can happen.
- `next_step` - An optional name of next workflow transition. If not provided, the next workflow-enabled transition is processed.
- `label` - An optional name of the step that can be displayed in the Twig helper.
- `translation_domain` - A optional setting that defines the domain for a site with translated content. By default it is set to `checkout`.

### Default checkout workflow configuration

Here is the default workflow configuration that comes shipped with the product:

``` yaml
framework:
    workflows:
        ibexa_checkout:
            type: state_machine
            audit_trail:
                enabled: false
            marking_store:
                type: method
                property: status
            supports:
                - Ibexa\Contracts\Checkout\Value\CheckoutInterface
            initial_marking: initialized
            places:
                - initialized
                - address_selected
                - shipping_selected
                - summarized
                - completed
            transitions:
                select_address:
                    from:
                        - initialized
                        - address_selected
                        - shipping_selected
                        - summarized
                    to: address_selected
                    metadata:
                        next_step: select_shipping
                        controller: Ibexa\Bundle\Checkout\Controller\CheckoutStep\AddressStepController::renderStepView
                        label: 'Billing & shipping address'
                        translation_domain: checkout
                select_shipping:
                    from:
                        - address_selected
                        - shipping_selected
                        - summarized
                    to: shipping_selected
                    metadata:
                        next_step: summary
                        controller: Ibexa\Bundle\Checkout\Controller\CheckoutStep\ShippingStepController::renderStepView
                        label: 'Shipping & payment method'
                        translation_domain: checkout
                summary:
                    from:
                        - shipping_selected
                        - summarized
                    to: summarized
                    metadata:
                        next_step: complete
                        controller: Ibexa\Bundle\Checkout\Controller\CheckoutStep\SummaryStepController::renderStepView
                        label: 'Payment & summary'
                        translation_domain: checkout
                complete:
                    from: summarized
                    to: completed
                    metadata:
                        controller: Ibexa\Bundle\Checkout\Controller\CheckoutStep\CompleteStepController::renderCompleteView
                        label: 'Order confirmation'
                        translation_domain: checkout
```


## Configure shipping and payment payment_methods

``` yaml 
ibexa:
    repositories:
        <your_repository>:
            checkout:
                workflow: <your_workflow_identifier>
                billing_address_format: <your_fieldtype_address_format_identifier> #coming from Corporate Account "billing" by default
                shipping_address_format: <your_fieldtype_address_format_identifier> #coming from Corporate Account "shipping" by default 
                customer_content_type: <your_ct_identifier_for_customer> #customer by default, it is used in registration and uses given shipping/billing addresses to pre-populate address forms in "Select Address" checkout step
                shipping_methods:
                    courier:
                        name: "Courier"
                        translation_domain: "checkout" #optional, all the shipping/payment methods use this one by default
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

## Shipping and billing address field configurations 

The billing and shipping addresses used in checkout are related to their respective 
values that exist in corporate account information. 
You can configure these addresses by modifying the following code under `../ibexa/checkout/blob/main/src/bundle/DependencyInjection/Configuration/CheckoutParser.php`

``` php 
          ->scalarNode('billing_address_format')
              ->defaultValue('billing')
          ->end()
          ->scalarNode('shipping_address_format')
              ->defaultValue('shipping')
          ->end()
```

## Checkout extension points 
