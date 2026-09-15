# TextBlock field type

The field type handles a block of multiple lines of unformatted text. It's capable of handling up to 16,777,216 characters.

| Name        | Internal name |
|-------------|---------------|
| `TextBlock` | `ibexa_text`  |

## Field value

The field value is the text as a string, or `null` when the field is empty.

``` json
{
    "fieldDefinitionIdentifier": "body",
    "languageCode": "eng-GB",
    "fieldValue": "This is a block\nof unformatted text"
}
```

## Validation

This field type doesn't perform any special validation of the input value.

## Settings

The field definition of this field type can be configured with a single option:

| Name       | Type      | Default value | Description                                             |
|------------|-----------|---------------|-----------------------------------------------------------|
| `textRows` | `integer` | `10`          | Number of rows for the editing box in the editing interface. |

``` json
{
    "fieldSettings": {
        "textRows": 10
    }
}
```
