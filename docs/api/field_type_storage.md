# Storage

## Storing external data

A Field Type may store arbitrary data in external data sources and is in fact encouraged to do so. External storages can be e.g. a web service, a file in the file system, another database or even the eZ Platform database itself (in form of a non-standard table). In order to perform this task, the Field Type will interact with the Persistence SPI, which can be found in `eZ\Publish\SPI\Persistence`, through the `eZ\Publish\SPI\FieldType\FieldStorage` interface.

Whenever the internal storage of a Content item that includes a Field of the Field Type is accessed, one of the following methods is called to also access the external data:

|Method|Description|
|------|-----------|
|`hasFieldData()`|Returns if the Field Type stores external data at all.|
|`storeFieldData()`|Called right before a Field of Field Type is stored. The method  stores `$externalData`. It returns `true`, if the call manipulated **internal data** of the given `Field`, so that it is updated in the internal database.|
|`getFieldData()`|Is called after a Field has been restored from the database in order to restore `$externalData`.|
|`deleteFieldData()`|Must delete external data for the given Field, if exists.|
|`getIndexData()`|Returns the actual index data for the provided `eZ\Publish\SPI\Persistence\Content\Field`. For more information see [search service](field_type_search.md#search-field-values).|

Each of the above methods receive a $context array, which contains information on the underlying storage and the environment. This context can be used to store data in the eZ Platform data storage, but outside of the normal structures (e.g. a custom table in an SQL database). Note that the Field Type must take care on its own for being compliant to different data sources and that 3rd parties can extend the data source support easily.

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

    For global service container integration, see [Register Field Type](field_type_registration.md).

## Gateway based Storage

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
