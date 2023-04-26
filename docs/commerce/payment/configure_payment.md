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

### Default payment workflow configuration

The default payment workflow configuration is called `ibexa_payment`, you can replace it with your custom workflow identifier if needed.

To see the default workflow, in your project directory, navigate to the following file: `vendor/Ibexa/payment/src/bundle/Resources/config/prepend.yaml`.

### Custom payment workflows

You define custom workflow implementations under the `framework.workflows` key. 
If your installation supports multiple languages, for each place in the workflow, you can define a label that is pulled from a XLIFF file based on the [translation domain setting](../../multisite/languages/back_office_translations.md). 
You can also define colors that are used for status labels.

``` yaml
[[= include_file('code_samples/front/shop/payment/config/packages/ibexa.yaml', 7, 39) =]]
```

Then reference it with `ibexa.repositories.<your_repository>.payment.workflow`, so that the system can identify which of your configured workflows handles the payment process.

``` yaml
[[= include_file('code_samples/front/shop/payment/config/packages/ibexa.yaml', 0, 5) =]]
```

## Configure payment methods

You can define the payment methods [in the UI]([[= user_doc =]]/commerce/payment/configure_payment_method/).
There is only one payment method type available: `offline`.