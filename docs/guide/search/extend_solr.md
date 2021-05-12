# Solr extensibility

[Solr](solr.md) can be extended by adding several functionalities, such as document field mappers, custom search criteria, custom sort clauses, or custom aggregations.

### Document field mappers

!!! note

    Document field mappers are available since Solr bundle version 1.2.

You can use document field mappers to index additional data in the search engine.

The additional data can come from external sources (for example, a Personalization 
service), or from internal ones.
An example of the latter is indexing data through the Location hierarchy: from the parent Location to the child Location, or indexing child data on the parent Location.
This may be needed when you want to find the content with full-text search, or to simplify search for a complicated data model.

To do this effectively, you first need to understand how the data is indexed with the Solr search engine.
Solr uses [documents](https://lucene.apache.org/solr/guide/7_7/overview-of-documents-fields-and-schema-design.html#how-solr-sees-the-world) as a unit of data that is indexed.
Documents are indexed per translation, as content blocks. A block is a nested document structure.
When used in [[= product_name =]], a parent document represents content, and Locations are indexed as child documents of the Content item.
To avoid duplication, full-text data is indexed on the Content document only. Knowing this, you have the option to index additional data on:

- all block documents (meaning content and its Locations, all translations)
- all block documents per translation
- content documents
- content documents per translation
- Location documents

Indexing additional data is done by implementing a document field mapper and registering it at one of the five extension points described above.
You can create the field mapper class anywhere inside your bundle,
as long as when you register it as a service, the `class` parameter in your `services.yaml` matches the correct path.
There are three different field mappers. Each mapper implements two methods, by the same name, but accepting different arguments:

- `ContentFieldMapper`
    - `::accept(Content $content)`
    - `::mapFields(Content $content)`
- `ContentTranslationFieldMapper`
    - `::accept(Content $content, $languageCode)`
    - `::mapFields(Content $content, $languageCode)`
- `LocationFieldMapper`
    - `::accept(Location $content)`
    - `::mapFields(Location $content)`

These can be used on the extension points by registering them with the [service container](../service_container.md) by using service tags, as follows:

- all block documents
    - `ContentFieldMapper`
    - `ezpublish.search.solr.field_mapper.block`
- all block documents per translation
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

The following example shows how to index data from the parent Location content, in order to make it available for full-text search on the children content.
It is based on the use case of indexing webinar data on the webinar events, which are children of the webinar. Field mapper could then look like this:

```php
 <?php

namespace My\WebinarApp;

use EzSystems\EzPlatformSolrSearchEngine\FieldMapper\ContentFieldMapper;
use eZ\Publish\SPI\Persistence\Content\Handler as ContentHandler;
use eZ\Publish\SPI\Persistence\Content\Location\Handler as LocationHandler;
use eZ\Publish\SPI\Persistence\Content;
use eZ\Publish\SPI\Search;

class WebinarEventTitleFulltextFieldMapper extends ContentFieldMapper
{
    /**
     * @var \eZ\Publish\SPI\Persistence\Content\Type\Handler
     */
    protected $contentHandler;

    /**
     * @var \eZ\Publish\SPI\Persistence\Content\Location\Handler
     */
    protected $locationHandler;

    /**
     * @param \eZ\Publish\SPI\Persistence\Content\Handler $contentHandler
     * @param \eZ\Publish\SPI\Persistence\Content\Location\Handler $locationHandler
     */
    public function __construct(
        ContentHandler $contentHandler,
        LocationHandler $locationHandler
    ) {
        $this->contentHandler = $contentHandler;
        $this->locationHandler = $locationHandler;
    }

    public function accept(Content $content)
    {
        // ContentType with ID 42 is webinar event
        return $content->versionInfo->contentInfo->contentTypeId == 42;
    }

    public function mapFields(Content $content)
    {
        $mainLocationId = $content->versionInfo->contentInfo->mainLocationId;
        $location = $this->locationHandler->load($mainLocationId);
        $parentLocation = $this->locationHandler->load($location->parentId);
        $parentContentInfo = $this->contentHandler->loadContentInfo($parentLocation->contentId);

        return [
            new Search\Field(
                'fulltext',
                $parentContentInfo->name,
                new Search\FieldType\FullTextField()
            ),
        ];
    }
}
```

Since you index full text data only on the content document, you would register the service like this:

``` yaml
my_webinar_app.webinar_event_title_fulltext_field_mapper:
    class: My\WebinarApp\WebinarEventTitleFulltextFieldMapper
    arguments:
        - '@ezpublish.spi.persistence.content_handler'
        - '@ezpublish.spi.persistence.location_handler'
    tags:
        - {name: ezpublish.search.solr.field_mapper.content}
```


!!! caution "Permission issues when using Repository API in document field mappers"

    Document field mappers are low level. They expect to be able to index all content regardless of current user permissions.
    If you use PHP API in your custom document field mappers, you need to apply [`sudo()`](../../api/public_php_api.md#using-sudo),
    otherwise use the Persistence SPI layer as in the example above.

## Custom Search Criterion

To provide support for a custom Search Criterion, perform the following steps.

First, in the `src/Query/Criterion/CameraManufacturerVisitor.php` file, implement `CriterionVisitor`:

``` php hl_lines="8"
<?php

declare(strict_types=1);

namespace App\Query\Criterion;

use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use EzSystems\EzPlatformSolrSearchEngine\Query\CriterionVisitor;
use Ibexa\Platform\Contracts\ElasticSearchEngine\Query\LanguageFilter;

final class CameraManufacturerVisitor implements CriterionVisitor
{
    public function supports(Criterion $criterion, LanguageFilter $languageFilter): bool
    {
        return $criterion instanceof CameraManufacturer;
    }

    public function visit(CriterionVisitor $dispatcher, Criterion $criterion, LanguageFilter $languageFilter): array
    {
        return [
            'terms' => [
                'exif_camera_manufacturer_id' => (array)$criterion->value
            ]
        ];
    }
}
```

Then, create the `src/Query/Criterion/CameraManufacturerCriterion.php` file and add the Search Criterion class:

``` php
<?php

declare(strict_types=1);

namespace App\Query\Criterion;

use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\Operator;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\Operator\Specifications;

final class CameraManufacturer extends Criterion
{
    /**
     * @param string|string[] $value Manufacturer name(s) to be matched.
     */
    public function __construct($value)
    {
        parent::__construct(null, null, $value);
    }

    public function getSpecifications(): array
    {
        return [
            new Specifications(
                Operator::IN,
                Specifications::FORMAT_ARRAY,
                Specifications::TYPE_STRING
            ),
            new Specifications(
                Operator::EQ,
                Specifications::FORMAT_SINGLE,
                Specifications::TYPE_STRING
            ),
        ];
    }
}
```

Finally, register the visitor as a service.

Search Criteria can be valid for both Content and Location search.
To choose the search type, use either `content` or `location` in the tag:

``` yaml
services:
    App\Query\Criterion\CameraManufacturerVisitor:
        tags:
            - { name: ezplatform.search.elasticsearch.query.content.criterion_visitor }
            - { name: ezplatform.search.elasticsearch.query.location.criterion_visitor }
```

## Custom Sort Clause

To create a custom Sort Clause, perform the following steps.

First, in the `src/Query/SortClause/ScoreVisitor.php` file, implement `SortClauseVisitor`:

``` php hl_lines="10"
<?php

declare(strict_types=1);

namespace App\Query\SortClause;

use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;
use Ibexa\Platform\Contracts\ElasticSearchEngine\Query\LanguageFilter;
use EzSystems\EzPlatformSolrSearchEngine\Query\SortClauseVisitor;

final class ScoreVisitor implements SortClauseVisitor
{
    public function supports(SortClause $sortClause, LanguageFilter $languageFilter): bool
    {
        return $sortClause instanceof Score;
    }

    public function visit(SortClauseVisitor $visitor, SortClause $sortClause, LanguageFilter $languageFilter): array
    {
        $order = $sortClause->direction === Query::SORT_ASC ? 'asc' : 'desc';

        return [
            '_score' => [
                'order' => $order,
            ],
        ];
    }
}
```

The `supports()` method checks whether the implementation can handle the requested Sort Clause.
The `visit()` method contains the logic that translates Sort Clause information into data that is understandable by Solr.
The `visit()` method takes the Sort Clause visitor, the Sort Clause itself and the language filter as arguments.

Then, in the `src/Query/SortClause/ScoreSortClause.php` file, add the Sort Clause class:

``` php
<?php

declare(strict_types=1);

namespace App\Query\SortClause;

use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;

final class Score extends SortClause
{
    public function __construct(string $sortDirection = Query::SORT_ASC)
    {
        parent::__construct('_score', $sortDirection);
    }
}
```

Finally, register the visitor as a service.

Sort Clauses can be valid for both Content and Location search.
To choose the search type, use either `content` or `location` in the tag:

``` yaml
services:
    App\Query\SortClause\ScoreVisitor:
        tags:
            - { name: ezplatform.search.elasticsearch.query.content.sort_clause_visitor }
            - { name: ezplatform.search.elasticsearch.query.location.sort_clause_visitor }
```

## Custom Aggregation

To create a custom Aggregation for use with Solr, create an aggregation class.
In the following example, an aggregation groups the Location query results by the Location priority:

``` php
<?php

declare(strict_types=1);

namespace App\Query\Aggregation;

use eZ\Publish\API\Repository\Values\Content\Query\Aggregation\AbstractRangeAggregation;
use eZ\Publish\API\Repository\Values\Content\Query\Aggregation\LocationAggregation;

final class PriorityRangeAggregation extends AbstractRangeAggregation implements LocationAggregation
{
    ...
}
```

The `PriorityRangeAggregation` class extends `AbstractRangeAggregation`.
The name of the class indicates that it aggregates the results by using 
the Range aggregation.

An aggregation must implement the `eZ\Publish\API\Repository\Values\Content\Query\Aggregation` 
interface or inherit one of following abstract classes:

- `eZ\Publish\API\Repository\Values\Content\Query\Aggregation\AbstractRangeAggregation`
- `eZ\Publish\API\Repository\Values\Content\Query\Aggregation\AbstractStatsAggregation`
- `eZ\Publish\API\Repository\Values\Content\Query\Aggregation\AbstractTermAggregation`

An aggregation can also implement one of the following interfaces:

- `eZ\Publish\API\Repository\Values\Content\Query\Aggregation\FieldAggregation`, based on a content Field
- `eZ\Publish\API\Repository\Values\Content\Query\Aggregation\LocationAggregation`, based on content Location
- `eZ\Publish\API\Repository\Values\Content\Query\Aggregation\RawAggregation`, based on details of the index structure

!!! note "Aggregation definition"

    An aggregation definition must contain at least the name of an aggregation 
    and optional aggregation parameters, such as, for example the path (string) 
    that is used to limit aggregation results to a specific subtree or Content 
    Type identifier, or a / Field definition identifier, which will be mapped 
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
services:
    App\Query\Aggregation\Elasticsearch\PriorityAggregationVisitor:
        class: Ibexa\Platform\ElasticSearchEngine\Query\AggregationVisitor\RangeAggregationVisitor
        factory: ['@Ibexa\Platform\ElasticSearchEngine\Query\AggregationVisitor\Factory\SearchFieldAggregationVisitorFactory', 'createRangeAggregationVisitor']
        arguments:
            $aggregationClass: 'App\Query\Aggregation\PriorityRangeAggregation'
            $searchIndexFieldName: 'priority_i'
        tags:
            - { name: ezplatform.search.elasticsearch.query.location.aggregation_visitor }
```

The visitor is created by `SearchFieldAggregationVisitorFactory`.
You provide it with two arguments:

- the aggregation class in `aggregationClass`
- the field name in search index in `searchIndexFieldName`

Tag the service with `ezplatform.search.elasticsearch.query.location.aggregation_visitor`.

For the result extractor, you can use the built-in `RangeAggregationResultExtractor`
and provide it with the aggregation class in the `aggregationClass` parameter.

Tag the service with `ezplatform.search.elasticsearch.query.location.aggregation_result_extractor`.

``` yaml
services:
    App\Query\Aggregation\Elasticsearch\PriorityAggregationResultExtractor:
        class: Ibexa\Platform\ElasticSearchEngine\Query\ResultExtractor\AggregationResultExtractor\RangeAggregationResultExtractor
        arguments:
            $aggregationClass: 'App\Query\Aggregation\PriorityRangeAggregation'
        tags:
            - { name: ezplatform.search.elasticsearch.query.location.aggregation_result_extractor }
```

If you are using a different type of aggregation than range, you can also use respective visitor and extractor classes:

- `Ibexa\Platform\ElasticSearchEngine\Query\AggregationVisitor\RangeAggregationVisitor`
- `Ibexa\Platform\ElasticSearchEngine\Query\AggregationVisitor\StatsAggregationVisitor`
- `Ibexa\Platform\ElasticSearchEngine\Query\AggregationVisitor\TermAggregationVisitor`

- `Ibexa\Platform\ElasticSearchEngine\Query\ResultExtractor\AggregationResultExtractor\RangeAggregationResultExtractor`
- `Ibexa\Platform\ElasticSearchEngine\Query\ResultExtractor\AggregationResultExtractor\StatsAggregationResultExtractor`
- `Ibexa\Platform\ElasticSearchEngine\Query\ResultExtractor\AggregationResultExtractor\TermAggregationResultExtractor`

If you have a more complex use case, you need to create your own visitor and extractor.

### Custom aggregation visitor

The aggregation visitor must implement `Ibexa\Platform\Contracts\ElasticSearchEngine\Query\AggregationVisitor`:

``` php
<?php

declare(strict_types=1);

namespace App\Query\Aggregation\Elasticsearch;

use App\Query\Aggregation\PriorityRangeAggregation;
use eZ\Publish\API\Repository\Values\Content\Query\Aggregation;
use Ibexa\Platform\Contracts\ElasticSearchEngine\Query\AggregationVisitor;
use Ibexa\Platform\Contracts\ElasticSearchEngine\Query\LanguageFilter;

final class PriorityAggregationVisitor implements AggregationVisitor
{

    public function supports(Aggregation $aggregation, LanguageFilter $languageFilter): bool
    {
        return $aggregation instanceof PriorityRangeAggregation;
    }

    /**
     *
     * @param PriorityRangeAggregation $aggregation
     *
     */
    public function visit(AggregationVisitor $dispatcher, Aggregation $aggregation, LanguageFilter $languageFilter): array
    {
        $ranges = [];

        foreach ($aggregation->getRanges() as $range) {
            if ($range->getFrom() !== null && $range->getTo() !== null) {
                $ranges[] = [
                    'from' => $range->getFrom(),
                    'to' => $range->getTo()
                ];
            } elseif ($range->getFrom() === null && $range->getTo() !== null) {
                $ranges[] = [
                    'to' => $range->getTo()
                ];
            } elseif ($range->getFrom() !== null && $range->getTo() === null) {
                $ranges[] = [
                    'from' => $range->getFrom()
                ];
            } else {
                // invalid range
            }
        }

        return [
            'range' => [
                'field' => 'priority_i',
                'ranges' => $ranges
            ]
        ];
    }
}
```

The `supports()` method checks whether the provided aggregation is of the supported type
(in this case, your custom `PriorityRangeAggregation`).

The `visit()` method returns an array of results.

### Custom result extractor

You also need to create a result extractor, implementing `Ibexa\Platform\Contracts\ElasticSearchEngine\Query\AggregationResultExtractor`,
that transforms raw aggregation results from Elasticsearch into `AggregationResult` objects:

``` php
<?php

declare(strict_types=1);

namespace App\Query\Aggregation\Elasticsearch;

use App\Query\Aggregation\PriorityRangeAggregation;
use eZ\Publish\API\Repository\Values\Content\Query\Aggregation;
use eZ\Publish\API\Repository\Values\Content\Search\AggregationResult;
use Ibexa\Platform\Contracts\ElasticSearchEngine\Query\AggregationResultExtractor;
use Ibexa\Platform\Contracts\ElasticSearchEngine\Query\LanguageFilter;
use stdClass;

final class PriorityAggregationResultExtractor implements AggregationResultExtractor
{

    public function supports(Aggregation $aggregation, LanguageFilter $languageFilter): bool
    {
        return $aggregation instanceof PriorityRangeAggregation;
    }

    public function extract(Aggregation $aggregation, LanguageFilter $languageFilter, array $data): AggregationResult
    {
        $entries = [];

        foreach ($data['buckets'] as $bucket) {
            $entries[] = new AggregationResult\RangeAggregationResultEntry(
                new Aggregation\Range($bucket['from'] ?? null, $bucket['to'] ?? null),
                $bucket['doc_count']
            );
        }

        return new AggregationResult\RangeAggregationResult($aggregation->getName(), $entries);
    }
}
```

The `supports()` method checks whether the provided aggregation is of the supported type
(in this case, your custom `PriorityRangeAggregation`).

The `extract()` method converts the [raw data provided by the search engine](https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations.html) to a `RangeAggregationResult` object.

Finally, register both the aggregation visitor and the result extractor as services.

Tag the aggregation visitor with `ezplatform.search.elasticsearch.query.location.aggregation_visitor`
and the result extractor with `ezplatform.search.elasticsearch.query.location.aggregation_result_extractor`:

``` yaml
services:
    App\Query\Aggregation\Elasticsearch\PriorityAggregationVisitor:
        tags:
            - { name: 'ezplatform.search.elasticsearch.query.location.aggregation_visitor' }
    App\Query\Aggregation\Elasticsearch\PriorityAggregationResultExtractor:
        tags:
            - { name: 'ezplatform.search.elasticsearch.query.location.aggregation_result_extractor' }
```

For content-based aggregations, use the `ezplatform.search.elasticsearch.query.content.aggregation_visitor` and `ezplatform.search.elasticsearch.query.content.aggregation_result_extractor` tags respectively.
