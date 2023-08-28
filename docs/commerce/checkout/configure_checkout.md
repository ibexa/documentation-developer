---
description: Configure checkout, modify the default checkout workflow.
edition: commerce
---

# Configure checkout

When you work with your Commerce implementation, you can review and modify 
the checkout configuration.

!!! note "Permissions" 

    When you modify the workflow configuration, make sure you properly set user [permissions](permission_use_cases.md#commerce) to the checkout component.

## Configure checkout workflow

Checkout workflow relies on [Symfony Workflow]([[= symfony_doc =]]/components/workflow.html).
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

### Checkout customization example

For more information about the results you can achieve by customizing checkout, see [Customize checkout](customize_checkout.md).

## Configure shipping and payment methods

You can define the shipping and payment methods in the user interface.
For more information, see [Work with shipping methods]([[= user_doc =]]/commerce/shipping_management/work_with_shipping_methods/) and [Work with payment methods]([[= user_doc =]]/commerce/payment/work_with_payment_methods/).

## Configure shipping and billing address field format

In your implementation, you may need to create custom format configurations 
for the shipping or billing address fields, for example, to use different address 
formats based on the buyer's geographical location.

Field formats for the billing and shipping addresses comply with the [FieldType Address](addressfield.md#formats) specification and can be controlled with the `billing_address_format` and `shipping_address_format` flags, respectively.
They fall back to `billing` and `shipping` predefined formats by default:

- `billing` is part of the `ibexa/corporate-accounts` repository 
- `shipping` is part of the `ibexa/checkout` bundle's default configuration 

To modify address formats you create custom ones.