---
description: Configure the default shipment process.
edition: commerce
---

# Configure shipment

When you work with your Commerce implementation, you can review and modify 
the shipment configuration.

!!! note "Permissions" 

    When you modify the workflow configuration, make sure you properly set user [permissions](permission_use_cases.md#commerce) for the shipping management component.

## Shipment workflow

Shipment workflow relies on a [Symfony Workflow](http://symfony.com/doc/5.4/components/workflow.html).
Each transition represents a separate shipment step. 

The default fallback workflow is `ibexa_shipment`, which is prepended at bundle level.

### Default shipment workflow configuration

The default payment workflow configuration is called `ibexa_shipment`, you can replace it with your custom workflow identifier if needed.

o see the default workflow, in your project directory, navigate to the following file: `vendor/Ibexa/checkout/src/bundle/Resources/config/workflow.yaml`.

### Custom shipment workflows

You define custom workflow implementations under the `framework.workflows` key. 
The `checkout.shipment_workflow` parameter is repository-aware.

To customize your configuration, place it in a YAML file, under the `framework.workflows.<your_workflow_name>` key:

``` yaml
[[= include_file('code_samples/front/shop/shipping_management/config/packages/ibexa.yaml', 8, 89) =]]
```

Reference it with `ibexa.repositories.<your_repository>.shipment.workflow: your_workflow_name`, so that the system can then identify which of your configured workflows handles the shipment process.

``` yaml
[[= include_file('code_samples/front/shop/shipping_management/config/packages/ibexa.yaml', 0, 5) =]]
```

## Configure shipping methods

You can define the shipping methods [in the UI]([[= user_doc =]]/commerce/shipping_management/configure_shipping_method/).
The following shipping method types are available by default: `flat rate` and `free`.