# MapLocationDistance Criterion

`MapLocationDistance` Search Criterion searches content based on the distance between the location
contained in a MapLocation Field and the provided coordinates.

## Arguments

- `target` - string representing the Field definition identifier
- `operator` - Operator constant (IN, EQ, GT, GTE, LT, LTE, BETWEEN)
- `distance` - float(s) representing the distances between the map location in the Field and the location provided in `latitude` and `longitude` arguments
- `latitude` - float representing the latitude of the location to calculate distance to
- `longitude` - float representing the longitude of the location to calculate distance to

## Example

``` php
$query->query = new Criterion\MapLocationDistance('location', Criterion\Operator::LTE, 5, 51.395973, 22.531696);
```
