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
    null,
    $criteria,
    [
        new Identifier(Identifier::SORT_ASC)
    ]
);
```
