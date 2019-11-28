# Type and Value classes

A Field Type must contain a Type class which contains the logic of the Field Type.

It is also good practice to provide a Value object class for storing the custom Field value provided by the Field Type.

## Type class

The Type class of a Field Type provides an implementation of the [`eZ\Publish\SPI\FieldType\FieldType`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/SPI/FieldType/FieldType.php) interface.

### Field Definition handling

A custom Field Type is used in a Field definition of a custom Content Type.
You can additionally provide [settings for the Field Type](#field-type-settings) and a [validator configuration](field_type_validation.md).
Since the Public API cannot know anything about these, their handling is delegated to the Field Type itself through the following methods:

#### `getFieldTypeIdentifier()`

Returns a unique identifier for the custom Field Type which is used to assign the type to a Field definition.
By convention it should be prefixed by a unique vendor shortcut (e.g. `ez` for eZ Systems).

#### `getSettingsSchema()`

This method retrieves via Public API a schema for the Field Type settings. A typical setting would be e.g. default value. The settings structure defined by this schema is stored in the `FieldDefinition`. Since it is not possible to define a generic format for such a schema, the Field Type is free to return any serializable data structure from this method.

#### `getValidatorConfigurationSchema()`

In addition to normal settings, the Field Type should provide schema settings for its validation process. The schema describes what kind of validation can be performed by the Field Type and which settings the user can specify to these validation methods. For example, the `ezstring` type can validate minimum and maximum length of the string. It therefore provides a schema to indicate to the user that they might specify the corresponding restrictions, when creating a `FieldDefinition` with this type. The schema does not underlie any regulations, except for that it must be serializable.

#### `validateFieldSettings()`

The type is asked to validate the settings (provided by the user) before the Public API stores those settings for the Field Type in a `FieldDefinition`. As a result, the Field Type must return if the given settings comply to the schema defined by `getSettingsSchema()`.

#### `validateValidatorConfiguration()`

As in `validateFieldSettings()`, this method verifies that the given validator configuration complies to the schema provided by `getValidatorConfigurationSchema()`.

It is important to note that the schema definitions of the Field Type can be both of arbitrary and serializable format. It is highly recommended to use a simple hash structure.

!!! note

    Since it is not possible to enforce a schema format, the code using a specific Field Type must basically know all Field Types it deals with.

This will also apply to all user interfaces and the REST API, which therefore must provide extension points to register handling code for custom Field Type. These extensions are not defined yet.

### Field Type name

To be able to generate a Content item name when the Field is part of a name schema or a URL schema,
implement `eZ\Publish\SPI\FieldType\Nameable` and register this service using the `ezpublish.fieldType.nameable` tag.

The `eZ\Publish\SPI\FieldType\Nameable::getFieldName` method will be used to retrieve the name.

``` yaml
ezpublish.fieldType.ezobjectrelation.nameable_field:
    class: '%ezpublish.fieldType.ezobjectrelation.nameable_field.class%'
    arguments:
      - '@ezpublish.spi.persistence.cache.contentHandler'
    tags:
        - {name: ezpublish.fieldType.nameable, alias: ezobjectrelation}
```

## Value handling

A Field Type needs to deal with the custom value format provided by it. In order for the public API to work properly, it delegates working with such custom Field values to the corresponding Field Type. The `ez\Publish\SPI\FieldType\FieldType` interface therefore provides the following methods:

#### `acceptValue()`

This method is responsible for accepting and converting user input for the Field. It checks the input structure by accepting, building, and returning a different structure holding the data.

For example: a user provides an HTTP link as a string, `acceptValue()` converts the link to a URL Field Type value object. Unlike the `FieldType\Value` constructor, it is possible to make this method aware of multiple input types (object or primitive).

!!! note

    `acceptValue()` asserts structural consistency of the value, but does not validate plausibility of the value.

#### `getEmptyValue()`

The Field Type can specify that the user may define a default value for the `Field` of the type through settings. If no default value is provided, the Field Type is asked for an "empty value" as the final fallback. 

The value chain for filling a specific Field of the Field Type is as follows:

1. Is a value provided by the filling user?
2. If not, is a default value provided by the`FieldDefinition`?
3. If not, take the empty value provided by the `FieldType`.

#### `validate()`

In contrast to `acceptValue()` this method validates the plausibility of the given value.
It is based on the Field Type settings and validator configuration and stored in the corresponding `FieldDefinition`.

### Serialization

When [REST API](rest_api_guide.md) is used, conversion needs to be done for Field Type values, settings and validator configurations. These are converted to and from a simple hash format that can be encoded in REST payload. As conversion needs to be done both when transmitting and receiving data through REST, Field Type implements the following pairs of methods:

|Method|Description|
|------|-----------|
|`toHash()`|Converts Field Type Value into a plain hash format.|
|`fromHash()`|Converts the other way around.|
|`fieldSettingsToHash()`|Converts Field Type settings to a simple hash format.|
|`fieldSettingsFromHash()`|Converts the other way around.|
|`validatorConfigurationToHash()`|Converts Field Type validator configuration to a simple hash format.|
|`validatorConfigurationFromHash()`|Converts the other way around.|

## Registration

A Field Type must be registered as a service:

``` yaml
services:
    EzSystems\EzPlatformMatrixFieldtype\FieldType\Type:
        parent: ezpublish.fieldType
        tags:
            - {name: ezpublish.fieldType, alias: ezmatrix}
```

#### `parent`

As described in the [Symfony Dependency Injection Component documentation](https://symfony.com/doc/3.4/service_container/parent_services.html), the `parent` config key indicates that you want your service to inherit from the parent's dependencies, including constructor arguments and method calls. This helps avoiding repetition in your Field Type configuration and keeps consistency between all Field Types.

#### `tags`

You must tag the Field Type service with `ezpublish.fieldType` so it is recognized as a regular Field Type.
The `alias` key is the `fieldTypeIdentifier`.

!!! tip

    The configuration of built-in Field Types is located in [`EzPublishCoreBundle/Resources/config/fieldtypes.yml`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.0/eZ/Publish/Core/settings/fieldtypes.yml).

## Field Type settings

It is recommended to use a simple associative array format for the settings schema returned by `eZ\Publish\SPI\FieldType\FieldType::getSettingsSchema()`, which follows these rules:

- The key of the associative array identifies a setting (e.g. `default`)
- Its value is an associative array describing the setting using:
    - `type` to identify the setting type (e.g. `int` or `string`)
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

The settings are mapped into Symfony forms via the [FormMapper](field_type_form_and_template.md#formmapper).


## Extensibility points

Some Field Types will require additional processing, for example a Field Type storing a binary file, or one having more complex settings or validator configuration. For this purpose specific implementations of an abstract class `eZ\Publish\Core\REST\Common\FieldTypeProcessor` are used. 

This class provides the following methods:

|Method|Description|
|------|-----------|
|`preProcessValueHash()`|Performs manipulations on a received value hash, so that it conforms to the format expected by the `fromHash()` method described above.|
|`postProcessValueHash()`|Performs manipulations on a outgoing value hash, previously generated by the `toHash()` method described above.|
|`preProcessFieldSettingsHash()`|Performs manipulations on a received settings hash, so that it conforms to the format expected by the `fieldSettingsFromHash()` method described above.|
|`postProcessFieldSettingsHash()`|Performs manipulations on a outgoing settings hash, previously generated by the `fieldSettingsToHash()` method described above.|
|`preProcessValidatorConfigurationHash()`|Performs manipulations on a received validator configuration hash, so that it conforms to the format expected by the `validatorConfigurationFromHash()` method described above.|
|`postProcessValidatorConfigurationHash()`|Performs manipulations on a outgoing validator configuration hash, previously generated by the `validatorConfigurationToHash()` method described above.|

Base implementations of these methods simply return the given hash, so you can implement only the methods your Field Type requires. Some built-in Field Types already implement processors and you are encouraged to take a look at them.
