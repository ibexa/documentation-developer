---
description: Order CustomerName Search Criterion
edition: commerce
---

# Order CustomerName Criterion

The `CustomerNameCriterion` Search Criterion searches for orders based on the name of the customer.

## Arguments

- `user_name` - string that represents a name of the customer

## Example

### PHP

``` php
$query = new OrderQuery(
    new \Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\CustomerNameCriterion('john')
);
```
