---
description: Sort Clauses help fine-tune sorting order when searching for content and Locations.
page_type: reference
---

# Sort Clause reference

Sort Clauses are the sorting options for Content and Location Search and
[Repository filtering](search_api.md#repository-filtering).

Capabilities of individual Sort Clauses can depend on the search engine.

All Sort Clauses can take the following optional argument:

- `sortDirection` - the direction of the sorting, either `Query::SORT_ASC` (default) or `Query::SORT_DESC`

## Sort Clauses

| Sort Clause                                                   | Sorting based on                                                                            | Content Search | Location Search | Filtering |
|---------------------------------------------------------------|---------------------------------------------------------------------------------------------|----------------|-----------------|-----------|
| [ContentId](contentid_sort_clause.md)                         | Content items' ID                                                                           | &#10004;       | &#10004;        | &#10004;  |
| [ContentName](contentname_sort_clause.md)                     | Content names                                                                               | &#10004;       | &#10004;        | &#10004;  |
| [ContentTranslatedName](contenttranslatedname_sort_clause.md) | Translated content names                                                                    | &#10004;       | &#10004;        |           |
| [CustomField](customfield_sort_clause.md)                     | Raw search index fields                                                                     | &#10004;       | &#10004;        |           |
| [DateModified](datemodified_sort_clause.md)                   | The date when content was last modified                                                     | &#10004;       | &#10004;        | &#10004;  |
| [DatePublished](datepublished_sort_clause.md)                 | The date when content was created                                                           | &#10004;       | &#10004;        | &#10004;  |
| [Depth](depth_sort_clause.md)                                 | Location depth in the Content Tree                                                          |                | &#10004;        | &#10004;  |
| [Field](field_sort_clause.md)                                 | Content of one of Content item's Fields                                                     | &#10004;       | &#10004;        |           |
| [Id](id_sort_clause.md)                                       | Location ID                                                                                 |                | &#10004;        | &#10004;  |
| [IsMainLocation](ismainlocation_sort_clause.md)               | Whether a Location is the main Location of a Content item                                   |                | &#10004;        |           |
| [MapLocationDistance](maplocationdistance_sort_clause.md)     | Distance between the location contained in a MapLocation Field and the provided coordinates | &#10004;       | &#10004;        |           |
| [Path](path_sort_clause.md)                                   | PathString of the Location                                                                  |                | &#10004;        | &#10004;  |
| [Priority](priority_sort_clause.md)                           | Location priority                                                                           |                | &#10004;        | &#10004;  |
| [Random](random_sort_clause.md)                               | Random seed                                                                                 | &#10004;       | &#10004;        |           |
| [Score](score_sort_clause.md)                                 | Score of the search result                                                                  | &#10004;       | &#10004;        |           |
| [SectionIdentifier](sectionidentifier_sort_clause.md)         | ID of the Section content is assigned to                                                    | &#10004;       | &#10004;        | &#10004;  |
| [SectionName](sectionname_sort_clause.md)                     | Name of the Section content is assigned to                                                  | &#10004;       | &#10004;        | &#10004;  |
| [Visibility](visibility_sort_clause.md)                       | Whether the Location is visible or not                                                      |                | &#10004;        | &#10004;  |
