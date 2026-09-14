# Measurement field type

The Measurement field type represents measurement information.
It stores the unit of measure, and either a single measurement value, or a pair of top and bottom values that defines a range.

| Name          | Internal name       |
|---------------|---------------------|
| `Measurement` | `ibexa_measurement` |

## Field value

The field value is an object, or `null` when the field is empty.
Its shape depends on the `inputType` key:

| Key                            | Type      | Description                                                             | Example      |
|--------------------------------|-----------|---------------------------------------------------------------------------|--------------|
| `measurementType`              | `string`  | Type of measurement, for example `length` or `mass`.                     | `length`     |
| `measurementUnit`              | `string`  | Identifier of the unit of measure, for example `centimeter`.             | `centimeter` |
| `inputType`                    | `integer` | `0` for a single value, `1` for a range.                                 | `0`          |
| `value`                        | `float`   | The measurement value. Used when `inputType` is `0`.                     | `2.5`        |
| `measurementRangeMinimumValue` | `float`   | Bottom value of the range. Used when `inputType` is `1`.                 | `1.2`        |
| `measurementRangeMaximumValue` | `float`   | Top value of the range. Used when `inputType` is `1`.                    | `4.5`        |

A single value:

``` json
{
    "fieldDefinitionIdentifier": "length",
    "languageCode": "eng-GB",
    "fieldValue": {
        "measurementType": "length",
        "measurementUnit": "centimeter",
        "value": 2.5,
        "inputType": 0
    }
}
```

A range:

``` json
{
    "fieldDefinitionIdentifier": "length",
    "languageCode": "eng-GB",
    "fieldValue": {
        "measurementType": "length",
        "measurementUnit": "inch",
        "measurementRangeMinimumValue": 1.2,
        "measurementRangeMaximumValue": 4.5,
        "inputType": 1
    }
}
```

## Measurement types and units

The following measurement types are available: `length`, `area`, `mass`, `pressure`, `speed`, `temperature`, `time`, `volume`, `datatransferrate`, and `energy`.
Each type comes with a set of units, for example `meter`, `centimeter`, `millimeter`, `foot`, `inch`, and `yard` for `length`.

## Validation

The field type validates the measurement type and unit passed in the value against the list of supported ones.

The field type supports `MeasurementValidator`, which constrains what the field accepts:

| Name                       | Type      | Default value | Description                                                     |
|----------------------------|-----------|---------------|-------------------------------------------------------------------|
| `measurementType`          | `string`  | `null`        | The only measurement type accepted by the field.                |
| `measurementUnit`          | `string`  | `null`        | The only unit of measure accepted by the field.                 |
| `inputType`                | `integer` | `null`        | `0` to accept a single value only, `1` to accept a range only.  |
| `sign`                     | `string`  | `null`        | Comparison operator applied to `minimum` and `maximum`.         |
| `minimum`                  | `float`   | `null`        | Minimum accepted value.                                         |
| `maximum`                  | `float`   | `null`        | Maximum accepted value.                                         |
| `defaultValue`             | `float`   | `null`        | Default single value.                                           |
| `defaultRangeMinimumValue` | `float`   | `null`        | Default bottom value of the range.                              |
| `defaultRangeMaximumValue` | `float`   | `null`        | Default top value of the range.                                 |

``` json
{
    "validatorConfiguration": {
        "MeasurementValidator": {
            "measurementType": "length",
            "measurementUnit": "centimeter",
            "inputType": 0,
            "minimum": 0.0,
            "maximum": 100.0
        }
    }
}
```
