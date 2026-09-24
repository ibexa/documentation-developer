# ISBN field type

This field type represents an ISBN string either an ISBN-10 or ISBN-13 format.

| Name | Field type identifier |
|------|-----------------------|
| ISBN | `ibexa_isbn`          |

## Field value

The field value is the ISBN as a string, or `null` when the field is empty.

``` json
{
    "fieldDefinitionIdentifier": "isbn",
    "languageCode": "eng-GB",
    "fieldValue": "9783161484100"
}
```

## Validation

The input is validated as an ISBN-13 or ISBN-10 number, depending on the `isISBN13` field definition setting.

## Settings

The field definition of this field type can be configured with a single option:

| Name       | Type      | Default value | Description                                                                    |
|------------|-----------|---------------|--------------------------------------------------------------------------------|
| `isISBN13` | `boolean` | `true`        | When `true`, input is validated as ISBN-13, otherwise it's validated as ISBN-10. |

``` json
{
    "fieldSettings": {
        "isISBN13": true
    }
}
```
