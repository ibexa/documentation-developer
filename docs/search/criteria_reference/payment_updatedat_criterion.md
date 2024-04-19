---
description: Payment UpdatedAt Criterion
edition: commerce
---

# Payment UpdatedAt Criterion

The `UpdatedAt` Search Criterion searches for payments based on the date when their status was updated.

## Arguments

- `updatedAt` - date to be matched, provided as a `DateTimeInterface` object
- `operator` - optional operator string (EQ, GT, GTE, LT, LTE)

## Example

### PHP

``` php
$criteria = new \Ibexa\Contracts\Payment\Payment\Query\Criterion\UpdatedAt(
    new DateTime('2023-03-01')
);
$query = new PaymentQuery($criteria);
```
