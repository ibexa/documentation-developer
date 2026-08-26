# Price LogicalAnd Criterion

Price LogicalAnd Search Criterion

Editions: Commerce

The `LogicalAnd` Search Criterion matches prices if all provided Criteria match.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

### PHP

```php
use Ibexa\Contracts\ProductCatalog\Values\Price\PriceQuery;

/** @var \Ibexa\Contracts\ProductCatalog\Values\CurrencyInterface $currencyUSD */
$query = new PriceQuery(
    new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\LogicalAnd(
        new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\Currency($currencyUSD),
        new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\IsCustomPrice()
    )
);
```
