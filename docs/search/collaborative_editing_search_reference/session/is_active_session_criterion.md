---
description: IsActive Search Criterion
---

# IsActive Criterion

The `IsActive` Search Criterion searches for sessions based on active status.

## Arguments

- (optional) `value` - bool representing the whether to search for active (default true) or inactive (false) sessions.

## Example

```php
$criteria = new Ibexa\Contracts\Collaboration\Session\Query\Criterion\IsActive();

OR

$criteria = new Ibexa\Contracts\Collaboration\Session\Query\Criterion\IsActive(false);

$query = new SessionQuery($criteria);
```