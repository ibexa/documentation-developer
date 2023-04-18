---
description: Payment UpdatedAt Criterion
edition: commerce
---

# Payment UpdatedAt Criterion

The `UpdatedAt` Search Criterion searches for payments based on the date when their status was updated.

## Arguments

- `UpdatedAt` - date to be matched, provided as a `DateTimeInterface` object
- `operator` - optional operator constant (EQ, GT, GTE, LT, LTE)

## Example

``` php
$criteria = new Ibexa\Contracts\Payment\Value\Payment\Query\Criterion\UpdatedAt(
    '2022-07-11T00:00:00+02:00',
    Ibexa\Contracts\Payment\Value\Payment\Query\Criterion\Operator::GTE
);
$query = new PaymentQuery(null, $criteria);
```