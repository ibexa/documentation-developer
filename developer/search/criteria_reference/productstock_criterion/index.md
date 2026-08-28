# ProductStock Criterion

ProductStock Search Criterion

The `ProductStock` Search Criterion searches for products by their numerical stock.

## Arguments

- `value` - the numerical stock to search for
- (optional) `operator` - operator string (`=` `<` `<=` `>` `>=`)

## Example

### PHP

```php
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion;

$productQuery = new ProductQuery(
    null,
    new Criterion\ProductStock(10)
);
```

```php
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion;

$productQuery = new ProductQuery(
    null,
    new Criterion\ProductStock(50, '>=')
);
```
