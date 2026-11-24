---
description: Payment Method Id Search Criterion
edition: commerce
---

# Payment Method Id Criterion

The `Id` Search Criterion searches for payment methods based on the payment method ID.

## Arguments

- `id` - integer that represents the payment method ID

## Example

### PHP

``` php
use Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodQuery;
use Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\Id;

$query = new PaymentMethodQuery(
    new Id(2)
);
```
