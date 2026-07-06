---
description: ProductStockRange Search Criterion
---

# ProductStockRange Criterion

The `ProductStockRange` Search Criterion searches for products by their numerical stock.

## Arguments

- `min` - minimum stock
- `max` - maximum stock

## Example

### PHP

``` php {skip-validation}
$productQuery = new ProductQuery(
    null,
    new Criterion\ProductStockRange(10, 120)
);
```
