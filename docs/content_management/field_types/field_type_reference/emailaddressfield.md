# EmailAddress field type

The EmailAddress field type represents an email address, in the form of a string.

| Name           | Internal name |
|----------------|---------------|
| `EmailAddress` | `ibexa_email` |

## Field value

The field value is the email address as a string, or `null` when the field is empty.

``` json
{
    "fieldDefinitionIdentifier": "email",
    "languageCode": "eng-GB",
    "fieldValue": "someuser@example.com"
}
```

## Validation

This field type uses a validator to make sure that a valid email address has been provided.
If the validation fails, the request is rejected.

## Settings

This field type doesn't support settings.
