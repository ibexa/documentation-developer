# Collaboration Search Criterion reference

Search Criteria available for Collaboration search

Search Criteria are found in the `Ibexa\Contracts\Collaboration\Invitation\Query\Criterion` namespace. Use them to work with objects related to [Collaborative editing API](../../../content_management/collaborative_editing/collaborative_editing_api/index.md).

## Invitation Search Criteria

Invitation Search Criteria are implementing the [`Ibexa\Contracts\Collaboration\Invitation\Query\CriterionInterface`](../../../../../../ibexa/collaboration/src/contracts/Invitation/Query/CriterionInterface.php) interface:

| Criterion                                                                                                                                                            | Description                                                                                                                                                                                                                             |
| -------------------------------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [`Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\CreatedAt`](../../../../../../ibexa/collaboration/src/contracts/Invitation/Query/Criterion/CreatedAt.php)               | Find invitations based on the date they were created                                                                                                                                                                                    |
| [`Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\Id`](../../../../../../ibexa/collaboration/src/contracts/Invitation/Query/Criterion/Id.php)                             | Find invitations with given invitation ID                                                                                                                                                                                               |
| [`Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\LogicalAnd`](../../../../../../ibexa/collaboration/src/contracts/Invitation/Query/Criterion/LogicalAnd.php)             | Composite criterion to group multiple criteria using the AND condition                                                                                                                                                                  |
| [`Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\LogicalOr`](../../../../../../ibexa/collaboration/src/contracts/Invitation/Query/Criterion/LogicalOr.php)               | Composite criterion to group multiple criteria using the OR condition                                                                                                                                                                   |
| [`Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\ParticipantScope`](../../../../../../ibexa/collaboration/src/contracts/Invitation/Query/Criterion/ParticipantScope.php) | Find invitations based on participant's scope, see [`Ibexa\Contracts\Share\Collaboration\ContentSessionScope`](../../../../../../ibexa/share/src/contracts/Collaboration/ContentSessionScope.php) for content-sharing sessions |
| [`Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\ParticipantType`](../../../../../../ibexa/collaboration/src/contracts/Invitation/Query/Criterion/ParticipantType.php)   | Find invitations based on participant type, see [`Ibexa\Contracts\Collaboration\Participant\ParticipantDiscriminator`](../../../../../../ibexa/collaboration/src/contracts/Participant/ParticipantDiscriminator.php)                 |
| [`Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\Sender`](../../../../../../ibexa/collaboration/src/contracts/Invitation/Query/Criterion/Sender.php)                     | Find invitations by invitation sender                                                                                                                                                                                                   |
| [`Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\Session`](../../../../../../ibexa/collaboration/src/contracts/Invitation/Query/Criterion/Session.php)                   | Find invitations by collaboration session                                                                                                                                                                                               |
| [`Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\Status`](../../../../../../ibexa/collaboration/src/contracts/Invitation/Query/Criterion/Status.php)                     | Find invitations with given status                                                                                                                                                                                                      |
| [`Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\UpdatedAt`](../../../../../../ibexa/collaboration/src/contracts/Invitation/Query/Criterion/UpdatedAt.php)               | Find invitations based on the date they were updated                                                                                                                                                                                    |

## Session Search Criteria

Session Search Criteria are implementing the [`Ibexa\Contracts\Collaboration\Session\Query\CriterionInterface`](../../../../../../ibexa/collaboration/src/contracts/Session/Query/CriterionInterface.php) interface:

| Criterion                                                                                                                                                         | Description                                                            |
| ----------------------------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------- |
| [`Ibexa\Contracts\Collaboration\Session\Query\Criterion\CreatedAt`](../../../../../../ibexa/collaboration/src/contracts/Session/Query/Criterion/CreatedAt.php)               | Find sessions based on the date they were created                      |
| [`Ibexa\Contracts\Collaboration\Session\Query\Criterion\Email`](../../../../../../ibexa/collaboration/src/contracts/Session/Query/Criterion/Email.php)                       | Find sessions based on external participant email                      |
| [`Ibexa\Contracts\Collaboration\Session\Query\Criterion\Id`](../../../../../../ibexa/collaboration/src/contracts/Session/Query/Criterion/Id.php)                             | Find sessions with the session ID                                      |
| [`Ibexa\Contracts\Collaboration\Session\Query\Criterion\IsActive`](../../../../../../ibexa/collaboration/src/contracts/Session/Query/Criterion/IsActive.php)                 | Find sessions based on active status                                   |
| [`Ibexa\Contracts\Collaboration\Session\Query\Criterion\LogicalAnd`](../../../../../../ibexa/collaboration/src/contracts/Session/Query/Criterion/LogicalAnd.php)             | Composite criterion to group multiple criteria using the AND condition |
| [`Ibexa\Contracts\Collaboration\Session\Query\Criterion\LogicalOr`](../../../../../../ibexa/collaboration/src/contracts/Session/Query/Criterion/LogicalOr.php)               | Composite criterion to group multiple criteria using the OR condition  |
| [`Ibexa\Contracts\Collaboration\Session\Query\Criterion\Owner`](../../../../../../ibexa/collaboration/src/contracts/Session/Query/Criterion/Owner.php)                       | Find sessions by their owner                                           |
| [`Ibexa\Contracts\Collaboration\Session\Query\Criterion\ParticipantToken`](../../../../../../ibexa/collaboration/src/contracts/Session/Query/Criterion/ParticipantToken.php) | Find sessions by participant token                                     |
| [`Ibexa\Contracts\Collaboration\Session\Query\Criterion\Token`](../../../../../../ibexa/collaboration/src/contracts/Session/Query/Criterion/Token.php)                       | Find sessions with given token                                         |
| [`Ibexa\Contracts\Collaboration\Session\Query\Criterion\Type`](../../../../../../ibexa/collaboration/src/contracts/Session/Query/Criterion/Type.php)                         | Find sessions by type                                                  |
| [`Ibexa\Contracts\Collaboration\Session\Query\Criterion\UpdatedAt`](../../../../../../ibexa/collaboration/src/contracts/Session/Query/Criterion/UpdatedAt.php)               | Find sessions based on the date they were updated                      |
| [`Ibexa\Contracts\Collaboration\Session\Query\Criterion\UserId`](../../../../../../ibexa/collaboration/src/contracts/Session/Query/Criterion/UserId.php)                     | Find sessions with given user ID                                       |

### Example

The following example shows how you can use the criteria to find all the currently active sessions:

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

The criteria limit the result set to sessions matching all of the conditions listed below:

- session has an active status
- session has a `content` type
- session creation date is within the last week
