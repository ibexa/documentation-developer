---
description: CreatedAt Search Criterion
---

# CreatedAt Criterion

The `CreatedAt` Search Criterion searches for sessions based on the date when they were created.

## Arguments

- `value` - date to be matched, provided as a DateTimeInterface object
- `operator` - optional operator string (EQ, GT, GTE, LT, LTE)

## Example

```php
$criteria = new Ibexa\Contracts\Collaboration\Session\Query\Criterion\CreatedAt(
    new DateTime('2025-05-01 14:07:02'),
    'GTE'
);

$query = new SessionQuery($criteria);
```