# Configure shipping

Configure shipping, modify the default shipment workflow.

Editions: Commerce

When you work with your Commerce implementation, you can review and modify the shipping configuration.

> **Note: Permissions**
>
> When you modify the workflow configuration, make sure you properly set user [permissions](../../../permissions/permission_use_cases/index.md#commerce) for the shipping component.

## Configure shipment workflow

Shipment workflow relies on a [Symfony Workflow](https://symfony.com/doc/7.4/components/workflow.html). Each transition represents a separate shipment step.

The default fallback workflow is `ibexa_shipment`, which is prepended at bundle level.

### Default shipment workflow configuration

The default payment workflow configuration is called `ibexa_shipment`, you can replace it with your custom workflow identifier if needed.

To see the default workflow, in your project directory, navigate to the following file: `vendor/ibexa/shipping/src/bundle/Resources/config/workflow.yaml`.

### Custom shipment workflows

You define custom workflow implementations under the `framework.workflows` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files). The `shipping.shipment_workflow` parameter is repository-aware.

To customize your configuration, place it under the `framework.workflows.<your_workflow_name>` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files):

```yaml
framework:
    workflows:
        custom_shipment_workflow:
            type: state_machine
            audit_trail:
                enabled: "%kernel.debug%"
            marking_store:
                type: method
                property: status
            supports:
                - Ibexa\Contracts\Shipping\Shipment\ShipmentInterface
                - Ibexa\Contracts\Shipping\Shipment\ShipmentCreateStruct
            initial_marking: pending
            places:
                pending:
                    metadata:
                        label: ibexa.shipment.workflow.place.pending.label
                        primary_color: '#F4B65F'
                        secondary_color: '#FEEED9'
                        translation_domain: ibexa_shipment_workflow
                ready_for_clearance:
                    metadata:
                        label: ibexa.shipment.workflow.place.ready_for_clearance.label
                        primary_color: '#DB2C54'
                        secondary_color: '#F7CCD6'
                        translation_domain: ibexa_shipment_workflow
                in_customs:
                    metadata:
                        label: ibexa.shipment.workflow.place.in_customs.label
                        primary_color: '#DB2C54'
                        secondary_color: '#F7CCD6'
                        translation_domain: ibexa_shipment_workflow
                passed_customs_clearance:
                    metadata:
                        label: ibexa.shipment.workflow.place.passed_customs_clearance.label
                        primary_color: '#1beb17'
                        secondary_color: '#c5f2c4'
                        translation_domain: ibexa_shipment_workflow
                shipped:
                    metadata:
                        label: ibexa.shipment.workflow.place.shipped.label
                        primary_color: '#5A5A5D'
                        secondary_color: '#E6E6ED'
                        translation_domain: ibexa_shipment_workflow
                delivered:
                    metadata:
                        label: ibexa.shipment.workflow.place.delivered.label
                        primary_color: '#2B6875'
                        secondary_color: '#CCDBDE'
                        translation_domain: ibexa_shipment_workflow
            transitions:
                prepare:
                    from:
                        - pending
                    to: ready_for_clearance
                    metadata:
                        exposed: false
                sent_to_customs:
                    from:
                        - ready_for_clearance
                    to: in_customs
                    metadata:
                        exposed: false
                clear_at_customs:
                    from:
                        - in_customs
                    to: passed_customs_clearance
                    metadata:
                        exposed: false
                send:
                    from:
                        - passed_customs_clearance
                    to: shipped
                    metadata:
                        exposed: false
                deliver:
                    from:
                        - shipped
                    to: delivered
                    metadata:
                        exposed: false
```

Reference it with `ibexa.repositories.<your_repository>.shipment.workflow: your_workflow_name`, so that the system can then identify which of your configured workflows handles the shipment process.

```yaml
ibexa:
    repositories:
        default: 
            shipping:
                shipment_workflow: custom_shipment_workflow
```

## Configure shipping methods

You can define the shipping methods [in the UI](../../../../user/commerce/shipping_management/work_with_shipping_methods/index.md). The following shipping method types are available by default: `flat rate` and `free`.
