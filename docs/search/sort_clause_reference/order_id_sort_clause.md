---
description: Order Id Sort Clause
edition: commerce
---

# Order Id Sort Clause

The `Id` Sort Clause sorts search results by order Id.

## Arguments

- (optional) `sortDirection` - `Id` constant, either `Id::SORT_ASC` or `Id::SORT_DESC`

## Example

``` php
use Ibexa\Contracts\OrderManagement\Value\Order\OrderQuery;

$criteria = null;

$orderQuery = new OrderQuery(
    $criteria,
    [
        new \Ibexa\Contracts\OrderManagement\Value\Order\Query\SortClause\Id(
            \Ibexa\Contracts\OrderManagement\Value\Order\Query\SortClause\Id::SORT_ASC
        ),
    ]
);
```
