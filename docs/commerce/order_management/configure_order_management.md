---
description: Configure order processing, modify the default workflow.
edition: commerce
---

# Configure order processing

When you work with your Commerce implementation, you can modify and customize the order processing configuration.

!!! note "Permissions" 

    When you modify the workflow configuration, make sure you properly set user [permissions](permission_use_cases.md#commerce) for the Order management component.

## Configure order processing workflow

Order processing workflow relies on a [Symfony Workflow](http://symfony.com/doc/5.4/components/workflow.html).
Each transition represents a separate order processing step. 

### Default order processing configuration

The default order processing workflow is called `ibexa_order`. 
To see the default workflow configuration, in your project directory, go to: `vendor/Ibexa/order-management/src/bundle/Resources/config/prepend.yaml`.

The default workflow uses keys defined in `src/lib/Value/Status.php` file as place and transition names, for example, `PENDING_PLACE` translates into `pending`.

You can replace the default workflow configuration with a custom one if needed.

### Custom order processing workflows

You define custom workflow implementations under the `framework.workflows` key. 
If your installation supports multiple languages, for each place in the workflow, you can define a label that is pulled from a XLIFF file based on the [translation domain setting](../../multisite/languages/back_office_translations.md). 
You can also define colors that are used for status labels.

To customize your configuration, place it under the `framework.workflows.<your_workflow_name>` [configuration key](configuration.md#configuration-files):

``` yaml
[[= include_file('code_samples/front/shop/order-management/config/packages/ibexa.yaml', 0, 66) =]]
```

Then reference it with `ibexa.repositories.<your_repository>.order_management.workflow: <your_workflow_name>`, so that the system can identify which of your configured workflows handles the ordering process.

``` yaml
[[= include_file('code_samples/front/shop/order-management/config/packages/ibexa.yaml', 69, 74) =]]
```

### PIM integration

By default, the component integration mechanism reduces product stock values when an order is made (in status "pending") and reverts it to the original value when an order is cancelled.
In your implementation, you may want the reduction/restoration of stock to happen at other stages of the order fulfillment process.
For this to happen, place the `reduce_stock: true` and/or `restore_stock: true` keys in other places of the workflow. 
Make sure that either of these keys is used only once.
