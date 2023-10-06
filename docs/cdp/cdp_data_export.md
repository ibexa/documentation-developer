---
description: Data export in Ibexa CDP.
---

# Data export

## Extensibility
​
You can customize Content, User and Product data exported to CDP and you can control what Field Type information you want to export.
By default, custom Field Types have basic export functionality that casts their `Value` object to string ,thanks to `\Stringable` implementation. 
​
## Exporting FieldTypes
​
Field Types are exported with metadata, for example, ID, Field Definition name, type, value. You can also provide your own  `\Ibexa\Contracts\Cdp\Export\Content\FieldProcessorInterface` instance to extend metadata. Provided implementation has to be defined as a service and tagged with `ibexa.cdp.export.content.field_processor`. Additionally, you can specify `priority` to override default behavior. All system Field Processors use `-100` priority, anything with higher priority value overrides them.
​
The interface is simple and has two methods that you need to provide:

- **supports** method - decides whether your `FieldProcessor` can work with this Field instance.
- **process** method - takes `Field` instance and returns flat array with scalar values which is merged to the payload data.
​
A typical FieldType will be serialized to:
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
Keys are automatically prefixed with Field identifier. Only scalar values are allowed.
​
### Built in Field Processors for custom Field Types
​
There are a few system Field Processors that you can use when providing CDP export functionality to your custom Field Type:
​
### `\Ibexa\Cdp\Export\Content\FieldProcessor\SkippingFieldProcessor`
​
Causes FieldType to be completely omitted from exported payload. To avoid adding your Field Type data to the payload, register a new service as follows:
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
## Exporting FieldType values
​
To customize how your FieldType's value is exported, you can provide your own `\Ibexa\Contracts\Cdp\Export\Content\FieldValueProcessorInterface` instance. Your implementation has to be registered as a service manually or by autoconfiguration. The service have to use the tag `ibexa.cdp.export.content.field_value_processor`, optionally you can provide `priority` property to override other Field Value Processors.
​
* `FieldValueProcessorInterface::process` - this method takes `Field` instance and returns an `array` with simple scalar values that are applied to export data payload. If your FieldType returns signle value, provide `value` key in the array. You can return multiple values. A good example is Measurement FieldType where we can return measurements in configured unit as well as base unit, which makes easier comparisons in CDP Audience Builder.
* `FieldValueProcessorInterface::supports` - Decides if `FieldValueProcessor` can work with this `Field`. 
​
### Built in Field Value Processors for custom Field Types
​
There are a few system Field Value Processors that either work by default or can be registered for custom Field Types:
​
### `\Ibexa\Cdp\Export\Content\FieldValueProcessor\CastToStringFieldValueProcessor`
​
This is the default Field Value Processor that is used when no other FieldValueProcessor with higher priority has been registered. It leverages `\Stringable` implementation of FieldType's `\Ibexa\Core\FieldType\Value` object to use as a value in the final payload.
​
### `\Ibexa\Cdp\Export\Content\FieldValueProcessor\JsonHashFieldValueProcessor`
​
This Field Value Processor will output JSON data from hash representation of the Field Type (`\Ibexa\Contracts\Core\FieldType\FieldType::toHash` method is being used). This can be useful in some cases, however CDP has no colum mapping that lets you match records on JSON data directly. A basic string comparison can be used but it may not fit your use case. `JsonHashFieldValueProcessor` can be used by registering new service:
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