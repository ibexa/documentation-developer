<?php

declare(strict_types=1);

namespace App\Query\Aggregation\Elasticsearch;

use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Search\AggregationResult;
use Ibexa\Contracts\Elasticsearch\Query\AggregationResultExtractor;
use Ibexa\Contracts\Elasticsearch\Query\LanguageFilter;

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
