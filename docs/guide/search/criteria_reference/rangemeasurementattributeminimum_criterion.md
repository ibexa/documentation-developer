# RangeMeasurementAttributeMinimum Criterion

The `RangeMeasurementAttributeMinimum` Search Criterion searches for products by the minimum value of their measurement (range) attribute.

## Arguments

-  `identifier` - string representing the attribute.
- `value` - `\Ibexa\Contracts\Measurement\Value\SimpleValueInterface` object representing the minimum attribute value.

## Example

``` php
$value = $this->measurementService->buildSimpleValue('length', 100, 'centimeter');
$criteria = new Criterion\RangeMeasurementAttributeMinimum('length', $value);
```
