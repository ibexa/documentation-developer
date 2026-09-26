# IsVirtual Criterion

IsVirtual Search Criterion

The `IsVirtual` Search Criterion searches for virtual or physical products.

## Arguments

- (optional) `isVirtual` - bool representing whether to search for virtual (default `true`) or physical (`false`) products.

## Example

### PHP

```php
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion;

$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\IsVirtual(true)
);
```

### REST API

**XML**

```xml
<ProductQuery>
    <Filter>
        <IsVirtualCriterion>true</IsVirtualCriterion>
    </Filter>
</ProductQuery>
```

**JSON**

```json
"ProductQuery": {
    "Filter": {
        "IsVirtualCriterion": true
    }
}
```
