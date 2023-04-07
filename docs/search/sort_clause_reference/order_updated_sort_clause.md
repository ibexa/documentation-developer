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
    null,
    $criteria,
    [
        new Updated(Updated::SORT_ASC)
    ]
);
```
