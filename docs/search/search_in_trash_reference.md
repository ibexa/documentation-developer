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

- [ContentName](contentname_criterion.md)
- [ContentTypeId](contenttypeid_criterion.md)
- [DateMetadata](datemetadata_criterion.md) (which can use the additional exclusive target `DateMetadata::TRASHED`)
- [MatchAll](matchall_criterion.md)
- [MatchNone](matchnone_criterion.md)
- [SectionId](sectionid_criterion.md)
- [UserMetadata](usermetadata_criterion.md)

## Logical operators

- [LogicalAnd](logicaland_criterion.md)
- [LogicalNot](logicalor_criterion.md)
- [LogicalOr](logicalor_criterion.md)

## Sort Clauses

- [ContentName](contentname_sort_clause.md)
- [ContentTypeName](contenttypename_sort_clause.md)
- [DateTrashed](datetrashed_sort_clause.md)
- [Depth](depth_sort_clause.md)
- [Path](path_sort_clause.md)
- [Priority](priority_sort_clause.md)
- [SectionName](sectionname_sort_clause.md)
- [UserLogin](userlogin_sort_clause.md)
