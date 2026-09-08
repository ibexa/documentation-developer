# Time field type

This field type represents time information.

Date information is **not stored**.

What is stored is the number of seconds, calculated from the beginning of the day in the given or the environment timezone.

| Name   | Internal name | Expected input type |
|--------|---------------|---------------------|
| `Time` | `ibexa_time`  | mixed               |

## Input expectations

If input value is of type `string` or `integer`, it's passed directly to the [PHP's built-in `\DateTime` class](https://www.php.net/manual/en/datetime.construct.php) constructor, therefore the same input format expectations apply.

It's also possible to directly pass an instance of `\DateTime`.

| Type        | Example                            |
|-------------|------------------------------------|
| `string`    | `"2012-08-28 12:20 Europe/Berlin"` |
| `integer`   | `1346149200`                       |
| `\DateTime` | `new \DateTime()`                  |

### Properties

The Value class of this field type contains the following properties:

| Property | Type                | Description                                                                       |
|----------|---------------------|-----------------------------------------------------------------------------------|
| `$time`  | `integer` or `null` | Holds the time information as a number of seconds since the beginning of the day. |

### Hash format

Value in hash format is an integer representing a number of seconds since the beginning of the day.

Example: `36000`

## Validation

This field type doesn't perform validation of the input value.

## Settings

The Field definition of this field type can be configured with several options:

| Name          | Type                                             | Default value         | Description                                                                       |
|---------------|--------------------------------------------------|-----------------------|-----------------------------------------------------------------------------------|
| `useSeconds`  | `boolean`                                        | `false`               | Used to control displaying of seconds in the output.                              |
| `defaultType` | `Type::DEFAULT_EMPTY Type::DEFAULT_CURRENT_TIME` | `Type::DEFAULT_EMPTY` | The constant used here defines default input value when using back-end interface. |
