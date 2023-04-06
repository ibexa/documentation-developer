---
description: Order Status Sort Clause
edition: commerce
---

# Order Status Sort Clause

The `Status` Sort Clause sorts search results by order status.

## Arguments

- (optional) `sortDirection` - `Status` constant, either `Status::SORT_ASC` or `Status::SORT_DESC`

## Example

``` php
$orderQuery = new OrderQuery(
    null,
    $criteria,
    [
        new Status(Status::SORT_ASC)
    ]
);
```
