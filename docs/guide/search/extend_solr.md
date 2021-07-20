# Solr extensibility

[Solr](solr.md) can be extended by adding several functionalities, such as document field mappers, custom search criteria, or custom sort clauses.

## Document field mappers

You can use document field mappers to index additional data in the search engine.

The additional data can come from external sources (for example, the [Personalization 
service](../personalization/personalization.md)), or from internal ones.
An example of indexing internal data is indexing data through the Location hierarchy: 
from the parent Location to the child Location, or indexing child data on the parent Location.
You can use this to find the content with full-text search, or to simplify a search 
in a complicated data model.

To do this effectively, you must understand how the data is indexed with the Solr search engine.
Solr uses [documents](https://lucene.apache.org/solr/guide/7_7/overview-of-documents-fields-and-schema-design.html#how-solr-sees-the-world) as a unit of data that is indexed.
Documents are indexed per translation, as content blocks. 
A block is a nested document structure.
When used in eZ Platform, a parent document represents content, 
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

Mappers can be used on the extension points by registering them with the [service container](../../api/service_container.md) by using service tags, as follows:

- All block documents
    - `ContentFieldMapper`
    - `ezpublish.search.solr.field_mapper.block`
- All block documents per translation
    - `ContentTranslationFieldMapper`
    - `ezpublish.search.solr.field_mapper.block_translation`
- Content documents
    - `ContentFieldMapper`
    - `ezpublish.search.solr.field_mapper.content`
- Content documents per translation
    - `ContentTranslationFieldMapper`
    - `ezpublish.search.solr.field_mapper.content_translation`
- Location documents
    - `LocationFieldMapper`
    - `ezpublish.search.solr.field_mapper.location`

The following example shows how you can index data from the parent Location content, 
to make it available for full-text search on the child content.
The example relies on a use case of indexing webinar data on the webinar events, 
which are children of the webinar. 
The field mapper could then look like this:

```php
[[= include_file('code_samples/search/solr/src/FieldMapper/WebinarEventTitleFulltextFieldMapper.php') =]]
```

You index full text data only on the content document, therefore, you would register the service like this:

``` yaml
[[= include_file('code_samples/search/solr/config/packages/services.yaml', 0, 1) =]][[= include_file('code_samples/search/solr/config/packages/services.yaml', 25, 31) =]]
```


!!! caution "Permission issues when using Repository API in document field mappers"

    Document field mappers are low-level and expect to be able to index all content 
    regardless of current user permissions.
    If you use PHP API in your custom document field mappers, apply [`sudo()`](../../api/public_php_api.md#using-sudo),
    or use the Persistence SPI layer as in the example above.

## Custom Search Criteria

To provide support for a custom Search Criterion, do the following.

First, create an `src/Query/Criterion/CameraManufacturerCriterion.php` file 
that contains the Criterion class:

``` php
[[= include_file('code_samples/search/solr/src/Query/Criterion/CameraManufacturerCriterion.php') =]]
```

Then, add an `src/Query/Criterion/CameraManufacturerVisitor.php` file, 
implement `CriterionVisitor`:

``` php
[[= include_file('code_samples/search/solr/src/Query/Criterion/CameraManufacturerVisitor.php') =]]
```

Finally, register the visitor as a service.

Search Criteria can be valid for both Content and Location search.
To choose the search type, use either `content` or `location` in the tag:

``` yaml
[[= include_file('code_samples/search/solr/config/packages/services.yaml', 0, 1) =]][[= include_file('code_samples/search/solr/config/packages/services.yaml', 32, 36) =]]
```

## Custom Sort Clause

To create a custom Sort Clause, do the following.

First, add an `src/Query/SortClause/ScoreSortClause.php` file with the Sort Clause class:

``` php
[[= include_file('code_samples/search/solr/src/Query/SortClause/ScoreSortClause.php') =]]
```

Then, add an `src/Query/SortClause/ScoreVisitor.php` file that implements `SortClauseVisitor`:

``` php
[[= include_file('code_samples/search/solr/src/Query/SortClause/ScoreVisitor.php') =]]
```

The `canVisit()` method checks whether the implementation can handle the requested Sort Clause.
The `visit()` method contains the logic that translates Sort Clause information into data that is understandable by Solr.
The `visit()` method takes the Sort Clause itself as an argument.

Finally, register the visitor as a service.

Sort Clauses can be valid for both Content and Location search.
To choose the search type, use either `content` or `location` in the tag:

``` yaml
[[= include_file('code_samples/search/solr/config/packages/services.yaml', 0, 1) =]][[= include_file('code_samples/search/solr/config/packages/services.yaml', 37, 41) =]]
```
