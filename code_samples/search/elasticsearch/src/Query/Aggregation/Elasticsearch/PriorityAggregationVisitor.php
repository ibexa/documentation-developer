<?php

declare(strict_types=1);

namespace App\Query\Aggregation\Elasticsearch;

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
     * @param PriorityRangeAggregation $aggregation
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
