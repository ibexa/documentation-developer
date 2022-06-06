# Elasticsearch extensibility

## Index custom data

[Elasticsearch](elastic.md) indexes content and Location data out of the box.
Besides what is indexed automatically, you can add additional data to the Elasticsearch index.

To do so, subscribe to one of the following events:

- `Ibexa\Contracts\ElasticSearchEngine\Mapping\Event\ContentIndexCreateEvent`
- `Ibexa\Contracts\ElasticSearchEngine\Mapping\Event\LocationIndexCreateEvent`

These events are called when the index is created for the content and Location documents, respectively.

You can pass the event to a subscriber which gives you access to the document that you can modify.

In the following example, when an index in created for a content or a Location document,
the event subscriber adds a `custom_field` of the type `StringField` to the index:

``` php hl_lines="19 20 21"
<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\Contracts\Core\Search\Field;
use Ibexa\Contracts\Core\Search\FieldType\StringField;
use Ibexa\Contracts\Elasticsearch\Mapping\Event\ContentIndexCreateEvent;
use Ibexa\Contracts\Elasticsearch\Mapping\Event\LocationIndexCreateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class CustomIndexDataSubscriber implements EventSubscriberInterface
{
    public function onContentDocumentCreate(ContentIndexCreateEvent $event): void
    {
        $document = $event->getDocument();
        $document->fields[] = new Field(
            'custom_field',
            'Custom field value',
            new StringField()
        );
    }

    public function onLocationDocumentCreate(LocationIndexCreateEvent $event): void
    {
        $document = $event->getDocument();
        $document->fields[] = new Field(
            'custom_field',
            'Custom field value',
            new StringField()
        );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ContentIndexCreateEvent::class => 'onContentDocumentCreate',
            LocationIndexCreateEvent::class => 'onLocationDocumentCreate'
        ];
    }
}
```

Remember to register the subscriber as a service:

``` yaml
services:
    App\EventSubscriber\CustomIndexDataSubscriber:
        tags:
            - { name: kernel.event_subscriber }
```

## Manipulate the query

You can customize the search query before it is executed.
To do it, subscribe to `Ibexa\Contracts\ElasticSearchEngine\Query\Event\QueryFilterEvent`.

The following example shows how to add an additional Search Criterion to all queries.

Depending on your configuration, this might impact all search queries,
including those used for search and content tree in the Back Office.

``` php hl_lines="35"
<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\LogicalAnd;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\ObjectStateIdentifier;
use Ibexa\Contracts\ElasticSearch\Query\Event\QueryFilterEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class CustomQueryFilterSubscriber implements EventSubscriberInterface
{
    public function onQueryFilter(QueryFilterEvent $event): void
    {
        $query = $event->getQuery();

        $additionalCriteria = new ObjectStateIdentifier('locked');

        if ($query->filter !== null) {
            $query->filter = $additionalCriteria;
        } else {
            // Append Criterion to existing filter
            $query->filter = new LogicalAnd([
                $query->filter,
                $additionalCriteria
            ]);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            QueryFilterEvent::class => 'onQueryFilter'
        ];
    }
}
```

Remember to register the subscriber as a service:

``` yaml
services:
    App\EventSubscriber\CustomQueryFilterSubscriber:
        tags:
            - { name: kernel.event_subscriber }
```

## Create custom Search Criterion

To provide support for a custom Search Criterion, you need to implement `CriterionVisitor`:

``` php hl_lines="8"
<?php

declare(strict_types=1);

namespace App\Query\Criterion;

use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\ElasticSearch\Query\CriterionVisitor;
use Ibexa\Contracts\ElasticSearch\Query\LanguageFilter;

final class CameraManufacturerVisitor implements CriterionVisitor
{
    public function supports(Criterion $criterion, LanguageFilter $languageFilter): bool
    {
        return $criterion instanceof CameraManufacturerCriterion;
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

Next, add the Search Criterion class itself in `src/Query/Criterion/CameraManufacturerCriterion.php`:

``` php
<?php

declare(strict_types=1);

namespace App\Query\Criterion;

use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Operator;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Operator\Specifications;

final class CameraManufacturerCriterion extends Criterion
{
    /**
     * @param string|string[] $value One or more manufacturer names that must be matched.
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

Search Criteria can be valid for both content and Location search.
To choose the search type, use either `content` or `location` in the tag when registering the visitor as a service:

``` yaml
services:
    App\Query\Criterion\CameraManufacturerVisitor:
        tags:
            - { name: ibexa.elasticsearch.query.content.criterion_visitor }
            - { name: ibexa.elasticsearch.query.location.criterion_visitor }
```

## Create custom Sort Clause

To create a custom Sort Clause for use with Elasticsearch,
implement `SortClauseVisitor`
in `src/Query/SortClause/ScoreVisitor.php`:

``` php hl_lines="10"
<?php

declare(strict_types=1);

namespace App\Query\SortClause;

use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;
use Ibexa\Contracts\ElasticSearch\Query\LanguageFilter;
use Ibexa\Contracts\ElasticSearch\Query\SortClauseVisitor;

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

The `supports()` method checks if the implementation can handle the given Sort Clause.
The `visit()` method contains the logic that translates Sort Clause information into data understandable by Elasticsearch.
The `visit()` method takes the Sort Clause visitor, the Sort Clause itself and the language filter as arguments.

Next, add the Sort Clause class itself in `src/Query/SortClause/ScoreSortClause.php`:

``` php
<?php

declare(strict_types=1);

namespace App\Query\SortClause;

use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

final class Score extends SortClause
{
    public function __construct(string $sortDirection = Query::SORT_ASC)
    {
        parent::__construct('_score', $sortDirection);
    }
}
```

Sort Clauses can be valid for both content and Location search.
To choose the search type, use either `content` or `location` in the tag when registering the visitor as a service:

``` yaml
services:
    App\Query\SortClause\ScoreVisitor:
        tags:
            - { name: ibexa.elasticsearch.query.content.sort_clause_visitor }
            - { name: ibexa.elasticsearch.query.location.sort_clause_visitor }
```

## Create custom Aggregation

To create a custom aggregation for use with Elasticsearch, create an aggregation class.
In the following example, an aggregation groups Location query results according to the Location priority:

``` php
<?php

declare(strict_types=1);

namespace App\Query\Aggregation;

use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\AbstractRangeAggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\LocationAggregation;

final class PriorityRangeAggregation extends AbstractRangeAggregation implements LocationAggregation
{

}
```

`PriorityRangeAggregation` in the example above extends `AbstractRangeAggregation`.
The name indicates that it is going to aggregate the results according to the Location priority, using Range aggregation.

An aggregation must implement the `Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation` interface or inherit one of following abstract classes:

- `Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\AbstractRangeAggregation`
- `Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\AbstractStatsAggregation`
- `Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\AbstractTermAggregation`

An aggregation can also implement one of the following interfaces:

- `Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\FieldAggregation`, based on a content Field
- `Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\LocationAggregation`, based on content Location
- `Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\RawAggregation`, based on details of the index structure

!!! note "Aggregation definition"

    Aggregation definition must contain at least aggregation name and optional aggregation parameters.
    e.g. path string used to limit aggregation results to specific subtree or Content Type identifier / Field definition identifier
    which will be mapped to search index field name.
    
    Aggregation definition should be independent of the search engine used.

A custom aggregation requires:

- an aggregation visitor which returns an array of results
- a result extractor which transforms raw aggregation results from Elasticsearch into `AggregationResult` objects.

For simpler cases, you can use one of the built-in visitors corresponding to the aggregation type.
In the example below it is `RangeAggregationVisitor`:

``` yaml
services:
    app.search.elasticsearch.query.aggregation_visitor.priority_range_aggregation:
        class: Ibexa\ElasticSearchEngine\Query\AggregationVisitor\RangeAggregationVisitor
        factory: ['@Ibexa\ElasticSearchEngine\Query\AggregationVisitor\Factory\SearchFieldAggregationVisitorFactory', 'createRangeAggregationVisitor']
        arguments:
            $aggregationClass: 'App\Query\Aggregation\PriorityRangeAggregation'
            $searchIndexFieldName: 'priority_i'
        tags:
            - { name: ibexa.elasticsearch.query.location.aggregation_visitor }
```

The visitor is created by `SearchFieldAggregationVisitorFactory`.
You provide it with two arguments:

- the aggregation class in `aggregationClass`
- the field name in search index in `searchIndexFieldName`

Tag the service with `ibexa.elasticsearch.query.location.aggregation_visitor`.

For the result extractor, you can use the built-in `RangeAggregationResultExtractor`
and provide it with the aggregation class in the `aggregationClass` parameter.

Tag the service with `ibexa.elasticsearch.query.location.aggregation_result_extractor`.

``` yaml
services:
    app.search.elasticsearch.query.aggregation_result_extractor.priority_range_aggregation:
        class: Ibexa\ElasticSearchEngine\Query\ResultExtractor\AggregationResultExtractor\RangeAggregationResultExtractor
        arguments:
            $aggregationClass: 'App\Query\Aggregation\PriorityRangeAggregation'
        tags:
            - { name: ibexa.elasticsearch.query.location.aggregation_result_extractor }
```

If you are using a different type of aggregation than range, you can also use respective visitor and extractor classes:

- `Ibexa\ElasticSearchEngine\Query\AggregationVisitor\RangeAggregationVisitor`
- `Ibexa\ElasticSearchEngine\Query\AggregationVisitor\StatsAggregationVisitor`
- `Ibexa\ElasticSearchEngine\Query\AggregationVisitor\TermAggregationVisitor`

- `Ibexa\ElasticSearchEngine\Query\ResultExtractor\AggregationResultExtractor\RangeAggregationResultExtractor`
- `Ibexa\ElasticSearchEngine\Query\ResultExtractor\AggregationResultExtractor\StatsAggregationResultExtractor`
- `Ibexa\ElasticSearchEngine\Query\ResultExtractor\AggregationResultExtractor\TermAggregationResultExtractor`

If you have a more complex use case, you need to create your own visitor and extractor.

### Create aggregation visitor

The aggregation visitor must implement `Ibexa\Contracts\ElasticSearchEngine\Query\AggregationVisitor`:

``` php
<?php

declare(strict_types=1);

namespace App\Query\Aggregation\Elasticsearch;

use App\Query\Aggregation\PriorityRangeAggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;
use Ibexa\Contracts\ElasticSearch\Query\AggregationVisitor;
use Ibexa\Contracts\ElasticSearch\Query\LanguageFilter;

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

### Create result extractor

You also need to create a result extractor, implementing `Ibexa\Contracts\ElasticSearchEngine\Query\AggregationResultExtractor`,
that transforms raw aggregation results from Elasticsearch into `AggregationResult` objects:

``` php
<?php

declare(strict_types=1);

namespace App\Query\Aggregation\Elasticsearch;

use App\Query\Aggregation\PriorityRangeAggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Search\AggregationResult;
use Ibexa\Contracts\ElasticSearch\Query\AggregationResultExtractor;
use Ibexa\Contracts\ElasticSearch\Query\LanguageFilter;
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

Tag the aggregation visitor with `ibexa.elasticsearch.query.location.aggregation_visitor`
and the result extractor with `ibexa.elasticsearch.query.location.aggregation_result_extractor`:

``` yaml
services:
    App\Query\Aggregation\Elasticsearch\PriorityAggregationVisitor:
        tags:
            - { name: ' ibexa.elasticsearch.query.location.aggregation_visitor' }
    App\Query\Aggregation\Elasticsearch\PriorityAggregationResultExtractor:
        tags:
            - { name: ' ibexa.elasticsearch.query.location.aggregation_result_extractor' }
```

For content-based aggregations, use the `ibexa.elasticsearch.query.content.aggregation_visitor.` and `ibexa.elasticsearch.query.content.aggregation_result_extractor` tags respectively.
