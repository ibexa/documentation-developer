---
description: Price LogicalAnd Criterion
edition: commerce
---

# Price LogicalAnd Criterion

The `LogicalAnd` Search Criterion matches prices if all provided Criteria match.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

### PHP

``` php
$query->query = new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\LogicalAnd(
    [
        new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\Currency('USD'),
        new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\IsCustomPrice('custom', 'customer_group_1')
    ]
);
```
