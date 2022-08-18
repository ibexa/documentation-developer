# Random Sort Clause

The [`Random` Sort Clause](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/SortClause/Random.php)
orders search results randomly.

## Arguments

- `seed` (optional) - int representing the random seed
- `sortDirection` (optional) - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`.

## Limitations

The `Random` Sort Clause is not available in [Repository filtering](search_api.md#repository-filtering).
In Elasticsearch engine, you cannot combine the `Random` Sort Clause with any other Sort Clause.

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\Random()];
```
