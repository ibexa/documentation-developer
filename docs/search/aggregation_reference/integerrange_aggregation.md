# IntegerRangeAggregation

The Field-based [IntegerRangeAggregation](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Aggregation-Field-IntegerRangeAggregation.html) aggregates search results by the value of the Integer Field.

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
