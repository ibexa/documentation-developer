# VisibilityTermAggregation

The [VisibilityTermAggregation](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Aggregation/VisibilityTermAggregation.php) aggregates search results by the Content item's visibility.

## Arguments

- `name` - name of the Aggregation object

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\VisibilityTermAggregation('visibility');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
