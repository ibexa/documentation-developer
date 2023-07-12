---
description: Payment CreatedAt Criterion
edition: commerce
---

# Payment CreatedAt Criterion

The `CreatedAt` Search Criterion searches for payments based on the date when they were created.

## Arguments

- `createdAt` - date to be matched, provided as a `DateTimeInterface` object
- `operator` - optional operator string (EQ, GT, GTE, LT, LTE)

## Example

### PHP

``` php
$criteria = new \Ibexa\Contracts\Payment\Payment\Query\Criterion\CreatedAt(
    new DateTime('2023-03-01')
);
$query = new PaymentQuery($criteria);
```
