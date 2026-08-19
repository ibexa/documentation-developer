---
description: ProductStockRangeAggregation
---

# ProductStockRangeAggregation

The ProductStockRangeAggregation aggregates search results by products' numerical stock.

## Arguments

- `name` - name of the Aggregation
- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Range;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Aggregation\ProductStockRangeAggregation;

$productQuery = new ProductQuery();
$productQuery->setAggregations([
    new ProductStockRangeAggregation('stock', [
        Range::ofInt(null, 10),
        Range::ofInt(10, 100),
        Range::ofInt(100, null),
    ]),
]);
```
