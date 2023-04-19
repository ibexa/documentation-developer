---
description: Payment CreatedAt Sort Clause
edition: commerce
---

# Payment CreatedAt Sort Clause

The `CreatedAt` Sort Clause sorts search results by the date and time when the payment was initiated.

## Arguments

- (optional) `sortDirection` - `CreatedAt` constant, either `CreatedAt::SORT_ASC` or `CreatedAt::SORT_DESC`

## Example

``` php
$paymentQuery = new PaymentQuery(
    $criteria,
    [
        new \Ibexa\Contracts\Payment\Payment\Query\SortClause\CreatedAt(
            \Ibexa\Contracts\Payment\Payment\Query\SortClause\CreatedAt::SORT_ASC)
    ]
);
```
