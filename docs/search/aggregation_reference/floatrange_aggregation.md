# FloatRangeAggregation

The Field-based [FloatRangeAggregation](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Aggregation-Field-FloatRangeAggregation.html) aggregates search results by the value of the Float Field.

## Arguments

[[= include_file('docs/snippets/aggregation_arguments.md') =]]
- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\Field\FloatRangeAggregation('float', 'product', 'weight',
[
    new Query\Aggregation\Range(null, 0.25),
    new Query\Aggregation\Range(0.25, 0.75),
    new Query\Aggregation\Range(0.75, null),
]);
```
