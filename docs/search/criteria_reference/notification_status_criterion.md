---
description: Notification Status Search Criterion
month_change: true
---

# Notification Status Criterion

The `Status` Search Criterion searches for notifications based on notification status.

## Arguments

- `status` - Boolean value that represents the status of the notification

## Example

### PHP

``` php
$criteria = new Ibexa\Contracts\Core\Repository\Values\Notification\Query\Criterion\(0);

$query = new NotificationQuery($criteria);
```
