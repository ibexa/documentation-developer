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
$orderQuery = new OrderQuery(
    null,
    $criteria,
    [
        new Id(Id::SORT_ASC)
    ]
);
```
