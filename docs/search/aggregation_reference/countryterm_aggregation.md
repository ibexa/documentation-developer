# CountryTermAggregation

The Field-based [CountryTermAggregation](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Aggregation/Field/CountryTermAggregation.php) aggregates search results by the value of the Country Field.

## Arguments

- `name` - name of the Aggregation object
- `contentTypeIdentifier` - string representing the Content Type identifier
- `fieldDefinitionIdentifier` - string representing the Field identifier

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\Field\CountryTermAggregation('country', 'article', 'country');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
