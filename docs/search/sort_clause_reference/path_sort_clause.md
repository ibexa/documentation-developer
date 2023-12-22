# Path Sort Clause

The [`Location\Path` Sort Clause](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-Location-Path.html)
sorts search results by the pathString of the Location.

!!! note

    Solr search engine uses dictionary sorting with the `Location/Path` Sort Clause.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\Location\Path()];
```
