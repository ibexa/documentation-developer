---
description: Notification DateCreated Search Criterion
month_change: true
---

# Notification DateCreated Criterion

The `DateCreated` Search Criterion searches for notifications based on the date when they were created.

## Arguments

- `created` - date to be matched, provided as a `DateTimeInterface` object
- `operator` - optional operator string (GTE, LTE)

## Example

### PHP

``` php
$criteria = new Ibexa\Contracts\Core\Repository\Values\Notification\Query\Criterion\DateCreated(
    new DateTime('2023-03-01 14:07:02'),
    'GTE'
);

$query = new NotificationQuery($criteria);
```
