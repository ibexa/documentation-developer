---
description: Payment Method LogicalAnd Criterion
edition: commerce
---

# Payment Method LogicalAnd Criterion

The `LogicalAnd` Search Criterion matches payment methods if all provided Criteria match.

## Arguments

- `criteria` - a set of Criteria combined by the logical operator

## Example

### PHP

``` php
$query->query = new \Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\LogicalAnd(
    [
        new \Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\CreatedAt(new DateTime('2023-03-01'));
        new \Ibexa\Contracts\Payment\PaymentMethod\Query\Criterion\Enabled(true);
    ]
);
```
