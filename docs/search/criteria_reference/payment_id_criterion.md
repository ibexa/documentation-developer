---
description: Payment Id Criterion
edition: commerce
---

# Payment Id Criterion

The `Id` Search Criterion searches for payments based on the payment ID.

## Arguments

- `id` - integer that represents the payment ID

## Example

``` php
$query->query = new \Ibexa\Contracts\Payment\Payment\Query\Criterion\Id(2);
```
