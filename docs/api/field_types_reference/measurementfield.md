# Measurement Field Type

This Field Type represents measurement information. What is stored is the unit of measure, and either single measurement value, or a pair of values that defines a range.

| Name          | Internal name       | Expected input type |
|---------------|---------------------|---------------------|
| `Measurement` | `ibexa_measurement` | `Ibexa\Contracts\Measurement\Value\ValueInterface`               |

## PHP API Field Type

### Input expectations

Type|Example|
|------|------|
|`array`|`[ 'measurementType' => "length", 'measurementUnit' => "inch", 'inputType' => 0, 'value' => 59.92, `measurementRangeMinimumValue` => `null`, `measurementRangeMaximumValue` => `null` ]`|

If `inputType` value is 1, which stands for `range`, the expected array must contain 'measurementRangeMinimumValue' and 'measurementRangeMaximumValue' parameters expressed as `float`.

### Value object

##### Properties

The Value class of this Field Type contains the following properties:

| Property | Type           | Description|
|----------|----------------|------------|
|`$measurementType`|`string`| Stores the type of measurement to inform whether it is length, weight, volume, pressure, etc.|
|`$measurementUnit`|`string`| Stores the name of the unit of measure used to express the value.|
| `$inputType`  | `integer|null` | Stores the information about whether the measurement is a single value or a pair of values that define a range. |
|`$value`|`float`|Stores a single measurement value. Null if input is a range.|
|`$measurementRangeMinimumValue`|`float`|Stores a bottom value of the range. Null if input is a single value.|
|`$measurementRangeMaximumValue`|`float`|Stores a top value of the range. Null if input is a single value.|

##### Constructor

The `Measurement\Value`constructor for this Value object initializes a new Value object with the value provided. Accepted keys are `measurementType` (`string`), `measurementUnit` (`string`), `inputType` (`integer`), `value` (`float`), `measurementRangeMinimumValue` (`float`), and `measurementRangeMaximumValue` (`float`).

``` php
// Constructor example

// Instantiates a Measurement Value object
$MeasurementValue = new Measurement\Value(
                        [
                            `measurementType` => "Volume", 
                            `measurementUnit` => "Litre",
                            `inputType` => 1
                            `value` => null, 
                            `measurementRangeMinimumValue` => 0.5,
                            `measurementRangeMaximumValue` => 0.71,
                        ]
                    );
```

##### String representation

String representation of the measurement ...

### Validation

This Field Type does not perform validation of the input value.

## Template rendering

The template called by [the `ibexa_render_field()` Twig function](../../guide/content_rendering/twig_function_reference/field_twig_functions.md#ibexa_render_field) while rendering a Measurement Field has access to the following parameters:

| Parameter | Type     | Default | Description|
|-----------|----------|---------|------------|
| `locale`  | `string` |   n/a   | Internal parameter set by the system based on current request locale or, if not set, calculated based on the language of the Field. |

Example:

``` html+twig
{{ ibexa_render_field(content, 'measurement', { 'parameters': { *** }}) }}
```
