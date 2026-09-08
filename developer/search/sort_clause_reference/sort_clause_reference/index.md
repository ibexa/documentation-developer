# Sort Clause reference

Sort Clauses help fine-tune sorting order when searching for content and locations.

Sort Clauses are the sorting options for Content and Location Search and [Repository filtering](../../search_api/index.md#repository-filtering).

Capabilities of individual Sort Clauses can depend on the search engine.

All Sort Clauses can take the following optional argument:

- `sortDirection` - the direction of the sorting, either `Query::SORT_ASC` (default) or `Query::SORT_DESC`

## Sort Clauses

| Sort Clause                                                                                                                  | Sorting based on                                                                            | Content Search | Location Search | Filtering | Trash |
| ---------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------- | -------------- | --------------- | --------- | ----- |
| [ContentId](../contentid_sort_clause/index.md)                         | Content items' ID                                                                           | Yes            | Yes             | Yes       |       |
| [ContentName](../contentname_sort_clause/index.md)                     | Content names                                                                               | Yes            | Yes             | Yes       | Yes   |
| [ContentTranslatedName](../contenttranslatedname_sort_clause/index.md) | Translated content names                                                                    | Yes            | Yes             |           |       |
| [ContentTypeName](../contenttypename_sort_clause/index.md)             | Content items' content type name                                                            |                |                 |           | Yes   |
| [CustomField](../customfield_sort_clause/index.md)                     | Raw search index fields                                                                     | Yes            | Yes             |           |       |
| [DateModified](../datemodified_sort_clause/index.md)                   | The date when content was last modified                                                     | Yes            | Yes             | Yes       |       |
| [DatePublished](../datepublished_sort_clause/index.md)                 | The date when content was created                                                           | Yes            | Yes             | Yes       |       |
| [DateTrashed](../datetrashed_sort_clause/index.md)                     | The date when content was sent to trash                                                     |                |                 |           | Yes   |
| [Depth](../depth_sort_clause/index.md)                                 | Location depth in the content tree                                                          |                | Yes             | Yes       | Yes   |
| [Field](../field_sort_clause/index.md)                                 | Content of one of content item's fields                                                     | Yes            | Yes             |           |       |
| [Id](../id_sort_clause/index.md)                                       | Location ID                                                                                 |                | Yes             | Yes       |       |
| [IsMainLocation](../ismainlocation_sort_clause/index.md)               | Whether a location is the main location of a content item                                   |                | Yes             |           |       |
| [MapLocationDistance](../maplocationdistance_sort_clause/index.md)     | Distance between the location contained in a MapLocation field and the provided coordinates | Yes            | Yes             |           |       |
| [Path](../path_sort_clause/index.md)                                   | PathString of the Location                                                                  |                | Yes             | Yes       | Yes   |
| [Priority](../priority_sort_clause/index.md)                           | Location priority                                                                           |                | Yes             | Yes       | Yes   |
| [Random](../random_sort_clause/index.md)                               | Random seed                                                                                 | Yes            | Yes             |           |       |
| [Score](../score_sort_clause/index.md)                                 | Score of the search result                                                                  | Yes            | Yes             |           |       |
| [SectionIdentifier](../sectionidentifier_sort_clause/index.md)         | ID of the Section content is assigned to                                                    | Yes            | Yes             | Yes       |       |
| [SectionName](../sectionname_sort_clause/index.md)                     | Name of the Section content is assigned to                                                  | Yes            | Yes             | Yes       | Yes   |
| [UserLogin](../userlogin_sort_clause/index.md)                         | Login of the content item's creator                                                         |                |                 |           | Yes   |
| [Visibility](../visibility_sort_clause/index.md)                       | Whether the location is visible or not                                                      |                | Yes             | Yes       |       |
