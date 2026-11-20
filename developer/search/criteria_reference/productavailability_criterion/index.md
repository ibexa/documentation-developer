# ProductAvailability Criterion

ProductAvailability Search Criterion

The `ProductAvailability` Search Criterion searches for products by the availability flag, the boolean value set per product or variant.

To search for products that can be ordered, recreate the availability conditions with [existing product search criteria](../product_search_criteria/index.md), for example [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\LogicalAnd`](../../../../../../ibexa/product-catalog/src/contracts/Values/Product/Query/Criterion/LogicalAnd.php), [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\LogicalOr`](../../../../../../ibexa/product-catalog/src/contracts/Values/Product/Query/Criterion/LogicalOr.php), and [`ProductStock`](../productstock_criterion/index.md). To recreate complex [custom availability strategies](../../../product_catalog/create_custom_availability_strategy/index.md), you might need to implement [custom search criteria](../../search_criteria_and_sort_clauses/index.md#custom-criteria-and-sort-clauses) for the conditions not covered by the built-in ones.

For more information, see [Availability and computed availability](../../../product_catalog/products/index.md#availability-and-computed-availability).

## Arguments

- (optional) `productAvailability` - bool representing whether the product is available (default `true`)

## Example

### PHP

```php
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion;

$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductAvailability(true)
);
```

### REST API

**XML**

```xml
<ProductQuery>
    <Filter>
        <ProductAvailabilityCriterion>false</ProductAvailabilityCriterion
    </Filter>
</ProductQuery>
```

**JSON**

```json
{
    "ProductQuery": {
        "Filter": {
            "ProductAvailabilityCriterion": false
        }
    }
}
```
