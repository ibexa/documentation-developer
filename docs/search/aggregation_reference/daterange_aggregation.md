# DateRangeAggregation

The Field-based [DateRangeAggregation](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Aggregation/Field/DateRangeAggregation.php) aggregates search results by the value of the Date, DateTime or Time Field.

## Arguments

[[= include_file('docs/snippets/aggregation_arguments.md') =]]
- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\Field\DateRangeAggregation('date', 'event', 'event_date',
[
    new Query\Aggregation\Range(null, new DateTime('2020-06-01')),
    new Query\Aggregation\Range(new DateTime('2020-06-01'), new DateTime('2020-12-31')),
    new Query\Aggregation\Range(new DateTime('2020-12-31'), null),
]);
```
