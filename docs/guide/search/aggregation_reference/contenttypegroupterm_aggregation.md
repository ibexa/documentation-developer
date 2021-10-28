# ContentTypeGroupTermAggregation

The [ContentTypeGroupTermAggregation](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Aggregation/ContentTypeGroupTermAggregation.php) aggregates search results by the Content item's Content Type group.

## Arguments

- `name` - name of the Aggregation object

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\ContentTypeGroupTermAggregation('content_type_group');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
