# eContent indexer [[% include 'snippets/commerce_badge.md' %]]

## eContent class elements

Solr index is built with data from the following eContent tables:

- `sve_class`
- `sve_class_attributes`
- `sve_object`
- `sve_object_attributes`
- `sve_object_catalog`

eContent supports n levels of class objects (stored in `sve_class`), and so does the indexer.

In the default configuration you can have only two classes: product and categories,
but the model is flexible and it can handle several class types,
for example: category_a, sub_category, product, or any other hierarchical schema.

All `sve_class` elements have a common name field. This name is used by the indexer as a common Solr field name for all types.

The name is specified in `sve_object_attributes` and its identifier is specified in the `sve_class` table.
This name is stored in Solr with field name `name_s`.

## Standard Solr field names

|Solr Field Name|Description|Database Field|Example|
|--- |--- |--- |--- |
|`id`|ID of index element. It is built by concatenating Content Type + Location ID + language.||`econtent11gerde`|
|`content_id`|Node ID of an element.|sve_object.node_id|`11`|
|`document_type_id`|The type of document. For eContent the value is `econtent`||`econtent`|
|`type_id`|The ID of the Content Type.|sve_class.class_id|`1`|
|`type_name_id`|The name of the Content Type.|sve_class.class_name|`product_group`|
|`section_id`|The Section is a number that can be used later to separate content.|sve_object.section_id|`1`|
|`meta_indexed_language_code_s`|Language code of the specified element.||`ger-DE`|
|`main_location_id`|The `node_id` of the element.|sve_object.node_id|`11`|
|`main_node_id`|The `node_id` of the element.|sve_object.node_id|`11`|
|`main_location_parent_id`|The `node_id` of the parent element.|sve_object.parent_id|`2`|
|`main_location_path_id`|The path of the element is the tree node ID of all parent elements separated by a slash.|sve_object.path_string|`/2/11/`|
|`main_location_visible_b`|A boolean value to determine whether the element is visible or not. The value indexed here is the negated value from the database. That is because, in database, the field specifies whether the element is hidden or not, and in Solr, the field specifies whether the element is visible or not.|NOT sve_object.hidden|`true`|
|`meta_blocked_b`|A boolean value to determine whether the element is blocked or not.|sve.object.blocked|`false`|
|`meta_depth_i`|The depth of the element. It should be the amount of elements in `path_string`|sve_object.depth|`2`|
|`name_s`|The name of the element as specified by the class ID identifier.|sve_object_attributes.data_text</br>With attribute ID determined in sve_class|`DMT`|
|`meta_modified_dt`|The date time value from the database in Solr datetime format.|sve_object.change_date|`2016-06-21T08:52:40Z`|
|`main_catalog_segments_ms`|A multivalue with all catalog code names.|sve_object_catalog.catalog_code|`ALL`, `NORMAL`|
|`is_main_b`|True if `content_id` is the main location ID.|sve_object.node_id|`true`|

## Language and fallback language

Each indexed language can have a fallback language.
In the following example, the key of the array is the language, and the content is the fallback language.

``` yaml
# indexer configuration for econtent
siso_search.default.index_econtent_languages:
    ger-DE: eng-GB #language: ger-DE, fallback: eng-GB
    eng-GB: ger-DE #language: eng-GB, ger-DE
 
```

This means that if a Content item in language `ger-DE` has some missing data,
the missing data is taken from the fallback language data (if there is any).

eContent languages are defined per attribute, so it is possible to have an object with a full set of attributes in one language
and a smaller set of attributes in another language.
