# CheckboxTermAggregation

The Field-based [CheckboxTermAggregation](https://github.com/ezsystems/ezplatform-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Query/Aggregation/Field/CheckboxTermAggregation.php) aggregates search results by the value of the Checkbox Field.

## Arguments

- `name` - name of the Aggregation object
- `contentTypeIdentifier` - string representing the Content Type identifier
- `fieldDefinitionIdentifier` - string representing the Field identifier

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\Field\CheckboxTermAggregation('checkbox', 'article', 'enable_comments');
```
