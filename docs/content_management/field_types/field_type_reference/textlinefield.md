# TextLine field type

This field type makes possible to store and retrieve a single line of unformatted text.
It's capable of handling up to 255 characters.

| Name       | Internal name  |
|------------|----------------|
| `TextLine` | `ibexa_string` |

## Field value

The field value is the text as a string, or `null` when the field is empty.

``` json
{
    "fieldDefinitionIdentifier": "title",
    "languageCode": "eng-GB",
    "fieldValue": "Flipper Zero"
}
```

## Validation

The input passed into this field type is subject to validation by the `StringLengthValidator`.
The length of the string provided must be between the minimum length defined in `minStringLength` and the maximum defined in `maxStringLength`.
The default value for both properties is `null`, which means that the validation is disabled by default.

``` json
{
    "validatorConfiguration": {
        "StringLengthValidator": {
            "minStringLength": null,
            "maxStringLength": 255
        }
    }
}
```

## Settings

This field type doesn't support settings.
