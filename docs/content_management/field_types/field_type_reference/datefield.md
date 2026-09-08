# Date field type

This field type represents a date without time information.

| Name   | Internal name | Expected input type |
|--------|---------------|---------------------|
| `Date` | `ibexa_date`  | mixed               |

## Input expectations

If input value is in `string` or `integer` format, it's passed directly to [PHP's built-in `\DateTime` class constructor](https://www.php.net/manual/en/datetime.construct.php), therefore the same input format expectations apply.

It's also possible to directly pass an instance of `\DateTime`.

| Type        | Example                            |
|-------------|------------------------------------|
| `string`    | `"2012-08-28 12:20 Europe/Berlin"` |
| `integer`   | `1346149200`                       |
| `\DateTime` | `new \DateTime()`                  |

Time information is **not stored**.

Before storing, the provided input value is set to the beginning of the day in the given or the environment timezone.

### Properties

The Value class of this field type contains the following properties:

| Property | Type        | Description                                 |
|----------|-------------|---------------------------------------------|
| `$date`  | `\DateTime` | This property is used for the text content. |

## Hash format

Hash value of this field type is an array with two keys:

| Key         | Type      | Description                                                                                                                                                         | Example                                 |
|-------------|-----------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------|-----------------------------------------|
| `timestamp` | `integer` | Time information in [Unix format timestamp](https://en.wikipedia.org/wiki/Unix_time).                                                                               | `1400856992`                            |
| `rfc850`    | `string`  | Time information as a string in [RFC 850 date format](https://datatracker.ietf.org/doc/html/rfc850). As input, this has higher precedence over the timestamp value. | `"Friday, 23-May-14 14:56:14 GMT+0000"` |

## Validation

This field type doesn't perform any special validation of the input value.

## Settings

The field definition of this field type can be configured with a single option:

| Name          | Type    | Default value         | Description                                                                                                                             |
|---------------|---------|-----------------------|-----------------------------------------------------------------------------------------------------------------------------------------|
| `defaultType` | `mixed` | `Type::DEFAULT_EMPTY` | One of the `DEFAULT_*` constants, used by the administration interface for setting the default field value. See below for more details. |

Following `defaultType` default value options are available as constants in the `Ibexa\Core\FieldType\Date\Type` class:

| Constant               | Description                      |
|------------------------|----------------------------------|
| `DEFAULT_EMPTY`        | Default value is empty.          |
| `DEFAULT_CURRENT_DATE` | Default value uses current date. |
