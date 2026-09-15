---
description: ProductAvailability Search Criterion
month_change: false
---

# ProductAvailability Criterion

The `ProductAvailability` Search Criterion searches for products by the availability flag, the boolean value set per product or variant.

To search for products that can be ordered, combine this Criterion with other [product search criteria](product_search_criteria.md).
For more information, see [Availability and computed availability](products.md#availability-and-computed-availability).

## Arguments

- (optional) `productAvailability` - bool representing whether the product is available (default `true`)

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request:

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
