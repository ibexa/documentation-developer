# Country field type

This field type represents one or multiple countries.

| Name      | Internal name | Expected input |
|-----------|---------------|----------------|
| `Country` | `ezcountry`   | `array`        |

## PHP API field type 

### Input expectations

Example array:

``` php
[
    "JP" => [
        "Name" => "Japan",
        "Alpha2" => "JP",
        "Alpha3" => "JPN",
        "IDC" => 81
    ]
];
```

When you set an array directly on a content field you don't need to provide all this information, the field type assumes it's a hash and in this case accepts a simplified structure described below under [Hash format](#hash-format).

### Validation

This field type validates whether multiple countries are allowed by the field definition, and whether the [Alpha2](https://www.iso.org/iso-3166-country-codes.html) is valid according to the countries configured in [[= product_name =]].

### Settings

The field definition of this field type can be configured with one option:

| Name         | Type      | Default value | Description|
|--------------|-----------|---------------|------------|
| `isMultiple` | `boolean` | `false`       | This setting allows (if true) or prohibits (if false) the selection of multiple countries. |

``` php
// Country FieldType example settings
$settings = [
    "isMultiple" => true
];
```

### Hash format

The format used for serialization is simpler than the full format. It's also available when setting value on the content field, by setting the value to an array instead of the Value object. Example of that shown below:

``` php
// Value object content example
$content->fields["countries"] = [ "JP", "NO" ];
```

The format used by the toHash method is the Alpha2 value, however the input is capable of accepting either Name, Alpha2 or Alpha3 value as shown below in the Value object section.

### Value object

##### Properties

The Value class of this field type contains the following properties:

| Property     | Type      | Description|
|--------------|-----------|------------|
| `$countries` | `array[]` | This property is used for the country selection provided as input, as its attributes. |

``` php
// Value object content example
$value->countries = [
    "JP" => [
        "Name" => "Japan",
        "Alpha2" => "JP",
        "Alpha3" => "JPN",
        "IDC" => 81
    ]
];
```

##### Constructor

The `Country\Value` constructor initializes a new Value object with the value provided. It expects an array as input.

``` php
// Constructor example

// Instantiates a Country Value object
$countryValue = new Country\Value(
    [
        "JP" => [
            "Name" => "Japan",
            "Alpha2" => "JP",
            "Alpha3" => "JPN",
            "IDC" => 81
        ]
    ]
);
```
