# Create custom Aggregation

Create custom Aggregation to use with Solr and Elasticsearch search engines.

## Create aggregation class

To create a custom Aggregation, create an aggregation class. In the following example, an aggregation groups the location query results by the location priority:

```php
<?php

declare(strict_types=1);

namespace App\Query\Aggregation;

use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\AbstractRangeAggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\LocationAggregation;

/**
 * @phpstan-template TValue
 *
 * @phpstan-extends \Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\AbstractRangeAggregation<TValue>
 */
final class PriorityRangeAggregation extends AbstractRangeAggregation implements LocationAggregation
{
}
```

The `PriorityRangeAggregation` class extends `AbstractRangeAggregation`. The name of the class indicates that it aggregates the results by using the Range aggregation.

An aggregation must implement the [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Aggregation.php) interface or inherit one of following abstract classes:

- [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\AbstractRangeAggregation`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Aggregation/AbstractRangeAggregation.php)
- [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\AbstractStatsAggregation`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Aggregation/AbstractStatsAggregation.php)
- [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\AbstractTermAggregation`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Aggregation/AbstractTermAggregation.php)

An aggregation can also implement one of the following interfaces:

- [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\FieldAggregation`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Aggregation/FieldAggregation.php), based on content field
- [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\LocationAggregation`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Aggregation/LocationAggregation.php), based on content location
- [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\RawAggregation`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Aggregation/RawAggregation.php), based on details of the index structure

> **Note: Aggregation definition**
>
> An aggregation definition must contain at least the name of an aggregation and optional aggregation parameters, such as, for example, the path (string) that is used to limit aggregation results to a specific subtree, content type identifier, or field definition identifier, which is mapped to the search index field name.
>
> Aggregation definition must be independent of the search engine used.

A custom aggregation requires that the following elements are provided:

- An aggregation visitor that returns an array of results
- A result extractor that transforms raw aggregation results from the search engine into `AggregationResult` objects

In simpler cases, you can apply one of the built-in visitors that correspond to the aggregation type. The example below uses `RangeAggregationVisitor`:

**Solr**

```yaml
services:
    app.search.solr.query.aggregation_visitor.priority_range_aggregation:
    class: Ibexa\Solr\Query\Common\AggregationVisitor\RangeAggregationVisitor
    factory: [ '@Ibexa\Solr\Query\Common\AggregationVisitor\Factory\SearchFieldAggregationVisitorFactory', 'createRangeAggregationVisitor' ]
    arguments:
        $aggregationClass: 'App\Query\Aggregation\Solr\PriorityRangeAggregation'
        $searchIndexFieldName: 'priority_i'
    tags:
        - { name: ibexa.search.solr.query.location.aggregation.visitor }
```

**Elasticsearch**

```yaml
services:
    app.search.elasticsearch.query.aggregation_visitor.priority_range_aggregation:
    class: Ibexa\Elasticsearch\Query\AggregationVisitor\RangeAggregationVisitor
    factory: [ '@Ibexa\Elasticsearch\Query\AggregationVisitor\Factory\SearchFieldAggregationVisitorFactory', 'createRangeAggregationVisitor' ]
    arguments:
        $aggregationClass: 'App\Query\Aggregation\Elasticsearch\PriorityRangeAggregation'
        $searchIndexFieldName: 'priority_i'
    tags:
        - { name: ibexa.search.elasticsearch.query.location.aggregation.visitor }
```

The visitor is created by `SearchFieldAggregationVisitorFactory`. You provide it with two arguments:

- The aggregation class in `aggregationClass`
- The field name in search index in `searchIndexFieldName`

In this example, the field is `priority_i` which exists only for locations.

**Solr**

Tag the service with `ibexa.search.solr.query.location.aggregation.visitor`.

For content-based aggregations, use the `ibexa.search.solr.query.content.aggregation.visitor` tag.

**Elasticsearch**

Tag the service with `ibexa.search.elasticsearch.query.location.aggregation_visitor`.

For content-based aggregations, use the `ibexa.search.elasticsearch.query.content.aggregation.visitor` tag.

For the result extractor, you can use the built-in `RangeAggregationResultExtractor` and provide it with the aggregation class in the `aggregationClass` parameter.

**Solr**

Tag the service with `ibexa.search.solr.query.location.aggregation.result.extractor`.

As `$keyMapper` to transform raw keys into more usable objects or scalar values, use `IntRangeAggregationKeyMapper` or create your own implementing [`Ibexa\Contracts\Solr\ResultExtractor\AggregationResultExtractor\RangeAggregationKeyMapper`](../../../../../../ibexa/solr/src/contracts/ResultExtractor/AggregationResultExtractor/RangeAggregationKeyMapper.php).

```yaml
services:
    app.search.solr.query.aggregation_result_extractor.priority_range_aggregation:
    class: Ibexa\Solr\ResultExtractor\AggregationResultExtractor\RangeAggregationResultExtractor
    arguments:
        $aggregationClass: 'App\Query\Aggregation\Solr\PriorityRangeAggregation'
        $keyMapper: 'Ibexa\Solr\ResultExtractor\AggregationResultExtractor\RangeAggregationKeyMapper\IntRangeAggregationKeyMapper'
    tags:
        - { name: ibexa.search.solr.query.location.aggregation.result.extractor }
```

For other cases, a [`Ibexa\Contracts\Solr\ResultExtractor\AggregationResultExtractor\TermAggregationKeyMapper`](../../../../../../ibexa/solr/src/contracts/ResultExtractor/AggregationResultExtractor/TermAggregationKeyMapper.php) interface is also available.

**Elasticsearch**

Tag the service with `ibexa.search.elasticsearch.query.location.aggregation.result.extractor`.

```yaml
services:
    app.search.elasticsearch.query.aggregation_result_extractor.priority_range_aggregation:
    class: Ibexa\Elasticsearch\Query\ResultExtractor\AggregationResultExtractor\RangeAggregationResultExtractor
    arguments:
        $aggregationClass: 'App\Query\Aggregation\Elasticsearch\PriorityRangeAggregation'
    tags:
        - { name: ibexa.search.elasticsearch.query.location.aggregation.result.extractor }
```

You can use a different type of aggregation, followed by respective visitor and extractor classes:

**Solr**

- Range
  - `Ibexa\Solr\Query\Common\AggregationVisitor\RangeAggregationVisitor`
  - `Ibexa\Solr\ResultExtractor\AggregationResultExtractor\RangeAggregationResultExtractor`
- Stats (count, minimum, maximum, average, sum)
  - `Ibexa\Solr\Query\Common\AggregationVisitor\StatsAggregationVisitor`
  - `Ibexa\Solr\ResultExtractor\AggregationResultExtractor\StatsAggregationResultExtractor`
- Term
  - `Ibexa\Solr\Query\Common\AggregationVisitor\TermAggregationVisitor`
  - `Ibexa\Solr\ResultExtractor\AggregationResultExtractor\TermAggregationResultExtractor`

**Elasticsearch**

- Range
  - `Ibexa\ElasticSearchEngine\Query\AggregationVisitor\RangeAggregationVisitor`
  - `Ibexa\ElasticSearchEngine\Query\ResultExtractor\AggregationResultExtractor\RangeAggregationResultExtractor`
- Stats (count, minimum, maximum, average, sum)
  - `Ibexa\ElasticSearchEngine\Query\AggregationVisitor\StatsAggregationVisitor`
  - `Ibexa\ElasticSearchEngine\Query\ResultExtractor\AggregationResultExtractor\StatsAggregationResultExtractor`
- Term
  - `Ibexa\ElasticSearchEngine\Query\AggregationVisitor\TermAggregationVisitor`
  - `Ibexa\ElasticSearchEngine\Query\ResultExtractor\AggregationResultExtractor\TermAggregationResultExtractor`

In a more complex use case, you must create your own visitor and extractor.

### Create aggregation visitor

**Solr**

The aggregation visitor must implement [`Ibexa\Contracts\Solr\Query\AggregationVisitor`](../../../../../../ibexa/solr/src/contracts/Query/AggregationVisitor.php):

```php
<?php

declare(strict_types=1);

namespace App\Query\Aggregation\Solr;

use App\Query\Aggregation\PriorityRangeAggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;
use Ibexa\Contracts\Solr\Query\AggregationVisitor;

/**
 * @phpstan-template TRangeAggregation of \Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\AbstractRangeAggregation
 */
final class PriorityRangeAggregationVisitor implements AggregationVisitor
{
    public function canVisit(Aggregation $aggregation, array $languageFilter): bool
    {
        return $aggregation instanceof PriorityRangeAggregation;
    }

    /**
     * @param \App\Query\Aggregation\PriorityRangeAggregation<TRangeAggregation> $aggregation
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
            $rangeFacets["{$from}_{$to}"] = [
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

**Elasticsearch**

The aggregation visitor must implement [`Ibexa\Contracts\ElasticSearchEngine\Query\AggregationVisitor`](../../../../../../ibexa/elasticsearch/src/contracts/Query/AggregationVisitor.php):

```php
<?php

declare(strict_types=1);

namespace App\Query\Aggregation\Elasticsearch;

use App\Query\Aggregation\PriorityRangeAggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;
use Ibexa\Contracts\Elasticsearch\Query\AggregationVisitor;
use Ibexa\Contracts\Elasticsearch\Query\LanguageFilter;

/**
 * @phpstan-template TRangeAggregation of \Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\AbstractRangeAggregation
 */
final class PriorityRangeAggregationVisitor implements AggregationVisitor
{
    public function supports(Aggregation $aggregation, LanguageFilter $languageFilter): bool
    {
        return $aggregation instanceof PriorityRangeAggregation;
    }

    /**
     * @param \App\Query\Aggregation\PriorityRangeAggregation<TRangeAggregation> $aggregation
     *
     * @return array<string, array<string, mixed>>
     */
    public function visit(AggregationVisitor $dispatcher, Aggregation $aggregation, LanguageFilter $languageFilter): array
    {
        $ranges = [];

        foreach ($aggregation->getRanges() as $range) {
            if ($range->getFrom() !== null && $range->getTo() !== null) {
                $ranges[] = [
                    'from' => $range->getFrom(),
                    'to' => $range->getTo(),
                ];
            } elseif ($range->getFrom() === null && $range->getTo() !== null) {
                $ranges[] = [
                    'to' => $range->getTo(),
                ];
            } elseif ($range->getFrom() !== null && $range->getTo() === null) {
                $ranges[] = [
                    'from' => $range->getFrom(),
                ];
            } else {
                // invalid range
            }
        }

        return [
            'range' => [
                'field' => 'priority_i',
                'ranges' => $ranges,
            ],
        ];
    }
}
```

The `canVisit()` method checks whether the provided aggregation is of the supported type (in this case, your custom `PriorityRangeAggregation`).

The `visit()` method returns an array of results.

Finally, register the aggregation visitor as a service.

**Solr**

Tag the aggregation visitor with `ibexa.search.solr.query.location.aggregation.visitor`:

```yaml
services:
    App\Query\Aggregation\Solr\PriorityRangeAggregationVisitor:
    tags:
        - { name: ibexa.search.solr.query.location.aggregation.visitor }
```

For content-based aggregations, use the `ibexa.search.solr.query.content.aggregation.visitor` tag.

**Elasticsearch**

Tag the aggregation visitor with `ibexa.elasticsearch.query.location.aggregation_visitor`:

```yaml
services:
    App\Query\Aggregation\Elasticsearch\PriorityRangeAggregationVisitor:
    tags:
        - { name: ibexa.search.elasticsearch.query.location.aggregation.visitor }
```

For content-based aggregations, use the `ibexa.search.elasticsearch.query.content.aggregation.visitor` tag.

### Create result extractor

**Solr**

You must also create a result extractor, which implements [`Ibexa\Contracts\Solr\ResultExtractor\AggregationResultExtractor`](../../../../../../ibexa/solr/src/contracts/ResultExtractor/AggregationResultExtractor.php) that transforms raw aggregation results from Solr into `AggregationResult` objects:

```php
<?php

declare(strict_types=1);

namespace App\Query\Aggregation\Solr;

use App\Query\Aggregation\PriorityRangeAggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Range;
use Ibexa\Contracts\Core\Repository\Values\Content\Search\AggregationResult;
use Ibexa\Contracts\Core\Repository\Values\Content\Search\AggregationResult\RangeAggregationResult;
use Ibexa\Contracts\Core\Repository\Values\Content\Search\AggregationResult\RangeAggregationResultEntry;
use Ibexa\Contracts\Solr\ResultExtractor\AggregationResultExtractor;
use stdClass;

final class PriorityRangeAggregationResultExtractor implements AggregationResultExtractor
{
    public function canVisit(Aggregation $aggregation, array $languageFilter): bool
    {
        return $aggregation instanceof PriorityRangeAggregation;
    }

    public function extract(Aggregation $aggregation, array $languageFilter, stdClass $data): AggregationResult
    {
        $entries = [];
        foreach ($data as $key => $bucket) {
            if ($key === 'count' || !str_contains($key, '_')) {
                continue;
            }
            [$from, $to] = explode('_', $key, 2);
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

The `canVisit()` method checks whether the provided aggregation is of the supported type (in this case, your custom `PriorityRangeAggregation`).

The `extract()` method converts the [raw data provided by the search engine](https://solr.apache.org/guide/solr/9_8/query-guide/search-sample.html#aggregation) to a `RangeAggregationResult` object.

**Elasticsearch**

You must also create a result extractor, which implements [`Ibexa\Contracts\ElasticSearchEngine\Query\AggregationResultExtractor`](../../../../../../ibexa/elasticsearch/src/contracts/Query/AggregationResultExtractor.php) that transforms raw aggregation results from Elasticsearch into `AggregationResult` objects:

```php
<?php

declare(strict_types=1);

namespace App\Query\Aggregation\Elasticsearch;

use App\Query\Aggregation\PriorityRangeAggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Search\AggregationResult;
use Ibexa\Contracts\Elasticsearch\Query\AggregationResultExtractor;
use Ibexa\Contracts\Elasticsearch\Query\LanguageFilter;

final class PriorityRangeAggregationResultExtractor implements AggregationResultExtractor
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

The `supports()` method checks whether the provided aggregation is of the supported type (in this case, your custom `PriorityRangeAggregation`).

The `extract()` method converts the [raw data provided by the search engine](https://www.elastic.co/docs/explore-analyze/query-filter/aggregations) to a `RangeAggregationResult` object.

Finally, register the result extractor as a service.

**Solr**

Tag the result extractor with `ibexa.search.solr.query.location.aggregation.result.extractor`:

```yaml
services:
    App\Query\Aggregation\Solr\PriorityRangeAggregationResultExtractor:
    tags:
        - { name: ibexa.search.solr.query.location.aggregation.result.extractor }
```

For content-based aggregations, use the `ibexa.search.solr.query.content.aggregation.result.extractor` tag.

**Elasticsearch**

Tag the result extractor with `ibexa.elasticsearch.query.location.aggregation_result_extractor`:

```yaml
services:
    App\Query\Aggregation\Elasticsearch\PriorityRangeAggregationResultExtractor:
    tags:
        - { name: ibexa.search.elasticsearch.query.location.aggregation.result.extractor }
```

For content-based aggregations, use the `ibexa.search.elasticsearch.query.content.aggregation.result.extractor` tag.
