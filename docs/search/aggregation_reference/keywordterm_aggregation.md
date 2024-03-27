# KeywordTermAggregation

The Field-based [KeywordTermAggregation](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Aggregation-Field-KeywordTermAggregation.html) aggregates search results by the value of the Keyword Field.

## Arguments

[[= include_file('docs/snippets/aggregation_arguments.md') =]]

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\Field\KeywordTermAggregation('keyword', 'article', 'tags');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
