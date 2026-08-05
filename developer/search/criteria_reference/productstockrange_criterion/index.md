# ProductStockRange Criterion

ProductStockRange Search Criterion

The `ProductStockRange` Search Criterion searches for products by their numerical stock.

## Arguments

- `min` - minimum stock
- `max` - maximum stock

## Example

### PHP

```php
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion;

$productQuery = new ProductQuery(
    null,
    new Criterion\ProductStockRange(10, 120)
);
```
