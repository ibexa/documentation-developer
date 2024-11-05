# Score Sort Clause

The [`Score` Sort Clause](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-Score.html)
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
