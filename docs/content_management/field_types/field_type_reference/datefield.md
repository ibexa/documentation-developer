# Date field type

This field type represents a date without time information.

Time information is **not stored**.
Before storing, the provided input value is set to the beginning of the day in the given or the environment timezone.

| Name   | Internal name |
|--------|---------------|
| `Date` | `ibexa_date`  |

## Field value

The field value is an object with the following keys, or `null` when the field is empty:

| Key         | Type      | Description                                                                          | Example                                 |
|-------------|-----------|--------------------------------------------------------------------------------------|-----------------------------------------|
| `timestamp` | `integer` | Date information in [Unix format timestamp](https://en.wikipedia.org/wiki/Unix_time). | `1400856992`                            |
| `rfc850`    | `string`  | Date information as a string in [RFC 850 date format](https://datatracker.ietf.org/doc/html/rfc850). | `"Friday, 23-May-14 14:56:14 GMT+0000"` |

``` json
{
    "fieldDefinitionIdentifier": "publication_date",
    "languageCode": "eng-GB",
    "fieldValue": {
        "timestamp": 1400856992,
        "rfc850": "Friday, 23-May-14 14:56:14 GMT+0000"
    }
}
```

On input, you can provide any one of the following keys. `rfc850` takes precedence over `timestring`, which takes precedence over `timestamp`:

| Key          | Type      | Description                                    | Example                            |
|--------------|-----------|------------------------------------------------|------------------------------------|
| `rfc850`     | `string`  | Date as an RFC 850 string.                     | `"Friday, 23-May-14 14:56:14 GMT+0000"` |
| `timestring` | `string`  | Date as a string in any commonly used format.  | `"2012-08-28 12:20 Europe/Berlin"` |
| `timestamp`  | `integer` | Date as a Unix timestamp.                      | `1346149200`                       |

## Validation

This field type doesn't perform any special validation of the input value.

## Settings

The field definition of this field type can be configured with a single option:

| Name          | Type     | Default value     | Description                                                        |
|---------------|----------|-------------------|----------------------------------------------------------------------|
| `defaultType` | `string` | `"DEFAULT_EMPTY"` | Default field value used by the editing interface. See the values below. |

| Value                    | Description                      |
|--------------------------|----------------------------------|
| `"DEFAULT_EMPTY"`        | Default value is empty.          |
| `"DEFAULT_CURRENT_DATE"` | Default value uses current date. |

``` json
{
    "fieldSettings": {
        "defaultType": "DEFAULT_CURRENT_DATE"
    }
}
```
