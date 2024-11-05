# IsCurrencyEnabledCriterion Criterion

The `IsCurrencyEnabledCriterion` Search Criterion searches for currencies that are enabled in the system.

## Arguments

- (optional) `enabled` - bool representing whether to search for enabled (default `true`),
or disabled Currencies (`false`)

## Limitations

The `IsCurrencyEnabledCriterion` Criterion is not available in Solr or Elasticsearch engines.

## Example

### PHP

``` php
$query->query = new \Ibexa\Contracts\ProductCatalog\Values\Currency\Query\Criterion\IsCurrencyEnabledCriterion();
```
