# CheckboxTermAggregation

The Field-based [CheckboxTermAggregation](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Aggregation/Field/CheckboxTermAggregation.php) aggregates search results by the value of the Checkbox Field.

## Arguments

[[= include_file('docs/snippets/aggregation_arguments.md') =]]

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\Field\CheckboxTermAggregation('checkbox', 'article', 'enable_comments');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
