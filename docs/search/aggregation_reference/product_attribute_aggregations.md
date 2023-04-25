# Product attribute aggregations

Product attribute aggregations aggregate search results by the value of the product's attributes.

Depending of attribute type, the following aggregations are available:

- `ProductAttributeBooleanAggregation`
- `ProductAttributeColorAggregation`
- `ProductAttributeFloatAggregation`
- `ProductAttributeFloatRangeAggregation`
- `ProductAttributeIntegerAggregation`
- `ProductAttributeIntegerRangeAggregation`
- `ProductAttributeSelectionAggregation`

## Arguments

- `name` - name of the Aggregation
- `attributeDefinitionIdentifier` - identifier of the attribute

Range aggregations (`ProductAttributeFloatRangeAggregation` and `ProductAttributeIntegerRangeAggregation`)
additionally take:

- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

``` php
$query = new ProductQuery();
$query->setAggregations([
    new ProductAttributeSelectionAggregation('skin', 'skin_type'),
]);
```

``` php
$query = new ProductQuery();
$query->setAggregations([
    new ProductAttributeIntegerRangeAggregation('buttons', 'number_of_buttons', [
        new \Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Range(null, 5),
        new \Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Range(5, 10),
        new \Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Range(10, null),
    ]),
]);
```
