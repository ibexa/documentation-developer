# VisibilityTermAggregation

The [VisibilityTermAggregation](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Aggregation-VisibilityTermAggregation.html) aggregates search results by the Content item's visibility.

## Arguments

- `name` - name of the Aggregation object

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\VisibilityTermAggregation('visibility');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
