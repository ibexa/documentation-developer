---
description: Order Updated Sort Clause
edition: commerce
---

# Order Updated Sort Clause

The `Updated` Sort Clause sorts search results by the date and time when order status was updated.

## Arguments

- (optional) `sortDirection` - `Updated` constant, either `Updated::SORT_ASC` or `Updated::SORT_DESC`

## Example

``` php
$orderQuery = new OrderQuery(
    $criteria,
    [
        new \Ibexa\Contracts\OrderManagement\Value\Order\Query\SortClause\Updated(
            \Ibexa\Contracts\OrderManagement\Value\Order\Query\SortClause\Updated::SORT_ASC)
    ]
);
```
