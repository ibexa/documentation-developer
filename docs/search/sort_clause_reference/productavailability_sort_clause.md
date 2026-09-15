---
description: ProductAvailability Sort Clause
---

# ProductAvailability Sort Clause

The `ProductAvailability` Sort Clause sorts search results by whether they have availability or not.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

You can use this Sort Clause over the REST API, in the `SortClauses` element of the payload of the [`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request:

=== "XML"

    ```xml
    <ProductQuery>
        <SortClauses>
            <ProductAvailability>ascending</ProductAvailability>
        </SortClauses>
    </ProductQuery>
    ```

=== "JSON"

    ```json
    "ProductQuery": {
        "SortClauses": {
            "ProductAvailability": "ascending"
        }
    }
    ```
