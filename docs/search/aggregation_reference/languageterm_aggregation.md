# LanguageTermAggregation

The [LanguageTermAggregation](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Aggregation/LanguageTermAggregation.php) aggregates search results by the Content item's language.

## Arguments

- `name` - name of the Aggregation object

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\LanguageTermAggregation('language');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
