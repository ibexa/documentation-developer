# Sort Clause reference

Sort Clauses are the sorting options for Content and Location Search.

A Sort Clause consists of two parts:

- The API Value: `SortClause`
- Specific handler per search engine: `SortClausesHandler`

`SortClause` represents the value you use in the API, while `SortClauseHandler` deals with the business logic in the background,
translating the value to something the search engine can understand.

Capabilities of individual Sort Clauses can depend on the search engine.

All Sort Clauses can take the following optional argument:

- `sortDirection` - the direction of the sorting, either `Query::SORT_ASC` (default) or `Query::SORT_DESC`

#### Sort Clauses 

| Sort Clause | Sorting based on | Search type|
|-----|-----|-----|
|[ContentId](sort_clause_reference/contentid_sort_clause.md)||Content and Location|
|[ContentName](sort_clause_reference/contentname_sort_clause.md)||Content and Location|
|[DateModified](sort_clause_reference/datemodified_sort_clause.md)||Content and Location|
|[DatePublished](sort_clause_reference/datepublished_sort_clause.md)||Content and Location|
|[Depth](sort_clause_reference/depth_sort_clause.md)||Location only|
|[Field](sort_clause_reference/field_sort_clause.md)||Content and Location|
|[Id](sort_clause_reference/id_sort_clause.md)||Location only|
|[IsMainLocation](sort_clause_reference/ismainlocation_sort_clause.md)||Location only|
|[MapLocationDistance](sort_clause_reference/maplocationdistance_sort_clause.md)||Content and Location|
|[Path](sort_clause_reference/path_sort_clause.md)||Location only|
|[Priority](sort_clause_reference/priority_sort_clause.md)||Location only|
|[Random](sort_clause_reference/random_sort_clause.md)||Content and Location|
|[SectionIdentifier](sort_clause_reference/sectionidentifier_sort_clause.md)||Content and Location|
|[SectionName](sort_clause_reference/sectionname_sort_clause.md)||Content and Location|
|[Visibility](sort_clause_reference/visibility_sort_clause.md)||Location only|
