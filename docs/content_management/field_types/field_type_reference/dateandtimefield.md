# DateAndTime field type

This field type represents a full date and time information.

| Name          | Internal name    |
|---------------|------------------|
| `DateAndTime` | `ibexa_datetime` |

## Field value

The field value is an object with the following keys, or `null` when the field is empty:

| Key         | Type      | Description                                                                          | Example                                 |
|-------------|-----------|--------------------------------------------------------------------------------------|-----------------------------------------|
| `timestamp` | `integer` | Time information in [Unix format timestamp](https://en.wikipedia.org/wiki/Unix_time). | `1400856992`                            |
| `rfc850`    | `string`  | Time information as a string in [RFC 850 date format](https://datatracker.ietf.org/doc/html/rfc850). | `"Friday, 23-May-14 14:56:14 GMT+0000"` |

``` json
{
    "fieldDefinitionIdentifier": "event_start",
    "languageCode": "eng-GB",
    "fieldValue": {
        "timestamp": 1400856992,
        "rfc850": "Friday, 23-May-14 14:56:14 GMT+0000"
    }
}
```

On input, you can provide any one of the following keys. `rfc850` takes precedence over `timestring`, which takes precedence over `timestamp`:

| Key          | Type      | Description                                            | Example                            |
|--------------|-----------|--------------------------------------------------------|------------------------------------|
| `rfc850`     | `string`  | Date and time as an RFC 850 string.                    | `"Friday, 23-May-14 14:56:14 GMT+0000"` |
| `timestring` | `string`  | Date and time as a string in any commonly used format. | `"2017-08-28 12:20 Europe/Berlin"` |
| `timestamp`  | `integer` | Date and time as a Unix timestamp.                     | `1346149200`                       |

## Validation

This field type doesn't perform any special validation of the input value.

## Settings

The field definition of this field type can be configured with several options:

| Name           | Type      | Default value     | Description                                                                                                                |
|----------------|-----------|-------------------|------------------------------------------------------------------------------------------------------------------------------|
| `useSeconds`   | `boolean` | `false`           | Used to control displaying of seconds in the output.                                                                        |
| `defaultType`  | `string`  | `"DEFAULT_EMPTY"` | Default field value used by the editing interface. See the values below.                                                     |
| `dateInterval` | `object`  | `null`            | Complements the `defaultType` setting and is used only when the latter is set to `"DEFAULT_CURRENT_DATE_ADJUSTED"`. The default input value is then adjusted by the given interval. |

| Value                             | Description                                                                                  |
|-----------------------------------|----------------------------------------------------------------------------------------------|
| `"DEFAULT_EMPTY"`                 | Default value is empty.                                                                      |
| `"DEFAULT_CURRENT_DATE"`          | Default value uses current date.                                                             |
| `"DEFAULT_CURRENT_DATE_ADJUSTED"` | Default value uses current date, adjusted by the interval defined in `dateInterval` setting. |

``` json
{
    "fieldSettings": {
        "useSeconds": false,
        "defaultType": "DEFAULT_CURRENT_DATE"
    }
}
```
