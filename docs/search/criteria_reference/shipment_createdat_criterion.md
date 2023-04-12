---
description: CreatedAt Criterion
edition: commerce
---

# Shipment CreatedAt Criterion

The `CreatedAtCriterion` Search Criterion searches for shipments based on the date when they were created.

## Arguments

- `createdAt` - date to be matched, provided as a `DateTimeInterface` object
- `operator` - optional operator constant (EQ, GT, GTE, LT, LTE)

## Example

``` php
$criteria = new Ibexa\Contracts\ShippingManagement\Value\Shipment\Query\Criterion\CreatedAtCriterion(
    '2022-07-11T00:00:00+02:00',
    Ibexa\Contracts\ShippingManagement\Value\Shipment\Query\Criterion\Operator::GTE
);

$query = new ShipmentQuery(null, $criteria);
```
