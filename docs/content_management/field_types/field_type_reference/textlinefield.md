# TextLine field type

This field type makes possible to store and retrieve a single line of unformatted text.
It's capable of handling up to 255 characters.

| Name       | Internal name | Expected input type |
|------------|---------------|---------------------|
| `TextLine` | `ibexa_string`    | `string`            |

## Properties

The Value class of this field type contains the following properties:

| Property | Type     | Description                                 |
|----------|----------|---------------------------------------------|
| `$text`  | `string` | This property is used for the text content. |

## Validation

The input passed into this field type is subject to validation by the `StringLengthValidator`.
The length of the string provided must be between the minimum length defined in `minStringLength` and the maximum defined in `maxStringLength`.
The default value for both properties is 0, which means that the validation is disabled by default.
To set the validation properties, the `validateValidatorConfiguration()` method needs to be inspected, which receives an array with `minStringLength` and `maxStringLength` like in the following representation:
