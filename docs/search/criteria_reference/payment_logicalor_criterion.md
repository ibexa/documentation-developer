---
description: Payment LogicalOr Criterion
edition: commerce
---

# Payment LogicalOr Criterion

The `LogicalOrCriterion` Search Criterion matches payments if at least one of the provided Criteria matches.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

``` php
$query->query = new Criterion\LogicalOrCriterion([
        new Criterion\CreatedAtCriterion(['2022-07-11T00:00:00+02:00', GT]),
        new Criterion\PaymentMethodCriterion(2);
    ]
);
```