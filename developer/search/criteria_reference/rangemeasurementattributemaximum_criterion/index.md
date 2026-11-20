# RangeMeasurementAttributeMaximum Criterion

RangeMeasurementAttributeMaximum Search Criterion

The `RangeMeasurementAttributeMaximum` Search Criterion searches for products by the maximum value of their measurement (range) attribute.

## Arguments

- `identifier` - string representing the attribute
- `value` - `\Ibexa\Contracts\Measurement\Value\SimpleValueInterface` object representing the maximum attribute value

## Example

### PHP

```php
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion;

/** @var \Ibexa\Contracts\Measurement\MeasurementServiceInterface $measurementService */
$value = $measurementService->buildSimpleValue('length', 150, 'centimeter');

$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\Measurement\Product\Query\Criterion\RangeMeasurementAttributeMaximum(
        'length',
        $value
    )
);
```
