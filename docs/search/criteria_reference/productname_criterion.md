---
description: ProductName Search Criterion
---

# ProductName Criterion

The `ProductName` Search Criterion searches for products by their names.

## Arguments

- `productName` - string representing the Product name, with `*` as wildcard

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request:

=== "XML"

    ```xml
    <ProductQuery>
        <Filter>
            <ProductNameCriterion>sofa*</ProductNameCriterion>
        </Filter>
    </ProductQuery>
    ```

=== "JSON"

    ```json
    {
        "ProductQuery": {
            "Filter": {
                "ProductNameCriterion": "sofa*"
            }
        }
    }
    ```
