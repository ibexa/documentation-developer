---
description: ProductAvailability Search Criterion
month_change: false
---

# ProductAvailability Criterion

The `ProductAvailability` Search Criterion searches for products by the availability flag, the boolean value set per product or variant.

To search for products that can be ordered, recreate the availability conditions with [existing product search criteria](product_search_criteria.md), for example LogicalAnd, LogicalOr, and [`ProductStock`](productstock_criterion.md).
For more information, see [Availability and computed availability](products.md#availability-and-computed-availability).

## Arguments

- (optional) `productAvailability` - bool representing whether the product is available (default `true`)

## Example

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
