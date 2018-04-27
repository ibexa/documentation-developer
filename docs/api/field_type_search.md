# Search

Fields, or a custom Field Type, might contain or maintain data relevant for user searches. To make the search engine aware of the data in your Field Type you need to implement an additional interface and register the implementation.

If your Field Type does not maintain any data, which should be available to search engines, feel free to just ignore this section.

The `eZ\Publish\SPI\FieldType\Indexable` defines below methods, which are required to be implemented, if the Field Type provides data relevant to search engines.

`getIndexData( Field $field )`

This method returns the actual index data for the provided `eZ\Publish\SPI\Persistence\Content\Field`. The index data consists of an array of `eZ\Publish\SPI\Persistence\Content\Search\Field` instances. They are described below in further detail.

`getIndexDefinition()`

To be able to query data properly an indexable Field Type also is required to return search specification. You must return a HashMap of `eZ\Publish\SPI\Persistence\Content\Search\FieldType` instances from this method, which could look like:

```
[
    'url'  => new Search\FieldType\StringField(),
    'text' => new Search\FieldType\StringField(),
]
```

 This example from the `Url` Field Type shows that the Field Type will always return two indexable values, both strings. They have the names `url` and `text` respectively.

 `getDefaultMatchField()`

This method retrieves name of the default field to be used for matching. As Field Types can index multiple fields (see [MapLocation](field_type_reference.md#maplocation-field-type) Field Type's implementation of this interface), this method is used to define default field for matching. Default field is typically used by Field criterion.

 `getDefaultSortField()`

This method gets name of the default field to be used for sorting. As Field Types can index multiple fields (see [MapLocation](field_type_reference.md#maplocation-field-type) Field Type's implementation of this interface), this method is used to define default field for sorting. Default field is typically used by Field sort clause.

## Register Indexable Implementations

 Implement `\eZ\Publish\SPI\FieldType\Indexable` as an extra service, and register this Service using the tag `ezpublish.fieldType.indexable`. Example from [`indexable_fieldtypes.yml`](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/settings/indexable_fieldtypes.yml):

 ``` yml
     ezpublish.fieldType.indexable.ezkeyword:
         class: eZ\Publish\Core\FieldType\Keyword\SearchField
         tags:
             - {name: ezpublish.fieldType.indexable, alias: ezkeyword}
  ```

 Please note that `alias` should be the same as Filed Type ID.

## Search Field Values

The search field values, returned by the `getIndexData` method are simple value objects consisting of the following properties:

|Property|Description|
|--------|-----------|
|`$name`|The name of the field|
|`$value`|The value of the field|
|`$type`|An `eZ\Publish\SPI\Persistence\Content\Search\FieldType` instance, describing the type information of the field.|

## Search Field Types

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

## Configuring Solr

As mentioned before, if you are using the standard type definitions **there is no need to configure the search backend in any way**. Everything will work fine. The field definitions are handled using `dynamicField` definitions in Solr, for example.

If you want to configure the handling of your field, you can always add a special field definition the Solr `schema.xml`. The Field Type names, which are used by the Solr search backend look like this for fields: `<content_type_identifier>/<field_identifier>/<search_field_name>_<type>`. You can, of course define custom `dynamicField` definitions to match, for example, on your custom `_<type>` definition.

You could also define a custom field definition for certain fields, like for the name field in an article:

```
<field name="article/name/value_s" type="string" indexed="true" stored="true" required="false"/>
```

!!! note

    If you want to learn more about the Solr implementation and detailed information about configuring it, check out the [Solr Search Bundle](../guide/solr.md).
