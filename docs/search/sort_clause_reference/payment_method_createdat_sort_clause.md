---
description: Payment Method CreatedAt Sort Clause
edition: commerce
---

# Payment Method CreatedAt Sort Clause

The `CreatedAt` Sort Clause sorts search results by the date and time when the payment method was created.

## Arguments

- (optional) `sortDirection` - `CreatedAt` constant, either `CreatedAt::SORT_ASC` or `CreatedAt::SORT_DESC`

## Example

``` php
$paymentMethodQuery = new PaymentMethodQuery(
    $criteria,
    [
        new \Ibexa\Contracts\Payment\PaymentMethod\Query\SortClause\CreatedAt(
            \Ibexa\Contracts\Payment\PaymentMethod\Query\SortClause\CreatedAt::SORT_ASC)
    ]
);
```
