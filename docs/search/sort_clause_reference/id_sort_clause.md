# Id Sort Clause

The [`Location\Id` Sort Clause](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-Location-Id.html)
sorts search results by the ID of the Location.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\Location\Id()];
```
