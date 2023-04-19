---
description: Shipment CreatedAt Criterion
edition: commerce
---

# Shipment CreatedAt Criterion

The `CreatedAtCriterion` Search Criterion searches for shipments based on the date when they were created.

## Arguments

- `createdAt` - date to be matched, provided as a `DateTimeInterface` object
- `operator` - optional operator constant (EQ, GT, GTE, LT, LTE)

## Example

``` php
$criteria = new \Ibexa\Contracts\Checkout\Shipment\Query\Criterion\CreatedAt(
    new DateTime('2023-03-01'),
    'GTE'
);

$query = new ShipmentQuery($criteria);
```
