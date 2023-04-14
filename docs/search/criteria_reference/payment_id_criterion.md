---
description: Payment Id Criterion
edition: commerce
---

# Payment Id Criterion

The `IdCriterion` Search Criterion searches for payments based on the payment ID.

## Arguments

- `id` - integer that represents the payment ID

## Example

``` php
$query->query = new Ibexa\Contracts\Payment\Value\Payment\Query\Criterion\IdCriterion(2);
```