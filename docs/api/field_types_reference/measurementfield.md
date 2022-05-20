# Measurement Field Type

The Measurement Field Type represents measurement information. 
It stores the unit of measure, and either a single measurement value, 
or a pair of values that defines a range.

| Name          | Internal name       | Expected input type                                |
|---------------|---------------------|----------------------------------------------------|
| `Measurement` | `ibexa_measurement` | `Ibexa\Contracts\Measurement\Value\ValueInterface` |

## PHP API Field Type

### Input expectations

To create a value, a Service of `Ibexa\Contracts\Measurement\MeasurementServiceInterface` 
type is required.
You must inject the service directly with [dependency injection(../api/service_container.md). 
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

The `Measurement\Value`constructor for this Value object initializes a new Value 
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
the Value object against a list of the ones that the system supports, which can 
be found in the `/Resources/config/builtin_units.yaml` file.

## Template rendering

Example:

``` html+twig
{{ ibexa_render_field(content, 'measurement') }}
```

## Extending Measurement Types and units

`config/packages/ibexa_measurement.yaml`:

```yaml
ibexa_measurement:
    types:
        speed:
            knot: { symbol: kt } # override existing unit symbol
            new_unit: { symbol: new } # add new unit to the existing type
        my_type: # define new custom type and its units
            my_unit: { symbol: my }

# each new type or unit needs to be enabled per given SiteAccess to be visible in AdminUI
ibexa:
    system:
        default:
            measurement:
                types:
                    speed:
                        - new_unit
                    my_type:
                        - my_unit

```
