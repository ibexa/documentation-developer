<?php

declare(strict_types=1);

namespace App\Query\Aggregation\Elasticsearch;

use eZ\Publish\API\Repository\Values\Content\Query\Aggregation;
use eZ\Publish\API\Repository\Values\Content\Search\AggregationResult;
use Ibexa\Platform\Contracts\ElasticSearchEngine\Query\AggregationResultExtractor;
use Ibexa\Platform\Contracts\ElasticSearchEngine\Query\LanguageFilter;

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
