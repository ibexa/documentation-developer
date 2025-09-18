---
description: Token Search Criterion
---

# Token Criterion

The `Token` Search Criterion searches for sessions based on session token.

## Arguments

- `value` - string(s) representing the session token(s)

## Example

```php
$criteria = new \Ibexa\Contracts\Collaboration\Session\Query\Criterion\Token('12345-12345-12345-12345-12345');

OR

$criteria = new \Ibexa\Contracts\Collaboration\Session\Query\Criterion\Token(['12345-12345-12345-12345-12345', '12345-67890-098765-54321-12345']);

$query = new SessionQuery($criteria);
```