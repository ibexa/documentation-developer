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
use Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodQuery;
use Ibexa\Contracts\Payment\PaymentMethod\Query\SortClause\Enabled;

$criteria = null;

$paymentMethodQuery = new PaymentMethodQuery(
    $criteria,
    [
        new Enabled(
            Enabled::SORT_DESC
        ),
    ]
);
```
