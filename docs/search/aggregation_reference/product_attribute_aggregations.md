---
description: Product attribute aggregations aggregate search results by the value of the product's attributes.
---

# Product attribute aggregations

Product attribute aggregations aggregate search results by the value of the product's attributes.

Depending on attribute type, the following aggregations are available:

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

Range aggregations (`ProductAttributeFloatRangeAggregation` and `ProductAttributeIntegerRangeAggregation`) additionally take:

- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

``` php
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Aggregation\AttributeSelectionTermAggregation;

$query = new ProductQuery();
$query->setAggregations([
    new AttributeSelectionTermAggregation('skin', 'skin_type'),
]);
```

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Range;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Aggregation\AttributeIntegerRangeAggregation;

$query = new ProductQuery();
$query->setAggregations([
    new AttributeIntegerRangeAggregation('buttons', 'number_of_buttons', [
        Range::ofInt(null, 5),
        Range::ofInt(5, 10),
        Range::ofInt(10, null),
    ]),
]);
```
