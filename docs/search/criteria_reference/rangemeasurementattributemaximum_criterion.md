---
description: RangeMeasurementAttributeMaximum Search Criterion
---

# RangeMeasurementAttributeMaximum Criterion

The `RangeMeasurementAttributeMaximum` Search Criterion searches for products by the maximum value of their measurement (range) attribute.

## Arguments

- `identifier` - string representing the attribute
- `value` - `\Ibexa\Contracts\Measurement\Value\SimpleValueInterface` object representing the maximum attribute value

## Example

### PHP

``` php
use Ibexa\Contracts\Measurement\MeasurementServiceInterface;
use Ibexa\Contracts\Measurement\Product\Query\Criterion\RangeMeasurementAttributeMaximum;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;

/** @var MeasurementServiceInterface $measurementService */
$value = $measurementService->buildSimpleValue('length', 150, 'centimeter');

$query = new ProductQuery(
    null,
    new RangeMeasurementAttributeMaximum(
        'length',
        $value
    )
);
```
