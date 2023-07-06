---
description: Payment LogicalOr Criterion
edition: commerce
---

# Payment LogicalOr Criterion

The `LogicalOr` Search Criterion matches payments if at least one of the provided Criteria matches.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

### PHP

``` php
$query->query = new Criterion\LogicalOr(
    [
        new \Ibexa\Contracts\Payment\Payment\Query\Criterion\CreatedAt(new DateTime('2023-03-01'));
        new \Ibexa\Contracts\Payment\Payment\Query\Criterion\Currency('USD');
    ]
);
```
