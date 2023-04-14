---
description: Payment PaymentMethod Criterion
edition: commerce
---

# Payment PaymentMethod Criterion

The `PaymentMethodCriterion` Search Criterion searches for payments based on a payment method applied to them.

## Arguments

- `method_id` - integer that represents an ID of the payment method that you want to match

## Example

``` php
$query->query = new Ibexa\Contracts\Payment\Value\Payment\Query\Criterion\PaymentMethodCriterion(2);
```