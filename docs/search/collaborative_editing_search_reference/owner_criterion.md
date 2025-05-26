# Owner Criterion

The `Owner` Search Criterion searches for sessions based on session Owner.

## Arguments

- `value` - user(s) to be matched, provided as a UserReference object

## Example

```php
$user = $this->userService->loadUserByLogin('foo');
$currentUser = $this->permissionResolver->getCurrentUserReference();

$criteria = new Ibexa\Contracts\Collaboration\Session\Query\Criterion\Owner($user);

OR

$criteria = new Ibexa\Contracts\Collaboration\Session\Query\Criterion\Owner([$user, $currentUser]);

$query = new SessionQuery($criteria);
```