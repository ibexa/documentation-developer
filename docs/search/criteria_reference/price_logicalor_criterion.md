---
description: Price LogicalOr Criterion
edition: commerce
---

# Price LogicalOr Criterion

The `LogicalOr` Search Criterion matches prices if at least one of the provided Criteria matches.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

### PHP

``` php
$query->query = new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\LogicalOr(
    [
        new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\Currency('USD'),
        new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\Currency('EUR')
    ]
);
```
