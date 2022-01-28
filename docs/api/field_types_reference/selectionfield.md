# Selection Field Type

The Selection Field Type stores single selections or multiple choices from a list of options, by populating a hash with the list of selected values.

| Name        | Internal name | Expected input type |
|-------------|---------------|---------------------|
| `Selection` | `ezselection` | mixed             |

## PHP API Field Type

### Input expectations

| Type    | Example         |
|---------|-----------------|
| `array` | `[ 1, 2 ]` |

### Value object

##### Properties

The Value class of this Field Type contains the following properties:

| Property     | Type    | Description|
|--------------|---------|------------|
| `$selection` | `int[]` | This property is used for the list of selections, which is a list of integer values, or one single integer value. |

``` php
// Value object content examples

// Single selection
$value->selection = 1;

// Multiple selection
$value->selection = [ 1, 4, 5 ];
```

##### Constructor

The `Selection\Value` constructor accepts an array of selected element identifiers.

``` php
// Constructor example

// Instanciates a selection value with items #1 and #2 selected
$selectionValue = new Selection\Value( [ 1, 2 ] );
```

##### String representation

String representation of this Field Type is its list of selections as a string, concatenated with a comma.

Example: `"1,2,24,42"`

### Hash format

Hash format of this Field Type is the same as Value object's `selection` property.

``` php
// Example of value in hash format

$hash = [ 1, 2 ];
```

### Validation

This Field Type validates the input, verifying if all selected options exist in the Field definition and checks if multiple selections are allowed in the Field definition.
If any of these validations fail, a `ValidationError` is thrown, specifying the error message. When option validation fails, a list with the invalid options is also presented.

### Settings

| Name         | Type      | Default value | Description|
|--------------|-----------|---------------|------------|
| `isMultiple` | `boolean` | `false`       | Used to allow or prohibit multiple selection from the option list. |
| `options`    | `hash`    | `[]`     | Stores the list of options defined in the Field definition.    |

``` php
// Selection Field Type example settings

use Ibexa\Core\FieldType\Selection\Type;

$settings = [
    "isMultiple" => true,
    "options" => [1 => 'One', 2 => 'Two', 3 => 'Three']
];
```
