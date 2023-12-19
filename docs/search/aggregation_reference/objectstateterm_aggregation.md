# ObjectStateTermAggregation

The [ObjectStateTermAggregation](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Aggregation-ObjectStateTermAggregation.html) aggregates search results by the Content item's Object state.

## Arguments

- `name` - name of the Aggregation object
- `objectStateGroupIdentifier` - string representing the identifier of the Object state group to aggregate results by

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\Location\ObjectStateTermAggregation('object_state', 'ez_lock');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
