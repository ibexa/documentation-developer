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
use Ibexa\Contracts\ProductCatalog\Values\CurrencyInterface;
use Ibexa\Contracts\ProductCatalog\Values\Price\PriceQuery;
use Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\Currency;
use Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\LogicalOr;

/**
 * @var CurrencyInterface $currencyUSD
 * @var CurrencyInterface $currencyEUR
 */
$query = new PriceQuery(
    new LogicalOr(
        new Currency($currencyUSD),
        new Currency($currencyEUR)
    )
);
```
