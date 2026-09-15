---
description: IsVirtual Search Criterion
---

# IsVirtual Criterion

The `IsVirtual` Search Criterion searches for virtual or physical products.

## Arguments

- (optional) `isVirtual` - bool representing whether to search for virtual (default `true`) or physical (`false`) products.

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request:

=== "XML"

    ```xml
    <ProductQuery>
        <Filter>
            <IsVirtualCriterion>true</IsVirtualCriterion>
        </Filter>
    </ProductQuery>
    ```

=== "JSON"

    ```json
    "ProductQuery": {
        "Filter": {
            "IsVirtualCriterion": true
        }
    }
    ```
