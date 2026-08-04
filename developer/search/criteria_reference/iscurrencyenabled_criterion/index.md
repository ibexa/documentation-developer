# IsCurrencyEnabledCriterion Criterion

IsCurrencyEnabledCriterion Search Criterion

The `IsCurrencyEnabledCriterion` Search Criterion searches for currencies that are enabled in the system.

## Arguments

- (optional) `enabled` - bool representing whether to search for enabled (default `true`), or disabled Currencies (`false`)

## Limitations

The `IsCurrencyEnabledCriterion` Criterion isn't available in Solr or Elasticsearch engines.

## Example

### PHP

```php
use Ibexa\Contracts\ProductCatalog\Values\Currency\CurrencyQuery;

$query = new CurrencyQuery(
    new \Ibexa\Contracts\ProductCatalog\Values\Currency\Query\Criterion\IsCurrencyEnabledCriterion()
);
```
