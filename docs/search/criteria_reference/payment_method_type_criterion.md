---
description: Payment Method Type Search Criterion
edition: commerce
---

# Payment Method Type Criterion

The `Type` Search Criterion searches for payment methods based on payment method type.

## Arguments

- `type` - string that represents a payment method type

## Example

### PHP

``` php
$query->query = new \Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\Type('offline');
```
