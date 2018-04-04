# Register Field Type

This section explains how to register a custom Field Type in eZ Platform.

To be integrated in unit and integration tests, Field Types need to be registered through the `service.ini` in `eZ/Publish/Core/settings`.

## Service container configuration

To be able to declare a Field Type, you need to have [registered bundle in your application kernel](http://symfony.com/doc/master/book/page_creation.html#the-bundle-system).

This bundle needs to expose some configuration for the service container somehow (read [related Symfony documentation](http://symfony.com/doc/master/book/service_container.html#importing-other-container-configuration-resources))

### Basic configuration

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

### Legacy Storage Engine

#### Converter

As stated in the [storage section](field_type_storage.md#legacy-storage-conversion), a conversion of Field Type values is needed in order to properly store the data into the *old* database schema (aka *Legacy Storage*).

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

#### External storage

A Field Type has the [ability to store its value (or part of it) in external data sources](field_type_storage.md#storing-external-data). This is made possible through the `eZ\Publish\SPI\FieldType\FieldStorage` interface. If you want to use this functionality, you will need to define a service implementing this interface and tag it as **`ezpublish.fieldType.externalStorageHandler`** to be recognized by the Repository.

Here is an example for **ezurl** Field Type:

**External storage handler for ezurl**

``` yaml
parameters:
    ezpublish.fieldType.ezurl.externalStorage.class: eZ\Publish\Core\FieldType\Url\UrlStorage
services:
    ezpublish.fieldType.ezurl.externalStorage:
        class: %ezpublish.fieldType.ezurl.externalStorage.class%
        arguments:
            - "@ezpublish.fieldType.ezurl.storage_gateway"
        tags: 
            - {name: ezpublish.fieldType.externalStorageHandler, alias: ezurl}
```

The configuration requires providing the **`ezpublish.fieldType.externalStorageHandler `** tag, with the `alias` attribute being the *fieldTypeIdentifier*. You also have to inject the gateway in `arguments`, [see below](#gateway-based-storage).

External storage configuration for basic Field Types is located in [eZ/Publish/Core/settings/fieldtype_external_storages.yml](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/settings/fieldtype_external_storages.yml).

#### Gateway based storage

As stated in the [storage section](field_type_storage.md#gateway-based-storage), in order to be storage agnostic an external storage handler should use a *storage gateway*. This can be done by using another service implementing `eZ\Publish\SPI\FieldType\StorageGateway`, to be injected into external storage handler ([see above](#external-storage)).

**Storage gateway for ezurl**

``` yaml
parameters:
    ezpublish.fieldType.ezurl.storage_gateway.class: eZ\Publish\Core\FieldType\Url\UrlStorage\Gateway\LegacyStorage

services:
    ezpublish.fieldType.ezurl.storage_gateway:
        class: %ezpublish.fieldType.ezurl.storage_gateway.class%
        arguments: ["@ezpublish.api.storage_engine.legacy.connection"]
```

`ezpublish.api.storage_engine.legacy.connection` is of type `\Doctrine\DBAL\Connection`. If your gateway still uses an implementation of `\eZ\Publish\Core\Persistence\Database\DatabaseHandler` (a.k.a `\eZ\Publish\Core\Persistence\Doctrine\ConnectionHandler`), instead of the `ezpublish.api.storage_engine.legacy.connection` you can pass the `ezpublish.api.storage_engine.legacy.dbhandler` service.

For this to work properly, your storage handler must inherit from `eZ\Publish\SPI\FieldType\GatewayBasedStorage`.

Also note that there can be several gateways per Field Type (one per storage engine basically).

The gateway configuration for basic Field Types are located in [EzPublishCoreBundle/Resources/config/storage\_engines.yml](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Bundle/EzPublishCoreBundle/Resources/config/storage_engines.yml).