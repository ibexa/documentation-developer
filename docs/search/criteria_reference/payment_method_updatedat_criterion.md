---
description: Payment Method UpdatedAt Criterion
edition: commerce
---

# Payment Method UpdatedAt Criterion

The `UpdatedAt` Search Criterion searches for payment methods based on the date when their status was updated.

## Arguments

- `updatedAt` - date to be matched, provided as a `DateTimeInterface` object
- `operator` - optional operator string (EQ, GT, GTE, LT, LTE)

## Example

``` php
$criteria = new \Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\UpdatedAt(
    new DateTime('2023-03-01')
);
$query = new PaymentMethodQuery($criteria);
```
