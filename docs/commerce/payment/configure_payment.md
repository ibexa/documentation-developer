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

The default payment workflow is called `ibexa_payment`.
To see the default workflow configuration, in your project directory, go to: `vendor/Ibexa/payment/src/bundle/Resources/config/prepend.yaml`.

You can replace the default workflow configuration with a custom one if needed.

### Custom payment workflows

You define custom workflow implementations under the `framework.workflows` key. 
They must support the `Ibexa\Contracts\Checkout\Value\CheckoutInterface`.

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