# RangeMeasurementAttributeMinimum Criterion

RangeMeasurementAttributeMinimum Search Criterion

The `RangeMeasurementAttributeMinimum` Search Criterion searches for products by the minimum value of their measurement (range) attribute.

## Arguments

- `identifier` - string representing the attribute
- `value` - `\Ibexa\Contracts\Measurement\Value\SimpleValueInterface` object representing the minimum attribute value

## Example

### PHP

```php
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion;

/** @var \Ibexa\Contracts\Measurement\MeasurementServiceInterface $measurementService */
$value = $measurementService->buildSimpleValue('length', 100, 'centimeter');

$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\Measurement\Product\Query\Criterion\RangeMeasurementAttributeMinimum(
        'length',
        $value
    )
);
```
