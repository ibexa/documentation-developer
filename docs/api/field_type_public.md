# Public API interaction

The interaction with the Public API is done through the interface `eZ\Publish\SPI\FieldType\FieldType`. A custom Field Type must provide an implementation of this interface. In addition, it is considered best practice to provide a value object class for storing the custom field value provided by the Field Type.

## Field Definition handling

In order to make use of a custom Field Type, the user must apply it in a `eZ\Publish\API\Repository\Values\ContentType\FieldDefinition` of a custom Content Type. The user may in addition provide settings for the Field Type and a validator configuration.  Since the Public API cannot know anything about these, their handling is delegated to the Field Type itself through the following methods:

`getFieldTypeIdentifier()`

Returns a unique identifier for the custom Field Type which is used to assign the type to a Field Definition. By convention for the returned type identifier string should be prefixed by a unique vendor shortcut (e.g. `ez` for eZ Systems).

`getSettingsSchema()`

This method retrieves via Public API a schema for the Field Type settings. A typical setting would be e.g. default value. The settings structure defined by this schema is stored in the `FieldDefinition`. Since it is not possible to define a generic format for such a schema, the Field Type is free to return any serializable data structure from this method.

`getValidatorConfigurationSchema()`

In addition to normal settings, the Field Type should provide a schema settings for its validation process. The schema describes, what kind of validation can be performed by the Field Type and which settings the user can specify to these validation methods. For example, the `ezstring` type can validate minimum and maximum length of the string. It therefore provides a schema to indicate to the user that they might specify the corresponding restrictions, when creating a `FieldDefinition` with this type. Again, the schema does not underlie any regulations, except for that it must be serializable.

`validateFieldSettings()`

The type is asked to validate the settings (provided by the user) before the Public API stores those settings for the Field Type in a `FieldDefinition`. As a result, the Field Type must return if the given settings comply to the schema defined by `getSettingsSchema()`. 
`validateValidatorConfiguration()`
 
 As in `validateFieldSettings()`, this method verifies that the given validator configuration complies to the schema provided by `getValidatorConfigurationSchema()`.

It is important to note that the schema definitions of the Field Type can be both of arbitrary and serializable format, it is highly recommended to use a simple hash structure.

!!! note 

    Since it is not possible to enforce a schema format, the code using a specific Field Type must basically know all Field Types it deals with.

This will also apply to all user interfaces and the REST API, which therefore must provide extension points to register handling code for custom Field Type. These extensions are not defined, yet.

### Name of the Field Type

If you implement `\eZ\Publish\SPI\FieldType\Nameable` as an extra service, and register this Service using the tag `ezpublish.fieldType.nameable`, the method `\eZ\Publish\SPI\FieldType\Nameable::getFieldName` will be used to retrieve the name.

Otherwise the `\eZ\Publish\SPI\FieldType\FieldType::getName` method is used.

!!! note 

    `\eZ\Publish\SPI\FieldType\FieldType::getName` method is deprecated. 
    `\eZ\Publish\SPI\FieldType\Nameable` should be implemented instead of it.

**Example from `fieldType_services.yml`**

``` yaml
# Nameable services (for Field Types that need advanced name handling)
    ezpublish.fieldType.ezobjectrelation.nameable_field:
        class: %ezpublish.fieldType.ezobjectrelation.nameable_field.class%
        arguments:
          - @ezpublish.spi.persistence.cache.contentHandler
        tags:
            - {name: ezpublish.fieldType.nameable, alias: ezobjectrelation}
```

## Value handling

A Field Type needs to deal with the custom value format provided by it. In order for the public API to work properly, it delegates working with such custom field values to the corresponding Field Type. The `SPI\FieldType\FieldType` interface therefore provides the following methods:

`acceptValue()`

This method is responsible for accepting and converting user input for the Field. It checks the input structure by accepting, building and returning a different structure holding the data. Example: user provides an HTTP link as a string, `acceptValue()` converts provided link to the Url Field Type value object. Unlike the `FieldType\Value` constructor, it is possible to make this method aware of multiple input types (object or primitive).

!!! note 

    `acceptValue()` asserts structural consistency of the value, but does not validate plausibility of the value.

`getEmptyValue()`

The Field Type can specify, that the user may define a default value for the `Field` of the type through settings. If no default value is provided, the Field Type is asked for an "empty value" as the final fallback. The value chain for filling a specific Field of the Field Type is therefore like this:

1. Is a value provided by the filling user? 
2. If not, is a default value provided by the`FieldDefinition`? 
3. If not, take the empty value provided by the `FieldType`

`validate()`

In contrast to `acceptValue()` this method validates the plausibility of the given value, based on the Field Type settings and validator configuration, stored in the corresponding `FieldDefinition`.

## Storage conversion

As said above, the value format of a Field Type is free form. However, in order to make eZ Platform store the value in its database, it must comply to certain rules at storage time. To not restrict the value itself, a `FieldValue` must be converted to the storage specific format used by the Persistence SPI: `eZ\Publish\SPI\Persistence\Content\FieldValue`. After restoring a Field of Field Type, the conversion must be undone. 

The following methods of the Field Type are responsible for that:

|Method|Description|
|------|-----------|
|`toPersistenceValue()`|This method receives the value of a Field of Field Type and must return an SPI `FieldValue`, which can be stored.|
|`fromPersistenceValue()`|As the counterpart, this method receives an SPI `FieldValue` and must reconstruct the original value of the Field from it.|

The SPI `FieldValue` struct has several properties, which might be used by the Field Type as follows:

|Property|Description|
|--------|-----------|
|`$data`|The data to be stored in the eZ Platform database. This may either be a scalar value, a HashMap or a simple, serializable object.|
|`$externalData`|The arbitrary data stored in this field will not be touched by any of the eZ Platform components directly, but will be hold available for [Storing external data](field_type_storage.md#storing-external-data).|
|`$sortKey`|A value which can be used to sort `Content` by the field.|