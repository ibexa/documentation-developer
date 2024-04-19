---
description: Payment Identifier Criterion
edition: commerce
---

# Payment Identifier Criterion

The `Identifier` Search Criterion searches for payments based on the payment identifier.

## Arguments

- `identifier` - string that represents the payment identifier

## Example

### PHP

``` php
$query->query = new \Ibexa\Contracts\Payment\Payment\Query\Criterion\Identifier('f7578972-e7f4-4cae-85dc-a7c74610204e');
```
