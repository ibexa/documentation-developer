---
description: CreatedAt Search Criterion
---

# CreatedAt Search Criterion

The `CreatedAt` Search Criterion searches for invitations based on the date they were created.

## Arguments

- `value` - date to be matched, provided as a DateTimeInterface object
- `operator` - optional operator string (EQ, GT, GTE, LT, LTE)

## Example

```php
$criteria = new \Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\CreatedAt(
    new DateTime('2025-05-01 14:07:02'),
    'GTE'
);

$query = new InvitationQuery($criteria);
```