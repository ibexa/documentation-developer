# Path Sort Clause

The [`Location\Path` Sort Clause](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/Query/SortClause/Location/Path.php)
sorts search results by the pathString of the Location.

!!! note

    Solr search engine uses dictionary sorting with the `Location/Path` Sort Clause.

## Arguments

- `sortDirection` (optional) - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`.

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\Location\Path()];
```
