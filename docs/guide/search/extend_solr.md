# Solr extensibility

[Solr](solr.md) can be extended by adding several functionalities, such as document field mappers, custom search criteria, custom sort clauses, or custom aggregations.

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

Mappers can be used on the extension points by registering them with the [service container](../../api/service_container.md) by using service tags, as follows:

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
[[= include_file('code_samples/search/solr/config/packages/services.yaml', 0, 1) =]][[= include_file('code_samples/search/solr/config/packages/services.yaml', 25, 31) =]]
```


!!! caution "Permission issues when using Repository API in document field mappers"

    Document field mappers are low-level and expect to be able to index all content 
    regardless of current user permissions.
    If you use PHP API in your custom document field mappers, apply [`sudo()`](../../api/public_php_api.md#using-sudo),
    or use the Persistence SPI layer as in the example above.

## Create custom Search Criteria

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

## Create custom Sort Clause

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

## Create custom Aggregation

To create a custom Aggregation for use with Solr, create an aggregation class.
In the following example, an aggregation groups the Location query results by the Location priority:

``` php
[[= include_file('code_samples/search/solr/src/Query/Aggregation/PriorityRangeAggregation.php') =]]
```

The `PriorityRangeAggregation` class extends `AbstractRangeAggregation`.
The name of the class indicates that it aggregates the results by using 
the Range aggregation.

An aggregation must implement the `Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation` 
interface or inherit one of following abstract classes:

- `Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\AbstractRangeAggregation`
- `Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\AbstractStatsAggregation`
- `Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\AbstractTermAggregation`

An aggregation can also implement one of the following interfaces:

- `Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\FieldAggregation`, based on content Field
- `Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\LocationAggregation`, based on content Location
- `Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\RawAggregation`, based on details of the index structure

!!! note "Aggregation definition"

    An aggregation definition must contain at least the name of an aggregation 
    and optional aggregation parameters, such as, for example, the path (string) 
    that is used to limit aggregation results to a specific subtree, Content 
    Type identifier, or Field definition identifier, which will be mapped 
    to the search index field name.
    
    Aggregation definition must be independent of the search engine used.

A custom aggregation requires that the following elements are provided:

- An aggregation visitor that returns an array of results
- A result extractor that transforms raw aggregation results from Solr 
into `AggregationResult` objects

In simpler cases, you can apply one of the built-in visitors that correspond 
to the aggregation type.
The example below uses `RangeAggregationVisitor`:

``` yaml
[[= include_file('code_samples/search/solr/config/packages/services.yaml', 0, 10) =]]
```

The visitor is created by `SearchFieldAggregationVisitorFactory`.
You provide it with two arguments:

- The aggregation class in `aggregationClass`
- The field name in search index in `searchIndexFieldName`

Tag the service with `ibexa.solr.query.location.aggregation_visitor`.

For the result extractor, you can use the built-in `RangeAggregationResultExtractor`
and provide it with the aggregation class in the `aggregationClass` parameter.

Tag the service with `ibexa.solr.query.location.aggregation_result_extractor`.

``` yaml
[[= include_file('code_samples/search/solr/config/packages/services.yaml', 0, 1) =]][[= include_file('code_samples/search/solr/config/packages/services.yaml', 11, 17) =]]
```

You can use a different type of aggregation, followed by respective visitor and extractor classes:

- `Ibexa\Solr\Query\Common\AggregationVisitor\StatsAggregationVisitor`
- `Ibexa\Solr\Query\Common\AggregationVisitor\TermAggregationVisitor`
- `Ibexa\Solr\ResultExtractor\AggregationResultExtractor\StatsAggregationResultExtractor`
- `Ibexa\Solr\ResultExtractor\AggregationResultExtractor\TermAggregationResultExtractor`

In a more complex use case, you must create your own visitor and extractor.

### Create aggregation visitor

The aggregation visitor must implement `Ibexa\Contracts\Solr\Query\AggregationVisitor`:

``` php
[[= include_file('code_samples/search/solr/src/Query/Aggregation/PriorityRangeAggregationVisitor.php') =]]
```

The `canVisit()` method checks whether the provided aggregation is of the supported type
(in this case, your custom `PriorityRangeAggregation`).

The `visit()` method returns an array of results.

### Create result extractor

You must also create a result extractor, which implements  `Ibexa\Solr\ResultExtractor\AggregationResultExtractor` 
that transforms raw aggregation results from Solr into `AggregationResult` objects:

``` php
[[= include_file('code_samples/search/solr/src/Query/Aggregation/PriorityAggregationResultExtractor.php') =]]
```

The `canVisit()` method checks whether the provided aggregation is of the supported type
(in this case, your custom `PriorityRangeAggregation`).

The `extract()` method converts the [raw data provided by the search engine](https://solr.apache.org/guide/8_8/search-sample.html#aggregation) to a `RangeAggregationResult` object.

Finally, register both the aggregation visitor and the result extractor as services.

Tag the aggregation visitor with `ibexa.solr.query.location.aggregation_visitor`
and the result extractor with `ibexa.solr.query.location.aggregation_result_extractor`:

``` yaml
[[= include_file('code_samples/search/solr/config/packages/services.yaml', 0, 1) =]][[= include_file('code_samples/search/solr/config/packages/services.yaml', 18, 24) =]]
```

For content-based aggregations, use the `ibexa.solr.query.content.aggregation_visitor` and `ibexa.solr.query.content.aggregation_result_extractor` tags respectively.
