# ProductTypeTerm

The ProductTypeTermAggregation aggregates search results by the product type.

## Arguments

- `name` - name of the Aggregation object

## Limitations

`ProductTypeTermAggregation` is not available in the Legacy Search engine.

## Example

``` php
$query = new ProductQuery();
$query->setAggregations([
    new ProductTypeTermAggregation('product_type'),
]);
```
