---
description: SessionId Sort Clause
---

# SessionId Sort Clause

The `SessionId` Sort Clause sorts search results by session ID.

## Arguments

- (optional) `direction` - SortDirection constant, either SortDirection::ASC or SortDirection::DESC.

## Example

```php
$sortClause = [new \Ibexa\Contracts\Collaboration\Session\Query\SortClause\Id(SortDirection::DESC)]);

$query = new SessionQuery($criteria, sortClause);
```