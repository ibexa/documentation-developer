---
description: Payment CreatedAt Criterion
edition: commerce
---

# Payment CreatedAt Criterion

The `CreatedAtCriterion` Search Criterion searches for payments based on the date when they were initiated.

## Arguments

- `createdAt` - date to be matched, provided as a `DateTimeInterface` object
- `operator` - optional operator constant (EQ, GT, GTE, LT, LTE)

## Example

``` php
$criteria = new Ibexa\Contracts\Payment\Value\Payment\Query\Criterion\CreatedAtCriterion(
    '2022-07-11T00:00:00+02:00',
    Ibexa\Contracts\Payment\Value\Payment\Query\Criterion\Operator::GTE
);
$query = new PaymentQuery(null, $criteria);
```