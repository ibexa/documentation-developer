# Search in trash reference

Trash Search Criteria and Sort Clauses help define and fine-tune search queries for content in trash.

When you [search for content items that are held in trash](../search_api/index.md#search-in-trash), you can apply only a limited subset of Search Criteria and Sort Clauses which can be used by [`Ibexa\Contracts\Core\Repository\TrashService::findTrashItems`](../../../../../ibexa/core/src/contracts/Repository/TrashService.php). Some sort clauses are exclusive to trash search.

## Search Criteria

- [ContentName](../criteria_reference/contentname_criterion/index.md)
- [ContentTypeId](../criteria_reference/contenttypeid_criterion/index.md)
- [DateMetadata](../criteria_reference/datemetadata_criterion/index.md) (which can use the additional exclusive target `DateMetadata::TRASHED`)
- [MatchAll](../criteria_reference/matchall_criterion/index.md)
- [MatchNone](../criteria_reference/matchnone_criterion/index.md)
- [SectionId](../criteria_reference/sectionid_criterion/index.md)
- [UserMetadata](../criteria_reference/usermetadata_criterion/index.md)

## Logical operators

- [LogicalAnd](../criteria_reference/logicaland_criterion/index.md)
- [LogicalNot](../criteria_reference/logicalor_criterion/index.md)
- [LogicalOr](../criteria_reference/logicalor_criterion/index.md)

## Sort Clauses

- [ContentName](../sort_clause_reference/contentname_sort_clause/index.md)
- [ContentTypeName](../sort_clause_reference/contenttypename_sort_clause/index.md)
- [DateTrashed](../sort_clause_reference/datetrashed_sort_clause/index.md)
- [Depth](../sort_clause_reference/depth_sort_clause/index.md)
- [Path](../sort_clause_reference/path_sort_clause/index.md)
- [Priority](../sort_clause_reference/priority_sort_clause/index.md)
- [SectionName](../sort_clause_reference/sectionname_sort_clause/index.md)
- [UserLogin](../sort_clause_reference/userlogin_sort_clause/index.md)
