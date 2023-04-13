---
description: Shipment UpdatedAt Criterion
edition: commerce
---

# Shipment UpdatedAt Criterion

The `UpdatedAtCriterion` Search Criterion searches for shipments based on the date when their status was updated.

## Arguments

- `updatedAt` - date to be matched, provided as a `DateTimeInterface` object
- `operator` - optional operator constant (EQ, GT, GTE, LT, LTE)

## Example

``` php
$criteria = new Ibexa\Contracts\ShippingManagement\Value\Shipment\Query\Criterion\UpdatedAtCriterion(
    '2021-12-06T13:00:00+00:00',
    Ibexa\Contracts\ShippingManagement\Value\Shipment\Query\Criterion\Operator::GTE
);

$query = new ShipmentQuery(null, $criteria);
```
