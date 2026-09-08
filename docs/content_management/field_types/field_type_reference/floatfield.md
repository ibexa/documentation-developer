# Float field type

This field type stores numeric values which are provided as floats.

| Name    | Internal name | Expected input |
|---------|---------------|----------------|
| `Float` | `ibexa_float` | `float`        |

## Input expectations

The field type expects a number as input. Both decimal and integer numbers are accepted.

| Type    | Example      |
|---------|--------------|
| `float` | `194079.572` |
| `int`   | `144`        |

### Properties

The Value class of this field type contains the following properties:

| Property | Type    | Description                                                   |
|----------|---------|---------------------------------------------------------------|
| `$value` | `float` | This property is used to store the value provided as a float. |

## Validation

This field type supports `FloatValueValidator`, defining maximum and minimum float value:

| Name            | Type    | Default value | Description                                                                       |
|-----------------|---------|---------------|-----------------------------------------------------------------------------------|
| `minFloatValue` | `float` | `null         | This setting defines the minimum value this field type which is allowed as input. |
| `maxFloatValue` | `float` | `null         | This setting defines the maximum value this field type which is allowed as input. |

## Settings

This field type doesn't support settings.
