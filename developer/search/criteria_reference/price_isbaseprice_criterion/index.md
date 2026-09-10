# Price IsBasePrice Criterion

Price IsBasePrice Search Criterion

The `IsBasePrice` Search Criterion searches for prices that are base prices.

## Arguments

This Criterion takes no arguments.

## Limitations

The `IsBasePrice` Criterion isn't available in Solr or Elasticsearch engines.

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\ProductCatalog\Values\Price\PriceQuery;

$query = new PriceQuery(
    new \Ibexa\Contracts\ProductCatalog\Values\Price\Query\Criterion\IsBasePrice()
);
```
