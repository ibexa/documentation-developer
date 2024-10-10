# Checkbox field type

The Checkbox field type stores the current status for a checkbox input, checked or unchecked, by storing a boolean value.

| Name       | Internal name | Expected input type |
|------------|---------------|---------------------|
| `Checkbox` | `ezboolean`   | `boolean`           |

## PHP API field type 

### Value object

##### Properties

The Value class of this field type contains the following properties:

| Property | Type      | Default value | Description|
|----------|-----------|---------------|------------|
| `$bool`  | `boolean` | `false`       | This property is used for the checkbox status, represented by a boolean value. |

``` php
//Value object content examples
use Ibexa\Core\FieldType\Checkbox\Type;
 
// Instantiates a checkbox value with a default state (false)
$checkboxValue = new Checkbox\Value();
 
// Checked
$value->bool = true;

// Unchecked
$value->bool = false;
```

##### Constructor

The `Checkbox\Value` constructor accepts a boolean value:

``` php
// Constructor example
use Ibexa\Core\FieldType\Checkbox\Type;
 
// Instantiates a checkbox value with a checked state
$checkboxValue = new Checkbox\Value( true );
```

##### String representation

As this field type isn't a string but a boolean, it returns "1" (true) or "0" (false) in cases where it's cast to string, and it's never considered empty.
