---
description: Email Search Criterion
---

# Email Criterion

The `Email` Search Criterion searches for sessions based on external participant email.

## Arguments

- `value` - string(s) representing the Participant email(s)

## Example

```php
$criteria = new Ibexa\Contracts\Collaboration\Session\Query\Criterion\Email('participant@link.invalid');

OR

$criteria = new \Ibexa\Contracts\Collaboration\Session\Query\Criterion\Email(...['participant1@link.invalid', 'participant2@link.invalid']);

$query = new SessionQuery($criteria);
```