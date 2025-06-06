<?php

declare(strict_types=1);

use Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationQuery;
use Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion;
use Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\SortClause;
use Ibexa\Contracts\CoreSearch\Values\Query\AbstractSortClause;
use Ibexa\Contracts\CoreSearch\Values\Query\Criterion\FieldValueCriterion;

$query = new ActionConfigurationQuery(
    new Criterion\LogicalAnd(
        new Criterion\Enabled(),
        new Criterion\LogicalOr(
            new Criterion\Name('Casual', FieldValueCriterion::COMPARISON_STARTS_WITH),
            new Criterion\Identifier('casual')
        )
    ),
    [
        new SortClause\Enabled(AbstractSortClause::SORT_DESC),
        new SortClause\Identifier(AbstractSortClause::SORT_ASC),
    ]
);
/** @var \Ibexa\Contracts\ConnectorAi\ActionConfigurationServiceInterface $actionConfigurationService */
$results = $actionConfigurationService->findActionConfigurations($query);
