---
description: Payment Id Search Criterion
edition: commerce
---

# Payment Id Criterion

The `Id` Search Criterion searches for payments based on the payment ID.

## Arguments

- `id` - integer that represents the payment ID

## Example

### PHP

``` php
use Ibexa\Contracts\Payment\Payment\PaymentQuery;
use Ibexa\Contracts\Payment\Payment\Query\Criterion\Id;

$query = new PaymentQuery(
    new Id(2)
);
```
