---
description: InvitationId Sort Clause
---

# InvitationId Sort Clause

The `InvitationId` Sort Clause sorts search results by invitation ID.

## Arguments

- (optional) `direction` - SortDirection constant, either SortDirection::ASC or SortDirection::DESC.

## Example

```php
$sortClause = [new \Ibexa\Contracts\Collaboration\Invitation\Query\SortClause\Id(SortDirection::DESC)]);

$query = new InvitationQuery($criteria, sortClause);
```