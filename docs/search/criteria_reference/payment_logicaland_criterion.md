---
description: Payment LogicalAnd Criterion
edition: commerce
---

# Payment LogicalAnd Criterion

The `LogicalAnd` Search Criterion matches payments if all provided Criteria match.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

### PHP

``` php
$query->query = new \Ibexa\Contracts\Payment\Payment\Query\Criterion\LogicalAnd(
    [
        new \Ibexa\Contracts\Payment\Payment\Query\Criterion\CreatedAt(new DateTime('2023-03-01'));
        new \Ibexa\Contracts\Payment\Payment\Query\Criterion\Currency('USD');
    ]
);
```
