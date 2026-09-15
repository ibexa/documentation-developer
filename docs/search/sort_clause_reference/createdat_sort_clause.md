---
description: CreatedAt Sort Clause
---

# CreatedAt Sort Clause

The `CreatedAt` Sort Clause sorts search results by the date and time of the creation of a product.

## Arguments

- (optional) sorting direction, either `ascending` (default) or `descending`

## Example

You can use this Sort Clause over the REST API, in the `SortClauses` element of the payload of the [`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request:

=== "XML"

    ```xml
    <ProductQuery>
        <SortClauses>
            <CreatedAt>ascending</CreatedAt>
        </SortClauses>
    </ProductQuery>
    ```

=== "JSON"

    ```json
    "ProductQuery": {
        "SortClauses": {
            "CreatedAt": "ascending"
        }
    }
    ```
