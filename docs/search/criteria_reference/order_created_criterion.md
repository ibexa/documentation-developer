---
description: Order CreatedAt Criterion
edition: commerce
---

# Order CreatedAt Criterion

The `CreatedAtCriterion` Search Criterion searches for orders based on the date when they were created.

## Arguments

- `createdAt` - date to be matched, provided as a `DateTimeInterface` object
- `operator` - optional operator string (EQ, GT, GTE, LT, LTE)

## Example

### PHP

``` php
$criteria = new \Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\CreatedAtCriterion(
    new DateTime('2023-03-01'),
    'GTE'
);

$orderQuery = new OrderQuery($criteria);
```
