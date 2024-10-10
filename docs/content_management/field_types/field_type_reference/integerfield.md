# Integer field type

This field type represents an integer value.

| Name      | Internal name | Expected input |
|-----------|---------------|----------------|
| `Integer` | `ezinteger`   | `integer`      |

## PHP API field type 

### Input expectations

|Type|Example|
|-------|------|
|`integer`|`2397`|

### Value object

##### Properties

The Value class of this field type contains the following properties:

| Property | Type  | Description|
|----------|-------|------------|
| `$value` | `int` | This property is used to store the value provided as an integer. |

``` php
// Value object content example
$integer->value = 8
```

##### Constructor

The `Integer\Value` constructor initializes a new Value object with the value provided. It expects a numeric, integer value.

``` php
// Constructor example
use Ibexa\Core\FieldType\Integer;
 
// Instantiates a Integer Value object
$integerValue = new Integer\Value( 8 );
```

### Hash format

Hash value of this field type is an integer value as a string.

Example: `"8"`

### String representation

String representation of the field type's value returns the integer value as a string.

Example: `"8"`

### Validation

This field type supports `IntegerValueValidator`, defining maximum and minimum float value:

|Name|Type|Default value|Description|
|------|------|------|------|
|`minIntegerValue`|`int`|`0`|This setting defines the minimum value this field type which is allowed as input.|
|`maxIntegerValue`|`int`|`null`|This setting defines the maximum value this field type which is allowed as input.|

``` php
// Example of validator configuration in PHP
$validatorConfiguration = [
    "minIntegerValue" => 1,
    "maxIntegerValue" => 24
];
```

### Settings

This field type does not support settings.
