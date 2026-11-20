# Action Configuration Search Criterion reference

Search Criteria available for Action Configuration search

Search criteria are found in the `Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion` namespace, implementing the [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\CriterionInterface`](../../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Query/CriterionInterface.php) interface:

| Criterion                                                                                                                                                       | Description                                                                                                                                                                                                                                                                                                                                                                      |
| --------------------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\Name`](../../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Query/Criterion/Name.php)             | Find Action Configurations matching given name. Use [FieldValueCriterion's constants](../../../../../../ibexa/core-search/src/contracts/Values/Query/Criterion/FieldValueCriterion.php) like `FieldValueCriterion::COMPARISON_CONTAINS` or `FieldValueCriterion::COMPARISON_STARTS_WITH` to specify the matching condition |
| [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\Enabled`](../../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Query/Criterion/Enabled.php)       | Find enabled or disabled Action Configurations                                                                                                                                                                                                                                                                                                                                   |
| [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\Identifier`](../../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Query/Criterion/Identifier.php) | Find Action Configuration having the exact given identifier                                                                                                                                                                                                                                                                                                                      |
| [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\LogicalAnd`](../../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Query/Criterion/LogicalAnd.php) | Composite criterion to group multiple criteria using the AND condition                                                                                                                                                                                                                                                                                                           |
| [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\LogicalOr`](../../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Query/Criterion/LogicalOr.php)   | Composite criterion to group multiple criteria using the OR condition                                                                                                                                                                                                                                                                                                            |
| [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\Query\Criterion\Type`](../../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/Query/Criterion/Type.php)             | Find Action Configuration having the exact given type                                                                                                                                                                                                                                                                                                                            |

The following example shows how to use them to find specific Action Configurations:

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

The result set contains Action Configurations that are:

- enabled, and
- with an identifier equal to `casual` or with a name starting with `Casual`.
