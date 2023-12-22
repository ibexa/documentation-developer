# Depth Sort Clause

The [`Location\Depth` Sort Clause](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-Location-Depth.html)
sorts search results by the depth of the Location in the Content tree.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\Depth()];
```
