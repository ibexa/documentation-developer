# ProductName Criterion

ProductName Search Criterion

The `ProductName` Search Criterion searches for products by their names.

## Arguments

- `productName` - string representing the Product name, with `*` as wildcard

## Example

### PHP

```php
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion;

$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductName('sofa*')
);
```

### REST API

**XML**

```xml
<ProductQuery>
    <Filter>
        <ProductNameCriterion>sofa*</ProductNameCriterion>
    </Filter>
</ProductQuery>
```

**JSON**

```json
{
    "ProductQuery": {
        "Filter": {
            "ProductNameCriterion": "sofa*"
        }
    }
}
```
