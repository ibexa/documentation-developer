# ProductAvailabilityTerm

The ProductAvailabilityTermAggregation aggregates search results by product availability (available/unavailable).

## Arguments

- `name` - name of the Aggregation object

## Limitations

`ProductAvailabilityTermAggregation` is not available in the Legacy Search engine.

## Example

``` php
$query = new ProductQuery();
$query->setAggregations([
    new ProductAvailabilityTermAggregation('product_availability'),
]);
```
