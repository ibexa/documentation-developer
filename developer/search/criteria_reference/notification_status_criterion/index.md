# Notification Status Criterion

Notification Status Search Criterion

The `Status` Search Criterion searches for notifications based on notification status.

## Arguments

- `status` - Boolean value that represents the status of the notification

## Example

### PHP

```php
<?php

declare(strict_types=1);

use Ibexa\Contracts\Core\Repository\Values\NotificationQuery;

$repository = $this->getRepository();
$notificationService = $repository->getNotificationService();
$query = new NotificationQuery([], 0, 25);

$query->addCriterion(new Type('Workflow:Review'));
$query->addCriterion(new Status(['unread']));

$from = new \DateTimeImmutable('-7 days');
$to = new \DateTimeImmutable();

$query->addCriterion(new DateCreated($from, $to));

$notificationList = $notificationService->findNotifications($query);
```
