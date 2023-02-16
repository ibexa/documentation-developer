# Score Sort Clause

The [`Score` Sort Clause](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/SortClause/Score.php)
orders search results by their score.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Limitations

The `Score` Sort Clause is not available in [Repository filtering](search_api.md#repository-filtering).

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\Score()];
```
