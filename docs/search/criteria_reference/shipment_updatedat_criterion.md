---
description: Shipment UpdatedAt Criterion
edition: commerce
---

# Shipment UpdatedAt Criterion

The `UpdatedAt` Search Criterion searches for shipments based on the date when their status was updated.

## Arguments

- `updatedAt` - date to be matched, provided as a `DateTimeInterface` object
- `operator` - optional operator string (EQ, GT, GTE, LT, LTE)

## Example

``` php
$criteria = new \Ibexa\Contracts\Checkout\Shipment\Query\Criterion\UpdatedAt(
    new DateTime('2023-03-01'),
    'GTE'
);

$query = new ShipmentQuery($criteria);
```
