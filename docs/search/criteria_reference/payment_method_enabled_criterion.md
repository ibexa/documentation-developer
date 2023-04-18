---
description: Payment Method Enabled Criterion
edition: commerce
---

# Payment Method Enabled Criterion

The `Enabled` Search Criterion searches for payment methods based on whether the payment method is enabled or not.

## Arguments

- `value` - whether the payment method is enabled

## Example

``` php
$query->query = new Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\Enabled(true);
```