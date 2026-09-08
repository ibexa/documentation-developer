# Selection field type

The Selection field type stores single selections or multiple choices from a list of options, by populating a hash with the list of selected values.

| Name        | Internal name     | Expected input type |
|-------------|-------------------|---------------------|
| `Selection` | `ibexa_selection` | mixed               |

## Input expectations

| Type    | Example    |
|---------|------------|
| `array` | `[ 1, 2 ]` |

### Properties

The Value class of this field type contains the following properties:

| Property     | Type    | Description                                                                                                       |
|--------------|---------|-------------------------------------------------------------------------------------------------------------------|
| `$selection` | `int[]` | This property is used for the list of selections, which is a list of integer values, or one single integer value. |

### Hash format

Hash format of this field type is the same as value object's `selection` property.

## Validation

This field type validates the input, verifying if all selected options exist in the field definition and checks if multiple selections are allowed in the field definition.
If any of these validations fail, a `ValidationError` is thrown, specifying the error message.
When option validation fails, a list with the invalid options is also presented.

## Settings

| Name         | Type      | Default value | Description|
|--------------|-----------|---------------|------------|
| `isMultiple` | `boolean` | `false`       | Used to allow or prohibit multiple selection from the option list. |
| `options`    | `hash`    | `[]`     | Stores the list of options defined in the field definition.    |
