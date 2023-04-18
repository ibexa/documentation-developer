---
description: Payment Method Id Criterion
edition: commerce
---

# Payment Method Id Criterion

The `Id` Search Criterion searches for payment methods based on the payment method ID.

## Arguments

- `id` - integer that represents the payment method ID

## Example

``` php
$query->query = new Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\Id(2);
```