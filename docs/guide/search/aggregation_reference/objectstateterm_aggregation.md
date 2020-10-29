# ObjectStateTermAggregation

The [ObjectStateTermAggregation](https://github.com/ezsystems/ezplatform-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Query/Aggregation/ObjectStateTermAggregation.php) aggregates search results by the Location's subtree path.

## Arguments

- `name` - name of the Aggregation object
- `objectStateGroupIdentifier` - string representing the identifier of the Object state group to aggregate results by

## Example

``` php
$query = new Query();
query->aggregations[] = new Aggregation\Location\ObjectStateTermAggregation('object_state', 'ez_lock');
```
