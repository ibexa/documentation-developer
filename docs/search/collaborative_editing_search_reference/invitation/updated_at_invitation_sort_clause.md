---
description: UpdatedAt Sort Clause
---

# UpdatedAt Sort Clause

The UpdatedAt Sort Clause sorts search results by the date and time when invitation was updated.

## Arguments

- (optional) `direction` - SortDirection constant, either SortDirection::ASC or SortDirection::DESC.

## Example

```php
$sortClause = [new \Ibexa\Contracts\Collaboration\Invitation\Query\SortClause\UpdatedAt(SortDirection::DESC)]);

$query = new InvitationQuery($criteria, sortClause);
```