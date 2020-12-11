# RawRangeAggregation

The [RawRangeAggregation](https://github.com/ezsystems/ezplatform-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Query/Aggregation/RawRangeAggregation.php) aggregates search results by the value of the selected search index field.

## Arguments

- `name` - name of the Aggregation object
- `field` - string representing the search index field
- `ranges` - array of Range objects that define the borders of the specific range sets

## Limitations

!!! caution

    Do not use the `RawRangeAggregation` Aggregation in production code, if you want to keep your project search engine independent.
    Valid use cases are testing or temporary, one-off tools.

## Example

``` php
$query = new LocationQuery();
$query->aggregations[] = new Aggregation\RawRangeAggregation('priority', 'priority_id', [
    new Query\Aggregation\Range(1, 10),
    new Query\Aggregation\Range(10, 100)
]);
```
