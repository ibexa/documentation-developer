# Path Sort Clause

The [`Location\Path` Sort Clause](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/SortClause/Location/Path.php)
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
