---
description: Use document field mappers to add additional data in Solr search engine.
---

# Solr document field mappers

You can use document field mappers to index additional data in the search engine.

The additional data can come from external sources (for example, the [Personalization service](personalization.md)), or from internal ones.
An example of indexing internal data is indexing data through the location hierarchy: from the parent location to the child location, or indexing child data on the parent location.
You can use this to find the content with full-text search, or to simplify a search in a complicated data model.

To do this effectively, you must understand how the data is indexed with the Solr search engine.
Solr uses [documents](https://solr.apache.org/guide/7_7/overview-of-documents-fields-and-schema-design.html#how-solr-sees-the-world) as a unit of data that is indexed.
Documents are indexed per translation, as content blocks.
A block is a nested document structure.
When used in [[= product_name =]], a parent document represents content, and locations are indexed as child documents of the content item.
To avoid duplication, full-text data is indexed on the content document only.
Knowing this, you can index additional data by the following:

- All block documents (meaning content and its locations, all translations)
- All block documents per translation
- Content documents
- Content documents per translation
- Location documents

Additional data is indexed by implementing a document field mapper and registering it at one of the five extension points described above.
You can create the field mapper class anywhere inside your bundle, as long as you register it as a Symfony service.
There are three different field mappers.
Each mapper implements two methods, by the same name, but accepting different arguments:

- [`ContentFieldMapper`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Solr-FieldMapper-ContentTranslationFieldMapper.html)
    - [`::accept(Content $content)`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Solr-FieldMapper-ContentTranslationFieldMapper.html#method_accept)
    - [`::mapFields(Content $content)`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Solr-FieldMapper-ContentTranslationFieldMapper.html#method_mapFields)
- [`ContentTranslationFieldMapper`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Solr-FieldMapper-ContentTranslationFieldMapper.html)
    - [`::accept(Content $content, $languageCode)`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Solr-FieldMapper-ContentTranslationFieldMapper.html#method_accept)
    - [`::mapFields(Content $content, $languageCode)`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Solr-FieldMapper-ContentTranslationFieldMapper.html#method_mapFields)
- [`LocationFieldMapper`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Solr-FieldMapper-LocationFieldMapper.html)
    - [`::accept(Location $content)`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Solr-FieldMapper-LocationFieldMapper.html#method_accept)
    - [`::mapFields(Location $content)`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Solr-FieldMapper-LocationFieldMapper.html#method_mapFields)

Mappers can be used on the extension points by registering them with the [service container](php_api.md#service-container) by using service tags, as follows:

- All block documents
    - `ibexa.search.solr.field.mapper.block`
- All block documents per translation
    - `ibexa.search.solr.field.mapper.block.translation`
- Content documents
    - `ibexa.search.solr.field.mapper.content`
- Content documents per translation
    - `ibexa.search.solr.field.mapper.content.translation`
- Location documents
    - `ibexa.search.solr.field.mapper.location`

The following example shows how you can index data from the parent location content, to make it available for full-text search on the child content.
The example relies on a use case of indexing webinar data on the webinar events, which are children of the webinar.
The field mapper could then look like this:

```php
[[= include_file('code_samples/search/custom/src/Search/FieldMapper/WebinarEventTitleFulltextFieldMapper.php') =]]
```

You index full text data only on the content document, therefore, you would register the service like this:

``` yaml
[[= include_file('code_samples/search/custom/config/field_mapper_services.yaml') =]]
```

!!! caution "Permission issues when using Repository API in document field mappers"

    Document field mappers are low-level and expect to be able to index all content regardless of current user permissions.
    If you use PHP API in your custom document field mappers, apply [`sudo()`](php_api.md#using-sudo), or use the Persistence SPI layer as in the example above.
