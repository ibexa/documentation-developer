# SectionTermAggregation

The [SectionTermAggregation](https://github.com/ezsystems/ezplatform-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Query/Aggregation/SectionTermAggregation.php) aggregates search results by the Content item's Section.

## Arguments

- `name` - name of the Aggregation object

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\SectionTermAggregation('section');
```
