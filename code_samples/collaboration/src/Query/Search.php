?php
declare(strict_types=1);
use Ibexa\Contracts\Collaboration\Value\Query\CollaborationQuery;
use Ibexa\Contracts\Collaboration\Value\Query\Criterion;
use Ibexa\Contracts\Collaboration\Value\Query\SortClause;
$now = new \DateTimeImmutable();
$query = new CollaborationQuery(
    new Criterion\LogicalAnd([
        new Criterion\IsActiveCriterion(),
        new Criterion\TypeCriterion(‘content’),
        new Criterion\CreatedAtCriterion($now, Criterion\CreatedAtCriterion::OPERATOR_LTE),
    ]),
    [
        new SortClause\CreatedAt(SortClause\CreatedAt::SORT_DESC),
    ]
);
/** @var \Ibexa\Contracts\Session\SessionServiceInterface $sessionService */
$results = $sessionService->findSessions($query);