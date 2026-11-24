---
description: Shipment Id Search Criterion
edition: commerce
---

# Shipment Id Criterion

The `Id` Search Criterion searches for shipments based on the shipment ID.

## Arguments

- `id` - integer that represents the shipment ID

## Example

### PHP

``` php
use Ibexa\Contracts\Shipping\Shipment\Query\Criterion\Id;
use Ibexa\Contracts\Shipping\Shipment\ShipmentQuery;

$query = new ShipmentQuery(
    new Id(2)
);
```
