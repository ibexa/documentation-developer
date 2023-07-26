---
description: Payment Method Identifier Sort Clause
edition: commerce
---

# Payment Method Identifier Sort Clause

The `Identifier` Sort Clause sorts search results by payment method identifier.

## Arguments

- (optional) `sortDirection` - `Identifier` constant, either `Identifier::SORT_ASC` or `Identifier::SORT_DESC`

## Example

``` php
$paymentMethodQuery = new PaymentMethodQuery(
    $criteria,
    [
        new \Ibexa\Contracts\Payment\PaymentMethod\Query\SortClause\Identifier(
            \Ibexa\Contracts\Payment\PaymentMethod\Query\SortClause\Identifier::SORT_ASC)
    ]
);
```
