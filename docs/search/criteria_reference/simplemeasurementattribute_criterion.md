---
description: SimpleMeasurementAttribute Search Criterion
---

# SimpleMeasurementAttribute Criterion

The `SimpleMeasurementAttribute` Search Criterion searches for products by the value of their measurement (single) attribute.

## Arguments

- `identifier` - string representing the attribute
- `value` - `Ibexa\Contracts\Measurement\Value\SimpleValueInterface` object representing the attribute value

## Example

### PHP

``` php
use Ibexa\Contracts\Measurement\MeasurementServiceInterface;
use Ibexa\Contracts\Measurement\Product\Query\Criterion\SimpleMeasurementAttribute;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;

/** @var MeasurementServiceInterface $measurementService */
$value = $measurementService->buildSimpleValue('length', 120, 'centimeter');

$query = new ProductQuery(
    null,
    new SimpleMeasurementAttribute(
        'width',
        $value
    )
);
```
