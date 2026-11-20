# ProductCategory Criterion

ProductCategory Search Criterion

The `ProductCategory` Search Criterion searches for products by the category they're assigned to.

## Arguments

- `taxonomyEntries` - array of ints representing category IDs

## Example

### PHP

```php
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion;

$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductCategory([2, 3])
);
```

### REST API

**XML**

```xml
<ProductQuery>
    <Filter>
        <ProductCategoryCriterion>[2, 3]</ProductCategoryCriterion>
    </Filter>
</ProductQuery>
```

**JSON**

```json
{
    "ProductQuery": {
        "Filter": {
            "ProductCategoryCriterion": [
                2,
                3
            ]
        }
    }
}
```
