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
    null,
    $criteria,
    [
        new Created(Created::SORT_ASC)
    ]
);
```
