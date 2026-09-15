---
description: ProductCategory Search Criterion
---

# ProductCategory Criterion

The `ProductCategory` Search Criterion searches for products by the category they're assigned to.

## Arguments

- `taxonomyEntries` - array of ints representing category IDs

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request:

=== "XML"

    ```xml
    <ProductQuery>
        <Filter>
            <ProductCategoryCriterion>[2, 3]</ProductCategoryCriterion>
        </Filter>
    </ProductQuery>
    ```

=== "JSON"

    ```json
    {
        "ProductQuery": {
            "Filter": {
                "ProductCategoryCriterion": [
                    2,
                    3
                ]
            }
        }
    }
    ```
