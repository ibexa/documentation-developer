# ProductAvailabilityTerm

The ProductAvailabilityTermAggregation aggregates search results by product availability (available/unavailable).

## Arguments

- `name` - name of the Aggregation object

## Example

``` php
$query = new ProductQuery();
$query->setAggregations([
    new ProductAvailabilityTermAggregation('product_availability'),
]);
```
