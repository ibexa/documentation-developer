<?php

namespace App\QueryType;

use eZ\Publish\Core\QueryType\QueryType;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;

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
