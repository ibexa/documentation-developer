# CurrencyCode Criterion

CurrencyCode Search Criterion

The `CurrencyCodeCriterion` Search Criterion searches for currencies by their codes.

## Arguments

- `code` - string representing the currency code

## Limitations

The `CurrencyCodeCriterion` Criterion isn't available in Solr or Elasticsearch engines.

## Example

### PHP

```php
use Ibexa\Contracts\ProductCatalog\Values\Currency\CurrencyQuery;

$query = new CurrencyQuery(
    new \Ibexa\Contracts\ProductCatalog\Values\Currency\Query\Criterion\CurrencyCodeCriterion('EUR')
);
```
