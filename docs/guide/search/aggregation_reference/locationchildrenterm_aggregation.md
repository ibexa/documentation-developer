# LocationChildrenTermAggregation

The [LocationChildrenTermAggregation](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Aggregation/Location/LocationChildrenTermAggregation.php) aggregates search results by the number of children of a Location.

## Arguments

- `name` - name of the Aggregation object

## Example

``` php
$query = new LocationQuery();
$query->aggregations[] = new Aggregation\Location\LocationChildrenTermAggregation('location_children');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
