# SelectionTermAggregation

The Field-based [SelectionTermAggregation](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Aggregation-Field-SelectionTermAggregation.html) aggregates search results by the value of the Selection Field.

## Arguments

[[= include_file('docs/snippets/aggregation_arguments.md') =]]

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\Field\SelectionTermAggregation('selection', 'article', 'select');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
