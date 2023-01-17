# Measurement Field Type

The Measurement Field Type represents measurement information. 
It stores the unit of measure, and either a single measurement value, 
or a pair of values that defines a range.

| Name          | Internal name       | Expected input type                                |
|---------------|---------------------|----------------------------------------------------|
| `Measurement` | `ibexa_measurement` | `Ibexa\Contracts\Measurement\Value\ValueInterface` |

## PHP API Field Type

### Input expectations

To create a value, you use a service that implements `Ibexa\Contracts\Measurement\MeasurementServiceInterface`.
You must inject the service directly with [dependency injection](php_api.md#service-container). 
The service contains the following API endpoints: 

- `buildSimpleValue` that is used to handle a single value
- `buildRangeValue` that is used to handle a range

Assuming that the service exists as `$measurementService`, the expected input 
examples are as follows:

| Type                                                    | Example                                                             |
|---------------------------------------------------------|---------------------------------------------------------------------|
|`\Ibexa\Contracts\Measurement\Value\SimpleValueInterface`| `$measurementService->buildSimpleValue('length', 2.5, 'centimeter')`|
|`\Ibexa\Contracts\Measurement\Value\RangeValueInterface` | `$measurementService->buildRangeValue('length', 1.2, 4.5,  'inch')` |

### Value object

##### Properties

The Value class of this Field Type contains the following properties:

| Property | Type                                             | Description                                                                                                          |
|----------|--------------------------------------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `$value` |`Ibexa\Contracts\Measurement\Value\ValueInterface`| Stores the Measurement API Value, which can be either an instance of `Ibexa\Contracts\Measurement\Value\SimpleValueInterface` or `Ibexa\Contracts\Measurement\Value\RangeValueInterface`. |

##### Constructor

The `Measurement\Value` constructor for this value object initializes a new value 
object with the value provided. 
As its first argument it accepts an object of `Ibexa\Contracts\Measurement\Value\ValueInterface` type.

Depending on the selected input type, the object resembles the following examples:

``` php
// Simple input (single value) example

// @var MeasurementServiceInterface $measurementService

// Instantiates a Measurement Value object
$measurementValue = new Measurement\Value(
    $measurementService->buildSimpleValue(
                    'length',
                    13.5,
                    'centimeter'
    )
);
```

``` php
// Range input value example

// @var MeasurementServiceInterface $measurementService

// Instantiates a Measurement Value object
$measurementValue = new Measurement\Value(
    $measurementService->buildRangeValue(
        'volume',
        0.5,
        0.7,
        'liter'
    )
);
```

### Validation

The Measurement Field Type validates measurement types and units passed within 
the value object against a list of the ones that the system supports, which can 
be found in the `vendor/ibexa/measurement/src/bundle/Resources/config/builtin_units.yaml` file.

### Modify and add Measurement types and units

You can extend the default list of Measurement types and units by modifying the existing entries or adding new ones. 
To do this, you modify the YAML configuration, for example, by creating a `config/packages/ibexa_measurement.yaml` file.

To override an existing designation of the unit of measure by changing the symbol that corresponds to a nautical unit of speed, and to add a rotational speed unit, add the following lines to your YAML configuration:

```yaml
ibexa_measurement:
    types:
        speed:
            knot: { symbol: kt }
            revolutions per minute: { symbol: RPM }

ibexa:
    system:
        default:
            measurement:
                types:
                    speed:
                        - revolutions per minute
```

To add a new Measurement type with its own new units, add the following lines to your YAML configuration:

```yaml hl_lines="4"
ibexa_measurement:
    types:
        my_type:
            my_unit: { symbol: my, is_base_unit: true }
ibexa:
    system:
        default:
            measurement:
                types:
                    my_type:
                        - my_unit
```

The configuration also requires that exactly one unit needs
to be marked as `is_base_unit` as in highlighted line above.

!!! note

    To be available for selection in the Back Office, each new Measurement type or unit must be enabled for the  Back Office SiteAccess.
    
## Template rendering

The Measurement field is rendered with the [`ibexa_render_field()`](field_twig_functions.md#ibexa_render_field) Twig function.

Example:

``` html+twig
{{ ibexa_render_field(content, 'measurement') }}
```
