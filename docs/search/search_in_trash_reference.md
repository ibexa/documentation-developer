---
description: Trash Search Criteria and Sort Clauses help define and fine-tune search queries for content in trash.
---

# Search in trash reference

When you [search for Content items that are held in trash](search_api.md#searching-in-trash), you can apply only a limited set of Search Criteria and Sort Clauses.
They can be used by `Ibexa\Contracts\Core\Repository\TrashService::findTrashItems` only.

## Search Criteria

- [ContentTypeId](contenttypeid_criterion.md)
- [DateMetadata](datemetadata_criterion.md)
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
