# DateMetadataRangeAggregation

The [DateMetadataRangeAggregation](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Aggregation/DateMetadataRangeAggregation.php) aggregates search results by the value of the Content items' date metadata.

## Arguments

- `name` - name of the Aggregation object
- `type` - string representing the type of the Aggregation (`MODIFIED` or `PUBLISHED`)
- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\DateMetadataRangeAggregation('date_metadata', Aggregation\DateMetadataRangeAggregation::PUBLISHED,
    [
        new Query\Aggregation\Range(null, new DateTime('2020-06-01')),
        new Query\Aggregation\Range(new DateTime('2020-06-01'), new DateTime('2020-12-31')),
        new Query\Aggregation\Range(new DateTime('2020-12-31'), null),
    ]);
```
