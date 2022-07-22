<?php

declare(strict_types=1);

namespace App\Query\SortClause\Elasticsearch;

use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;
use Ibexa\Contracts\Elasticsearch\Query\LanguageFilter;
use Ibexa\Contracts\Elasticsearch\Query\SortClauseVisitor;

final class ScoreVisitor implements SortClauseVisitor
{
    public function supports(SortClause $sortClause, LanguageFilter $languageFilter): bool
    {
        return $sortClause instanceof ScoreSortClause;
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
