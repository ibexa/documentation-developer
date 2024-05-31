# Visibility Sort Clause

The [`Location\Visibility` Sort Clause](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-Location-Visibility.html)
sorts search results by whether the Location is visible or not.

Locations that are not visible are ranked as higher values (e.g. with ascending order they will be returned last).

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\Location\Visibility()];
```
