---
description: MapLocationDistance Sort Clause
---

# MapLocationDistance Sort Clause

The [`MapLocationDistance` Sort Clause](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-MapLocationDistance.html) sorts search results by the distance of the indicated MapLocation field to the provided location.

## Arguments

- `typeIdentifier` - string representing the identifier of the content type to which the MapLocation field belongs
- `fieldIdentifier` - string representing the identifier of the MapLocation field to sort by
- `latitude` - float representing the latitude of the location to calculate distance to
- `longitude`- float representing the longitude of the location to calculate distance to [[= include_file('docs/snippets/sort_direction.md') =]]

## Limitations

The `MapLocationDistance` Sort Clause isn't available in [Repository filtering](search_api.md#repository-filtering).

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\MapLocationDistance('place', 'location', 49.542889, 20.111349)];
```
