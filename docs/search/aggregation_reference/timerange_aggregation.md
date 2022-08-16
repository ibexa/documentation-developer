# TimeRangeAggregation

The Field-based [TimeRangeAggregation](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Aggregation/Field/TimeRangeAggregation.php) aggregates search results by the value of the Date, DateTime or Time Field.

## Arguments

- `name` - name of the Aggregation object
- `contentTypeIdentifier` - string representing the Content Type identifier
- `fieldDefinitionIdentifier` - string representing the Field identifier
- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\Field\TimeRangeAggregation('date', 'event', 'event_time',
[
    new Query\Aggregation\Range(null, new DateTime('T14:00')),
    new Query\Aggregation\Range(new DateTime('T14:003'), null),
]);
```
