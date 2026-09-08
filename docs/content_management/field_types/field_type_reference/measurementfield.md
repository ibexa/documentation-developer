---
saas_review:
    - siteaccess
    - links_removed
saas_review_note: >-
    Each Measurement type and unit must be enabled for the back office SiteAccess before
    it can be selected. Confirm where that per-SiteAccess enabling happens once
    SiteAccess configuration moves to a UI.

    Links to the deleted php_api.md and field_twig_functions.md pages were removed;
    check that the surrounding text still reads correctly.
---

# Measurement field type

The Measurement field type represents measurement information.
It stores the unit of measure, and either a single measurement value, or a pair of top and bottom values that defines a range.

| Name          | Internal name       | Expected input type                                |
|---------------|---------------------|----------------------------------------------------|
| `Measurement` | `ibexa_measurement` | `Ibexa\Contracts\Measurement\Value\ValueInterface` |

## Input expectations

To create a value, you use a service that implements `Ibexa\Contracts\Measurement\MeasurementServiceInterface`.
You must inject the service directly with [dependency injection]([[= symfony_doc =]]/service_container.html).
The service contains the following API endpoints:

- `buildSimpleValue` that is used to handle a single value
- `buildRangeValue` that is used to handle a range

Assuming that the service exists as `$measurementService`, the expected input examples are as follows:

| Type                                                    | Example                                                              |
|---------------------------------------------------------|----------------------------------------------------------------------|
|`\Ibexa\Contracts\Measurement\Value\SimpleValueInterface`| `$measurementService->buildSimpleValue('length', 2.5, 'centimeter')` |
|`\Ibexa\Contracts\Measurement\Value\RangeValueInterface` | `$measurementService->buildRangeValue('length', 1.2, 4.5,  'inch')`  |

### Properties

The Value class of this field type contains the following properties:

| Property | Type                                               | Description                                                                                                                                                                               |
|----------|----------------------------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `$value` | `Ibexa\Contracts\Measurement\Value\ValueInterface` | Stores the Measurement API Value, which can be either an instance of `Ibexa\Contracts\Measurement\Value\SimpleValueInterface` or `Ibexa\Contracts\Measurement\Value\RangeValueInterface`. |

## Validation

The Measurement field type validates measurement types and units passed within the value object against a list of the ones that the system supports, which can be found in the `vendor/ibexa/measurement/src/bundle/Resources/config/builtin_units.yaml` file.

## Modify and add Measurement types and units

You can extend the default list of Measurement types and units by modifying the existing entries or adding new ones.
To do this, you modify the YAML configuration.

To override an existing designation of the unit of measure by changing the symbol that corresponds to a nautical unit of speed, and to add a rotational speed unit, add the following lines to your [YAML configuration](configuration.md#configuration-files):

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

The configuration also requires that exactly one unit needs to be marked as `is_base_unit` as in highlighted line above.

!!! note

    To be available for selection in the back office, each new Measurement type or unit must be enabled for the back office SiteAccess.

Next, you need to define how the new unit should be converted under the `ibexa.system.<scope>.ibexa_measurement` [configuration key](configuration.md#configuration-files):

```yaml
ibexa_measurement:
    conversion:
        formulas:
            - { source_unit: foo, target_unit: bar, formula: 'value / 100' }
    types:
        length:
            foo: { symbol: foo }
            bar: { symbol: bar }
```

!!! tip

    The `target_unit` must be an existing unit, for example meter, otherwise the conversion results in an error.
