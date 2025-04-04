<?php

declare(strict_types=1);

namespace App\Query\Aggregation\Elasticsearch;

use App\Query\Aggregation\PriorityRangeAggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;
use Ibexa\Contracts\Elasticsearch\Query\AggregationVisitor;
use Ibexa\Contracts\Elasticsearch\Query\LanguageFilter;

final class PriorityRangeAggregationVisitor implements AggregationVisitor
{
    public function supports(Aggregation $aggregation, LanguageFilter $languageFilter): bool
    {
        return $aggregation instanceof PriorityRangeAggregation;
    }

    /**
     * @param \App\Query\Aggregation\PriorityRangeAggregation $aggregation
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
