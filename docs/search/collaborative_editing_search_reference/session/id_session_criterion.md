---
description: Id Search Criterion
---

# Id Criterion

The `Id` Search Criterion searches for sessions based on session ID.

## Arguments

- `value` - integer(s) representing the Session ID(s)

## Example

```php
$criteria = new \Ibexa\Contracts\Collaboration\Session\Query\Criterion\Id(1);

OR

$criteria = new \Ibexa\Contracts\Collaboration\Session\Query\Criterion\Id([1, 2]);

$query = new SessionQuery($criteria);
```