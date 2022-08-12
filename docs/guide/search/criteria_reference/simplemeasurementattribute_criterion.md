# SimpleMeasurementAttribute Criterion

The `SimpleMeasurementAttribute` Search Criterion searches for products by the minimum of their measurement (single) attribute.

## Arguments

-  `identifier` - string representing the attribute.
-  `value` - `SimpleValue` object representing the attribute value.

## Example

``` php
$value = $this->measurementService->buildSimpleValue('length', 120, 'centimeter');
$criteria = new Criterion\SimpleMeasurementAttribute('width', $value);
```
