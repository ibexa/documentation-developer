# Solr extensibility

[Solr](solr.md) can be extended by adding several functionalities, such as document field mappers, custom search criteria, custom sort clauses, or custom aggregations.

## Document field mappers

!!! note

    Document field mappers are available since Solr bundle version 1.2.

You can use document field mappers to index additional data in the search engine.

The additional data can come from external sources (for example, a Personalization 
service), or from internal ones.
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
as long as, when you register it as a service, the `class` parameter in your 
`services.yaml` matches the correct path.
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

Mappers can be used on the extension points by registering them with the [service container](../service_container.md) by using service tags, as follows:

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

You index full text data only on the content document, therefore, you would register the service like this:

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

    Document field mappers are low-level and expect to be able to index all content 
    regardless of current user permissions.
    If you use PHP API in your custom document field mappers, apply [`sudo()`](../../api/public_php_api.md#using-sudo),
    or use the Persistence SPI layer as in the example above.

## Custom Search Criteria

To provide support for a custom Search Criterion, do the following.

First, in the `src/Query/Criterion/CameraManufacturerVisitor.php` file, implement `CriterionVisitor`:

``` php
<?php

declare(strict_types=1);

namespace App\Query\Criterion;

use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use EzSystems\EzPlatformSolrSearchEngine\Query\CriterionVisitor;

final class CameraManufacturerVisitor extends CriterionVisitor
{
    public function canVisit(Criterion $criterion)
    {
        return $criterion instanceof CameraManufacturer;
    }
    public function visit(Criterion $criterion, CriterionVisitor $subVisitor = null)
    {
        $expressions = array_map(
            static function ($value): string {
                return 'exif_camera_manufacturer_id:"' . $this->escapeQuote($value) . '"';
            },
            ($criterion->value
        );
        return '(' . implode(' OR ', $expressions) . ')';
    }
}
```

Then, create the `src/Query/Criterion/CameraManufacturerCriterion.php` file and add the Criterion class:

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
            - { name: ezpublish.search.solr.query.content.criterion_visitor }
            - { name: ezpublish.search.solr.query.location.criterion_visitor }    
```

## Custom Sort Clause

To create a custom Sort Clause, do the following.

First, in the `src/Query/SortClause/ScoreVisitor.php` file, implement `SortClauseVisitor`:

``` php
<?php

declare(strict_types=1);

namespace App\Query\SortClause;

use eZ\Publish\API\Repository\Values\Content\Query\SortClause;
use EzSystems\EzPlatformSolrSearchEngine\Query\SortClauseVisitor;

class Score extends SortClauseVisitor
{
    public function canVisit(SortClause $sortClause): bool
    {
        return $sortClause instanceof SortClause\Score;
    }
    public function visit(SortClause $sortClause): string
    {
        return 'score ' . $this->getDirection($sortClause);
    }
}
```

The `canVisit()` method checks whether the implementation can handle the requested Sort Clause.
The `visit()` method contains the logic that translates Sort Clause information into data that is understandable by Solr.
The `visit()` method takes the Sort Clause itself as an argument.

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
    App\Query\SortClause\Score:
        tags:
            - { name: ezpublish.search.solr.query.content.sort_clause_visitor }
            - { name: ezpublish.search.solr.query.location.sort_clause_visitor }
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

- `eZ\Publish\API\Repository\Values\Content\Query\Aggregation\FieldAggregation`, based on content Field
- `eZ\Publish\API\Repository\Values\Content\Query\Aggregation\LocationAggregation`, based on content Location
- `eZ\Publish\API\Repository\Values\Content\Query\Aggregation\RawAggregation`, based on details of the index structure

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
services:
    App\Query\Aggregation\Solr\PriorityAggregationVisitor:
        class: EzSystems\EzPlatformSolrSearchEngine\Query\Common\AggregationVisitor\RangeAggregationVisitor
        factory: ['@EzSystems\EzPlatformSolrSearchEngine\Query\Common\AggregationVisitor\Factory\ContentFieldAggregationVisitorFactory', 'createRangeAggregationVisitor']
        arguments:
            $aggregationClass: 'App\Query\Aggregation\PriorityRangeAggregation'
            $searchIndexFieldName: 'priority_i'
        tags:
            - { name: ezplatform.search.solr.query.content.aggregation_visitor }
            - { name: ezplatform.search.solr.query.location.aggregation_visitor }
```

The visitor is created by `SearchFieldAggregationVisitorFactory`.
You provide it with two arguments:

- The aggregation class in `aggregationClass`
- The field name in search index in `searchIndexFieldName`

Tag the service with `ezplatform.search.solr.query.location.aggregation_visitor`.

For the result extractor, you can use the built-in `RangeAggregationResultExtractor`
and provide it with the aggregation class in the `aggregationClass` parameter.

Tag the service with `ezplatform.search.solr.query.location.aggregation_result_extractor`.

``` yaml
services:
    App\Query\Aggregation\Solr\PriorityAggregationResultExtractor:
        class: EzSystems\EzPlatformSolrSearchEngine\ResultExtractor\AggregationResultExtractor\RangeAggregationResultExtractor
        arguments:
            $aggregationClass: 'App\Query\Aggregation\PriorityRangeAggregation'
        tags:
            - { name: ezplatform.search.solr.query.location.aggregation_result_extractor } 
```

You can use a different type of aggregation, followed by respective visitor and extractor classes:

- `EzSystems\EzPlatformSolrSearchEngine\Query\Common\AggregationVisitor\StatsAggregationVisitor`
- `EzSystems\EzPlatformSolrSearchEngine\Query\Common\AggregationVisitor\TermAggregationVisitor`
- `EzSystems\EzPlatformSolrSearchEngine\ResultExtractor\AggregationResultExtractor\StatsAggregationResultExtractor`
- `EzSystems\EzPlatformSolrSearchEngine\ResultExtractor\AggregationResultExtractor\TermAggregationResultExtractor`

In a more complex use case, you must create your own visitor and extractor.

### Custom aggregation visitor

The aggregation visitor must implement `EzSystems\EzPlatformSolrSearchEngine\Query\AggregationVisitor`:

``` php
<?php

declare(strict_types=1);

namespace App\Query\Aggregation;
use eZ\Publish\API\Repository\Values\Content\Query\Aggregation;
use EzSystems\EzPlatformSolrSearchEngine\Query\AggregationVisitor;

final class PriorityRangeAggregationVisitor implements AggregationVisitor
{
    public function canVisit(Aggregation $aggregation, array $languageFilter): bool
    {
        return $aggregation instanceof PriorityRangeAggregation;
    }
    /**
     * @param \eZ\Publish\API\Repository\Values\Content\Query\Aggregation\AbstractRangeAggregation $aggregation
     */
    public function visit(
        AggregationVisitor $dispatcherVisitor,
        Aggregation $aggregation,
        array $languageFilter
    ): array {
        $rangeFacets = [];
        foreach ($aggregation->getRanges() as $range) {
            $from = $this->formatRangeValue($range->getFrom());
            $to = $this->formatRangeValue($range->getTo());
            $rangeFacets["${from}_${to}"] = [
                'type' => 'query',
                'q' => sprintf('priority_i:[%s TO %s}', $from, $to),
            ];
        }
        return [
            'type' => 'query',
            'q' => '*:*',
            'facet' => $rangeFacets,
        ];
    }
    private function formatRangeValue($value): string
    {
        if ($value === null) {
            return '*';
        }
        return (string)$value;
    }
}
```

The `canVisit()` method checks whether the provided aggregation is of the supported type
(in this case, your custom `PriorityRangeAggregation`).

The `visit()` method returns an array of results.

### Custom result extractor

You must also create a result extractor, which implements  `EzSystems\EzPlatformSolrSearchEngine\ResultExtractor\AggregationResultExtractor` 
that transforms raw aggregation results from Solr into `AggregationResult` objects:

``` php
<?php

declare(strict_types=1);

namespace App\Query\Aggregation;

use eZ\Publish\API\Repository\Values\Content\Query\Aggregation;
use eZ\Publish\API\Repository\Values\Content\Query\Aggregation\Range;
use eZ\Publish\API\Repository\Values\Content\Search\AggregationResult;
use eZ\Publish\API\Repository\Values\Content\Search\AggregationResult\RangeAggregationResult;
use eZ\Publish\API\Repository\Values\Content\Search\AggregationResult\RangeAggregationResultEntry;
use EzSystems\EzPlatformSolrSearchEngine\ResultExtractor\AggregationResultExtractor;
use stdClass;

final class PriorityAggregationResultExtractor implements AggregationResultExtractor
{
    public function canVisit(Aggregation $aggregation, array $languageFilter): bool
    {
        return $aggregation instanceof PriorityRangeAggregation;
    }
    public function extract(Aggregation $aggregation, array $languageFilter, stdClass $data): AggregationResult
    {
        $entries = [];
        foreach ($data as $key => $bucket) {
            if ($key === 'count') {
                continue;
            }
            if (strpos($key, '_') === false) {
                continue;
            }
            list($from, $to) = explode('_', $key, 2);
            $entries[] = new RangeAggregationResultEntry(
                new Range(
                    $from !== '*' ? $from : null,
                    $to !== '*' ? $to : null
                ),
                $bucket->count
            );
        }
        return new RangeAggregationResult($aggregation->getName(), $entries);
    }
}
```

The `canVisit()` method checks whether the provided aggregation is of the supported type
(in this case, your custom `PriorityRangeAggregation`).

The `extract()` method converts the [raw data provided by the search engine](https://solr.apache.org/guide/8_8/search-sample.html#aggregation) to a `RangeAggregationResult` object.

Finally, register both the aggregation visitor and the result extractor as services.

Tag the aggregation visitor with `ezplatform.search.solr.query.location.aggregation_visitor`
and the result extractor with `ezplatform.search.solr.query.location.aggregation_result_extractor`:

``` yaml
services:
    App\Query\Aggregation\PriorityAggregationVisitor:
        tags:
            - { name: 'ezplatform.search.solr.query.location.aggregation_visitor' }
    App\Query\Aggregation\PriorityAggregationResultExtractor:
        tags:
            - { name: 'ezplatform.search.solr.query.location.aggregation_result_extractor' }
```

For content-based aggregations, use the `ezplatform.search.solr.query.content.aggregation_visitor` and `ezplatform.search.solr.query.content.aggregation_result_extractor` tags respectively.
