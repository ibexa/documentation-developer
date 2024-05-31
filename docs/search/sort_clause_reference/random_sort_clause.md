# Random Sort Clause

The [`Random` Sort Clause](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-Random.html)
orders search results randomly.

## Arguments

- (optional) `seed` - int representing the random seed
[[= include_file('docs/snippets/sort_direction.md') =]]

## Limitations

The `Random` Sort Clause is not available in [Repository filtering](search_api.md#repository-filtering).
In Elasticsearch engine, you cannot combine the `Random` Sort Clause with any other Sort Clause.

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\Random()];
```
