<?php

declare(strict_types=1);

use Ibexa\Contracts\Collaboration\Session\Query\Criterion;
use Ibexa\Contracts\Collaboration\Session\Query\SortClause;
use Ibexa\Contracts\Collaboration\Session\SessionQuery;

$now = new DateTimeImmutable();

$query = new SessionQuery(
    new Criterion\LogicalAnd([
        new Criterion\IsActive(),
        new Criterion\Type(‘content’),
        new Criterion\CreatedAt($now, Criterion\CreatedAt::OPERATOR_LTE),
    ]),
    [
        new SortClause\CreatedAt(SortClause\CreatedAt::SORT_DESC),
    ]
);

/** @var \Ibexa\Contracts\Collaboration\SessionServiceInterface $sessionService */
$results = $sessionService->findSessions($query);