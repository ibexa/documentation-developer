# ISBN field type

This field type represents an ISBN string either an ISBN-10 or ISBN-13 format.

| Name   | Internal name | Expected input type |
|--------|---------------|---------------------|
| `ISBN` | `ezisbn`      | `string`            |

## PHP API field type 

### Value object

##### Properties

The Value class of this field type contains the following properties:

| Property | Type     | Description|
|----------|----------|------------|
| `$isbn`  | `string` | This property is used for the ISBN string. |

##### String representation

An ISBN's string representation is the `$isbn` property's value, as a string.

##### Constructor

The constructor for this value object initializes a new Value object with the value provided. It accepts a string as argument and sets it to the `isbn` attribute.

### Validation

The input passed into this field type is subject of ISBN validation depending on the field settings in its FieldDefinition stored in the content type. An example of this field setting is shown below and controls if input is validated as ISBN-13 or ISBN-10:

``` php
Array
(
    [isISBN13] => true
)
```
