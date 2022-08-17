# Time Field Type

This Field Type represents time information.

Date information is **not stored**.

What is stored is the number of seconds, calculated from the beginning of the day in the given or the environment timezone.

| Name   | Internal name | Expected input type |
|--------|---------------|---------------------|
| `Time` | `eztime`      | mixed             |

## PHP API Field Type

### Input expectations

If input value is of type `string` or `integer`, it will be passed directly to the [PHP's built-in `\DateTime` class](http://www.php.net/manual/en/datetime.construct.php) constructor, therefore the same input format expectations apply.

It is also possible to directly pass an instance of `\DateTime`.

|Type|Example|
|------|------|
|`string`|`"2012-08-28 12:20 Europe/Berlin"`|
|`integer`|`1346149200`|
|`\DateTime`|`new \DateTime()`|

### Value object

##### Properties

The Value class of this Field Type contains the following properties:

| Property | Type           | Description|
|----------|----------------|------------|
| `$time`  | `integer|null` | Holds the time information as a number of seconds since the beginning of the day. |

##### Constructor

The constructor for this Value object will initialize a new Value object with the value provided. It accepts an integer representing the number of seconds since the beginning of the day.

##### String representation

String representation of the date value will generate the date string in the format "H:i:s" as accepted by [PHP's built-in `date()` function](http://www.php.net/manual/en/function.date.php).

|Character|Description|Example|
|---------|----------|--------|
|H|Two digit representation of an hour, 24-hour format, range 00 to 23 |12|
|i|Two digit representation of minutes, range 00 to 59|14|
|s|Two digit representation of seconds, range 00 to 59|56|

Example: `"12:14:56"`

### Hash format

Value in hash format is an integer representing a number of seconds since the beginning of the day.

Example: `36000`

### Validation

This Field Type does not perform validation of the input value.

### Settings

The Field definition of this Field Type can be configured with several options:

|Name|Type|Default value|Description|
|------|------|------|------|
|`useSeconds`|`boolean`|`false`|Used to control displaying of seconds in the output.|
|`defaultType`|`Type::DEFAULT_EMPTY Type::DEFAULT_CURRENT_TIME`|`Type::DEFAULT_EMPTY`|The constant used here defines default input value when using back-end interface.|

``` php
// Time Field Type example settings
use Ibexa\Core\FieldType\Time\Type;

$settings = [
    "defaultType" => DateAndTime::DEFAULT_EMPTY
];
```

## Template rendering

The template called by [the `ibexa_render_field()` Twig function](field_twig_functions.md#ibexa_render_field) while rendering a Date Field has access to the following parameters:

| Parameter | Type     | Default | Description|
|-----------|----------|---------|------------|
| `locale`  | `string` |   n/a   | Internal parameter set by the system based on current request locale or, if not set, calculated based on the language of the Field. |

Example:

``` php
{{ ibexa_render_field(content, 'time') }}
```
