<?php

declare(strict_types=1);

use Ibexa\Contracts\Core\Repository\Values\Notification\Query\Criterion\DateCreated;
use Ibexa\Contracts\Core\Repository\Values\Notification\Query\Criterion\Status;
use Ibexa\Contracts\Core\Repository\Values\Notification\Query\Criterion\Type;
use Ibexa\Contracts\Core\Repository\Values\Notification\Query\NotificationQuery;

/** @var \Ibexa\Contracts\Core\Repository\NotificationService $notificationService */
$query = new NotificationQuery([], 0, 25);

$query->addCriterion(new Type('Workflow:Review'));
$query->addCriterion(new Status(['unread']));

$from = new \DateTimeImmutable('-7 days');
$to = new \DateTimeImmutable();

$query->addCriterion(new DateCreated($from, $to));

$notificationList = $notificationService->findNotifications($query);
