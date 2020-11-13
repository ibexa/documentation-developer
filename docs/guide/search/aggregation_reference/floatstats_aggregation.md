# FloatStatsAggregation

The Field-based [FloatStatsAggregation](https://github.com/ezsystems/ezplatform-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Query/Aggregation/Field/FloatStatsAggregation.php) aggregates search results by the value of the Float Field
and provides statistical information for the values including:

- sum
- count of values
- minimum value
- maximum value
- average

## Arguments

- `name` - name of the Aggregation object
- `contentTypeIdentifier` - string representing the Content Type identifier
- `fieldDefinitionIdentifier` - string representing the Field identifier

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\Field\FloatStatsAggregation('float', 'product', 'weight');
```
