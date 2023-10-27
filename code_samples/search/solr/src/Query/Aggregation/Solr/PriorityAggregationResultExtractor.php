<?php

declare(strict_types=1);

namespace App\Query\Aggregation\Solr;

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
            if ($key === 'count' || strpos($key, '_') === false) {
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
