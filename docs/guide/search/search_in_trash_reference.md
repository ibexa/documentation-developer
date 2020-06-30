# Searching in trash reference

When you [search for Content Items that are held in trash](../../api/public_php_api_search.md#searching-in-trash), you can apply only a limited set of Search Criteria and Sort Clauses.
They can be used by `\eZ\Publish\API\Repository\TrashService::findTrashItems` only.

## Supported Search Criteria

| Search Criterion | Search based on | Search type |
|-----|-----|-----|
|[ContentTypeId](criteria_reference/contenttypeid_criterion.md)|ID of the Content Item's Content Type|Content and Location|
|[DateMetadata](criteria_reference/datemetadata_criterion.md)|The date when Content Item was created or last modified|Content and Location|
|[SectionId](criteria_reference/sectionid_criterion.md)|ID of the Section the Content Item was assigned to|Content and Location|
|[UserMetadata](criteria_reference/usermetadata_criterion.md)|The creator or modifier of a Content Item|Content and Location|

## Supported logical operators

|Search Criterion|Search based on|Search type|
|-----|-----|-----|
|[LogicalAnd](criteria_reference/logicaland_criterion.md)|Implements a logical AND Criterion. It matches if ALL of the provided Criteria match.|Content and Location|

## Supported Sort Clauses

| Sort Clause | Sorting based on | Search type|
|-----|-----|-----|
|[ContentName](sort_clause_reference/contentname_sort_clause.md)|Content names|Content and Location|
|[SectionName](sort_clause_reference/sectionname_sort_clause.md)|Name of the Section that content was assigned to|Content and Location|
|[Depth](sort_clause_reference/depth_sort_clause.md)|Location depth in the Content tree|Location only|
|[Path](sort_clause_reference/path_sort_clause.md)|PathString of the Location|Location only|
|[Priority](sort_clause_reference/priority_sort_clause.md)|Location priority|Location only|
|[ContentTypeName](https://github.com/ezsystems/ezplatform-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Query/SortClause/Trash/ContentTypeName.php)|Name of the Content Item's Content Type|Trash only|
|[DateTrashed](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.2/eZ/Publish/API/Repository/Values/Content/Query/SortClause/Trash/DateTrashed.php)|Date when content was sent to trash|Trash only|
|[UserLogin](https://github.com/ezsystems/ezplatform-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Query/SortClause/Trash/UserLogin.php)|Login of the Content Item's creator|Trash only|
