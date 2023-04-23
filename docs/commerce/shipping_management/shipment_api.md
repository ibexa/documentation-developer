---
description: Use PHP API to manage shipments n Commerce: create, update and delete shipments.
edition: commerce
---

# Shipment API

!!! tip "Shipping management REST API"

    To learn how to manage shipments with the REST API, see the [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-shipping).

To get shipments and manage them, use the `Ibexa\Contracts\ShippingManagement\ShipmentServiceInterface` interface.

## Get single shipment 

### Get single shipment by identifier

To access a single shipment by using its string identifier, use the `ShipmentService::getShipmentByIdentifier` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/ShipmentCommand.php', 56, 60) =]]
```

### Get single shipment by id

To access a single shipment by using its numerical id, use the `ShipmentService::getShipment` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/ShipmentCommand.php', 50, 54) =]]
```

## Get multiple shipments

To fetch multiple shipments, use the `ShipmentService::findShipments` method. 
It follows the same search query pattern as other APIs:

``` php
[[= include_file('code_samples/api/commerce/src/Command/ShipmentCommand.php', 62, 79) =]]
```

## Create shipment

To create a shipment, use the `ShipmentService::createShipment` method and provide it with 
the `Ibexa\Contracts\Checkout\Value\ShipmentCreateStruct` object that passes two parameters, the `shippingMethod` string and `Money` object.

``` php
[[= include_file('code_samples/api/commerce/src/Command/ShipmentCommand.php', 81, 90) =]]
```

## Update shipment

You can update the shipment after it is created. 
You could do it to support a scenario when, for example, the shipment is processed offline and its status has to be updated in the system. 
To update shipment information, use the `ShipmentService::updateShipment` method:

``` php
[[= include_file('code_samples/api/commerce/src/Command/ShipmentCommand.php', 92, 98) =]]
```
## Delete shipment

To delete a shipment from the system, use the ``ShipmentService::deleteShipment` method:


``` php
[[= include_file('code_samples/api/commerce/src/Command/ShipmentCommand.php', 100, 103) =]]
```