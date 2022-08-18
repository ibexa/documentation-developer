# RawRangeAggregation

The [RawRangeAggregation](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Aggregation/RawRangeAggregation.php) aggregates search results by the value of the selected search index field.

## Arguments

- `name` - name of the Aggregation object
- `field` - string representing the search index field
- `ranges` - array of Range objects that define the borders of the specific range sets

## Limitations

!!! caution

    To keep your project search engine independent, do not use the `RawRangeAggregation` Aggregation in production code.
    Valid use cases are: testing, or temporary (one-off) tools.

## Example

``` php
$query = new LocationQuery();
$query->aggregations[] = new Aggregation\RawRangeAggregation('priority', 'priority_id', [
    new Query\Aggregation\Range(1, 10),
    new Query\Aggregation\Range(10, 100)
]);
```
