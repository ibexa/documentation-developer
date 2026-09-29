# Integer field type

This field type represents an integer value.

| Name    | Field type identifier |
|---------|-----------------------|
| Integer | `ibexa_integer`       |

## Field value

The field value is an integer, or `null` when the field is empty.

``` json
{
    "fieldDefinitionIdentifier": "quantity",
    "languageCode": "eng-GB",
    "fieldValue": 2397
}
```

## Validation

This field type supports `IntegerValueValidator`, defining maximum and minimum integer value:

| Name              | Type      | Default value | Description                                                |
|-------------------|-----------|---------------|--------------------------------------------------------------|
| `minIntegerValue` | `integer` | `null`        | Minimum value that this field type allows as input. |
| `maxIntegerValue` | `integer` | `null`        | Maximum value that this field type allows as input. |

``` json
{
    "validatorConfiguration": {
        "IntegerValueValidator": {
            "minIntegerValue": 0,
            "maxIntegerValue": 100
        }
    }
}
```

## Settings

This field type doesn't support settings.
