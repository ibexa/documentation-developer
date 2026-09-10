# Type Criterion

Type Search Criterion

The `Type` Search Criterion searches for notifications by their types.

## Arguments

- `type` - string that represents the type of the notification, takes values defined in notification workflow

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
