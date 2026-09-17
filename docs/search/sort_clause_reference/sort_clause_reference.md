---
description: Sort Clauses help fine-tune sorting order when searching for content and locations.
page_type: reference
month_change: false
---

# Sort Clause reference

Sort Clauses are the sorting options for content and location search.

You use them over the REST API, in the `SortClauses` element of the payload of the
[`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request.

All Sort Clauses take the sorting direction as their value, either `ascending` (default) or `descending`.

## Sort Clauses

| Sort Clause                                                   | Sorting based on                                                                           | Content Search | Location Search | Filtering |
|---------------------------------------------------------------|--------------------------------------------------------------------------------------------|----------------|-----------------|-----------|
| [ContentId](contentid_sort_clause.md)                         | Content items' ID                                                                          | &#10004;       | &#10004;        | &#10004;  |
| [ContentName](contentname_sort_clause.md)                     | Content names                                                                              | &#10004;       | &#10004;        | &#10004;  |
| [DateModified](datemodified_sort_clause.md)                   | The date when content was last modified                                                    | &#10004;       | &#10004;        | &#10004;  |
| [DatePublished](datepublished_sort_clause.md)                 | The date when content was created                                                          | &#10004;       | &#10004;        | &#10004;  |
| [Depth](depth_sort_clause.md)                                 | Location depth in the content tree                                                         |                | &#10004;        | &#10004;  |
| [Field](field_sort_clause.md)                                 | Content of one of content item's fields                                                    | &#10004;       | &#10004;        |           |
| [Id](id_sort_clause.md)                                       | Location ID                                                                                |                | &#10004;        | &#10004;  |
| [Path](path_sort_clause.md)                                   | PathString of the Location                                                                 |                | &#10004;        | &#10004;  |
| [Priority](priority_sort_clause.md)                           | Location priority                                                                          |                | &#10004;        | &#10004;  |
| [Score](score_sort_clause.md)                                 | Score of the search result                                                                 | &#10004;       | &#10004;        |           |
| [SectionIdentifier](sectionidentifier_sort_clause.md)         | ID of the Section content is assigned to                                                   | &#10004;       | &#10004;        | &#10004;  |
| [SectionName](sectionname_sort_clause.md)                     | Name of the Section content is assigned to                                                 | &#10004;       | &#10004;        | &#10004;  |
