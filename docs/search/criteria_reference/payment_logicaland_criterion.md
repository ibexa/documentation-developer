---
description: Payment LogicalAnd Criterion
edition: commerce
---

# Payment LogicalAnd Criterion

The `LogicalAnd` Search Criterion matches payments if all provided Criteria match.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

``` php
$query->query = new Criterion\LogicalAnd([
        new Criterion\CreatedAt(['2022-07-11T00:00:00+02:00', LT]),
        new Criterion\PaymentMethod(1);
    ]
);
```