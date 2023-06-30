---
description: Order Created Sort Clause
edition: commerce
---

# Order Created Sort Clause

The `Created` Sort Clause sorts search results by the date and time when the order was created.

## Arguments

- (optional) `sortDirection` - `Created` constant, either `Created::SORT_ASC` or `Created::SORT_DESC`

## Example

``` php
$orderQuery = new OrderQuery(
    $criteria,
    [
        new \Ibexa\Contracts\OrderManagement\Value\Order\Query\SortClause\Created(
            \Ibexa\Contracts\OrderManagement\Value\Order\Query\SortClause\Created::SORT_ASC)
    ]
);
```
