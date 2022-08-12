# RangeMeasurementAttributeMaximum Criterion

The `RangeMeasurementAttributeMaximum` Search Criterion searches for products by the maximum value of their measurement (range) attribute.

## Arguments

-  `identifier` - string representing the attribute.
-  `value` - `\Ibexa\Contracts\Measurement\Value\SimpleValueInterface` object representing the maximum attribute value.

## Example

``` php
$value = $this->measurementService->buildSimpleValue('length', 150, 'centimeter');
$criteria = new Criterion\RangeMeasurementAttributeMaximum('length', $value);
```
