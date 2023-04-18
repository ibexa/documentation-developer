---
description: Payment Method LogicalAnd Criterion
edition: commerce
---

# Payment Method LogicalAnd Criterion

The `LogicalAnd` Search Criterion matches payment methods if all provided Criteria match.

## Arguments

- `criteria` - a set of Criteria combined by the logical operator

## Example

``` php
$query->query = new Criterion\LogicalAnd([
        new Criterion\CreatedAt(['2022-07-10T00:00:00+02:00', GT]),
        new Criterion\CreatedAt(['2022-07-15T00:00:00+02:00', LT]);
    ]
);
```