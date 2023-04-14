---
description: Payment Status Criterion
edition: commerce
---

# Payment Status Criterion

The `StatusCriterion` Search Criterion searches for payments based on payment status.

## Arguments

- `status` - string that represents the status of the payment, takes values defined in payment processing workflow

## Example

``` php
$query->query = new Ibexa\Contracts\Payment\Value\Payment\Query\Criterion\StatusCriterion('failed');
```