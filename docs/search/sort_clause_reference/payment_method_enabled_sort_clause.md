---
description: Payment Method Enabled Sort Clause
edition: commerce
---

# Payment Method Enabled Sort Clause

The `Enabled` Sort Clause sorts search results by payment method status.

## Arguments

- (optional) `sortDirection` - `Enabled` constant, either `Enabled::SORT_ASC` or `Enabled::SORT_DESC`

## Example

``` php
$paymentMethodQuery = new PaymentMethodQuery(
    null,
    $criteria,
    [
        new Enabled(Enabled::SORT_DESC)
    ]
);
```
