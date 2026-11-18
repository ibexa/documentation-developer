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
use Ibexa\Contracts\Payment\PaymentMethod\PaymentMethodQuery;
use Ibexa\Contracts\Payment\PaymentMethod\Query\SortClause\Identifier;

$criteria = null;

$paymentMethodQuery = new PaymentMethodQuery(
    $criteria,
    [
        new Identifier(
            Identifier::SORT_ASC
        ),
    ]
);
```
