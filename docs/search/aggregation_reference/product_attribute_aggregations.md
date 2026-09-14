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
