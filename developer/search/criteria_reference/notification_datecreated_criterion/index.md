# Notification DateCreated Criterion

Notification DateCreated Search Criterion

The `DateCreated` Search Criterion searches for notifications based on the date when they were created.

## Arguments

- `created` - date to be matched, provided as a `DateTimeInterface` object
- `operator` - optional operator string (GTE, LTE)

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
