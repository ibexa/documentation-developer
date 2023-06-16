# ProductStockRangeAggregation

The ProductStockRangeAggregation aggregates search results by products' numerical stock.

## Arguments

- `name` - name of the Aggregation
- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

``` php
$productQuery = new ProductQuery();
$productQuery->setAggregations([
    new ProductStockRangeAggregation('stock', [
        new Range(null, 10),
        new Range(10, 100),
        new Range(100, null),
    ]),
]);
```
