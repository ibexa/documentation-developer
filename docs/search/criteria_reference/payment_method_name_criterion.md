---
description: Payment Method Name Search Criterion
edition: commerce
---

# Payment Method Name Criterion

The `Name` Search Criterion searches for payment methods based on the existing payment method name.

## Arguments

- `name` - string that represents the payment method name

## Example

### PHP

``` php
use Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodQuery;
use Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\Name;

$query = new PaymentMethodQuery(
    new Name('Credit Card')
);
```
