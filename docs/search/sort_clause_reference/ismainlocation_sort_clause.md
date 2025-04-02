---
description: IsMainLocation Sort Clause
---

# IsMainLocation Sort Clause

The [`Location\IsMainLocation` Sort Clause](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-Location-IsMainLocation.html) sorts search results by whether their location is the main location of the content item.

Locations that aren't main locations are ranked as lower values (for example, with ascending order they're returned first).

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Limitations

The `Location\IsMainLocation` Sort Clause isn't available in [Repository filtering](search_api.md#repository-filtering).

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\Location\InMainLocation()];
```
