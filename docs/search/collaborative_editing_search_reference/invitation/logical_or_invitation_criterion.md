---
description: LogicalOr Search Criterion
---

# LogicalOr Criterion

The `LogicalOr` Search Criterion matches combined invitations by the logical operator.

## Example

```php
$criteria = \Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\LogicalOr( , 
    new \Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\Id(1),
    new \Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\Status('pending') 
);

$query = new InvitationQuery($criteria);
```