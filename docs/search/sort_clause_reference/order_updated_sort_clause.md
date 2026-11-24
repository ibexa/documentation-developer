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
use Ibexa\Contracts\OrderManagement\Value\Order\OrderQuery;
use Ibexa\Contracts\OrderManagement\Value\Order\Query\SortClause\Updated;

$criteria = null;

$orderQuery = new OrderQuery(
    $criteria,
    [
        new Updated(
            Updated::SORT_ASC
        ),
    ]
);
```
