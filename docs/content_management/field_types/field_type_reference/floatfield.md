# Float field type

This field type stores numeric values which are provided as floats.

| Name    | Internal name | Expected input |
|---------|---------------|----------------|
| `Float` | `ezfloat`     | `float`        |

## PHP API field type 

### Input expectations

The field type expects a number as input. Both decimal and integer numbers are accepted.

|Type|Example|
|------|------|
|`float`|`194079.572`|
|`int`|`144`|

### Value object

##### Properties

The Value class of this field type contains the following properties:

| Property | Type    | Description|
|----------|---------|------------|
| `$value` | `float` | This property is used to store the value provided as a float. |

``` php
// Value object content example

use Ibexa\Core\FieldType\Float\Type;

// Instantiates a Float Value object
$floatValue = new Type\Value();

$float->value = 284.773
```

##### Constructor

The `Float\Value` constructor initializes a new value object with the value provided.
It expects a numeric value with or without decimals.

``` php
// Constructor example

use Ibexa\Core\FieldType\Float\Type;

// Instantiates a Float Value object
$floatValue = new Type\Value( 284.773 );
```

### Validation

This field type supports `FloatValueValidator`, defining maximum and minimum float value:

|Name|Type|Default value|Description|
|------|------|------|------|
|`minFloatValue`|`float`|`null|This setting defines the minimum value this field type which is allowed as input.|
|`maxFloatValue`|`float`|`null|This setting defines the maximum value this field type which is allowed as input.|

``` php
// Validator configuration example in PHP

use Ibexa\Core\FieldType\Float\Type;

$contentTypeService = $repository->getContentTypeService();
$floatFieldCreateStruct = $contentTypeService->newFieldDefinitionCreateStruct( "float", "ezfloat" );

// Accept only numbers between 0.1 and 203.99
$floatFieldCreateStruct->validatorConfiguration = [
    "FileSizeValidator" => [
        "minFloatValue" => 0.1,
        "maxFloatValue" => 203.99
    ]
];
```

### Settings

This field type doesn't support settings.
