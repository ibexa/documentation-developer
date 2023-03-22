# SelectionTermAggregation

The Field-based [SelectionTermAggregation](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Aggregation/Field/SelectionTermAggregation.php) aggregates search results by the value of the Selection Field.

## Arguments

[[= include_file('docs/snippets/aggregation_arguments.md') =]]

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\Field\SelectionTermAggregation('selection', 'article', 'select');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
