---
description: Sort Clauses help fine-tune sorting order when searching for content and Locations.
---

# Sort Clause reference

Sort Clauses are the sorting options for Content and Location Search and
[Repository filtering](search_api.md#repository-filtering).

Capabilities of individual Sort Clauses can depend on the search engine.

All Sort Clauses can take the following optional argument:

- `sortDirection` - the direction of the sorting, either `Query::SORT_ASC` (default) or `Query::SORT_DESC`

## Sort Clauses 

| Sort Clause | Sorting based on | Supported by |
|-----|-----|-----|
|[ContentId](contentid_sort_clause.md)|Content items' ID|Content and Location Search, and Filtering|
|[ContentName](contentname_sort_clause.md)|Content names|Content and Location Search, and Filtering|
|[ContentTranslatedName](contenttranslatedname_sort_clause.md)|Translated content names|Content and Location Search|
|[CustomField](customfield_sort_clause.md)|Raw search index fields|Content and Location Search|
|[DateModified](datemodified_sort_clause.md)|The date when content was last modified|Content and Location Search, and Filtering|
|[DatePublished](datepublished_sort_clause.md)|The date when content was created|Content and Location Search, and Filtering|
|[Depth](depth_sort_clause.md)|Location depth in the Content tree|Location Search, Filtering|
|[Field](field_sort_clause.md)|Content of one of Content item's Fields|Content and Location Search|
|[Id](id_sort_clause.md)|Location ID|Location Search, Filtering|
|[IsMainLocation](ismainlocation_sort_clause.md)|Whether a Location is the main Location of a Content item|Location only|
|[MapLocationDistance](maplocationdistance_sort_clause.md)|Distance between the location contained in a MapLocation Field and the provided coordinates|Content and Location Search|
|[Path](path_sort_clause.md)|PathString of the Location|Location Search, Filtering|
|[Priority](priority_sort_clause.md)|Location priority|Location Search, Filtering|
|[Random](random_sort_clause.md)|Random seed|Content and Location Search|
|[Score](score_sort_clause.md)|Score of the search result|Content and Location Search|
|[SectionIdentifier](sectionidentifier_sort_clause.md)|ID of the Section content is assigned to|Content and Location Search, and Filtering|
|[SectionName](sectionname_sort_clause.md)|Name of the Section content is assigned to|Content and Location Search, and Filtering|
|[Visibility](visibility_sort_clause.md)|Whether the Location is visible or not|Location Search, Filtering|

### Product search

| Sort Clause | Sorting based on | Supported by |
|-----|-----|-----|
|[BasePrice](baseprice_sort_clause.md)|Base product price|Product search|
|[CreatedAt](createdat_sort_clause.md)|Date and time of the creation of a product.|Product search|
|[CustomPrice](customprice_sort_clause.md)|Custom product price|Product search|
|[ProductAvailability](productavailability_sort_clause.md)|Product's availability|Content and Location Search; Filtering|
|[ProductCode](productcode_sort_clause.md)|Product's code|Content and Location Search; Filtering|
|[ProductName](productname_sort_clause.md)|Product's name|Content and Location Search; Filtering|
