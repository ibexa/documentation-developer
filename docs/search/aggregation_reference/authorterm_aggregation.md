# AuthorTermAggregation

The Field-based [AuthorTermAggregation](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Aggregation/Field/AuthorTermAggregation.php) aggregates search results by the value of the Author Field.

## Arguments

[[= include_file('docs/snippets/aggregation_arguments.md') =]]

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\Field\AuthorTermAggregation('author', 'article', 'authors');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
