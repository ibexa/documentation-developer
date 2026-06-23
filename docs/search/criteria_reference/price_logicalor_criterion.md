---
description: Price LogicalOr Search Criterion
edition: commerce
---

# Price LogicalOr Criterion

The `LogicalOr` Search Criterion matches prices if at least one of the provided Criteria matches.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

### PHP

``` php
use Ibexa\Contracts\ProductCatalog\Values\Price\PriceQuery;

/** @var \Ibexa\Contracts\ProductCatalog\Values\CurrencyInterface $currencyUSD */
/** @var \Ibexa\Contracts\ProductCatalog\Values\CurrencyInterface $currencyEUR */
$query = new PriceQuery(
    new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\LogicalOr(
        new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\Currency($currencyUSD),
        new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\Currency($currencyEUR)
    )
);
```
