---
description: Payment Method LogicalOr Criterion
edition: commerce
---

# Payment Method LogicalOr Criterion

The `LogicalOr` Search Criterion matches payment methods if at least one of the provided Criteria matches.

## Arguments

- `criteria` - a set of Criteria combined by the logical operator

## Example

### PHP

``` php
$query->query = new \Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\LogicalOr(
    [
        new \Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\CreatedAt(new DateTime('2023-03-01'));
        new \Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\CreatedAt(new DateTime('2023-05-01'));
    ]
);
```
