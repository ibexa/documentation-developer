# SelectionTermAggregation

The Field-based [SelectionTermAggregation](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Aggregation/Field/SelectionTermAggregation.php) aggregates search results by the value of the Selection Field.

## Arguments

- `name` - name of the Aggregation object
- `contentTypeIdentifier` - string representing the Content Type identifier
- `fieldDefinitionIdentifier` - string representing the Field identifier

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\Field\SelectionTermAggregation('selection', 'article', 'select');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
