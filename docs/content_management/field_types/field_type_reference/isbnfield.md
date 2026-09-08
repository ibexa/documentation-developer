# ISBN field type

This field type represents an ISBN string either an ISBN-10 or ISBN-13 format.

| Name   | Internal name | Expected input type |
|--------|---------------|---------------------|
| `ISBN` | `ibexa_isbn`  | `string`            |

## Properties

The Value class of this field type contains the following properties:

| Property | Type     | Description                                |
|----------|----------|--------------------------------------------|
| `$isbn`  | `string` | This property is used for the ISBN string. |

## Validation

The input passed into this field type is subject of ISBN validation depending on the field settings in its FieldDefinition stored in the content type.
An example of this field setting is shown below and controls if input is validated as ISBN-13 or ISBN-10:
