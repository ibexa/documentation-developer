# DateRangeAggregation

The Field-based [DateRangeAggregation](https://github.com/ezsystems/ezplatform-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Query/Aggregation/Field/DateRangeAggregation.php) aggregates search results by the value of the Date, DateTime or Time Field.

## Arguments

- `name` - name of the Aggregation object
- `contentTypeIdentifier` - string representing the Content Type identifier
- `fieldDefinitionIdentifier` - string representing the Field identifier
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
