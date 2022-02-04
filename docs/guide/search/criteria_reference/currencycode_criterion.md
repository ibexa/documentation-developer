# CurrencyCode Criterion

The `CurrencyCode` Search Criterion searches for currencies by their codes.

## Arguments

- `code` - string representing the currency code.

## Limitations

The `CurrencyCode` Criterion is not available in Solr or Elasticsearch engines.

## Example

``` php
$query->query = new Ibexa\Contracts\ProductCatalog\Values\Currency\Query\Criterion\CurrencyCode('EUR');
```
