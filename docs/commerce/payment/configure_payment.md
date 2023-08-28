---
description: Configure payments, modify the default payment processing workflow.

edition: commerce
---

# Configure payment

When you work with your Commerce implementation, you can review and modify the payment configuration.

!!! note "Permissions" 

    When you modify the workflow configuration, make sure you properly set user [permissions](permission_use_cases.md#commerce) for the Payment component.

## Configure payment workflow

Payment workflow relies on a [Symfony Workflow]([[= symfony_doc =]]/components/workflow.html).
Each transition represents a separate payment step. 

### Default payment workflow configuration

The default payment workflow is called `ibexa_payment`.
To see the default workflow configuration, in your project directory, go to: `vendor/Ibexa/payment/src/bundle/Resources/config/prepend.yaml`.

You can replace the default workflow configuration with a custom one if needed.

### Custom payment workflows

You define custom workflow implementations under the `framework.workflows` key. 
They must support the `Ibexa\Contracts\Checkout\Value\CheckoutInterface`.

If your installation supports multiple languages, for each place in the workflow, you can define a label that is pulled from an XLIFF file based on the translation domain setting. 
You can also define colors that are used for status labels.
The `primary_color` key defines a color of the font used for the label, while the `secondary_color` key defines a color of its background.

Additionally, you can decide whether users can manually transition between places. 
You do this by setting a value for the `exposed` key. 
If you set it to `true`, a button is displayed in the UI that triggers the transition. 
Otherwise, the transition can only be triggered by means of the API.

``` yaml
[[= include_file('code_samples/front/shop/payment/config/packages/ibexa.yaml', 7, 39) =]]
```

After you configure a custom workflow, reference it under the `ibexa.repositories.<your_repository>.payment.workflow` [configuration key](configuration.md#configuration-files),
so that the system can identify which of your workflows handles the payment process.

``` yaml
[[= include_file('code_samples/front/shop/payment/config/packages/ibexa.yaml', 0, 5) =]]
```

## Configure payment methods

You can define the payment methods [in the UI]([[= user_doc =]]/commerce/payment/configure_payment_method/).
There is only one default payment method type available: `offline`, but you can [add custom ones](extend_payment.md).
