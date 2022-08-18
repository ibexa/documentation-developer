# ObjectStateTermAggregation

The [ObjectStateTermAggregation](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Aggregation/ObjectStateTermAggregation.php) aggregates search results by the Content item's Object state.

## Arguments

- `name` - name of the Aggregation object
- `objectStateGroupIdentifier` - string representing the identifier of the Object state group to aggregate results by

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\Location\ObjectStateTermAggregation('object_state', 'ez_lock');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
