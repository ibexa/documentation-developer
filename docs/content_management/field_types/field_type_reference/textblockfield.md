# TextBlock field type

The field type handles a block of multiple lines of unformatted text. It's capable of handling up to 16,777,216 characters.

| Name        | Internal name | Expected input type |
|-------------|---------------|---------------------|
| `TextBlock` | `ibexa_text`  | `string`            |

## Input expectations

| Type     | Example                                 |
|----------|-----------------------------------------|
| `string` | `"This is a block of unformatted text"` |

### Properties

The Value class of this field type contains the following properties:

| Property | Type     | Description                                 |
|----------|----------|---------------------------------------------|
| `$text`  | `string` | This property is used for the text content. |

## Validation

This field type doesn't perform any special validation of the input value.

## Settings

Settings contain only one option:

| Name       | Type      | Default value | Description                                                   |
|------------|-----------|---------------|---------------------------------------------------------------|
| `textRows` | `integer` | `10`          | Number of rows for the editing box in the back-end interface. |
