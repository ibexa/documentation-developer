---
description: Use document field mappers to add additional data in Solr search engine.
---

# Solr document field mappers

You can use document field mappers to index additional data in the search engine.

The additional data can come from external sources (for example, the [Personalization 
service](personalization.md)), or from internal ones.
An example of indexing internal data is indexing data through the Location hierarchy: 
from the parent Location to the child Location, or indexing child data on the parent Location.
You can use this to find the content with full-text search, or to simplify a search 
in a complicated data model.

To do this effectively, you must understand how the data is indexed with the Solr search engine.
Solr uses [documents](https://lucene.apache.org/solr/guide/7_7/overview-of-documents-fields-and-schema-design.html#how-solr-sees-the-world) as a unit of data that is indexed.
Documents are indexed per translation, as content blocks. 
A block is a nested document structure.
When used in [[= product_name =]], a parent document represents content, 
and Locations are indexed as child documents of the Content item.
To avoid duplication, full-text data is indexed on the Content document only. 
Knowing this, you can index additional data by the following:

- All block documents (meaning content and its Locations, all translations)
- All block documents per translation
- Content documents
- Content documents per translation
- Location documents

Additional data is indexed by implementing a document field mapper and registering it 
at one of the five extension points described above.
You can create the field mapper class anywhere inside your bundle,
as long as you register it as a Symfony service.
There are three different field mappers. 
Each mapper implements two methods, by the same name, but accepting different arguments:

- `ContentFieldMapper`
    - `::accept(Content $content)`
    - `::mapFields(Content $content)`
- `ContentTranslationFieldMapper`
    - `::accept(Content $content, $languageCode)`
    - `::mapFields(Content $content, $languageCode)`
- `LocationFieldMapper`
    - `::accept(Location $content)`
    - `::mapFields(Location $content)`

Mappers can be used on the extension points by registering them with the [service container](php_api.md#service-container) by using service tags, as follows:

- All block documents
    - `ContentFieldMapper`
    - `ibexa.solr.field_mapper.block`
- All block documents per translation
    - `ContentTranslationFieldMapper`
    - `ibexa.solr.field_mapper.block_translation`
- Content documents
    - `ContentFieldMapper`
    - `ibexa.solr.field_mapper.content`
- Content documents per translation
    - `ContentTranslationFieldMapper`
    - `ibexa.solr.field_mapper.content_translation`
- Location documents
    - `LocationFieldMapper`
    - `Ibexa\Solr\FieldMapper\LocationFieldMapper\Aggregate`

The following example shows how you can index data from the parent Location content, 
to make it available for full-text search on the child content.
The example relies on a use case of indexing webinar data on the webinar events, 
which are children of the webinar. 
The field mapper could then look like this:

```php
[[= include_file('code_samples/search/solr/src/Search/FieldMapper/WebinarEventTitleFulltextFieldMapper.php') =]]
```

You index full text data only on the content document, therefore, you would register the service like this:

``` yaml
[[= include_file('code_samples/search/solr/config/field_mapper_services.yaml') =]]
```

!!! caution "Permission issues when using Repository API in document field mappers"

    Document field mappers are low-level and expect to be able to index all content 
    regardless of current user permissions.
    If you use PHP API in your custom document field mappers, apply [`sudo()`](php_api.md#using-sudo),
    or use the Persistence SPI layer as in the example above.
