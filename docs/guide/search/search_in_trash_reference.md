# Search in trash reference

When you [search for Content items that are held in trash](../../api/public_php_api_search.md#searching-in-trash), you can apply only a limited set of Search Criteria and Sort Clauses.
They can be used by `Ibexa\Contracts\Core\Repository\TrashService::findTrashItems` only.

## Search Criteria

| Search Criterion | Search based on | Search type |
|-----|-----|-----|
|[ContentTypeId](criteria_reference/contenttypeid_criterion.md)|ID of the Content item's Content Type|Content and Location|
|[DateMetadata](criteria_reference/datemetadata_criterion.md)|The date when Content item was created or last modified|Content and Location|
|[MatchAll](criteria_reference/matchall_criterion.md)|Returns all search results|Content and Location|
|[MatchNone](criteria_reference/matchnone_criterion.md)|Returns no search results|Content and Location|
|[SectionId](criteria_reference/sectionid_criterion.md)|ID of the Section the Content item was assigned to|Content and Location|
|[UserMetadata](criteria_reference/usermetadata_criterion.md)|The creator or modifier of a Content item|Content and Location|

## logical operators

|Search Criterion|Search based on|Search type|
|-----|-----|-----|
|[LogicalAnd](criteria_reference/logicaland_criterion.md)|Implements a logical AND Criterion. It matches if ALL of the provided Criteria match.|Content and Location|
|[LogicalNot](criteria_reference/logicalor_criterion.md)|Implements a logical NOT Criterion. It matches if the provided Criterion doesn't match.|Content and Location|
|[LogicalOr](criteria_reference/logicalor_criterion.md)|Implements a logical OR Criterion. It matches if at least one of the provided Criteria matches.|Content and Location|

## Sort Clauses

| Sort Clause | Sorting based on | Search type|
|-----|-----|-----|
|[ContentName](sort_clause_reference/contentname_sort_clause.md)|Content item's name|Content and Location|
|[ContentTypeName](sort_clause_reference/contenttypename_sort_clause.md)|Name of the Content item's Content Type|Trash only|
|[DateTrashed](sort_clause_reference/datetrashed_sort_clause.md)|Date when the Content item was sent to trash|Trash only|
|[Depth](sort_clause_reference/depth_sort_clause.md)|Location depth in the Content Tree|Location only|
|[Path](sort_clause_reference/path_sort_clause.md)|PathString of the Location|Location only|
|[Priority](sort_clause_reference/priority_sort_clause.md)|Location priority|Location only|
|[SectionName](sort_clause_reference/sectionname_sort_clause.md)|Name of the Section the Content item was assigned to|Content and Location|
|[UserLogin](sort_clause_reference/userlogin_sort_clause.md)|Login of the Content item's creator|Trash only|
