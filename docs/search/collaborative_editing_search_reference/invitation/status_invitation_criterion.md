---
description: Status Search Criterion
---

# Status Search Criterion

The `Status` Search Criterion searches for invitations based on status.

## Arguments

- `value` - string(s) representing the invitation status(es)

## Example

```php
$criteria = new \Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\Type('pending');

OR

$criteria = new \Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\Type(['pending', 'accepted']);

$query = new InvitationQuery($criteria);
```