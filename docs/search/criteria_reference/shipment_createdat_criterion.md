---
description: Shipment CreatedAt Search Criterion
edition: commerce
---

# Shipment CreatedAt Criterion

The `CreatedAt` Search Criterion searches for shipments based on the date when they were created.

## Arguments

- `createdAt` - date to be matched, provided as a `DateTimeInterface` object
- `operator` - optional operator string (EQ, GT, GTE, LT, LTE)

## Example

### PHP

``` php
$criteria = new \Ibexa\Contracts\Shipping\Shipment\Query\Criterion\CreatedAt(
    new DateTime('2023-03-01 14:07:02'),
    'GTE'
);

$query = new ShipmentQuery($criteria);
```
