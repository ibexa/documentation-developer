---
description: Type Search Criterion
month_change: true
---

# Type Criterion

The `Type` Search Criterion searches for notifications by their types.

## Arguments

- `type` - string that represents the type of the notification, takes values defined in notification workflow

## Example

### PHP

``` php
$criteria = new Ibexa\Contracts\Core\Repository\Values\Notification\Query\Criterion\Type('Workflow:Reject');

$query = new NotificationQuery($criteria);
```
