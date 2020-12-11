# RawStatsAggregation

The [RawStatsAggregation](https://github.com/ezsystems/ezplatform-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Query/Aggregation/RawStatsAggregation.php) aggregates search results by the value of the selected search index field
and provides statistical information for the values including:

- sum
- count of values
- minimum value
- maximum value
- average

## Arguments

- `name` - name of the Aggregation object
- `field` - string representing the search index field

## Limitations

!!! caution

    Do not use the `RawStatsAggregation` Aggregation in production code, if you want to keep your project search engine independent.
    Valid use cases are testing or temporary, one-off tools.

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\RawStatsAggregation('location_depth', 'depth_i');
```
