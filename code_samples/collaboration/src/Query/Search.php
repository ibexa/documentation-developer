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
