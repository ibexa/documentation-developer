---
description: ProductCode Sort Clause
---

# ProductCode Sort Clause

The `ProductCode` Sort Clause sorts search results by the product code.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

You can use this Sort Clause over the REST API, in the `SortClauses` element of the payload of the [`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request:

=== "XML"

    ```xml
    <ProductQuery>
        <SortClauses>
            <ProductCode>ascending</ProductCode>
        </SortClauses>
    </ProductQuery>
    ```

=== "JSON"

    ```json
    "ProductQuery": {
        "SortClauses": {
            "ProductCode": "ascending"
        }
    }
    ```
