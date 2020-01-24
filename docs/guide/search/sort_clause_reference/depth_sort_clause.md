# Depth Sort Clause

The [`Location\Depth` Sort Clause](https://github.com/ezsystems/ezpublish-kernel/blob/v8.0.0-beta3/eZ/Publish/API/Repository/Values/Content/Query/SortClause/Location/Depth.php)
sorts search results by the depth of the Location in the Content tree.

## Arguments

- `sortDirection` (optional) - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`.

## Example

``` php
$query = new LocationQuery;
$query->sortClauses = [new SortClause\Depth()];
```
