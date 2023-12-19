# AuthorTermAggregation

The Field-based [AuthorTermAggregation](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Aggregation-Field-AuthorTermAggregation.html) aggregates search results by the value of the Author Field.

## Arguments

[[= include_file('docs/snippets/aggregation_arguments.md') =]]

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\Field\AuthorTermAggregation('author', 'article', 'authors');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
