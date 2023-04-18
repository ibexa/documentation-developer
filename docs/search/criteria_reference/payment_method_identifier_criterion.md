---
description: Payment Method Identifier Criterion
edition: commerce
---

# Payment Method Identifier Criterion

The `Identifier` Search Criterion searches for payment methods based on the payment method identifier.

## Arguments

- `identifier` - string that represents the payment method identifier

## Example

``` php
$query->query = new Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\Identifier('f7578972-e7f4-4cae-85dc-a7c74610204e');
```