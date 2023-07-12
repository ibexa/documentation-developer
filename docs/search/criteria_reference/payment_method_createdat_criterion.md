---
description: Payment Method CreatedAt Criterion
edition: commerce
---

# Payment Method CreatedAt Criterion

The `CreatedAt` Search Criterion searches for payment methods based on the date when they were created.

## Arguments

- `createdAt` - date to be matched, provided as a `DateTimeInterface` object
- `operator` - optional operator string (EQ, GT, GTE, LT, LTE)

## Example

### PHP

``` php
$criteria = new \Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\CreatedAt(
    new DateTime('2023-03-01')
);
$query = new PaymentMethodQuery($criteria);
```
