---
description: Trash Search Criteria and Sort Clauses help define and fine-tune search queries for content in trash.
---

# Search in trash reference

When you [search for Content items that are held in trash](search_api.md#searching-in-trash), you can apply only a limited set of Search Criteria and Sort Clauses.
They can be used by `Ibexa\Contracts\Core\Repository\TrashService::findTrashItems` only.

## Search Criteria

| Search Criterion | Search based on | Search type |
|-----|-----|-----|
|[ContentTypeId](contenttypeid_criterion.md)|ID of the Content item's Content Type|Content and Location|
|[DateMetadata](datemetadata_criterion.md)|The date when Content item was created or last modified|Content and Location|
|[MatchAll](matchall_criterion.md)|Returns all search results|Content and Location|
|[MatchNone](matchnone_criterion.md)|Returns no search results|Content and Location|
|[SectionId](sectionid_criterion.md)|ID of the Section the Content item was assigned to|Content and Location|
|[UserMetadata](usermetadata_criterion.md)|The creator or modifier of a Content item|Content and Location|

## logical operators

|Search Criterion|Search based on|Search type|
|-----|-----|-----|
|[LogicalAnd](logicaland_criterion.md)|Implements a logical AND Criterion. It matches if ALL of the provided Criteria match.|Content and Location|
|[LogicalNot](logicalor_criterion.md)|Implements a logical NOT Criterion. It matches if the provided Criterion doesn't match.|Content and Location|
|[LogicalOr](logicalor_criterion.md)|Implements a logical OR Criterion. It matches if at least one of the provided Criteria matches.|Content and Location|

## Sort Clauses

| Sort Clause | Sorting based on | Search type|
|-----|-----|-----|
|[ContentName](contentname_sort_clause.md)|Content item's name|Content and Location|
|[ContentTypeName](contenttypename_sort_clause.md)|Name of the Content item's Content Type|Trash only|
|[DateTrashed](datetrashed_sort_clause.md)|Date when the Content item was sent to trash|Trash only|
|[Depth](depth_sort_clause.md)|Location depth in the Content Tree|Location only|
|[Path](path_sort_clause.md)|PathString of the Location|Location only|
|[Priority](priority_sort_clause.md)|Location priority|Location only|
|[SectionName](sectionname_sort_clause.md)|Name of the Section the Content item was assigned to|Content and Location|
|[UserLogin](userlogin_sort_clause.md)|Login of the Content item's creator|Trash only|
