---
description: Data customization in Ibexa CDP.
---

# Data customization
​
You can customize Content and Product data exported to CDP and you can control what Field Type information you want to export.
By default, custom Field Types have basic export functionality. It casts their `Value` object to string, thanks to `\Stringable` implementation.
​
## Exporting Field Types
​
Field Types are exported with metadata, for example, ID, Field Definition name, type, value. 
You can also provide your own  `\Ibexa\Contracts\Cdp\Export\Content\FieldProcessorInterface` instance to extend metadata. 
Provided implementation has to be defined as a service and tagged with `ibexa.cdp.export.content.field_processor`. 
Additionally, you can specify `priority` to override default behavior. 
All system Field Processors use `-100` priority, and any higher priority value overrides them.

The interface is plain and has two methods that you need to provide:

- **supports** - decides whether your `FieldProcessor` can work with the `Field` instance.
- **process** - takes `Field` instance and then returns a flat array of scalar values that are combined with the payload data.
​
A common Field Type is serialized to:
​
```json
{
    "field_measurement_simple_id": 1792,
    "field_measurement_simple_type": "ibexa_measurement",
    "field_measurement_simple_language_code": "eng-GB",
    "field_measurement_simple_value_measurement": "data transfer rate",
    "field_measurement_simple_value_unit_identifier": "megabyte per second",
    "field_measurement_simple_value_unit_symbol": "MB/s",
    "field_measurement_simple_value_unit_is_base": false,
    "field_measurement_simple_value_base_unit_identifier": "bit per second",
    "field_measurement_simple_value_base_unit_symbol": "bit/s",
    "field_measurement_simple_value_simple": 100,
    "field_measurement_simple_value_simple_base_unit": 800000000
}
```
​
Field identifier is a prefix that is automatically added to each key. You can only use scalar values.
​
### Built in Field Processors for custom Field Types
​
You may provide your own CDP export functionality by using one of the system Field Processors:

#### `\Ibexa\Cdp\Export\Content\FieldProcessor\SkippingFieldProcessor`.
​
It results in the Field Type being excluded from the exported payload.
To avoid adding the Field Type data to the payload, register a new service as follow:
​
```yaml
custom_fieldtype.cdp.export.field_processor:
    class: Ibexa\Cdp\Export\Content\FieldProcessor\SkippingFieldProcessor
    autoconfigure: false
    arguments:
        $fieldTypeIdentifier: custom_fieldtype
    tags:
        - { name: 'ibexa.cdp.export.content.field_processor', priority: 0 }
```
​
## Exporting Field Type values
​
To customize export of Field Type values, provide your own `\Ibexa\Contracts\Cdp\Export\Content\FieldValueProcessorInterface` instance.
New implementation has to be registered as a service manually or by using autoconfiguration. 
The service has to use the tag `ibexa.cdp.export.content.field_value_processor`, you can also provide `priority` property to override other Field Value Processors.
​
* `FieldValueProcessorInterface::process` - takes `Field` instance and returns an `array` with scalar values that are applied to export data payload.
If the Field Type returns single value, provided `value` key in the array. You can return multiple values.

* `FieldValueProcessorInterface::supports` - decides whether `FieldValueProcessor` can work with the `Field`.
​
### Built in Field Value Processors for custom Field Types
​
Several system Field Value Processors either work by default or can be registered for custom Field Types:
​
#### `\Ibexa\Cdp\Export\Content\FieldValueProcessor\CastToStringFieldValueProcessor`
​
This Processor is a default one, as long as no other Processor with higher priority is registered. It makes `\Stringable` implementation of the Field Type `\Ibexa\Core\FieldType\Value` object to use it as a value in the final payload.
​
#### `\Ibexa\Cdp\Export\Content\FieldValueProcessor\JsonHashFieldValueProcessor`
​
This Processor generates JSON data from hash representation of the Field Type (it uses `\Ibexa\Contracts\Core\FieldType\FieldType::toHash` method).

!!! warning

    CDP doesn't support column mapping, which allows you to match records on JSON data directly.

To use `JsonHashFieldValueProcessor`, you need to register a new service:
​
```yaml
custom_fieldtype.cdp.export.field_processor:
    class: Ibexa\Cdp\Export\Content\FieldValueProcessor\JsonHashFieldValueProcessor
    autoconfigure: false
    arguments:
        $fieldTypeIdentifier: custom_fieldtype
    tags:
        - { name: 'ibexa.cdp.export.content.field_value_processor', priority: 0 }
```