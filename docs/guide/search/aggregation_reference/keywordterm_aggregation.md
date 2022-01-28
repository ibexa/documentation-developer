# KeywordTermAggregation

The Field-based [KeywordTermAggregation](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Aggregation/Field/KeywordTermAggregation.php) aggregates search results by the value of the Keyword Field.

## Arguments

- `name` - name of the Aggregation object
- `contentTypeIdentifier` - string representing the Content Type identifier
- `fieldDefinitionIdentifier` - string representing the Field identifier

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\Field\KeywordTermAggregation('keyword', 'article', 'tags');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
