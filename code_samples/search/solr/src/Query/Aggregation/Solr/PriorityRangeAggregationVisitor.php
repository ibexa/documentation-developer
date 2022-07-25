<?php

declare(strict_types=1);

namespace App\Query\Aggregation\Solr;

use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;
use Ibexa\Contracts\Solr\Query\AggregationVisitor;

final class PriorityRangeAggregationVisitor implements AggregationVisitor
{
    public function canVisit(Aggregation $aggregation, array $languageFilter): bool
    {
        return $aggregation instanceof PriorityRangeAggregation;
    }

    /**
     * @param \Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\AbstractRangeAggregation $aggregation
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
