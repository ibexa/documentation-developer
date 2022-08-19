# ISBN Field Type

This Field Type represents an ISBN string either an ISBN-10 or ISBN-13 format.

| Name   | Internal name | Expected input type |
|--------|---------------|---------------------|
| `ISBN` | `ezisbn`      | `string`            |

## PHP API Field Type 

### Value object

##### Properties

The Value class of this Field Type contains the following properties:

| Property | Type     | Description|
|----------|----------|------------|
| `$isbn`  | `string` | This property will be used for the ISBN string. |

##### String representation

An ISBN's string representation is the `$isbn` property's value, as a string.

##### Constructor

The constructor for this value object will initialize a new Value object with the value provided. It accepts a string as argument and will set it to the `isbn` attribute.

### Validation

The input passed into this Field Type is subject of ISBN validation depending on the Field settings in its FieldDefinition stored in the Content Type. An example of this Field setting is shown below and will control if input is validated as ISBN-13 or ISBN-10:

``` php
Array
(
    [isISBN13] => true
)
```
