---
description: Payment Status Criterion
edition: commerce
---

# Payment Status Criterion

The `Status` Search Criterion searches for payments based on payment status.

## Arguments

- `status` - string that represents the status of the payment, takes values defined in payment processing workflow

## Example

### PHP

``` php
$query->query = new \Ibexa\Contracts\Payment\Payment\Query\Criterion\Status('failed');
```
