<?php declare(strict_types=1);

namespace App\QueryType;

use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\Core\QueryType\OptionsResolverBasedQueryType;
use eZ\Publish\Core\QueryType\QueryType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OptionsBasedLatestContentQueryType extends OptionsResolverBasedQueryType implements QueryType
{
    public static function getName()
    {
        return 'OptionsLatestContent';
    }

    protected function doGetQuery(array $parameters)
    {
        $criteria[] = new Query\Criterion\Visibility(Query\Criterion\Visibility::VISIBLE);
        if (isset($parameters['contentType'])) {
            $criteria[] = new Query\Criterion\ContentTypeIdentifier($parameters['contentType']);
        }

        return new LocationQuery([
            'filter' => new Query\Criterion\LogicalAnd($criteria),
            'sortClauses' => [
                new Query\SortClause\DatePublished(Query::SORT_DESC),
            ],
            'limit' => isset($parameters['limit']) ? $parameters['limit'] : 10,
        ]);
    }

    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(['contentType', 'limit']);
        $resolver->setAllowedTypes('contentType', 'array');
        $resolver->setAllowedTypes('limit', 'int');
        $resolver->setDefault('limit', 10);
    }
}
