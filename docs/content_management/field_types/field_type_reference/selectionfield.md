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

!!! caution "Option indexes aren't always array positions"

    Option indexes come from the field definition and don't have to be consecutive.
    Because the API returns `options` as an array, a gap in the indexes isn't visible in the response,
    and the position of an option in that array is then no longer its index.

    For example, a field defined with the options `0`, `2` and `5` returns
    `["Small", "Medium", "Large"]`.
    The field value `[5]` selects `Large`, and the values `[1]`, `[3]` and `[4]` are rejected,
    even though the returned array has entries at positions `1` and `2`.

## Validation

This field type validates the input, verifying if all selected options exist in the field definition and checking if multiple selections are allowed in the field definition.
If any of these validations fail, the request is rejected.
When option validation fails, a list with the invalid options is also presented.

## Settings

| Name                  | Type      | Default value            | Description                                                        |
|-----------------------|-----------|--------------------------|----------------------------------------------------------------------|
| `isMultiple`          | `boolean` | `false`                  | Used to allow or prohibit multiple selection from the option list. |
| `options`             | `array`   | `[]`                     | The list of options defined in the field definition.               |
| `multilingualOptions` | `object`  | `{"<languageCode>": []}` | The list of options per language code.                             |

On input, you can provide `options` either as an array, or as an object keyed by option index.
On output, the API always returns an array.

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
