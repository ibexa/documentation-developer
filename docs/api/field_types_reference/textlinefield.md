# TextLine Field Type

This Field Type makes possible to store and retrieve a single line of unformatted text. It is capable of handling up to 255 characters.

| Name       | Internal name | Expected input type |
|------------|---------------|---------------------|
| `TextLine` | `ezstring`    | `string`            |

## PHP API Field Type

### Value object

##### Properties

The Value class of this Field Type contains the following properties:

| Property | Type     | Description|
|----------|----------|------------|
| `$text`  | `string` | This property will be used for the text content. |

##### String representation

A TextLine's string representation is the `$text` property's value, as a string.

##### Constructor

The constructor for this Value object will initialize a new Value object with the value provided. It accepts a string as argument and will import it to the `$text` attribute.

### Validation

The input passed into this Field Type is subject to validation by the `StringLengthValidator`. The length of the string provided must be between the minimum length defined in `minStringLength` and the maximum defined in `maxStringLength`. The default value for both properties is 0, which means that the validation is disabled by default.
To set the validation properties, the `validateValidatorConfiguration()` method needs to be inspected, which will receive an array with `minStringLength` and `maxStringLength` like in the following representation:

```
Array
(
    [minStringLength] => 1
    [maxStringLength] => 60
)
```
