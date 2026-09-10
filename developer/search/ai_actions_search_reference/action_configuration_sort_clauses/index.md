# Action Configuration Search Sort Clauses reference

Sort Clauses available for Action Configuration search

Sort Clauses are found in the `Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\SortClause` namespace, implementing the [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\SortClauseInterface`](../../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Query/SortClauseInterface.php) interface:

- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\SortClause\Enabled`](../../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Query/SortClause/Enabled.php)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\SortClause\Id`](../../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Query/SortClause/Id.php)
- [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\SortClause\Identifier`](../../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Query/SortClause/Identifier.php)

The following example shows how to use them to sort the searched Action Configurations:

```php
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
```

The search results are sorted by:

- status, with enabled on top
- identifier, in ascending order.
