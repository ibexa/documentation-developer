---
description: Payment Method UpdatedAt Criterion
edition: commerce
---

# Payment Method UpdatedAt Criterion

The `UpdatedAt` Search Criterion searches for payment methods based on the date when their status was updated.

## Arguments

- `UpdatedAt` - date to be matched, provided as a `DateTimeInterface` object
- `operator` - optional operator constant (EQ, GT, GTE, LT, LTE)

## Example

``` php
$criteria = new Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\UpdatedAt(
    '2022-07-11T00:00:00+02:00',
    Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\Operator::GTE
);
$query = new PaymentMethodQuery(null, $criteria);
```