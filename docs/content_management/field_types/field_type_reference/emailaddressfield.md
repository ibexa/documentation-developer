# EmailAddress field type

The EmailAddress field type represents an email address, in the form of a string.

| Name           | Internal name | Expected input type |
|----------------|---------------|---------------------|
| `EmailAddress` | `ibexa_email` | `string`            |

## Properties

The `Value` class of this field type contains the following properties:

| Property | Type     | Description                                                           |
|----------|----------|-----------------------------------------------------------------------|
| `$email` | `string` | This property is used for the input string provided as email address. |

## Hash format

Hash value for this field type's Value is simply the email address as a string.

Example: `someuser@example.com`

## Validation

This field type uses the `EmailAddressValidator` validator as a resource which tests the string supplied as input against a pattern, to make sure that a valid email address has been provided.
If the validations fail, a `ValidationError` is thrown, specifying the error message.

## Settings

This field type doesn't support settings.
