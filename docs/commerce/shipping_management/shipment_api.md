---
description: Use PHP API to manage shipments in Commerce. Create, update and delete shipments.
edition: commerce
---

# Shipment API

To get shipments and manage them, use the `Ibexa\Contracts\Shipping\ShipmentServiceInterface` interface.

From the developer's perspective, shipments are referenced with a UUID identifier.

## Get single shipment

### Get single shipment by identifier

To access a single shipment by using its string identifier, use the `ShipmentService::getShipmentByIdentifier` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/ShipmentCommand.php', 55, 64) =]]
```

### Get single shipment by id

To access a single shipment by using its numerical id, use the `ShipmentService::getShipment` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/ShipmentCommand.php', 43, 53) =]]
```

## Get multiple shipments

To fetch multiple shipments, use the `ShipmentService::findShipments` method.
It follows the same search query pattern as other APIs:

``` php
[[= include_file('code_samples/api/commerce/src/Command/ShipmentCommand.php', 66, 85) =]]
```

## Create shipment

To create a shipment, use the `ShipmentService::createShipment` method and provide it with an `Ibexa\Contracts\Shipping\Value\ShipmentCreateStruct` object that takes two parameters, a `shippingMethod` string and a `Money` object.

``` php
[[= include_file('code_samples/api/commerce/src/Command/ShipmentCommand.php', 87, 101) =]]
```

## Update shipment

You can update the shipment after it's created.
You could do it to support a scenario when, for example, the shipment is processed offline and its status has to be updated in the system.
To update shipment information, use the `ShipmentService::updateShipment` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/ShipmentCommand.php', 103, 114) =]]
```
## Delete shipment

To delete a shipment from the system, use the `ShipmentService::deleteShipment` method:


``` php
[[= include_file('code_samples/api/commerce/src/Command/ShipmentCommand.php', 116, 117) =]]
```
