# IsMainLocation Sort Clause

The [`Location\IsMainLocation` Sort Clause](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/SortClause/Location/IsMainLocation.php)
sorts search results by whether their Location is the main Location of the Content item.

Locations that are not main Locations are ranked as lower values (e.g. with ascending order they will be returned first).

## Arguments

- `sortDirection` (optional) - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`.

## Limitations

The `Location\IsMainLocation` Sort Clause is not available in [Repository filtering](search_api.md#repository-filtering).

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\Location\InMainLocation()];
```
