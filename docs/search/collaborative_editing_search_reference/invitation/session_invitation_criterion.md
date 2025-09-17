---
description: Session Search Criterion
---

# Session Search Criterion

The `Session` Search Criterion searches for invitations based on session.

## Arguments

- `value` - objects(s) representing the session(s) and implementing `\Ibexa\Contracts\Collaboration\Session\SessionInterface`

## Example

```php
$firstSession = $this->sessionService->getSession(1);
$secondSession = $this->sessionService->getSession(2);

$criteria = new \Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\Session($firstSession);

OR

$criteria = new \Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\Session([$firstSession, $secondSession]);

$query = new InvitationQuery($criteria);
```