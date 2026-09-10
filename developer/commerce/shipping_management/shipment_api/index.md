# Shipment API

Use PHP API to manage shipments in Commerce. Create, update and delete shipments.

Editions: Commerce

To get shipments and manage them, use the `Ibexa\Contracts\Shipping\ShipmentServiceInterface` interface.

From the developer's perspective, shipments are referenced with a UUID identifier.

## Get single shipment

### Get single shipment by identifier

To access a single shipment by using its string identifier, use the `ShipmentService::getShipmentByIdentifier` method:

```php
$identifier = '4ac4b8a0-eed8-496d-87d9-32a960a10629';
$shipment = $this->shipmentService->getShipmentByIdentifier($identifier);

$output->writeln(
    sprintf(
        'Your shipment has status %s',
        $shipment->getStatus()
    )
);
```

### Get single shipment by id

To access a single shipment by using its numerical id, use the `ShipmentService::getShipment` method:

```php
$id = 1;
$shipment = $this->shipmentService->getShipment($id);

$output->writeln(
    sprintf(
        'Shipment %d has status %s',
        $id,
        $shipment->getStatus()
    )
);
```

## Get multiple shipments

To fetch multiple shipments, use the `ShipmentService::findShipments` method. It follows the same search query pattern as other APIs:

```php
$shipmentCriteria = [
    new ShippingMethod($this->shippingMethodService->getShippingMethod('free')),
    new CreatedAt(new \DateTime('2023-03-24 15:09:16')),
    new UpdatedAt(new \DateTime('2023-03-25 09:00:15')),
];

$shipmentQuery = new ShipmentQuery(new LogicalOr(...$shipmentCriteria));
$shipmentQuery->setLimit(20);

$shipmentsList = $this->shipmentService->findShipments($shipmentQuery);

$shipmentsList->getShipments();
$shipmentsList->getTotalCount();

foreach ($shipmentsList as $shipment) {
    $output->writeln(
        $shipment->getIdentifier() . ': ' . $shipment->getStatus()
    );
}
```

## Create shipment

To create a shipment, use the `ShipmentService::createShipment` method and provide it with an `Ibexa\Contracts\Shipping\Value\ShipmentCreateStruct` object that takes two parameters, a `shippingMethod` string and a `Money` object.

```php
$shipmentCreateStruct = new ShipmentCreateStruct(
    $this->shippingMethodService->getShippingMethod('free'),
    $this->orderService->getOrder(135),
    new Money\Money(100, new Money\Currency('EUR'))
);

$shipment = $this->shipmentService->createShipment($shipmentCreateStruct);

$output->writeln(
    sprintf(
        'Created shipment with identifier %s',
        $shipment->getIdentifier()
    )
);
```

## Update shipment

You can update the shipment after it's created. You could do it to support a scenario when, for example, the shipment is processed offline and its status has to be updated in the system. To update shipment information, use the `ShipmentService::updateShipment` method:

```php
$shipmentUpdateStruct = new ShipmentUpdateStruct();
$shipmentUpdateStruct->setTransition('send');

$this->shipmentService->updateShipment($shipment, $shipmentUpdateStruct);

$output->writeln(
    sprintf(
        'Changed shipment status to %s',
        $shipment->getStatus()
    )
);
```

## Delete shipment

To delete a shipment from the system, use the `ShipmentService::deleteShipment` method:

```php
$this->shipmentService->deleteShipment($shipment);
```
