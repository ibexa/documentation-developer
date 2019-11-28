# Field Type storage

## Storage conversion

If you want to store Field values in regular eZ Platform database tables,
the `FieldValue` must be converted to the storage-specific format used by the Persistence SPI:
`eZ\Publish\SPI\Persistence\Content\FieldValue`.
After restoring a Field of the Field Type, you must reverse the conversion.

The following methods of the Field Type are responsible for that:

|Method|Description|
|------|-----------|
|`toPersistenceValue()`|This method receives the value of a Field of the Field Type and returns an SPI `FieldValue`, which can be stored.|
|`fromPersistenceValue()`|This method receives an SPI `FieldValue` and reconstructs the original value of the Field from it.|

The SPI `FieldValue` struct has properties which the Field Type can use:

|Property|Description|
|--------|-----------|
|`$data`|The data to be stored in the database. This may be a scalar value, an associative array or a simple, serializable object.|
|`$externalData`|The arbitrary data stored in this field will not be touched by any of the eZ Platform components directly, but will be available for [Storing external data](#storing-external-data).|
|`$sortKey`|A value which can be used to sort content by this Field.|

### Legacy storage engine

The default Legacy storage engine cannot store arbitrary value information as provided by a Field Type.
This means that using this storage engine requires a conversion.

The conversion takes place through the `eZ\Publish\Core\Persistence\Legacy\Content\FieldValue\Converter` interface,
which you must implement in your Field Type. The interface contains the following methods:

|Method|Description|
|------|-----------|
|`toStorageValue()`|Converts a Persistence `Value` into a Legacy storage specific value.|
|`toFieldValue()`|Converts the other way around.|
|`toStorageFieldDefinition()`|Converts a Persistence `FieldDefinition` to a storage specific one.|
|`toFieldDefinition`|Converts the other way around.|
|`getIndexColumn()`|Returns the storage column which is used for indexing.|

#### Registering a converter

The registration of a `Converter` currently works through the `$config` parameter of [`eZ\Publish\Core\Persistence\Legacy\Handler`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/Core/Persistence/Legacy/Handler.php).

Those converters also need to be correctly exposed as services and tagged with `ezpublish.storageEngine.legacy.converter`:

``` yaml
services:
    eZ\Publish\Core\Persistence\Legacy\Content\FieldValue\Converter\TextLine:
        tags:
            - {name: ezpublish.storageEngine.legacy.converter, alias: ezstring}
```

The tag has the following attribute:

| Attribute name | Usage |
|----------------|-------|
| `alias` | Represents the `fieldTypeIdentifier` (just like for the [Field Type service](field_type_type_and_value.md#registration)). |

!!! tip

    Converter configuration for built-in Field Types is located in [`eZ/Publish/Core/settings/fieldtype_external_storages.yml`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/Core/settings/fieldtype_external_storages.yml).

## Storing external data

A Field Type may store arbitrary data in external data sources.
External storage can be e.g. a web service, a file in the file system, another database
or even the eZ Platform database itself (in form of a non-standard table).

In order to store data in external storage, the Field Type will interact with the Persistence SPI
through the `eZ\Publish\SPI\FieldType\FieldStorage` interface.

Accessing the internal storage of a Content item that includes a Field of the Field Type
calls one of the following methods to also access the external data:

|Method|Description|
|------|-----------|
|`hasFieldData()`|Returns whether the Field Type stores external data at all.|
|`storeFieldData()`|Called right before a Field of the Field Type is stored. The method stores `$externalData`. It returns `true` if the call manipulated internal data of the given Field, so that it is updated in the internal database.|
|`getFieldData()`|Called after a Field has been restored from the database in order to restore `$externalData`.|
|`deleteFieldData()`|Must delete external data for the given Field, if exists.|
|`getIndexData()`|Returns the actual index data for the provided `eZ\Publish\SPI\Persistence\Content\Field`. For more information, see [search service](field_type_search.md#search-field-values).|

Each of the above methods (except `hasFieldData`) receives a `$context` array with information on the underlying storage and the environment.
To retrieve and store data in the eZ Platform data storage,
but outside of the normal structures (e.g. a custom table in an SQL database),
use [Gateway-based storage](#gateway-based-storage) with properly injected Doctrine Connection.

Note that the Field Type must take care on its own for being compliant with different data sources and that third parties can extend the data source support easily.

### Gateway-based storage

In order to allow the usage of a Field Type that uses external data with different data storages, it is recommended to implement a gateway infrastructure and a registry for the gateways. To make this easier, the Core implementation of Field Types provides corresponding interfaces and base classes. They can also be used for custom Field Types.

The interface `eZ\Publish\Core\FieldType\StorageGateway` is implemented by gateways, in order to be handled correctly by the registry. It has one method:

|Method|Description|
|------|-----------|
|`setConnection()`|The registry mechanism uses this method to set the SPI storage connection (e.g. the database connection to the Legacy Storage database) into the gateway, which might be used to store external data. The connection is retrieved from the `$context` array automatically by the registry.|

Note that the Gateway implementation itself must take care of validating that it received a usable connection. If it does not, it should throw a `RuntimeException`.

The registry mechanism is realized as a base class for `FieldStorage` implementations: `eZ\Publish\Core\FieldType\GatewayBasedStorage`. For managing `StorageGateway`s, the following methods are already implemented in the base class:

|Method|Description|
|------|-----------|
|`addGateway()`|Allows the registration of additional `StorageGateway`s from the outside. Furthermore, an associative array of `StorageGateway`s can be given to the constructor for basic initialization. This array should originate from the Dependency injection mechanism.|
|`getGateway()`|This protected method is used by the implementation to retrieve the correct `StorageGateway` for the current context.|

!!! tip

    Refer to the built-in Keyword, URL and User Field Types for usages of such infrastructure.

### Registering external storage

To use external storage, you need to define a service implementing the `eZ\Publish\SPI\FieldType\FieldStorage` interface
and tag it as `ezpublish.fieldType.externalStorageHandler` to be recognized by the Repository.

Here is an example for the `myfield` Field Type:

``` yaml
services:
    _defaults:
        autowire: true
        autoconfigure: true
        public: false

    Acme\ExampleBundle\FieldType\MyField\Storage\MyFieldStorage: ~
        tags:
            - {name: ezpublish.fieldType.externalStorageHandler, alias: myfield}
```

The configuration requires providing the `ezpublish.fieldType.externalStorageHandler` tag, with the `alias` attribute being the *fieldTypeIdentifier*. You also have to inject the gateway in `arguments`, [see below](#gateway-based-storage).

External storage configuration for basic Field Types is located in [eZ/Publish/Core/settings/fieldtype_external_storages.yml](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/Core/settings/fieldtype_external_storages.yml).

#### Registration

Using gateway-based storage requires another service implementing `eZ\Publish\SPI\FieldType\StorageGateway` to be injected into the [external storage handler](#storing-external-data)).

``` yaml
services:
    _defaults:
        autowire: true
        autoconfigure: true
        public: false

    Acme\ExampleBundle\FieldType\MyField\Storage\Gateway\DoctrineStorage: ~
```

Note that `ezpublish.api.storage_engine.legacy.connection` is of type `Doctrine\DBAL\Connection`. If your gateway still uses an implementation of `eZ\Publish\Core\Persistence\Database\DatabaseHandler` (`eZ\Publish\Core\Persistence\Doctrine\ConnectionHandler`), instead of the `ezpublish.api.storage_engine.legacy.connection`, you can pass the `ezpublish.api.storage_engine.legacy.dbhandler` service.


Also note that there can be several gateways per Field Type (one per storage engine). In this case it's recommended to either create base implementation which each gateway can inherit or create interface which each gateway must implement and reference it instead of specific implementation when type-hinting method arguments.

!!! tip

    Gateway configuration for built-in Field Types is located in [`EzPublishCoreBundle/Resources/config/storage_engines.yml`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Bundle/EzPublishCoreBundle/Resources/config/storage_engines.yml).
