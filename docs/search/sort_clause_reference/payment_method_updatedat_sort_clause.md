---
description: Payment Method UpdatedAt Sort Clause
edition: commerce
---

# Payment Method UpdatedAt Sort Clause

The `UpdatedAt` Sort Clause sorts search results by the date and time when payment method status was updated.

## Arguments

- (optional) `sortDirection` - `UpdatedAt` constant, either `UpdatedAt::SORT_ASC` or `UpdatedAt::SORT_DESC`

## Example

``` php
$paymentMethodQuery = new PaymentMethodQuery(
    $criteria,
    [
        new \Ibexa\Contracts\Payment\PaymentMethod\Query\SortClause\UpdatedAt(
            \Ibexa\Contracts\Payment\PaymentMethod\Query\SortClause\UpdatedAt::SORT_DESC)
    ]
);
```
