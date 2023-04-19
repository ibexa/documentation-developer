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
    $criteria,
    [
        new \Ibexa\Contracts\Payment\Payment\Query\SortClause\Id(
            \Ibexa\Contracts\Payment\Payment\Query\SortClause\Id::SORT_ASC)
    ]
);
```
