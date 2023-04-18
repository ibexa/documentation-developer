---
description: Payment Method Id Sort Clause
edition: commerce
---

# Payment Method Id Sort Clause

The `Id` Sort Clause sorts search results by payment method ID.

## Arguments

- (optional) `sortDirection` - `Id` constant, either `Id::SORT_ASC` or `Id::SORT_DESC`

## Example

``` php
$paymentMethodQuery = new PaymentMethodQuery(
    null,
    $criteria,
    [
        new Id(Id::SORT_ASC)
    ]
);
```
