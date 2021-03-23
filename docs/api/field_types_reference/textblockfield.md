# TextBlock Field Type

The Field Type handles a block of multiple lines of unformatted text. It is capable of handling up to 16,777,216 characters.

| Name        | Internal name | Expected input type |
|-------------|---------------|---------------------|
| `TextBlock` | `eztext`      | `string`            |

## PHP API Field Type

### Input expectations

|Type|Example|
|----|-------|
|`string`|`"This is a block of unformatted text"`|

### Value object

##### Properties

The Value class of this Field Type contains the following properties:

|Property|Type|Description|
|--------|----|-----------|
|`$text`|`string`|This property will be used for the text content.|

##### String representation

A TextBlock's string representation is the `$text` property's value, as a string.

##### Constructor

The constructor for this Value object will initialize a new Value object with the value provided. It accepts a string as argument and will import it to the `$text` attribute.

### Validation

This Field Type does not perform any special validation of the input value.

### Settings

Settings contain only one option:

| Name       | Type      | Default value | Description|
|------------|-----------|---------------|------------|
| `textRows` | `integer` | `10`          | Number of rows for the editing box in the back-end interface. |
