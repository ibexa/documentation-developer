# Collaboration Search Sort Clauses reference

Sort Clauses available for Collaboration search

Sort Clauses are found in the [`Ibexa\Contracts\Collaboration\Value\Query\SortClause`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-collaboration-invitation-query-sortclause.html) namespace. Use them to work with objects related to [Collaborative editing API](../../../content_management/collaborative_editing/collaborative_editing_api/index.md).

## Invitation Search Sort Clauses

Invitation Search Sort Clauses are implementing the [`Ibexa\Contracts\Collaboration\Invitation\Query\SortClauseInterface`](../../../../../../ibexa/collaboration/src/contracts/Invitation/Query/SortClauseInterface.php) interface:

| Name                                                                                                                                                    | Description                                           |
| ------------------------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------- |
| [`Ibexa\Contracts\Collaboration\Invitation\Query\SortClause\CreatedAt`](../../../../../../ibexa/collaboration/src/contracts/Invitation/Query/SortClause/CreatedAt.php) | Sort by invitation's creation date                    |
| [`Ibexa\Contracts\Collaboration\Invitation\Query\SortClause\Id`](../../../../../../ibexa/collaboration/src/contracts/Invitation/Query/SortClause/Id.php)               | Sort by invitation's ID                               |
| [`Ibexa\Contracts\Collaboration\Invitation\Query\SortClause\Status`](../../../../../../ibexa/collaboration/src/contracts/Invitation/Query/SortClause/Status.php)       | Sort by invitation's status                           |
| [`Ibexa\Contracts\Collaboration\Invitation\Query\SortClause\UpdatedAt`](../../../../../../ibexa/collaboration/src/contracts/Invitation/Query/SortClause/UpdatedAt.php) | Sort by the date and time when invitation was updated |

## Session Search Sort Clauses

Session Search Sort Clauses are implementing the [`Ibexa\Contracts\Collaboration\Session\Query\SortClauseInterface`](../../../../../../ibexa/collaboration/src/contracts/Session/Query/SortClauseInterface.php) interface:

| Name                                                                                                                                                 | Description                                        |
| ---------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------- |
| [`Ibexa\Contracts\Collaboration\Session\Query\SortClause\CreatedAt`](../../../../../../ibexa/collaboration/src/contracts/Session/Query/SortClause/CreatedAt.php) | Sort by session's creation date                    |
| [`Ibexa\Contracts\Collaboration\Session\Query\SortClause\Id`](../../../../../../ibexa/collaboration/src/contracts/Session/Query/SortClause/Id.php)               | Sort by session's ID                               |
| [`Ibexa\Contracts\Collaboration\Session\Query\SortClause\UpdatedAt`](../../../../../../ibexa/collaboration/src/contracts/Session/Query/SortClause/UpdatedAt.php) | Sort by the date and time when session was updated |

### Example

The following example shows how to use them to sort the searched sessions:

```php
<?php declare(strict_types=1);

use Ibexa\Contracts\Collaboration\Session\Query\Criterion;
use Ibexa\Contracts\Collaboration\Session\Query\SortClause;
use Ibexa\Contracts\Collaboration\Session\SessionQuery;
use Ibexa\Contracts\CoreSearch\Values\Query\Criterion\FieldValueCriterion;
use Ibexa\Contracts\CoreSearch\Values\Query\SortClause\FieldValueSortClause;

$lastWeek = new DateTimeImmutable('-7 days');
$query = new SessionQuery(
    new Criterion\LogicalAnd(
        new Criterion\IsActive(true),
        new Criterion\Type('content'),
        new Criterion\CreatedAt($lastWeek, FieldValueCriterion::COMPARISON_GTE),
    ),
    [
        new SortClause\CreatedAt(FieldValueSortClause::SORT_DESC),
    ]
);
/** @var \Ibexa\Contracts\Collaboration\SessionServiceInterface $sessionService */
$sessionList = $sessionService->findSessions($query);
```

The returned active sessions are sorted by creation date (descending).
