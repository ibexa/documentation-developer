---
description: Configure shipping, modify the default shipment workflow.
edition: commerce
---

# Configure shipping

When you work with your Commerce implementation, you can review and modify the shipping configuration.

!!! note "Permissions"

    When you modify the workflow configuration, make sure you properly set user [permissions](permission_use_cases.md#commerce) for the shipping component.

## Configure shipment workflow

Shipment workflow relies on a [Symfony Workflow]([[= symfony_doc =]]/components/workflow.html).
Each transition represents a separate shipment step.

The default fallback workflow is `ibexa_shipment`, which is prepended at bundle level.

### Default shipment workflow configuration

The default payment workflow configuration is called `ibexa_shipment`, you can replace it with your custom workflow identifier if needed.

To see the default workflow, in your project directory, navigate to the following file: `vendor/Ibexa/shipping/src/bundle/Resources/config/workflow.yaml`.

### Custom shipment workflows

You define custom workflow implementations under the `framework.workflows` [configuration key](configuration.md#configuration-files).
The `shipping.shipment_workflow` parameter is repository-aware.

To customize your configuration, place it under the `framework.workflows.<your_workflow_name>` [configuration key](configuration.md#configuration-files):

``` yaml
[[= include_file('code_samples/front/shop/shipping/config/packages/ibexa.yaml', 8, 89) =]]
```

Reference it with `ibexa.repositories.<your_repository>.shipment.workflow: your_workflow_name`, so that the system can then identify which of your configured workflows handles the shipment process.

``` yaml
[[= include_file('code_samples/front/shop/shipping/config/packages/ibexa.yaml', 0, 5) =]]
```

## Configure shipping methods

You can define the shipping methods [in the UI]([[= user_doc =]]/commerce/shipping_management/work_with_shipping_methods/).
The following shipping method types are available by default: `flat rate` and `free`.
