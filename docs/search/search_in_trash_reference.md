---
description: Trash Search Criteria and Sort Clauses help define and fine-tune search queries for content in trash.
page_type: reference
month_change: false
---

# Search in trash reference

When you [search for content items that are held in trash](search_api.md#searching-in-trash), you can apply only a limited subset of Search Criteria and Sort Clauses
which can be used by [`Ibexa\Contracts\Core\Repository\TrashService::findTrashItems`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-TrashService.html#method_findTrashItems).
Some sort clauses are exclusive to trash search.

## Search Criteria

| Criterion | Description |
|---|---|
| [ContentName](contentname_criterion.md) | Find content items by their name |
| [ContentTypeId](contenttypeid_criterion.md) | Find content items by their Content Type ID |
| [DateMetadata](datemetadata_criterion.md) | Find content items by metadata dates. Can use the additional exclusive target `DateMetadata::TRASHED` for trash-specific searches |
| [MatchAll](matchall_criterion.md) | Match all content items (no filtering) |
| [MatchNone](matchnone_criterion.md) | Match no content items (filter out all) |
| [SectionId](sectionid_criterion.md) | Find content items by their Section ID |
| [UserMetadata](usermetadata_criterion.md) | Find content items by user metadata (creator or modifier) |

## Logical operators

| Operator | Description |
|---|---|
| [LogicalAnd](logicaland_criterion.md) | Composite criterion to group multiple criteria using the AND condition |
| [LogicalNot](logicalor_criterion.md) | Negate the result of the wrapped criterion |
| [LogicalOr](logicalor_criterion.md) | Composite criterion to group multiple criteria using the OR condition |

## Sort Clauses

| Name | Description |
| --- | --- |
| [ContentName](contentname_sort_clause.md) | Sort by content item name |
| [ContentTypeName](contenttypename_sort_clause.md) | Sort by Content Type name |
| [DateTrashed](datetrashed_sort_clause.md) | Sort by the date when content was moved to trash (exclusive to trash search) |
| [Depth](depth_sort_clause.md) | Sort by the original depth in the content tree |
| [Path](path_sort_clause.md) | Sort by the original path in the content tree |
| [Priority](priority_sort_clause.md) | Sort by content item priority |
| [SectionName](sectionname_sort_clause.md) | Sort by Section name |
| [UserLogin](userlogin_sort_clause.md) | Sort by the login of the user who created the content |

The following example shows how you can use the criteria and sort clauses to find trashed content items:

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new Query();

// Find trashed articles
$query->filter = new Criterion\ContentTypeId([2]);

// Sort by date trashed (most recent first), then by content name
$query->sortClauses = [
    new SortClause\DateTrashed(Query::SORT_DESC),
    new SortClause\ContentName(Query::SORT_ASC)
];

$results = $trashService->findTrashItems($query);
```
