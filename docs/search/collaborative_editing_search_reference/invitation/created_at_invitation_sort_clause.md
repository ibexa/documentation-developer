---
description: CreatedAt Sort Clause
---

# CreatedAt Sort Clause

The `CreatedAt` Sort Clause sorts search results by the date and time of the creation of invitation.

## Arguments

- (optional) `direction` - SortDirection constant, either SortDirection::ASC or SortDirection::DESC.

## Example

```php
$sortClause = [new \Ibexa\Contracts\Collaboration\Invitation\Query\SortClause\CreatedAt(SortDirection::DESC)]);

$query = new InvitationQuery($criteria, sortClause);
```