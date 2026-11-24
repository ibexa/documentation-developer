---
description: Price LogicalAnd Search Criterion
edition: commerce
---

# Price LogicalAnd Criterion

The `LogicalAnd` Search Criterion matches prices if all provided Criteria match.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

### PHP

``` php
use Ibexa\Contracts\ProductCatalog\Values\CurrencyInterface;
use Ibexa\Contracts\ProductCatalog\Values\Price\PriceQuery;
use Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\Currency;
use Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\IsCustomPrice;
use Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\LogicalAnd;

/** @var CurrencyInterface $currencyUSD */
$query = new PriceQuery(
    new LogicalAnd(
        new Currency($currencyUSD),
        new IsCustomPrice()
    )
);
```
