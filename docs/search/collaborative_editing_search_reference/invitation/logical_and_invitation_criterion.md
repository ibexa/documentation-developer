---
description: LogicalAnd Search Criterion
---

# LogicalAnd Criterion

The `LogicalAnd` Search Criterion matches combined invitations by the logical operator.

## Example

```php
$currentUser = $this->permissionResolver->getCurrentUserReference();

$criteria = \Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\LogicalAnd( 
    new \Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\Status('pending'), 
    new \Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\Sender($currentUser)
);

$query = new InvitationQuery($criteria);
```