<?php

namespace App\QueryType;

use Ibexa\Core\QueryType\QueryType;
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

class MenuQueryType implements QueryType
{
    public function getQuery(array $parameters = [])
    {
        $criteria = new Query\Criterion\LogicalAnd([
            new Query\Criterion\Visibility(Query\Criterion\Visibility::VISIBLE),
            new Query\Criterion\ParentLocationId(2),
        ]);
        $options = [
            'filter' => $criteria,
            'sortClauses' => [
                new SortClause\Location\Priority(LocationQuery::SORT_ASC),
            ],
        ];
        return new LocationQuery($options);
    }
    public static function getName()
    {
        return 'Menu';
    }
    public function getSupportedParameters()
    {
        return [];
    }
}
