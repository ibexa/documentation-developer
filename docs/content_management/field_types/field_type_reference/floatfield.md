# Float field type

This field type stores numeric values which are provided as floats.

| Name    | Internal name |
|---------|---------------|
| `Float` | `ibexa_float` |

## Field value

The field value is a number, or `null` when the field is empty.
Both decimal and integer numbers are accepted as input, and numeric strings are cast to a float.

``` json
{
    "fieldDefinitionIdentifier": "weight",
    "languageCode": "eng-GB",
    "fieldValue": 194079.572
}
```

## Validation

This field type supports `FloatValueValidator`, defining maximum and minimum float value:

| Name            | Type    | Default value | Description                                              |
|-----------------|---------|---------------|------------------------------------------------------------|
| `minFloatValue` | `float` | `null`        | Minimum value that this field type allows as input. |
| `maxFloatValue` | `float` | `null`        | Maximum value that this field type allows as input. |

``` json
{
    "validatorConfiguration": {
        "FloatValueValidator": {
            "minFloatValue": 0.0,
            "maxFloatValue": 1000.0
        }
    }
}
```

## Settings

This field type doesn't support settings.
