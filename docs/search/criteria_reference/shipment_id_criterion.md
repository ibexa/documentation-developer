---
description: Shipment Id Criterion
edition: commerce
---

# Shipment Id Criterion

The `Id` Search Criterion searches for shipments based on the shipment ID.

## Arguments

- `id` - integer that represents the shipment ID

## Example

### PHP

``` php
$query = new ShipmentQuery( 
    new \Ibexa\Contracts\Shipping\Shipment\Query\Criterion\Id(2)
);
```
