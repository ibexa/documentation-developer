---
description: CreatedAt Criterion
edition: commerce
---

# Order CreatedAt Criterion

The `CreatedAtCriterion` Search Criterion searches for orders based on the date when they were created.

## Arguments

- `createdAt` - date to be matched, provided as a `DateTimeInterface` object
- `operator` - optional operator constant (EQ, GT, GTE, LT, LTE)

## Example

``` php
$criteria = new Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\CreatedAtCriterion(
    '2022-07-11T00:00:00+02:00',
    Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\Operator::GTE
);

$orderQuery = new OrderQuery(null, $criteria);
```
