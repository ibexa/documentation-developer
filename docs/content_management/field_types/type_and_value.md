---
description: The basis of all field types are their Type and Value classes, containing, respectively, the logic and the data for the fields.
---

# Type and Value

A field type must contain a Type class which contains the logic of the field type, for example, validating data, transforming from various formats, or describing the validators.
A Type class must implement `Ibexa\Core\FieldType\FieldType` ("field type interface").
All native field types also extend the `Ibexa\Core\FieldType\FieldType` abstract class that implements this interface and provides implementation facilities through a set of abstract methods of its own.

You should also provide a value object class for storing the custom field value provided by the field type.
The Value is used to represent an instance of the field type within a content item.
Each field presents its data using an instance of the Type's Value class.
A Value class must implement the `Ibexa\Contracts\Core\FieldType` interface.
It may also extend the `Ibexa\Core\FieldType\Value` abstract class.
It's meant to be stateless and as lightweight as possible.
This class must contain as little logic as possible, because the logic is handled by the Type class.

## Type class

The Type class of a field type provides an implementation of the [`Ibexa\Contracts\Core\FieldType\FieldType`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-FieldType-FieldType.html) interface.

### Field Definition handling

A custom field type is used in a field definition of a custom content type.
You can additionally provide [settings for the field type](#field-type-settings) and a [validator configuration](field_type_validation.md).
Since the public PHP API cannot know anything about these, their handling is delegated to the field type itself through the following methods:

#### `getFieldTypeIdentifier()`

Returns a unique identifier for the custom field type which is used to assign the type to a field definition.
By convention it should be prefixed by a unique vendor shortcut (for example, `ibexa` for [[= product_name =]]).

#### `getSettingsSchema()`

This method retrieves via public PHP API a schema for the field type settings.
A typical setting would be, for example, default value.
The settings structure defined by this schema is stored in the `FieldDefinition`.
Since it's not possible to define a generic format for such a schema, the field type is free to return any serializable data structure from this method.

#### `getValidatorConfigurationSchema()`

In addition to normal settings, the field type should provide schema settings for its validation process.
The schema describes what kind of validation can be performed by the field type and which settings the user can specify to these validation methods.
For example, the `ezstring` type can validate minimum and maximum length of the string.
It therefore provides a schema to indicate to the user that they might specify the corresponding restrictions, when creating a `FieldDefinition` with this type.
The schema doesn't underlie any regulations, except for that it must be serializable.

#### `validateFieldSettings()`

The type is asked to validate the settings (provided by the user) before the public PHP API stores those settings for the field type in a `FieldDefinition`.
As a result, the field type must return if the given settings comply to the schema defined by `getSettingsSchema()`.

#### `validateValidatorConfiguration()`

As in `validateFieldSettings()`, this method verifies that the given validator configuration complies to the schema provided by `getValidatorConfigurationSchema()`.

It's important to know that the schema definitions of the field type can be both of arbitrary and serializable format.
It's highly recommended to use a simple hash structure.

!!! note

    Since it's not possible to enforce a schema format, the code using a specific field type must basically know all field types it deals with.

This also applies to all user interfaces and the REST API, which therefore must provide extension points to register handling code for custom field type.
These extensions aren't defined yet.

### Field type name

The content item name is retrieved by the `Ibexa\Core\FieldType\FieldType::getName` method which must be implemented.
To generate content item name or URL alias the field type name must be a part of a name schema or a URL schema.

## Value handling

A field type needs to deal with the custom value format provided by it.
In order for the public PHP API to work properly, it delegates working with such custom field values to the corresponding field type.
The `Ibexa\Core\FieldType\FieldType` interface therefore provides the following methods:

#### `acceptValue()`

This method is responsible for accepting and converting user input for the field.
It checks the input structure by accepting, building, and returning a different structure holding the data.

For example: a user provides an HTTP link as a string, `acceptValue()` converts the link to a URL field type value object.
Unlike the `FieldType\Value` constructor, it's possible to make this method aware of multiple input types (object or primitive).

!!! note

    `acceptValue()` asserts structural consistency of the value, but doesn't validate plausibility of the value.

#### `getEmptyValue()`

The field type can specify that the user may define a default value for the `Field` of the type through settings.
If no default value is provided, the field type is asked for an "empty value" as the final fallback.

The value chain for filling a specific field of the field type is as follows:

1. Is a value provided by the filling user?
2. If not, is a default value provided by the`FieldDefinition`?
3. If not, take the empty value provided by the `FieldType`.

#### `validate()`

In contrast to `acceptValue()` this method validates the plausibility of the given value.
It's based on the field type settings and validator configuration and stored in the corresponding `FieldDefinition`.

### Serialization

When [REST API](rest_api_usage.md) is used, conversion needs to be done for field type values, settings, and validator configurations.
These are converted to and from a simple hash format that can be encoded in REST payload.
As conversion needs to be done both when transmitting and receiving data through REST, field type implements the following pairs of methods:

|Method|Description|
|------|-----------|
|`toHash()`|Converts field type Value into a simple hash format.|
|`fromHash()`|Converts the other way around.|
|`fieldSettingsToHash()`|Converts field type settings to a simple hash format.|
|`fieldSettingsFromHash()`|Converts the other way around.|
|`validatorConfigurationToHash()`|Converts field type validator configuration to a simple hash format.|
|`validatorConfigurationFromHash()`|Converts the other way around.|

[[= include_file('docs/snippets/simple_hash_value_caution.md') =]]

## Registration

The field type must be registered in `config/services.yml`:

``` yaml
services:
    Ibexa\FieldTypeMatrix\FieldType\Type:
        parent: Ibexa\Core\FieldType\FieldType
        tags:
            - {name: ibexa.field_type, alias: ezmatrix}
```

#### `parent`

As described in the [Symfony service container documentation]([[= symfony_doc =]]/service_container/parent_services.html), the `parent` config key indicates that you want your service to inherit from the parent's dependencies, including constructor arguments and method calls.
This helps to avoid repetition in your field type configuration and keeps consistency between all field types.
If you need to inject other services into your Type class, skip using the `parent` config key.

#### `tags`

Like most API components, field types use the [Symfony service tag mechanism]([[= symfony_doc =]]/service_container/tags.html).

A service can be assigned one or several tags, with specific parameters.
When the [service container](php_api.md#service-container) is compiled into a PHP file, tags are read by `CompilerPass` implementations that add extra handling for tagged services.
Each service tagged as `ibexa.field_type` is added to a [registry](https://martinfowler.com/eaaCatalog/registry.html) using the `alias` key as its unique `fieldTypeIdentifier`, for example, `ezstring`.
Each field type must also inherit from the abstract `ibexa.field_type` service.
This ensures that the initialization steps shared by all field types are executed.

!!! tip

    The configuration of built-in field types is located in [`core/src/lib/Resources/settings/fieldtypes.yml`](https://github.com/ibexa/core/blob/4.6/src/lib/Resources/settings/fieldtypes.yml).

### Indexing

To make the search engine aware of the data stored in a field type, register it as [indexable](field_type_search.md)

## Field type settings

It's recommended to use a simple associative array format for the settings schema returned by `Ibexa\Contracts\Core\FieldType\FieldType::getSettingsSchema()`, which follows these rules:

- The key of the associative array identifies a setting (for example, `default`)
- Its value is an associative array describing the setting using:
    - `type` to identify the setting type (for example, `int` or `string`)
    - `default` containing the default setting value

An example schema could look like this:

``` php
[
    'backupData' => [
        'type' => 'bool',
        'default' => false
    ],
    'defaultValue' => [
        'type' => 'string',
        'default' => 'Default Value'
    ]
];
```

The settings are mapped into Symfony forms via the [FormMapper](form_and_template.md#formmapper).

!!! note

    You can store field type settings internally, or, when the schema becomes too complex, move them to [external storage](field_type_storage.md#storing-field-type-settings-externally).

## Extensibility points

Some field types require additional processing, for example a field type storing a binary file, or one having more complex settings, or validator configuration.
For this purpose specific implementations of an abstract class `Ibexa\Contracts\Rest\FieldTypeProcessor` are used.

This class provides the following methods:

|Method|Description|
|------|-----------|
|`preProcessValueHash()`|Performs manipulations on a received value hash, so that it conforms to the format expected by the `fromHash()` method described above.|
|`postProcessValueHash()`|Performs manipulations on a outgoing value hash, previously generated by the `toHash()` method described above.|
|`preProcessFieldSettingsHash()`|Performs manipulations on a received settings hash, so that it conforms to the format expected by the `fieldSettingsFromHash()` method described above.|
|`postProcessFieldSettingsHash()`|Performs manipulations on a outgoing settings hash, previously generated by the `fieldSettingsToHash()` method described above.|
|`preProcessValidatorConfigurationHash()`|Performs manipulations on a received validator configuration hash, so that it conforms to the format expected by the `validatorConfigurationFromHash()` method described above.|
|`postProcessValidatorConfigurationHash()`|Performs manipulations on a outgoing validator configuration hash, previously generated by the `validatorConfigurationToHash()` method described above.|

Base implementations of these methods return the given hash, so you can implement only the methods your field type requires.
Some built-in field types already implement processors and you're encouraged to take a look at them.
