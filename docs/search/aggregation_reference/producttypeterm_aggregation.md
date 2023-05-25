# ProductTypeTerm

The ProductTypeTermAggregation aggregates search results by the product type.

## Arguments

- `name` - name of the Aggregation object

## Example

``` php
$query = new ProductQuery();
$query->setAggregations([
    new ProductTypeTermAggregation('product_type'),
]);
```
