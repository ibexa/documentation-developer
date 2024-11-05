---
description: Payment Method Name Criterion
edition: commerce
---

# Payment Method Name Criterion

The `Name` Search Criterion searches for payment methods based on the existing payment method name.

## Arguments

- `name` - string that represents the payment method name

## Example

### PHP

``` php
$query->query = new \Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\Name('Credit Card');
```
