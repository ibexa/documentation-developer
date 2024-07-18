# LocationChildrenTermAggregation

The [LocationChildrenTermAggregation](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Aggregation-Location-LocationChildrenTermAggregation.html) aggregates search results by the number of children of a Location.

## Arguments

- `name` - name of the Aggregation object

## Example

``` php
$query = new LocationQuery();
$query->aggregations[] = new Aggregation\Location\LocationChildrenTermAggregation('location_children');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
