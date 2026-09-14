# Checkbox field type

The Checkbox field type stores the current status for a checkbox input, checked or unchecked.

| Name       | Internal name   |
|------------|-----------------|
| `Checkbox` | `ibexa_boolean` |

## Field value

The field value is a boolean: `true` when the checkbox is checked, `false` when it isn't.
It's never considered empty.

``` json
{
    "fieldDefinitionIdentifier": "enable_comments",
    "languageCode": "eng-GB",
    "fieldValue": true
}
```
