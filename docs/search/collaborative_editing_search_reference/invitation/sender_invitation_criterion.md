---
description: Sender Search Criterion
---

# Sender Search Criterion

The `Sender` Search Criterion searches for invitations based on invitation sender.

## Arguments

- `value` - user(s) to be matched, provided as a UserReference object

## Example

```php
$user = $this->userService->loadUserByLogin('foo');
$currentUser = $this->permissionResolver->getCurrentUserReference();

$criteria = new \Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\Owner($user);

OR

$criteria = new \Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\Owner([$user, $currentUser]);

$query = new InvitationQuery($criteria);
```