---
description: Shipment Status Search Criterion
edition: commerce
---

# Shipment Status Criterion

The `Status` Search Criterion searches for shipments based on shipment status.

## Arguments

- `status` - string that represents the status of the shipment, takes values defined in shipment processing workflow

## Example

### PHP

``` php
$query = new ShipmentQuery(
    new \Ibexa\Contracts\Shipping\Shipment\Query\Criterion\Status('pending')
);
```
