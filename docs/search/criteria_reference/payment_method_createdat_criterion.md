---
description: Payment Method CreatedAt Criterion
edition: commerce
---

# Payment Method CreatedAt Criterion

The `CreatedAt` Search Criterion searches for payment methods based on the date when they were created.

## Arguments

- `createdAt` - date to be matched, provided as a `DateTimeInterface` object
- `operator` - optional operator constant (EQ, GT, GTE, LT, LTE)

## Example

``` php
$criteria = new Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\CreatedAt(
    '2022-07-11T00:00:00+02:00',
    Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\Operator::GTE
);
$query = new PaymentMethodQuery(null, $criteria);
```