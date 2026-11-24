---
description: Payment CreatedAt Sort Clause
edition: commerce
---

# Payment CreatedAt Sort Clause

The `CreatedAt` Sort Clause sorts search results by the date and time when the payment was created.

## Arguments

- (optional) `sortDirection` - `CreatedAt` constant, either `CreatedAt::SORT_ASC` or `CreatedAt::SORT_DESC`

## Example

``` php
use Ibexa\Contracts\Payment\Payment\PaymentQuery;
use Ibexa\Contracts\Payment\Payment\Query\SortClause\CreatedAt;

$criteria = null;

$paymentQuery = new PaymentQuery(
    $criteria,
    [
        new CreatedAt(
            CreatedAt::SORT_ASC
        ),
    ]
);
```
