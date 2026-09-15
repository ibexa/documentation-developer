---
description: ProductType Search Criterion
---

# ProductType Criterion

The `ProductType` Search Criterion searches for products by their codes.

## Arguments

- `productType` - array of strings representing the product type(s)

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request:

=== "XML"

    ```xml
    <ProductQuery>
        <Filter>
            <ProductTypeCriterion>desk</ProductTypeCriterion>
        </Filter>
    </ProductQuery>
    ```

=== "JSON"

    ```json
    {
        "ProductQuery": {
            "Filter": {
                "ProductTypeCriterion": "desk"
            }
        }
    }
    ```
