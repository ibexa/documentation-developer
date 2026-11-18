---
description: Payment Status Sort Clause
edition: commerce
---

# Payment Status Sort Clause

The `Status` Sort Clause sorts search results by payment status.

## Arguments

- (optional) `sortDirection` - `Status` constant, either `Status::SORT_ASC` or `Status::SORT_DESC`

## Example

``` php
use Ibexa\Contracts\Payment\Payment\PaymentQuery;
use Ibexa\Contracts\Payment\Payment\Query\SortClause\Status;

$criteria = null;

$paymentQuery = new PaymentQuery(
    $criteria,
    [
        new Status(
            Status::SORT_ASC
        ),
    ]
);
```
