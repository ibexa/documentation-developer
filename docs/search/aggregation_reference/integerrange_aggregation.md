# IntegerRangeAggregation

The Field-based [IntegerRangeAggregation](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Aggregation/Field/IntegerRangeAggregation.php) aggregates search results by the value of the Integer Field.

## Arguments

[[= include_file('docs/snippets/aggregation_arguments.md') =]]
- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\Field\IntegerRangeAggregation('integer', 'product', 'amount',
[
    new Query\Aggregation\Range(null, 12),
    new Query\Aggregation\Range(12, 24),
    new Query\Aggregation\Range(24, null),
]);
```
