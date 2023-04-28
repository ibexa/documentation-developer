---
description: Order Status Criterion
edition: commerce
---

# Order Status Criterion

The `StatusCriterion` Search Criterion searches for orders based on order status.

## Arguments

- `status` - string that represents the status of the order, takes values defined in order management workflow

## Example

``` php
$query = new OrderQuery(
    new \Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\StatusCriterion('pending')
);
```
