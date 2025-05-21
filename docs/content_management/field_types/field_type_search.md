---
description: To be searchable, a field type must implement the Indexable interface.
---

# Field type searching

Fields, or a custom field type, might contain or maintain data relevant for user searches.
To make the search engine aware of the data in your field type you need to implement an additional interface and register the implementation.

## `Indexable` interface

The `Ibexa\Contracts\Core\FieldType\Indexable` interface defines the methods below which are required if the field type provides data relevant to search engines.

### `getIndexData(Field $field, FieldDefinition $fieldDefinition)`

This method returns the actual index data for the provided `Ibexa\Contracts\Core\Persistence\Content\Field`.
The index data consists of an array of `Ibexa\Contracts\Core\Search\Field` instances.
They're described below in further detail.

### `getIndexDefinition()`

To be able to query data properly an indexable field type also is required to return search specification. You must return an associative array of `Ibexa\Contracts\Core\Search\FieldType` instances from this method, which could look like:

```
[
    'url'  => new Search\FieldType\StringField(),
    'text' => new Search\FieldType\StringField(),
]
```

This example from the `Url` field type shows that the field type always returns two indexable values, both strings.
They have the names `url` and `text` respectively.

### `getDefaultMatchField()`

This method retrieves the name of the default field to be used for matching.
As field types can index multiple fields (see [MapLocation](maplocationfield.md) field type's implementation of this interface), this method is used to define the default field for matching.
Default field is typically used by the [`Field` Search Criterion](field_criterion.md).

### `getDefaultSortField()`

This method gets name of the default field to be used for sorting.
As field types can index multiple fields (see [MapLocation](maplocationfield.md) field type's implementation of this interface), this method is used to define default field for sorting.
Default field is typically used by the [`Field` Sort Clause](field_sort_clause.md).

## Register `Indexable` implementations

Implement `Ibexa\Contracts\Core\FieldType\Indexable` as an extra service and register this Service using the `ibexa.field_type.indexable` tag.
Example from [`indexable_fieldtypes.yaml`](https://github.com/ibexa/core/blob/4.6/src/lib/Resources/settings/indexable_fieldtypes.yml):

``` yaml
Ibexa\Core\FieldType\Keyword\SearchField:
    class: Ibexa\Core\FieldType\Keyword\SearchField
    tags:
        - {name: ibexa.field_type.indexable, alias: ezkeyword}
```

The `alias` should be the same as field type ID.

## Search field values

The search field values returned by the `getIndexData` method are simple value objects consisting of the following properties:

|Property|Description|
|--------|-----------|
|`$name`|The name of the field|
|`$value`|The value of the field|
|`$type`|An `Ibexa\Contracts\Core\Search\FieldType` instance, describing the type information of the field.|

## Search field types

There are many available search field types which are handled by search backend configuration.
When using them, there is no need to adapt, for example, the Solr configuration in any way.
You can always use custom field types, but these might require re-configuration of the search backend. For Solr this would mean adapting the `schema.xml` file.

The default available search field types that can be found in the `Ibexa\Contracts\Core\Search\FieldType` namespace are:

|Field type|Description|
|--------|-----------|
|`BooleanField`|Boolean values.|
|`CustomField`|Custom field, for custom search data types. Probably requires additional configuration in the search backend.|
|`DateField`|Date field. Can be used for date range queries.|
|`DocumentField`|Document field|
|`FloatField`|Field for floating point numbers.|
|`FullTextField`|Represents full text searchable value of the field which can be indexed by the legacy search engine. Some full text fields are stored as an array of strings.|
|`GeoLocationField`|Field used for Geo location.|
|`IdentifierField`|Field used for IDs. Basically acts like the string field, but it's not queried by fulltext searches|
|`IntegerField`|Field for integer numbers.|
|`MultipleBooleanField`|Multiple boolean values.|
|`MultipleIdentifierField`|Multiple IDs values.|
|`MultipleIntegerField`|Multiple integer numbers.|
|`MultipleStringField`|Multiple string values.|
|`PriceField`|Field for price values. Currency conversion might be applied by the search backends. Might require careful configuration.|
|`StringField`|Standard string values. It's also queried by full text searches.|
|`TextField`|Standard text values. It's queried by full text searches. Configured text normalizations in the search backend apply.|

## Configuring Solr

As mentioned before, if you use the standard type definitions, there is no need to configure the search backend in any way.
The field definitions are handled using `dynamicField` definitions in Solr, for example.

If you want to configure the handling of your field, you can always add a special field definition to the Solr `schema.xml`.
For fields, the field type names used by the Solr search backend look like this: `<content_type_identifier>/<field_identifier>/<search_field_name>_<type>`.
You can define custom `dynamicField` definitions to match, for example, on your custom `_<type>` definition.

You could also define a custom field definition for certain fields, like for the name field in an article:

```
<field name="article/name/value_s" type="string" indexed="true" stored="true" required="false"/>
```

!!! note

    If you want to learn more about the Solr implementation and detailed information about configuring it, check out the [Solr Search Bundle](solr_overview.md).
