<?php

declare(strict_types=1);

namespace App\Query\SortClause\Solr;

use App\Query\SortClause\ScoreSortClause;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;
use Ibexa\Contracts\Solr\Query\SortClauseVisitor;

class ScoreVisitor extends SortClauseVisitor
{
    public function canVisit(SortClause $sortClause): bool
    {
        return $sortClause instanceof ScoreSortClause;
    }

    public function visit(SortClause $sortClause): string
    {
        return 'score ' . $this->getDirection($sortClause);
    }
}
