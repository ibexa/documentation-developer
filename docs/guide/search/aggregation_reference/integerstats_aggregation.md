# IntegerStatsAggregation

The Field-based [IntegerStatsAggregation](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Aggregation/Field/IntegerStatsAggregation.php) aggregates search results by the value of the Integer Field
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
$query->aggregations[] = new Aggregation\Field\IntegerStatsAggregation('integer', 'product', 'amount');
```
Use provided getter to access properties values: `getSum()`, `getCount())`, `getMin()`, `getMax()`, `getAvg()`, `getName()`
