---
description: Order Status Search Criterion
edition: commerce
---

# Order Status Criterion

The `StatusCriterion` Search Criterion searches for orders based on order status.

## Arguments

- `status` - string that represents the status of the order, takes values defined in order management workflow

## Example

### PHP

``` php
use Ibexa\Contracts\OrderManagement\Value\Order\OrderQuery;
use Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\StatusCriterion;

$query = new OrderQuery(
    new StatusCriterion('pending')
);
```
