---
description: Payment Id Sort Clause
edition: commerce
---

# Payment Id Sort Clause

The `Id` Sort Clause sorts search results by payment ID.

## Arguments

- (optional) `sortDirection` - `Id` constant, either `Id::SORT_ASC` or `Id::SORT_DESC`

## Example

``` php
$paymentQuery = new PaymentQuery(
    null,
    $criteria,
    [
        new Id(Id::SORT_ASC)
    ]
);
```
