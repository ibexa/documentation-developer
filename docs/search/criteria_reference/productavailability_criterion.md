---
description: ProductAvailability Search Criterion
month_change: false
---

# ProductAvailability Criterion

The `ProductAvailability` Search Criterion searches for products by the availability flag, the boolean value set per product or variant.

To search for products that can be ordered, recreate the availability conditions with [existing product search criteria](product_search_criteria.md), for example [LogicalAnd](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-Query-Criterion-LogicalAnd.html), [LogicalOr](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-Query-Criterion-LogicalOr.html), and [`ProductStock`](productstock_criterion.md).
To recreate complex [custom availability strategies](create_custom_availability_strategy.md), you might need to implement [custom search criteria](search_criteria_and_sort_clauses.md#custom-criteria-and-sort-clauses) for the conditions not covered by the built-in ones.

For more information, see [Availability and computed availability](products.md#availability-and-computed-availability).

## Arguments

- (optional) `productAvailability` - bool representing whether the product is available (default `true`)

## Example

### PHP

``` php
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion;

$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductAvailability(true)
);
```

### REST API

=== "XML"

    ```xml
    <ProductQuery>
        <Filter>
            <ProductAvailabilityCriterion>false</ProductAvailabilityCriterion
        </Filter>
    </ProductQuery>
    ```

=== "JSON"

    ```json
    {
        "ProductQuery": {
            "Filter": {
                "ProductAvailabilityCriterion": false
            }
        }
    }
    ```
