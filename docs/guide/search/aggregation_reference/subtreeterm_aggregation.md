# SubtreeTermAggregation

The [SubtreeTermAggregation](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Aggregation/Location/SubtreeTermAggregation.php) aggregates search results by the Location's subtree path.

## Arguments

- `name` - name of the Aggregation object
- `pathString` - string representing the pathstring to aggregate results by

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\Location\SubtreeTermAggregation('pathstring', '/1/2/');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
