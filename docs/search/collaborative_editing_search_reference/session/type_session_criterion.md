---
description: Type Search Criterion
---

# Type Criterion

The `Type` Search Criterion searches for sessions based on session type.

## Arguments

- `value` - string(s) representing the session type(s)

## Example

```php
$criteria = new Ibexa\Contracts\Collaboration\Session\Query\Criterion\Type('content');

OR

$criteria = new Ibexa\Contracts\Collaboration\Session\Query\Criterion\Type(['content', 'product']);

$query = new SessionQuery($criteria);
```