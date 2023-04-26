---
description: Configure the order processing workflow.
edition: commerce
---

# Configure order processing

When you work with your Commerce implementation, you can review and modify the order processing configuration.

!!! note "Permissions" 

    When you modify the workflow configuration, make sure you properly set user [permissions](permission_use_cases.md#commerce) for the Order management component.

## Order processing workflow

Order processing workflow relies on a [Symfony Workflow](http://symfony.com/doc/5.4/components/workflow.html).
Each transition represents a separate order processing step. 

### Default order processing configuration

The default order workflow configuration is called `ibexa_order`, you can replace it with your custom workflow identifier if needed.

To see the default workflow, in your project directory, navigate to the following file: `vendor/Ibexa/order-management/src/bundle/Resources/config/prepend.yaml`.

The default workflow uses keys defined in `src/lib/Value/Status.php` file as place and transition names, for example, `PENDING_PLACE` translates into `pending`.

### Custom order processing workflows

You define custom workflow implementations under the `framework.workflows` key. 
If your installation supports multiple languages, for each place in the workflow, you can define a label that is pulled from a XLIFF file based on the [translation domain setting](../../multisite/languages/back_office_translations.md). 
You can also define colors that are used for status labels.

To customize your configuration, place it in a YAML file under the `framework.workflows.<your_workflow_name>` key:

``` yaml
[[= include_file('code_samples/front/shop/order-management/config/packages/ibexa.yaml', 0, 66) =]]
```

Then reference it with `ibexa.repositories.<your_repository>.order_management.workflow: <your_workflow_name>`, so that the system can identify which of your configured workflows handles the ordering process.

``` yaml
[[= include_file('code_samples/front/shop/order-management/config/packages/ibexa.yaml', 69, 74) =]]
```