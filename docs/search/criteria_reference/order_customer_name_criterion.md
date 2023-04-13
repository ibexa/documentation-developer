---
description: Order CustomerName Criterion
edition: commerce
---

# Order CustomerName Criterion

The `CustomerNameCriterion` Search Criterion searches for orders based on the name of the customer.

## Arguments

- `user_name` - string that represents a name of the customer

## Example

``` php
$query->query = new Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\CustomerNameCriterion('john');
```
