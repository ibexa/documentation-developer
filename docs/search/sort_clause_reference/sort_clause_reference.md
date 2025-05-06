---
description: Sort Clauses help fine-tune sorting order when searching for content and locations.
page_type: reference
month_change: false
---

# Sort Clause reference

Sort Clauses are the sorting options for Content and Location Search and
[Repository filtering](search_api.md#repository-filtering).

Capabilities of individual Sort Clauses can depend on the search engine.

All Sort Clauses can take the following optional argument:

- `sortDirection` - the direction of the sorting, either `Query::SORT_ASC` (default) or `Query::SORT_DESC`

## Sort Clauses

| Sort Clause                                                   | Sorting based on                                                                           | Content Search | Location Search | Filtering | Trash    |
|---------------------------------------------------------------|--------------------------------------------------------------------------------------------|----------------|-----------------|-----------|----------|
| [ContentId](contentid_sort_clause.md)                         | Content items' ID                                                                          | &#10004;       | &#10004;        | &#10004;  |          |
| [ContentName](contentname_sort_clause.md)                     | Content names                                                                              | &#10004;       | &#10004;        | &#10004;  | &#10004; |
| [ContentTranslatedName](contenttranslatedname_sort_clause.md) | Translated content names                                                                   | &#10004;       | &#10004;        |           |          |
| [ContentTypeName](contenttypename_sort_clause.md)             | Content items' content type name                                                           |                |                 |           | &#10004; |
| [CustomField](customfield_sort_clause.md)                     | Raw search index fields                                                                    | &#10004;       | &#10004;        |           |          |
| [DateModified](datemodified_sort_clause.md)                   | The date when content was last modified                                                    | &#10004;       | &#10004;        | &#10004;  |          |
| [DatePublished](datepublished_sort_clause.md)                 | The date when content was created                                                          | &#10004;       | &#10004;        | &#10004;  |          |
| [DateTrashed](datetrashed_sort_clause.md)                     | The date when content was sent to trash                                                    |                |                 |           | &#10004; |
| [Depth](depth_sort_clause.md)                                 | Location depth in the content tree                                                         |                | &#10004;        | &#10004;  | &#10004; |
| [Field](field_sort_clause.md)                                 | Content of one of content item's fields                                                    | &#10004;       | &#10004;        |           |          |
| [Id](id_sort_clause.md)                                       | Location ID                                                                                |                | &#10004;        | &#10004;  |          |
| [IsMainLocation](ismainlocation_sort_clause.md)               | Whether a location is the main location of a content item                                  |                | &#10004;        |           |          |
| [MapLocationDistance](maplocationdistance_sort_clause.md)     | Distance between the location contained in a MapLocation field and the provided coordinates | &#10004;       | &#10004;        |           |          |
| [Path](path_sort_clause.md)                                   | PathString of the Location                                                                 |                | &#10004;        | &#10004;  | &#10004; |
| [Priority](priority_sort_clause.md)                           | Location priority                                                                          |                | &#10004;        | &#10004;  | &#10004; |
| [Random](random_sort_clause.md)                               | Random seed                                                                                | &#10004;       | &#10004;        |           |          |
| [Score](score_sort_clause.md)                                 | Score of the search result                                                                 | &#10004;       | &#10004;        |           |          |
| [SectionIdentifier](sectionidentifier_sort_clause.md)         | ID of the Section content is assigned to                                                   | &#10004;       | &#10004;        | &#10004;  |          |
| [SectionName](sectionname_sort_clause.md)                     | Name of the Section content is assigned to                                                 | &#10004;       | &#10004;        | &#10004;  | &#10004; |
| [UserLogin](userlogin_sort_clause.md)                         | Login of the content item's creator                                                        |                |                 |           | &#10004; |
| [Visibility](visibility_sort_clause.md)                       | Whether the location is visible or not                                                     |                | &#10004;        | &#10004;  |          |
