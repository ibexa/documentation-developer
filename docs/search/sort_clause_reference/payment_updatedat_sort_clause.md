---
description: Payment UpdatedAt Sort Clause
edition: commerce
---

# Payment UpdatedAt Sort Clause

The `UpdatedAt` Sort Clause sorts search results by the date and time when payment status was updated.

## Arguments

- (optional) `sortDirection` - `UpdatedAt` constant, either `UpdatedAt::SORT_ASC` or `UpdatedAt::SORT_DESC`

## Example

``` php
$paymentQuery = new PaymentQuery(
    null,
    $criteria,
    [
        new UpdatedAt(UpdatedAt::SORT_ASC)
    ]
);
```
