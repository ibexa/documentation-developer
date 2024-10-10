# TextBlock field type

The field type handles a block of multiple lines of unformatted text. It's capable of handling up to 16,777,216 characters.

| Name        | Internal name | Expected input type |
|-------------|---------------|---------------------|
| `TextBlock` | `eztext`      | `string`            |

## PHP API field type

### Input expectations

|Type|Example|
|----|-------|
|`string`|`"This is a block of unformatted text"`|

### Value object

##### Properties

The Value class of this field type contains the following properties:

|Property|Type|Description|
|--------|----|-----------|
|`$text`|`string`|This property is used for the text content.|

##### String representation

A TextBlock's string representation is the `$text` property's value, as a string.

##### Constructor

The constructor for this Value object initializes a new Value object with the value provided. It accepts a string as argument and imports it to the `$text` attribute.

### Validation

This field type does not perform any special validation of the input value.

### Settings

Settings contain only one option:

| Name       | Type      | Default value | Description|
|------------|-----------|---------------|------------|
| `textRows` | `integer` | `10`          | Number of rows for the editing box in the back-end interface. |
