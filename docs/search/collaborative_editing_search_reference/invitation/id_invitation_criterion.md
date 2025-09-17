---
description: Id Search Criterion
---

# Id Criterion

The `Id` Search Criterion searches for invitations based on invitation ID.

## Arguments

- `value` - integer(s) representing the Invitation ID(s)

## Example

```php
$criteria = new \Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\Id(1);

OR

$criteria = new \Ibexa\Contracts\Collaboration\Invitation\Query\Criterion\Id([1, 2]);

$query = new SessionQuery($criteria);
```