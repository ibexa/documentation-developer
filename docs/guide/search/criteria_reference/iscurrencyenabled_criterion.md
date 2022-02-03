# IsCurrencyEnabled Criterion

The `IsCurrencyEnabled` Search Criterion searches for currencies that are enabled in the system.

## Limitations

The `IsCurrencyEnabled` Criterion is not available in Solr or Elasticsearch engines.

## Example

``` php
$query->query = new Ibexa\Contracts\ProductCatalog\Values\Currency\Query\Criterion\IsCurrencyEnabled();
```
