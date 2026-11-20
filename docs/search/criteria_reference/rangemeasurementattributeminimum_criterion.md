---
description: RangeMeasurementAttributeMinimum Search Criterion
---

# RangeMeasurementAttributeMinimum Criterion

The `RangeMeasurementAttributeMinimum` Search Criterion searches for products by the minimum value of their measurement (range) attribute.

## Arguments

- `identifier` - string representing the attribute
- `value` - `\Ibexa\Contracts\Measurement\Value\SimpleValueInterface` object representing the minimum attribute value

## Example

### PHP

``` php
use Ibexa\Contracts\Measurement\MeasurementServiceInterface;
use Ibexa\Contracts\Measurement\Product\Query\Criterion\RangeMeasurementAttributeMinimum;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;

/** @var MeasurementServiceInterface $measurementService */
$value = $measurementService->buildSimpleValue('length', 100, 'centimeter');

$query = new ProductQuery(
    null,
    new RangeMeasurementAttributeMinimum(
        'length',
        $value
    )
);
```
