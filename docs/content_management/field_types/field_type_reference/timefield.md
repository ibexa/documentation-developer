# Time field type

This field type represents time information.

Date information is **not stored**.
What is stored is the number of seconds, calculated from the beginning of the day in the given or the environment timezone.

| Name | Field type identifier |
|------|-----------------------|
| Time | `ibexa_time`          |

## Field value

The field value is an integer representing the number of seconds since the beginning of the day, or `null` when the field is empty.

``` json
{
    "fieldDefinitionIdentifier": "opening_time",
    "languageCode": "eng-GB",
    "fieldValue": 36000
}
```

## Validation

This field type doesn't perform validation of the input value.

## Settings

The field definition of this field type can be configured with several options:

| Name          | Type      | Default value     | Description                                                        |
|---------------|-----------|-------------------|----------------------------------------------------------------------|
| `useSeconds`  | `boolean` | `false`           | Used to control displaying of seconds in the output.                |
| `defaultType` | `string`  | `"DEFAULT_EMPTY"` | Default field value used by the editing interface. See the values below. |

| Value                    | Description                      |
|--------------------------|----------------------------------|
| `"DEFAULT_EMPTY"`        | Default value is empty.          |
| `"DEFAULT_CURRENT_TIME"` | Default value uses current time. |

``` json
{
    "fieldSettings": {
        "useSeconds": false,
        "defaultType": "DEFAULT_CURRENT_TIME"
    }
}
```
