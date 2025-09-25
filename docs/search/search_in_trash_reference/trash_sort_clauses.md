---
description: Sort Clauses for ordering search results of content items in trash.
page_type: reference
month_change: false
---

# Trash Search Sort Clauses reference

| Name | Description |
| --- | --- |
| [ContentName](../contentname_sort_clause.md) | Sort by content item name |
| [ContentTypeName](../contenttypename_sort_clause.md) | Sort by Content Type name |
| [DateTrashed](../datetrashed_sort_clause.md) | Sort by the date when content was moved to trash (exclusive to trash search) |
| [Depth](../depth_sort_clause.md) | Sort by the original depth in the content tree |
| [Path](../path_sort_clause.md) | Sort by the original path in the content tree |
| [Priority](../priority_sort_clause.md) | Sort by content item priority |
| [SectionName](../sectionname_sort_clause.md) | Sort by Section name |
| [UserLogin](../userlogin_sort_clause.md) | Sort by the login of the user who created the content |

The following example shows how to use sort clauses to order the searched trash items:

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new Query();
$query->sortClauses = [
    new SortClause\DateTrashed(Query::SORT_DESC),
    new SortClause\ContentName(Query::SORT_ASC),
    new SortClause\ContentTypeName(Query::SORT_ASC)
];

// Search results will be sorted by:
// 1. Date trashed (most recent first)
// 2. Content name (alphabetically)
// 3. Content Type name (alphabetically)
$results = $trashService->findTrashItems($query);
```

The returned trash items are sorted by:

- date when content was trashed (descending - most recent first)
- content name (ascending - alphabetically)
- Content Type name (ascending - alphabetically)

You can change the default sorting order by using the `Query::SORT_ASC` and `Query::SORT_DESC` constants.