---
description: Payment Method LogicalOr Criterion
edition: commerce
---

# Payment Method LogicalOr Criterion

The `LogicalOr` Search Criterion matches payment methods if at least one of the provided Criteria matches.

## Arguments

- `criteria` - a set of Criteria combined by the logical operator

## Example

``` php
$query->query = new Criterion\LogicalOr([
        new Criterion\CreatedAt(['2022-07-11T00:00:00+02:00', GT]),
        new Criterion\Enabled(1);
    ]
);
```