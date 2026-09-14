---
description: MapLocationDistance Search Criterion
---

# MapLocationDistance Criterion

The `MapLocationDistance` Search Criterion searches content based on the distance between the location contained in a MapLocation field and the provided coordinates.

## Arguments

- `target` - string representing the field definition identifier
- `operator` - Operator constant (IN, EQ, GT, GTE, LT, LTE, BETWEEN)
- `distance` - float(s) representing the distances between the map location in the field and the location provided in `latitude` and `longitude` arguments
- `latitude` - float representing the latitude of the location to calculate distance to
- `longitude` - float representing the longitude of the location to calculate distance to

The `distance` argument requires:

- a list of floats for `Operator::IN` or `Operator::BETWEEN`
- a single float for other Operators
