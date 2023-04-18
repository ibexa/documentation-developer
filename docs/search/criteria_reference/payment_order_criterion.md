---
description: Payment Order Criterion
edition: commerce
---

# Payment Order Criterion

The `Order` Search Criterion searches for payments based on an ID of an associated order.

## Arguments

- `Order_id` - integer that represents an ID of an associated order

## Example

``` php
$query->query = new Ibexa\Contracts\Payment\Value\Payment\Query\Criterion\Order(4);
```