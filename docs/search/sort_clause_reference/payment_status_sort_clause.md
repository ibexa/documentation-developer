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
$paymentQuery = new PaymentQuery(
    null,
    $criteria,
    [
        new Status(Status::SORT_ASC)
    ]
);
```
