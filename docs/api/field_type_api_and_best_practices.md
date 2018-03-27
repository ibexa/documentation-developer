# Field Type API and best practices

eZ Platform can support arbitrary data to be stored in the fields of a content item. In order to support custom data, besides the standard data types, a developer needs to create a custom Field Type.

The implementation of a custom Field Type is done based on the **FieldType SPI** and its interfaces. These can be found under `eZ\Publish\SPI\FieldType`.

In order to provide custom functionality for a Field Type, the SPI interacts with multiple layers of the eZ Platform architecture, as shown in the following diagram:

![Field Type Overview](img/field_type_overview.png)

On the top layer, the Field Type needs to provide conversion from and to a simple PHP hash value to support the **REST API**. The generated hash value may only consist of scalar values and hashes. It must not contain objects or arrays with numerical indexes that aren't sequential and/or don't start with zero.

Below that, the Field Type must support the **Public API** implementation (aka Business Layer), regarding:

-   Settings definition for `FieldDefinition`
-   Value creation and validation
-   Communication with the Persistence SPI

On the bottom level, a Field Type can additionally hook into the **Persistence SPI**, in order to store data from a `FieldValue` in an external service. Note that all non-standard eZ Platform database tables (e.g. `ezurl`) will be considered as external storage.

The following sequence diagrams visualize the process of creating and publishing a new `Content` across all layers, especially focused on the interaction with a Field Type.

#### Create Content Sequence

![Create Content Sequence](img/create_content_sequence.png)

#### Publish Content Sequence
 
!!! note "indexLocation()"
 
    `indexLocation()` is implemented for **ElasticSearch** only. 
    For **Solr** Locations are indexed during Content indexing. 
    For **Legacy/SQL** indexing is not required as Location data already exists in a database. 

![Publish Content Sequence](img/publish_content_sequence.png)

In the next paragraphs, this document explains how to implement a custom Field Type based on the SPI and what is expected from it. Please refer to the Url Field Type, which has been implemented as a reference code example.

## Public API interaction

The interaction with the Public API is done through the interface `eZ\Publish\SPI\FieldType\FieldType`. A custom Field Type must provide an implementation of this interface. In addition, it is considered best practice to provide a value object class for storing the custom field value provided by the Field Type.

### Field Definition handling

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

It is important to note that the schema definitions of the Field Type can be both of arbitrary and serializable format, it is highly recommended to use a simple hash structure. You should follow the [Best practices](../guide/best_practices.md) in order to create future-proof schemas.

!!! note 

    Since it is not possible to enforce a schema format, the code using a specific Field Type must basically know all Field Types it deals with.

This will also apply to all user interfaces and the REST API, which therefore must provide extension points to register handling code for custom Field Type. These extensions are not defined, yet.

#### Name of the Field Type

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

### Value handling

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

### Storage conversion

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
|`$externalData`|The arbitrary data stored in this field will not be touched by any of the eZ Platform components directly, but will be hold available for [Storing external data](#storing-external-data).|
|`$sortKey`|A value which can be used to sort `Content` by the field.|


## Searching

Fields, or a custom Field Type, might contain or maintain data relevant for user searches. To make the search engine aware of the data in your Field Type you need to implement an additional interface and register the implementation.

If your Field Type does not maintain any data, which should be available to search engines, feel free to just ignore this section.

The `eZ\Publish\SPI\FieldType\Indexable` defines below methods, which are required to be implemented, if the Field Type provides data relevant to search engines.

`getIndexData( Field $field )`

This method returns the actual index data for the provided `eZ\Publish\SPI\Persistence\Content\Field`. The index data consists of an array of `eZ\Publish\SPI\Persistence\Content\Search\Field` instances. They are described below in further detail.

`getIndexDefinition()`

To be able to query data properly an indexable Field Type also is required to return search specification. You must return a HashMap of `eZ\Publish\SPI\Persistence\Content\Search\FieldType` instances from this method, which could look like:

```
array(
    'url'  => new Search\FieldType\StringField(),
    'text' => new Search\FieldType\StringField(),
)
```

 This example from the `Url` Field Type shows that the Field Type will always return two indexable values, both strings. They have the names `url` and `text` respectively.
 
 `getDefaultMatchField()`
 
This method retrieves name of the default field to be used for matching. As Field Types can index multiple fields (see [MapLocation](../guide/field_type_reference.md#maplocation-field-type) Field Type's implementation of this interface), this method is used to define default field for matching. Default field is typically used by Field criterion.
 
 `getDefaultSortField()`
 
This method gets name of the default field to be used for sorting. As Field Types can index multiple fields (see [MapLocation](../guide/field_type_reference.md#maplocation-field-type) Field Type's implementation of this interface), this method is used to define default field for sorting. Default field is typically used by Field sort clause.
 
### Register Indexable Implementations

 Implement `\eZ\Publish\SPI\FieldType\Indexable` as an extra service, and register this Service using the tag `ezpublish.fieldType.indexable`. Example from [`indexable_fieldtypes.yml`](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/settings/indexable_fieldtypes.yml):
 
 ``` yml
     ezpublish.fieldType.indexable.ezkeyword:
         class: eZ\Publish\Core\FieldType\Keyword\SearchField
         tags:
             - {name: ezpublish.fieldType.indexable, alias: ezkeyword}
  ```
 
 Please note that `alias` should be the same as Filed Type ID.

### Search Field Values

The search field values, returned by the `getIndexData` method are simple value objects consisting of the following properties:

|Property|Description|
|--------|-----------|
|`$name`|The name of the field|
|`$value`|The value of the field|
|`$type`|An `eZ\Publish\SPI\Persistence\Content\Search\FieldType` instance, describing the type information of the field.|

### Search Field Types

There are many available search Field Types, which are handled by Search backend configuration. When using those there is no requirement to adapt, for example, the Solr configuration in any way. You can always use custom Field Types, but these might require re-configuration of the search backend. For Solr this would mean adapting the schema.xml.

The default available search Field Types that can be found in namespace:`eZ\Publish\SPI\Search\FieldType` are:

|Field Type|Description|
|--------|-----------|
|`BooleanField`|Boolean values.|
|`CustomField`|Custom field, for custom search data types. Will probably require additional configuration in the search backend.|
|`DateField`|Date field. Can be used for date range queries.|
|`DocumentField`|Document field|
|`FloatField`|Field for floating point numbers.|
|`FullTextField`|Represents full text searchable value of Content object field which can be indexed by the legacy search engine. Some full text fields are stored as an array of strings.|
|`GeoLocationField`|Field used for Geo Location.|
|`IdentifierField`|Field used for IDs. Basically acts like the string field, but will not be queried by fulltext searches|
|`IntegerField`|Field for integer numbers.|
|`MultipleBooleanField`|Multiple boolean values.|
|`MultipleIdentifierField`|Multiple IDs values.|
|`MultipleIntegerField`|Multiple integer numbers.|
|`MultipleStringField`|Multiple string values.|
|`PriceField`|Field for price values. Currency conversion might be applied by the search backends. Might require careful configuration.|
|`StringField`|Standard string values. Will also be queries by full text searches.|
|`TextField`|Standard text values. Will be queried by full text searches. Configured text normalizations in the search backend apply.|

### Configuring Solr

As mentioned before, if you are using the standard type definitions **there is no need to configure the search backend in any way**. Everything will work fine. The field definitions are handled using `dynamicField` definitions in Solr, for example.

If you want to configure the handling of your field, you can always add a special field definition the Solr `schema.xml`. The Field Type names, which are used by the Solr search backend look like this for fields: `<content_type_identifier>/<field_identifier>/<search_field_name>_<type>`. You can, of course define custom `dynamicField` definitions to match, for example, on your custom `_<type>` definition.

You could also define a custom field definition for certain fields, like for the name field in an article:

```
<field name="article/name/value_s" type="string" indexed="true" stored="true" required="false"/>
```

!!! note 

    If you want to learn more about the Solr implementation and detailed information about configuring it, check out the [Solr Search Bundle](../guide/search.md#solr-bundle).

## Storing external data

A Field Type may store arbitrary data in external data sources and is in fact encouraged to do so. External storages can be e.g. a web service, a file in the file system, another database or even the eZ Platform database itself (in form of a non-standard table). In order to perform this task, the Field Type will interact with the Persistence SPI, which can be found in `eZ\Publish\SPI\Persistence`, through the `eZ\Publish\SPI\FieldType\FieldStorage` interface.

Whenever the internal storage of a Content item that includes a Field of the Field Type is accessed, one of the following methods is called to also access the external data:

|Method|Description|
|------|-----------|
|`hasFieldData()`|Returns if the Field Type stores external data at all.|
|`storeFieldData()`|Called right before a Field of Field Type is stored. The method  stores `$externalData`. It returns `true`, if the call manipulated **internal data** of the given `Field`, so that it is updated in the internal database.|
|`getFieldData()`|Is called after a Field has been restored from the database in order to restore `$externalData`.|
|`deleteFieldData()`|Must delete external data for the given Field, if exists.|
|`getIndexData()`|Returns the actual index data for the provided `eZ\Publish\SPI\Persistence\Content\Field`. For more information see [search service](#search-field-values).|

Each of the above methods receive a $context array, which contains information on the underlying storage and the environment. This context can be used to store data in the eZ Platform data storage, but outside of the normal structures (e.g. a custom table in an SQL database). Note that the Field Type must take care on its own for being compliant to different data sources and that 3rd parties can extend the data source support easily. For more information about this, take a look at the [Best practices](#best-practices) section.

## Legacy Storage conversion

The Field Type system is designed for future storage back ends of eZ Platform. However, the old database schema (*Legacy Storage*) must still be supported. Since this database cannot store arbitrary value information as provided by a Field Type, another conversion step must take place if the Legacy Storage is used.

The conversion takes place through the interface `eZ\Publish\Core\Persistence\Legacy\Content\FieldValue\Converter`, which you must provide an implementation of with your Field Type. The following methods are contained in the interface:

|Method|Description|
|------|-----------|
|`toStorageValue()`|Converts a Persistence `Value` into a legacy storage specific value.|
|`fromStorageValue()`|Converts the other way around.|
|`toStorageFieldDefinition()`|Converts a Persistence `FieldDefinition` to a storage specific one.|
|`fromStorageFieldDefinition`|Converts the other way around.|
|`getIndexColumn()`|Returns the storage column which is used for indexing.|

### Registering a converter

The registration of a `Converter` currently works through the `$config` parameter of `eZ\Publish\Core\Persistence\Legacy\Handler`. See the class documentation for further details.

!!! note

    For global service container integration, see [Register Field Type](#register-field-type).

## REST API interaction

When REST API is used, conversion needs to be done for Field Type values, settings and validator configurations. These are converted to and from a simple hash format that can be encoded in REST payload (typically XML or JSON). As conversion needs to be done both when transmitting and receiving data through REST, Field Type implements following pairs of methods:

|Method|Description|
|------|-----------|
|`toHash()`|Converts Field Type Value into a plain hash format.|
|`fromHash()`|Converts the other way around.|
|`fieldSettingsToHash()`|Converts Field Type settings to a simple hash format.|
|`fieldSettingsFromHash()`|Converts the other way around.|
|`validatorConfigurationToHash()`|Converts Field Type validator configuration to a simple hash format.|
|`validatorConfigurationFromHash()`|Converts the other way around.|

### Extension points

Some Field Types will require additional processing, for example a Field Type storing a binary file, or one having more complex settings or validator configuration. For this purpose specific implementations of an abstract class `eZ\Publish\Core\REST\Common\FieldTypeProcessor` are used. This class provides following methods:

|Method|Description|
|------|-----------|
|`preProcessValueHash()`|Performs manipulations on a received value hash, so that it conforms to the format expected by the `fromHash()` method described above.|
|`postProcessValueHash()`|Performs manipulations on a outgoing value hash, previously generated by the `toHash()` method described above.|
|`preProcessFieldSettingsHash()`|Performs manipulations on a received settings hash, so that it conforms to the format expected by the `fieldSettingsFromHash()` method described above.|
|`postProcessFieldSettingsHash()`|Performs manipulations on a outgoing settings hash, previously generated by the `fieldSettingsToHash()` method described above.|
|`preProcessValidatorConfigurationHash()`|Performs manipulations on a received validator configuration hash, so that it conforms to the format expected by the `validatorConfigurationFromHash()` method described above.|
|`postProcessValidatorConfigurationHash()`|Performs manipulations on a outgoing validator configuration hash, previously generated by the `validatorConfigurationToHash()` method described above.|

Base implementations of these methods simply return the given hash, so you can implement only the methods your Field Type requires. Some Field Types coming with the eZ Platform installation already implement processors and you are encouraged to take a look at them.

For details on registering a Field Type processor, see [Register Field Type](#register-field-type).

## Best practices

In this chapter, best practices for implementing a custom Field Type are collected. We highly encourage following these practices to be future proof.

### Gateway based Storage

In order to allow the usage of a Field Type that uses external data with different data storages, it is recommended to implement a gateway infrastructure and a registry for the gateways. In order to ease this action, the Core implementation of Field Type s provides corresponding interfaces and base classes. These can also be used for custom Field Types.

The interface `eZ\Publish\Core\FieldType\StorageGateway` is implemented by gateways, in order to be handled correctly by the registry. It has only a single method:

|Method|Description|
|------|-----------|
|`setConnection()`|The registry mechanism uses this method to set the SPI storage connection (e.g. the database connection to the Legacy Storage database) into the gateway, which might be used to store external data. The connection is retrieved from the `$context` array  automatically by the registry.|

Note that the Gateway implementation itself must take care about validating that it received a usable connection. If it did not, it should throw a `RuntimeException`.

The registry mechanism is realized as a base class for `FieldStorage` implementations: `eZ\Publish\Core\FieldType\GatewayBasedStorage`. For managing `StorageGateway`s, the following methods are already implemented in the base class:

|Method|Description|
|------|-----------|
|`addGateway()`|Allows the registration of additional `StorageGateway`s from the outside. Furthermore, a HashMap of `StorageGateway`s can be given to the constructor for basic initialization. This array should originate from the Dependency Injection mechanism.|
|`getGateway()`|This protected method is used by the implementation to retrieve the correct `StorageGateway` for the current context.|

As a reference for the usage of these infrastructure, the Keyword, Url and User types can be examined.

### Settings schema

It is recommended to use a simple HashMap format for the settings schema returned by `eZ\Publish\SPI\FieldType\FieldType::getSettingsSchema()`, which follows these rules:

-   The key of the HashMap identifies a setting (e.g. `default`)
-   Its value is a HashMap (2nd level) describing the setting using:
    -   `type` to identify the setting type (e.g. `int` or `string`)
    -   `default` containing the default setting value

An example schema could look like this:

```
array(
    'backupData' => array(
        'type' => 'bool',
        'default' => false
    ),
    'defaultValue' => array(
        'type' => 'string',
        'default' => 'Sindelfingen'
    )
);
```

### Validator schema

The schema for validator configuration should have a similar format to the settings schema, except it has an additional level, to group settings for a certain validation mechanism:

-   The key on the 1st level is a string, identifying a validator
-   Assigned to that is a HashMap (2nd level) of settings
-   This HashMap has a string key for each setting of the validator
-   It is assigned to a 3rd level HashMap, the setting description
-   This HashMap should have the same format as for normal settings

For example, for the `ezstring` type, the validator schema could be:

```
array(
    'stringLength' => array(
        'minStringLength' => array(
            'type'    => 'int',
            'default' => 0,
        ),
        'maxStringLength' => array(
            'type'    => 'int'
            'default' => null,
        )
    ),
);
```


## Field Type template


### Defining your Field Type template

You need to define a **template containing a block** dedicated to the Field display in order to be used by [`ez_render_field()` Twig helper](../guide/content_rendering.md#twig-functions-reference). Only with it it can be correctly displayed.

This block consists of a piece of template receiving specific variables you can use to make the display vary.

You will find examples with built-in Field Types in [EzPublishCoreBundle/Resources/views/content\_fields.html.twig](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Bundle/EzPublishCoreBundle/Resources/views/content_fields.html.twig)

**Template for a Field Type with `myfieldtype` identifier**

``` twig
{% block myfieldtype_field %}
{# Your code here #}
{% endblock %}
```

By convention, your block **must** be named `<fieldTypeIdentifier>_field`.

### Exposed variables

| Name | Type | Description |
|------|------|-------------|
| field | `eZ\Publish\API\Repository\Values\Content\Field` | The field to display |
| contentInfo | `eZ\Publish\API\Repository\Values\Content\ContentInfo` | The ContentInfo to which the field belongs to |
| versionInfo | `eZ\Publish\API\Repository\Values\Content\VersionInfo` | The VersionInfo to which the field belongs to |
| fieldSettings | mixed | Settings of the field (depends on the Field Type) |
|parameters | hash | Options passed to `ez_render_field()` under the parameters key |
|attr | hash | The attributes to add the generate the HTML markup. Contains at least a class entry, containing <fieldtypeidentifier>-field |

### Reusing blocks

To ease Field Type template development, you can take advantage of all defined blocks by using the [block() function](http://twig.sensiolabs.org/doc/functions/block.html).

You can for example use `simple_block_field`, `simple_inline_field` or `field_attributes` blocks provided in [content\_fields.html.twig](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Bundle/EzPublishCoreBundle/Resources/views/content_fields.html.twig#L413).

!!! caution

    To be able to reuse built-in blocks, **your template must inherit from `EzPublishCoreBundle::content_fields.html.twig`**.

### Registering your template

To make your template available, you must register it in the system.

**app/config/ezplatform.yml**

``` yaml
ezpublish:
    system:
        my_siteaccess:
            field_templates:
                -
                    template: "AcmeTestBundle:fields:my_field_template.html.twig"
                    # Priority is optional (default is 0). The higher it is, the higher your template gets in the list.
                    priority: 10
```

You can define these rules in a dedicated file instead of `app/config/ezplatform.yml`. Read the [cookbook recipe to learn more about it](../cookbook/importing_settings_from_a_bundle.md).


## Register Field Type

This section explains how to register a custom Field Type in eZ Platform.

To be integrated in unit and integration tests, Field Types need to be registered through the `service.ini` in `eZ/Publish/Core/settings`.

### Service container configuration

To be able to declare a Field Type, you need to have [registered bundle in your application kernel](http://symfony.com/doc/master/book/page_creation.html#the-bundle-system).

This bundle needs to expose some configuration for the service container somehow (read [related Symfony documentation](http://symfony.com/doc/master/book/service_container.html#importing-other-container-configuration-resources))

#### Basic configuration

This part relates to the [base FieldType class that interacts with the Public API](#public-api).

Let's take a basic example from `ezstring` configuration.

``` yaml
parameters:
    ezpublish.fieldType.ezstring.class: eZ\Publish\Core\FieldType\TextLine\Type

services:
    ezpublish.fieldType.ezstring:
        class: %ezpublish.fieldType.ezstring.class%
        parent: ezpublish.fieldType
        tags:
            - {name: ezpublish.fieldType, alias: ezstring}
```

So far, this is a regular service configuration but 2 parts worth particular attention:

`parent`

As described in the [Symfony Dependency Injection Component documentation](http://symfony.com/doc/master/components/dependency_injection/parentservices.html), the `parent` config key indicates that you want your service to inherit from the parent's dependencies, including constructor arguments and method calls. This helps avoiding repetition in your Field Type configuration and keeps consistency between all Field Types.

`tags`

Tagging your Field Type service with **`ezpublish.fieldType`** is mandatory to be recognized by the API loader as a regular Field Type, the `alias` key being simply the *fieldTypeIdentifier* (formerly called *datatype string*)

Basic Field Types configuration is located in [EzPublishCoreBundle/Resources/config/fieldtypes.yml](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/settings/fieldtypes.yml).

#### Legacy Storage Engine

##### Converter

As stated [above](#legacy-storage-conversion), a conversion of Field Type values is needed in order to properly store the data into the *old* database schema (aka *Legacy Storage*).

Those converters also need to be correctly exposed as services.

**Field Type converter for ezstring**

``` yaml
parameters:
    ezpublish.fieldType.ezstring.converter.class: eZ\Publish\Core\Persistence\Legacy\Content\FieldValue\Converter\TextLine

services:
    ezpublish.fieldType.ezstring.converter:
        class: %ezpublish.fieldType.ezstring.converter.class%
        tags:
            - {name: ezpublish.storageEngine.legacy.converter, alias: ezstring, lazy: true, callback: '::create'}
```

Here again you need to tag your converter service, with **`ezpublish.storageEngine.legacy.converter`** tag this time.

As for the tag attributes:

| Attribute name | Usage |
|----------------|-------|
| alias | Represents the fieldTypeIdentifier (just like for the Field Type service). |
| lazy | Boolean indicating if the converter should be lazy loaded or not. Performance wise, it is recommended to set it to true unless you have very specific reasons. |
| callback | If lazy is set to true, it represents the callback that will be called to build the converter. Any valid callback can be used. Note that if the callback is defined in the converter class, the class name can be omitted. This way, in the example above, the full callback will be resolved to `eZ\Publish\Core\Persistence\Legacy\Content\FieldValue\Converter\TextLine::create` |

The converter configuration for basic Field Types are located in [eZ/Publish/Core/settings/fieldtype\_external\_storages.yml](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/settings/fieldtype_external_storages.yml).

##### External storage

A Field Type has the [ability to store its value (or part of it) in external data sources](#storing-external-data). This is made possible through the `eZ\Publish\SPI\FieldType\FieldStorage` interface. If you want to use this functionality, you will need to define a service implementing this interface and tag it as **`ezpublish.fieldType.externalStorageHandler`** to be recognized by the Repository.

Here is an example for **ezurl** Field Type:

**External storage handler for ezurl**

``` yaml
parameters:
    ezpublish.fieldType.ezurl.externalStorage.class: eZ\Publish\Core\FieldType\Url\UrlStorage

services:
    ezpublish.fieldType.ezurl.externalStorage:
        class: %ezpublish.fieldType.ezurl.externalStorage.class%
        tags: 
            - {name: ezpublish.fieldType.externalStorageHandler, alias: ezurl}
```

The configuration is straight forward. Nothing specific except the **`ezpublish.fieldType.externalStorageHandler `** tag, the `alias` attribute still begin the *fieldTypeIdentifier*.

External storage configuration for basic Field Types is located in [EzPublishCoreBundle/Resources/config/fieldtypes.yml](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/settings/fieldtypes.yml).

##### Gateway based storage

As stated in the [Field Type best practices](#gateway-based-storage), in order to be storage agnostic an external storage handler should use a *storage gateway*. This can be done by implementing another service implementing `eZ\Publish\Core\FieldType\StorageGateway` and being tagged as `ezpublish.fieldType.externalStorageHandler.gateway`.

**Storage gateway for ezurl**

``` yaml
parameters:
    ezpublish.fieldType.ezurl.storage_gateway.class: eZ\Publish\Core\FieldType\Url\UrlStorage\Gateway\LegacyStorage

services:
    ezpublish.fieldType.ezurl.storage_gateway:
        class: '%ezpublish.fieldType.ezurl.storage_gateway.class%'
        tags:
            - {name: ezpublish.fieldType.externalStorageHandler.gaeZ\Publish\SPI\Search\FieldTypeteway, alias: ezurl, identifier: LegacyStorage}
```

| Attribute name | Usage |
|----------------|-------|
| alias | Represents the `fieldTypeIdentifier` (just like for the Field Type service) |
| identifier | Identifier for the gateway. Must be unique per storage engine. `LegacyStorage` is the convention name for Legacy Storage Engine. |

For this to work properly, your storage handler must inherit from `eZ\Publish\Core\FieldType\GatewayBasedStorage`.

Also note that there can be several gateways per Field Type (one per storage engine basically).

The gateway configuration for basic Field Types are located in [EzPublishCoreBundle/Resources/config/storage\_engines.yml](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Bundle/EzPublishCoreBundle/Resources/config/storage_engines.yml).

## Testing

Field Types should be integration tested on 2 different levels:

1.  Their integration with the Persistence SPI
2.  Their integration with the Public API

For both test environments, infrastructure is already in place, so that you can easily implement the required tests for your custom Field Type

### Persistence SPI

This type of integration test ensures, that a Field Type stores its data properly on basis of different Persistence SPI implementations.

!!! note

    By now, only the Legacy Storage implementation exists.

The integration tests with the Persistence SPI can be found in `eZ\Publish\SPI\Tests\FieldType`. In order to implement a test for your custom Field Type, you need to extend the common base class `eZ\Publish\SPI\Tests\FieldType\BaseIntegrationTest` and implement its abstract methods. As a reference the `KeywordIntegrationTest`, `UrlIntegrationTest` and `UserIntegrationTest` can deal.

Running the test is fairly simple: Just specify the global `phpunit.xml` for PHPUnit configuration and make it execute a single test or a directory of tests, for example:

``` bash
$ phpunit -c phpunit.xml eZ/Publish/SPI/Tests/FieldType
```

in order to run all Field Type tests.

### Public API

On a second level, the interaction between an implementation of the Public API (aka the Business Layer) and the Field Type is tested. Again, there is a common base class as the infrastructural basis for such tests, which resides in `eZ\Publish\API\Repository\Tests\FieldType\BaseIntegrationTest`.

!!! note 

    Note that the In-Memory stubs for the Public API integration test suite, do not perform actual Field Type calls, but mainly emulate the behavior of a Field Type for simplicity reasons.

    If your Field Type needs to convert data between `storeFieldData()` and `getFieldData()`, you need to implement a `eZ\Publish\API\Repository\Tests\Stubs\PseudoExternalStorage` in addition, which performs this task. Running the tests against the Business Layer implementation of the Public API is not affected by this.


## Settings schema and allowed validators

### Internal Field Type conventions and best practices

`FieldType=>settingsSchema` and `FieldType=>allowedValidators` are intentionally left free-form, to give flexibility to Field Type developers. However, for internal Field Types (aka those delivered with eZ Platform), a common standard should be established as best practice. The purpose of this page is to collect and unify this standard.

#### Settings schema

The general format of the settings schema of a Field Type is a HashMap of setting names, assigned to their type and default value, e.g.:

``` php
    array(
        'myFancySetting' => array(
            'type' => 'int',
            'default' => 23,
        ),
        'myOtherFancySetting' => array(
            'type' => 'string',
            'default' => 'Sindelfingen',
        ),
    );
```

The type should be either a valid PHP type shortcut or one of the following special types:

-   Hash (a simple HashMap)
-   Choice (an enumeration)
-   &lt;&lt;&lt;YOUR TYPE HERE&gt;&gt;&gt;


 
