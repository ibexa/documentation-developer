---
description: Payment Identifier Sort Clause
edition: commerce
---

# Payment Identifier Sort Clause

The `Identifier` Sort Clause sorts search results by payment identifier.

## Arguments

- (optional) `sortDirection` - `Identifier` constant, either `Identifier::SORT_ASC` or `Identifier::SORT_DESC`

## Example

``` php
$paymentQuery = new PaymentQuery(
    $criteria,
    [
        new \Ibexa\Contracts\Payment\Payment\Query\SortClause\Identifier(
            \Ibexa\Contracts\Payment\Payment\Query\SortClause\Identifier::SORT_ASC)
    ]
);
```
