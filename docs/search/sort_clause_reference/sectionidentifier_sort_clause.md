# SectionIdentifier Sort Clause

The [`SectionIdentifier` Sort Clause](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-SectionIdentifier.html)
sorts search results by the Section IDs of the Content items.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

!!! note

    Solr search engine uses the `Query::SORT_DESC` sort direction by default.

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\SectionIdentifier()];
```
