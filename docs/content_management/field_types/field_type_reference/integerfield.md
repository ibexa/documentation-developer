# Integer field type

This field type represents an integer value.

| Name      | Internal name   | Expected input |
|-----------|-----------------|----------------|
| `Integer` | `ibexa_integer` | `integer`      |

## Input expectations

| Type      | Example |
|-----------|---------|
| `integer` | `2397`  |

### Properties

The Value class of this field type contains the following properties:

| Property | Type  | Description|
|----------|-------|------------|
| `$value` | `int` | This property is used to store the value provided as an integer. |

### Hash format

Hash value of this field type is an integer value as a string.

Example: `"8"`

## Validation

This field type supports `IntegerValueValidator`, defining maximum and minimum float value:

|Name|Type|Default value|Description|
|------|------|------|------|
|`minIntegerValue`|`int`|`0`|This setting defines the minimum value this field type which is allowed as input.|
|`maxIntegerValue`|`int`|`null`|This setting defines the maximum value this field type which is allowed as input.|

## Settings

This field type doesn't support settings.
