---
description: Configure the default shipment process.
edition: commerce
---

# Configure shipment

When you work with your Commerce implementation, you can review and modify 
the shipment configuration.

!!! note "Permissions" 

    When you modify the workflow configuration, make sure you properly set user [permissions](permission_use_cases.md#commerce) to the shipping management component.

## Shipment workflow

Shipment workflow relies on a [Symfony Workflow](http://symfony.com/doc/5.4/components/workflow.html).
Each transition represents a separate shipment step. 

The default fallback workflow is `ibexa_shipment`, which is prepended at bundle level.

### Default shipment workflow configuration

The default shipment workflow configuration looks as follows. `ibexa_shipment` key is used by default, you can replace it with your custom workflow identifier if needed.

``` yaml
[[= include_file('code_samples/front/shop/shipping_management/config/packages/ibexa.yaml', 15, 46) =]]
```

### Custom shipment workflows

You define custom workflow implementations under the `framework.workflows` key. 
The `shipment.workflow` parameter is repository-aware.

To customize your configuration, place it in a YAML file, under the `framework.workflows.<your_workflow_name>` key, and reference it with `ibexa.repositories.<your_repository>.shipment.workflow: your_workflow_name`. 
The system can then identify which of your configured workflows handles the shipment process.

## Configure shipping methods

You can define the shipping methods.
Under `ibexa.repositories.<repository_name>.shipment`, create entries that resemble 
the following example.
If you do not set a value for the `workflow` key, `ibexa_shipment` is used by default.

``` yaml 
ibexa:
    repositories:
        default: 
            shipment:
                workflow: ibexa_shipment
                shipping_methods:
                    flat_rate:
                        name: "Flat rate"
                        translation_domain: "shipment"
                    free:
                        name: "Free"
                        translation_domain: "shipment" #optional, all shipping methods use this one by default
```