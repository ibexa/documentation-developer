# SimpleMeasurementAttribute Criterion

The `SimpleMeasurementAttribute` Search Criterion searches for products by the value of their measurement (single) attribute.

## Arguments

- `identifier` - string representing the attribute
- `value` - `Ibexa\Contracts\Measurement\Value\SimpleValueInterface` object representing the attribute value

## Example

### PHP

``` php
$value = $this->measurementService->buildSimpleValue('length', 120, 'centimeter');

$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\SimpleMeasurementAttribute(
        'width',
        $value
    )
);
```
