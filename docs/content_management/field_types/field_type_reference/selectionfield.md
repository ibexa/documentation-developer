# Selection field type

The Selection field type stores single selections or multiple choices from a list of options defined in the field definition.

| Name        | Internal name     |
|-------------|-------------------|
| `Selection` | `ibexa_selection` |

## Field value

The field value is an array of integers, each one the index of a selected option in the `options` field definition setting.

``` json
{
    "fieldDefinitionIdentifier": "size",
    "languageCode": "eng-GB",
    "fieldValue": [1, 2]
}
```

## Validation

This field type validates the input, verifying if all selected options exist in the field definition and checking if multiple selections are allowed in the field definition.
If any of these validations fail, the request is rejected.
When option validation fails, a list with the invalid options is also presented.

## Settings

| Name                  | Type      | Default value | Description                                                                        |
|-----------------------|-----------|---------------|--------------------------------------------------------------------------------------|
| `isMultiple`          | `boolean` | `false`       | Used to allow or prohibit multiple selection from the option list.                  |
| `options`             | `object`  | `{}`          | The list of options defined in the field definition, keyed by option index.         |
| `multilingualOptions` | `object`  | `{}`          | The list of options per language code, keyed by language code and then option index. |

``` json
{
    "fieldSettings": {
        "isMultiple": true,
        "options": {
            "0": "Small",
            "1": "Medium",
            "2": "Large"
        }
    }
}
```
