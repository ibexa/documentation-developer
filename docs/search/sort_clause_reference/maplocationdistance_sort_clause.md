---
description: MapLocationDistance Sort Clause
---

# MapLocationDistance Sort Clause

The `MapLocationDistance` Sort Clause sorts search results by the distance of the indicated MapLocation field to the provided location.

## Arguments

- `typeIdentifier` - string representing the identifier of the content type to which the MapLocation field belongs
- `fieldIdentifier` - string representing the identifier of the MapLocation field to sort by
- `latitude` - float representing the latitude of the location to calculate distance to
- `longitude`- float representing the longitude of the location to calculate distance to [[= include_file('docs/snippets/sort_direction.md') =]]
