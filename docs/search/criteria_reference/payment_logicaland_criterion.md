---
description: Payment LogicalAnd Criterion
edition: commerce
---

# Payment LogicalAnd Criterion

The `LogicalAndCriterion` Search Criterion matches payments if all provided Criteria match.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

``` php
$query->query = new Criterion\LogicalAndCriterion([
        new Criterion\CreatedAtCriterion(['2022-07-11T00:00:00+02:00', LT]),
        new Criterion\PaymentMethodCriterion(1);
    ]
);
```