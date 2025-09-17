---
description: UserID Search Criterion
---

# UserID Criterion

The `UserID` Search Criterion searches for sessions	based on internal participants.

## Arguments

- `value` - user(s) to be matched, provided as a UserReference object

## Example

```php
$user = $this->userService->loadUserByLogin('foo');
$currentUser = $this->permissionResolver->getCurrentUserReference();

$criteria = new \Ibexa\Contracts\Collaboration\Session\Query\Criterion\UserId($user);

OR

$criteria = new \Ibexa\Contracts\Collaboration\Session\Query\Criterion\UserId(…[$user, $currentUser]);

$query = new SessionQuery($criteria);
```