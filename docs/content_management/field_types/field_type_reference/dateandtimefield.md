# DateAndTime field type

This field type represents a full date and time information.

| Name          | Internal name | Expected input type |
|---------------|---------------|---------------------|
| `DateAndTime` | `ezdatetime`  | mixed             |

## PHP API field type 

### Input expectations

If input value is of type `string` or `integer`, it's passed directly to the [PHP's built-in `\DateTime` class constructor](https://www.php.net/manual/en/datetime.construct.php), therefore the same input format expectations apply.

It's also possible to directly pass an instance of `\DateTime`.

|Type|Example|
|------|------|
|`integer`|`"2017-08-28 12:20 Europe/Berlin"`|
|`integer`|`1346149200`|
|`\DateTime`|`new \DateTime()`|

### Value object

##### Properties

The Value class of this field type contains the following properties:

| Property | Type        | Description|
|----------|-------------|------------|
| `$value` | `\DateTime` | The date and time value as an instance of `\DateTime`. |

##### Constructor

The constructor for this value object initializes a new value object with the value provided. It accepts an instance of PHP's built-in `\DateTime` class.

##### String representation

String representation of the date value generates the date string in the format `D Y-d-m H:i:s` as accepted by [PHP's built-in `date()` function](https://www.php.net/manual/en/function.date.php).

|Character|Description|Example|
|---------|----------|--------|
|D|Three letter representation of a day, range Mon to Sun|Wed|
|Y|Four digit representation of a year|2016|
|d|Two digit representation of a day, range 01 to 31|22|
|m|Two digit representation of a month, range 01 to 12|05|
|H|Two digit representation of an hour, 24-hour format, range 00 to 23 |12|
|i|Two digit representation of minutes, range 00 to 59|19|
|s|Two digit representation of seconds, range 00 to 59|18|

Example: `Wed 2016-22-05 12:19:18`

### Hash format

Hash value of this field type is an array with two keys:

|Key|Type| Description                                                                                                                                             |Example|
|------|------|---------------------------------------------------------------------------------------------------------------------------------------------------------|------|
|`timestamp`|`integer`| Time information in [Unix format timestamp](https://en.wikipedia.org/wiki/Unix_time).                                                                   |`1400856992`|
|`rfc850`|`string`| Time information as a string in [RFC 850 date format](https://datatracker.ietf.org/doc/html/rfc850). As input, this has precedence over the timestamp value. |`"Friday, 23-May-14 14:56:14 GMT+0000"`|

``` php
$hash = [
    "timestamp" => 1400856992,
    "rfc850" => "Friday, 23-May-14 14:56:14 GMT+0000"
];
```

### Validation

This field type doesn't perform any special validation of the input value.

### Settings

The field definition of this field type can be configured with several options:

|Name|Type|Default value|Description|
|------|------|------|------|
|`useSeconds`|`boolean`|`false`|Used to control displaying of seconds in the output.|
|`defaultType`|`mixed`|`Type::DEFAULT_EMPTY`|One of the `DEFAULT_*` constants, used by the administration interface for setting the default field value. See below for more details.|
|`dateInterval`|`null|\DateInterval`|`null`|This setting complements `defaultType` setting and can be used only when the latter is set to `Type::DEFAULT_CURRENT_DATE_ADJUSTED`. In that case the default input value when using administration interface is adjusted by the given `\DateInterval`.|

Following `defaultType` default value options are available as constants in the `Ibexa\Core\FieldType\DateAndTime\Type` class:

|Constant|Description|
|------|------|
|`DEFAULT_EMPTY`|Default value is empty.|
|`DEFAULT_CURRENT_DATE`|Default value uses current date.|
|`DEFAULT_CURRENT_DATE_ADJUSTED`|Default value uses current date, adjusted by the interval defined in `dateInterval` setting.|

``` php
// DateAndTime FieldType example settings

use Ibexa\Core\FieldType\DateAndTime\Type;

$settings = [
    "useSeconds" => false,
    "defaultType" => Type::DEFAULT_EMPTY,
    "dateInterval" => null
];
```

## Template rendering

The template called by the [`ibexa_render_field()` Twig function](field_twig_functions.md#ibexa_render_field) while rendering a Date field has access to the following parameters:

| Parameter | Type     | Default | Description|
|-----------|----------|---------|------------|
| `locale`  | `string` |   n/a   | Internal parameter set by the system based on current request locale or if not set calculated based on the language of the field. |

Example:

``` php
{{ ibexa_render_field(content, 'datetime') }}
```
