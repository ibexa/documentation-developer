# Field Type searching

Fields, or a custom Field Type, might contain or maintain data relevant for user searches.
To make the search engine aware of the data in your Field Type you need to implement an additional interface and register the implementation.

The `eZ\Publish\SPI\FieldType\Indexable` interface defines the methods below which are required if the Field Type provides data relevant to search engines.

### `getIndexData(Field $field)`

This method returns the actual index data for the provided `eZ\Publish\SPI\Persistence\Content\Field`. The index data consists of an array of `eZ\Publish\SPI\Persistence\Content\Search\Field` instances. They are described below in further detail.

### `getIndexDefinition()`

To be able to query data properly an indexable Field Type also is required to return search specification. You must return an associative array of `eZ\Publish\SPI\Search\FieldType` instances from this method, which could look like:

```
[
    'url'  => new Search\FieldType\StringField(),
    'text' => new Search\FieldType\StringField(),
]
```

This example from the `Url` Field Type shows that the Field Type will always return two indexable values, both strings. They have the names `url` and `text` respectively.

### `getDefaultMatchField()`

This method retrieves the name of the default Field to be used for matching. As Field Types can index multiple Fields (see [MapLocation](field_type_reference.md#maplocation-field-type) Field Type's implementation of this interface), this method is used to define the default field for matching. The default Field is typically used by the [`Field` Search Criterion](../guide/search/criteria_reference/field_criterion.md).

### `getDefaultSortField()`

This method gets name of the default Field to be used for sorting. As Field Types can index multiple Fields (see [MapLocation](field_type_reference.md#maplocation-field-type) Field Type's implementation of this interface), this method is used to define default field for sorting. Default Field is typically used by the [`Field` Sort Clause](../guide/search/sort_clause_reference/field_sort_clause.md).

## Register Indexable Implementations

Implement `eZ\Publish\SPI\FieldType\Indexable` as an extra service and register this Service using the `ezpublish.fieldType.indexable` tag. Example from [`indexable_fieldtypes.yml`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/Core/settings/indexable_fieldtypes.yml):

``` yml
ezpublish.fieldType.indexable.ezkeyword:
    class: eZ\Publish\Core\FieldType\Keyword\SearchField
    tags:
        - {name: ezpublish.fieldType.indexable, alias: ezkeyword}
```

Note that `alias` should be the same as Field Type ID.

## Search Field Values

The search field values returned by the `getIndexData` method are simple value objects consisting of the following properties:

|Property|Description|
|--------|-----------|
|`$name`|The name of the field|
|`$value`|The value of the field|
|`$type`|An `eZ\Publish\SPI\Persistence\Content\Search\FieldType` instance, describing the type information of the field.|

## Search Field Types

There are many available search Field Types which are handled by search backend configuration. When using them, there is no need to adapt, for example, the Solr configuration in any way. You can always use custom Field Types, but these might require re-configuration of the search backend. For Solr this would mean adapting the `schema.xml` file.

The default available search Field Types that can be found in the `eZ\Publish\SPI\Search\FieldType` namespace are:

|Field Type|Description|
|--------|-----------|
|`BooleanField`|Boolean values.|
|`CustomField`|Custom field, for custom search data types. Will probably require additional configuration in the search backend.|
|`DateField`|Date field. Can be used for date range queries.|
|`DocumentField`|Document field|
|`FloatField`|Field for floating point numbers.|
|`FullTextField`|Represents full text searchable value of the Field which can be indexed by the legacy search engine. Some full text fields are stored as an array of strings.|
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

As mentioned before, if you use the standard type definitions, there is no need to configure the search backend in any way.
The Field definitions are handled using `dynamicField` definitions in Solr, for example.

If you want to configure the handling of your field, you can always add a special field definition to the Solr `schema.xml`. For fields, the Field Type names used by the Solr search backend look like this: `<content_type_identifier>/<field_identifier>/<search_field_name>_<type>`. 
You can define custom `dynamicField` definitions to match, for example, on your custom `_<type>` definition.

You could also define a custom Field definition for certain fields, like for the name Field in an article:

```
<field name="article/name/value_s" type="string" indexed="true" stored="true" required="false"/>
```

!!! note

    If you want to learn more about the Solr implementation and detailed information about configuring it, check out the [Solr Search Bundle](../guide/solr.md).
