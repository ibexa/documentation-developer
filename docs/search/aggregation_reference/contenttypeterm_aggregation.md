# ContentTypeTermAggregation

The [ContentTypeTermAggregation](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Aggregation/ContentTypeTermAggregation.php) aggregates search results by the Content item's Content Type.

## Arguments

- `name` - name of the Aggregation object

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\ContentTypeTermAggregation('content_type');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
