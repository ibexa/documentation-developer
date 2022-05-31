# CurrencyCode Criterion

The `CurrencyCodeCriterion` Search Criterion searches for currencies by their codes.

## Arguments

- `code` - string representing the currency code.

## Limitations

The `CurrencyCodeCriterion` Criterion is not available in Solr or Elasticsearch engines.

## Example

``` php
$query->query = new \Ibexa\Contracts\ProductCatalog\Values\Currency\Query\Criterion\CurrencyCodeCriterion('EUR');
```
