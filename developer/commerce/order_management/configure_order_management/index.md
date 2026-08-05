# Configure order processing

Configure order processing, modify the default workflow.

Editions: Commerce

When you work with your Commerce implementation, you can modify and customize the order processing configuration.

> **Note: Permissions**
>
> When you modify the workflow configuration, make sure you properly set user [permissions](../../../permissions/permission_use_cases/index.md#commerce) for the Order management component.

## Configure order processing workflow

Order processing workflow relies on a [Symfony Workflow](https://symfony.com/doc/7.4/components/workflow.html). Each transition represents a separate order processing step.

### Default order processing configuration

The default order processing workflow is called `ibexa_order`. To see the default workflow configuration, in your project directory, go to: `vendor/ibexa/order-management/src/bundle/Resources/config/prepend.yaml`.

The default workflow uses keys defined in `Ibexa\OrderManagement\Value\Status` class as place and transition names, for example, `PENDING_PLACE` translates into `pending`.

You can replace the default workflow configuration with a custom one if needed.

### Custom order processing workflows

You define custom workflow implementations under the `framework.workflows` key. If your installation supports multiple languages, for each place in the workflow, you can define a label that is pulled from a XLIFF file based on the [translation domain setting](../../../multisite/languages/back_office_translations/index.md). You can also define colors that are used for status labels.

To customize your configuration, place it under the `framework.workflows.<your_workflow_name>` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files):

```yaml
framework:
    workflows:
        custom_order_workflow:
            type: state_machine
            audit_trail:
                enabled: "%kernel.debug%"
            marking_store:
                type: method
                property: status
            supports:
                - Ibexa\Contracts\OrderManagement\Workflow\WorkflowSubjectInterface
            initial_marking: created
            places:
                created:
                    metadata:
                        reduce_stock: true
                        label: 'order.status.label.created'
                        translation_domain: 'order_management'
                        primary_color: '#F4B65F'
                        secondary_color: '#FEEED9'
                verified:
                    metadata:
                        label: 'order.status.label.verified'
                        translation_domain: 'order_management'
                        primary_color: '#2B6875'
                        secondary_color: '#CCDBDE'
                in_progress:
                    metadata:
                        label: 'order.status.label.in_progress'
                        translation_domain: 'order_management'
                        primary_color: '#FF9071'
                        secondary_color: '#FFDACF'
                completed:
                    metadata:
                        label: 'order.status.label.completed'
                        translation_domain: 'order_management'
                        primary_color: '#33B655'
                        secondary_color: '#E5F5E9'
                dropped:
                    metadata:
                        restore_stock: true
                        label: 'order.status.label.dropped'
                        translation_domain: 'order_management'
                        primary_color: '#5A5A5D'
                        secondary_color: '#E6E6ED'
            transitions:
                verify:
                    from:
                        - created
                    to:
                        - verified
                advance:
                    from:
                        - verified
                    to:
                        - in_progress
                finish:
                    from:
                        - in_progress
                    to:
                        - completed
                drop:
                    from:
                        - created
                    to:
                        - dropped
```

Then reference it with `ibexa.repositories.<your_repository>.order_management.workflow: <your_workflow_name>`, so that the system can identify which of your configured workflows handles the ordering process.

```yaml
ibexa:
    repositories:
        default:
            order_management:
                workflow: custom_order_workflow
```

### Define cancel order

You can define a status and transition in which the order can be canceled by modifying workflow under the `framework.workflows` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files).

```yaml
framework:
    workflows:
        ibexa_order:
            metadata:
                cancel_status: !php/const Ibexa\OrderManagement\Value\Status::CANCELLED_PLACE
                cancel_transition: !php/const Ibexa\OrderManagement\Value\Status::CANCEL_TRANSITION
```

### PIM integration

By default, the component integration mechanism reduces product stock values when an order is made (in status "pending") and reverts it to the original value when an order is cancelled. In your implementation, you may want the reduction/restoration of stock to happen at other stages of the order fulfillment process. For this to happen, place the `reduce_stock: true` and/or `restore_stock: true` keys in other places of the workflow. Make sure that either of these keys is used only once.
