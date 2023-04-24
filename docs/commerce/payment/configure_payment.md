---
description: Configure the payment process.
edition: commerce
---

# Configure payment

When you work with your Commerce implementation, you can review and modify the payment configuration.

!!! note "Permissions" 

    When you modify the workflow configuration, make sure you properly set user [permissions](permission_use_cases.md#commerce) for the Payment component.

## Payment workflow

Payment workflow relies on a [Symfony Workflow](http://symfony.com/doc/5.4/components/workflow.html).
Each transition represents a separate payment step. 

The default fallback workflow is `ibexa_payment`.

### Default payment workflow configuration

The default payment workflow configuration is called `ibexa_payment`, you can replace it with your custom workflow identifier if needed.

To see the default workflow, in your project directory, navigate to the following file: `src/bundle/Resources/config/workflow.yaml`.

### Custom payment workflows

You define custom workflow implementations under the `framework.workflows` key. 
The `payment.workflow` parameters are repository-aware.

To customize your configuration, place it in a YAML file under the `framework.workflows.<your_workflow_name>` key:

``` yaml
[[= include_file('code_samples/front/shop/payment/config/packages/ibexa.yaml', 7, 39) =]]
```

Then reference it with `ibexa.repositories.<your_repository>.payment.workflow: your_workflow_name`, so that the system can then identify which of your configured workflows handles the payment process.

``` yaml
[[= include_file('code_samples/front/shop/payment/config/packages/ibexa.yaml', 0, 5) =]]
```

## Configure payment methods

You can define the payment methods [in the UI]([[= user_doc =]]/commerce/payment/configure_payment_method/).
There is only one payment method type available: `offline`.