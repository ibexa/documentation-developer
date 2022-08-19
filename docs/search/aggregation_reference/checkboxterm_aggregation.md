# CheckboxTermAggregation

The Field-based [CheckboxTermAggregation](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Aggregation/Field/CheckboxTermAggregation.php) aggregates search results by the value of the Checkbox Field.

## Arguments

- `name` - name of the Aggregation object
- `contentTypeIdentifier` - string representing the Content Type identifier
- `fieldDefinitionIdentifier` - string representing the Field identifier

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\Field\CheckboxTermAggregation('checkbox', 'article', 'enable_comments');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
