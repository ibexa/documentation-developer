# Sort Clause reference

Sort Clauses are the sorting options for Content and Location Search and
[Repository filtering](../../api/public_php_api_filtering.md).

Capabilities of individual Sort Clauses can depend on the search engine.

All Sort Clauses can take the following optional argument:

- `sortDirection` - the direction of the sorting, either `Query::SORT_ASC` (default) or `Query::SORT_DESC`

#### Sort Clauses 

| Sort Clause | Sorting based on | Supported by |
|-----|-----|-----|
|[ContentId](sort_clause_reference/contentid_sort_clause.md)|Content items' ID|Content & Location Search, Filtering|
|[ContentName](sort_clause_reference/contentname_sort_clause.md)|Content names|Content & Location Search, Filtering|
|[DateModified](sort_clause_reference/datemodified_sort_clause.md)|The date when content was last modified|Content & Location Search, Filtering|
|[DatePublished](sort_clause_reference/datepublished_sort_clause.md)|The date when content was created|Content & Location Search, Filtering|
|[Depth](sort_clause_reference/depth_sort_clause.md)|Location depth in the Content tree|Location Search, Filtering|
|[Field](sort_clause_reference/field_sort_clause.md)|Content of one of Content item's Fields|Content & Location Search|
|[Id](sort_clause_reference/id_sort_clause.md)|Location ID|Location Search, Filtering|
|[IsMainLocation](sort_clause_reference/ismainlocation_sort_clause.md)|Whether a Location is the main Location of a Content item|Location only|
|[MapLocationDistance](sort_clause_reference/maplocationdistance_sort_clause.md)|Distance between the location contained in a MapLocation Field and the provided coordinates|Content & Location Search|
|[Path](sort_clause_reference/path_sort_clause.md)|PathString of the Location|Location Search, Filtering|
|[Priority](sort_clause_reference/priority_sort_clause.md)|Location priority|Location Search, Filtering|
|[Random](sort_clause_reference/random_sort_clause.md)|Random seed|Content & Location Search|
|[SectionIdentifier](sort_clause_reference/sectionidentifier_sort_clause.md)|ID of the Section content is assigned to|Content & Location Search, Filtering|
|[SectionName](sort_clause_reference/sectionname_sort_clause.md)|Name of the Section content is assigned to|Content & Location Search, Filtering|
|[Visibility](sort_clause_reference/visibility_sort_clause.md)|Whether the Location is visible or not|Location Search, Filtering|
