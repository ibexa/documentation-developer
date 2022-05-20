# Measurement Field Type

This Field Type represents measurement information. What is stored is the unit of measure, and either single measurement value, or a pair of values that defines a range.

| Name          | Internal name       | Expected input type |
|---------------|---------------------|---------------------|
| `Measurement` | `ibexa_measurement` | `Ibexa\Contracts\Measurement\Value\ValueInterface`               |

## PHP API Field Type

### Input expectations

To create a value, a Service of `\Ibexa\Contracts\Measurement\MeasurementServiceInterface` type is required.
It should be injected directly using Symfony Dependency Injection. It contains the following API endpoints:
- `buildSimpleValue`
- `buildRangeValue`

Assuming, the service exists as `$measurementService`:

Type| Example                                                             |
|------|---------------------------------------------------------------------|
|`\Ibexa\Contracts\Measurement\Value\SimpleValueInterface`| `$measurementService->buildSimpleValue('length', 2.5, 'centimeter')` |
|`\Ibexa\Contracts\Measurement\Value\RangeValueInterface`| `$measurementService->buildRangeValue('length', 1.2, 4.5,  'inch')` |

### Value object

##### Properties

The Value class of this Field Type contains the following properties:

| Property                        | Type           | Description                                                                                                                        |
|---------------------------------|----------------|------------------------------------------------------------------------------------------------------------------------------------|
| `$value`                        |`Ibexa\Contracts\Measurement\Value\ValueInterface`| Stores the API Measurement Value, which can be either an instance of `\Ibexa\Contracts\Measurement\Value\SimpleValueInterface` or `\Ibexa\Contracts\Measurement\Value\RangeValueInterface` |

##### Constructor

The `Measurement\Value`constructor for this Value object initializes a new Value object with the value provided. It accepts as the first argument an object of `Ibexa\Contracts\Measurement\Value\ValueInterface` type. 

``` php
// Simple input (single value) example

// @var MeasurementServiceInterface $measurementService

// Instantiates a Measurement Value object
$measurementValue = new Measurement\Value(
    $measurementService->buildSimpleValue(
                    'length',
                    2.5,
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

This Field Type validates given measurement types and units against the ones supported by the system.

```yaml

    length:
        meter: { symbol: m }
        centimeter: { symbol: cm }
        millimeter: { symbol: mm }
        foot: { symbol: ft }
        inch: { symbol: in }
        yard: { symbol: yd }
    area:
        acre: { symbol: ac }
        hectare: { symbol: ha }
        square foot: { symbol: sq ft }
        square inch: { symbol: sq in }
        square meter: { symbol: sq m }
        square mile: { symbol: sq mi }
        square yard: { symbol: sq yd }
    mass:
        gram: { symbol: g }
        imperial ton: { symbol: UK t }
        kilogram: { symbol: kg }
        microgram: { symbol: μg }
        milligram: { symbol: mg }
        ounce: { symbol: oz. }
        pound: { symbol: £ }
        stone: { symbol: st. }
        tonne: { symbol: t }
        US ton: { symbol: US t }
    pressure:
        bar: { symbol: bar }
        pascal: { symbol: Pa }
        pound per square inch: { symbol: psi }
    speed:
        foot per second: { symbol: ft/s }
        kilometer per hour: { symbol: km/h }
        knot: { symbol: kn }
        meter per second: { symbol: m/s }
        miles per hour: { symbol: mph }
    temperature:
        celsius: { symbol: °C }
        fahrenheit: { symbol: °F }
        kelvin: { symbol: K }
    time:
        day: { symbol: D }
        hour: { symbol: H }
        millisecond: { symbol: ms }
        minute: { symbol: m }
        month: { symbol: M }
        second: { symbol: s }
        week: { symbol: W }
    volume:
        cubic meter: { symbol: m^3 }
        fluid ounce: { symbol: fl. oz. }
        liter: { symbol: l }
        milliliter: { symbol: ml }
        US legal cup: { symbol: c (US) }
        US liquid gallon: { symbol: gal }
        US liquid pint: { symbol: pt }
        US liquid quart: { symbol: qt }
        US tablespoon: { symbol: tbsp }
        US teaspoon: { symbol: tsp }
    data transfer rate:
        gibibit per second: { symbol: Gibit/s }
        gibibyte per second: { symbol: GiB/s }
        gigabit per second: { symbol: Gb/s }
        mebibit per second: { symbol: Mibit/s }
        megabit per second: { symbol: Mb/s }
        megabyte per second: { symbol: MB/s }
        terabit per second: { symbol: Tb/s }
        terabyte per second: { symbol: TB/s }
    energy:
        British thermal unit: { symbol: Btu }
        electronvolt: { symbol: eV }
        gram calorie: { symbol: cal }
        joule: { symbol: J }
        kilocalorie: { symbol: kcal }
        kilojoule: { symbol: kJ }
        kilowatt hour: { symbol: kWh }
        US therm: { symbol: thm }
        watt hour: { symbol: Wh }
```

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
