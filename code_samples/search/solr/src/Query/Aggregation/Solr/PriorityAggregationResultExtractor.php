<?php

declare(strict_types=1);

namespace App\Query\Aggregation\Solr;

use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Range;
use Ibexa\Contracts\Core\Repository\Values\Content\Search\AggregationResult;
use Ibexa\Contracts\Core\Repository\Values\Content\Search\AggregationResult\RangeAggregationResult;
use Ibexa\Contracts\Core\Repository\Values\Content\Search\AggregationResult\RangeAggregationResultEntry;
use Ibexa\Contracts\Solr\ResultExtractor\AggregationResultExtractor;
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
