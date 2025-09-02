---
description: InvitationStatus Sort Clause
---

# InvitationStatus Sort Clause

The `InvitationStatus` Sort Clause sorts search results by invitation status.

## Arguments

- (optional) `direction` - SortDirection constant, either SortDirection::ASC or SortDirection::DESC.

## Example

```php
$sortClause = [new \Ibexa\Contracts\Collaboration\Invitation\Query\SortClause\Status(SortDirection::DESC)]);

$query = new InvitationQuery($criteria, sortClause);
```