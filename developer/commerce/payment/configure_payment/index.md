# Configure payment

Configure payments, modify the default payment processing workflow.

Editions: Commerce

When you work with your Commerce implementation, you can review and modify the payment configuration.

> **Note: Permissions**
>
> When you modify the workflow configuration, make sure you properly set user [permissions](../../../permissions/permission_use_cases/index.md#commerce) for the Payment component.

## Configure payment workflow

Payment workflow relies on a [Symfony Workflow](https://symfony.com/doc/7.4/workflow.html). Each transition represents a separate payment step.

### Default payment workflow configuration

The default payment workflow is called `ibexa_payment`. To see the default workflow configuration, in your project directory, go to: `vendor/ibexa/payment/src/bundle/Resources/config/prepend.yaml`.

You can replace the default workflow configuration with a custom one if needed.

### Custom payment workflows

You define custom workflow implementations under the `framework.workflows` key. They must support the `Ibexa\Contracts\Checkout\Value\CheckoutInterface`.

If your installation supports multiple languages, for each place in the workflow, you can define a label that is pulled from an XLIFF file based on the translation domain setting. You can also define colors that are used for status labels. The `primary_color` key defines a color of the font used for the label, while the `secondary_color` key defines a color of its background.

Additionally, you can decide whether users can manually transition between places. You do this by setting a value for the `exposed` key. If you set it to `true`, a button is displayed in the UI that triggers the transition. Otherwise, the transition can only be triggered by means of the API.

```yaml
framework:
    workflows:
        custom_payment_workflow:
            type: state_machine
            audit_trail:
                enabled: "%kernel.debug%"
            marking_store:
                type: method
                property: status
            supports:
                - Ibexa\Contracts\Payment\Payment\Workflow\WorkflowSubjectInterface
            initial_marking: open
            places:
                open:
                    metadata:
                        label: ibexa.payment.workflow.place.open.label
                        primary_color: '#F4B65F'
                        secondary_color: '#FEEED9'
                        translation_domain: ibexa_payment_workflow
                paid:
                    metadata:
                        label: ibexa.payment.workflow.place.paid.label
                        primary_color: '#2B6875'
                        secondary_color: '#CCDBDE'
                        translation_domain: ibexa_payment_workflow
            transitions:
                pay:
                    from:
                        - open
                    to: paid
                    metadata:
                        exposed: false
```

After you configure a custom workflow, reference it under the `ibexa.repositories.<your_repository>.payment.workflow` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files), so that the system can identify which of your workflows handles the payment process.

```yaml
ibexa:
    repositories:
        default: 
            payment:
                workflow: custom_payment_workflow
```

## Configure payment methods

You can define payment methods [in the UI](../../../../user/commerce/payment/work_with_payment_methods/index.md). There is only one default payment method type available: `offline`, but you can configure more by [integrating with Payum](../payum_integration/index.md), or [add custom ones](../extend_payment/index.md).
