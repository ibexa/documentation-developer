---
description: ProductCode Search Criterion
---

# ProductCode Criterion

The `ProductCode` Search Criterion searches for products by their codes.

## Arguments

- `productCode` - array of strings representing the product codes(s)

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request:

=== "XML"

```xml
<ProductQuery>
    <Filter>
        <ProductCodeCriterion>ski</ProductCodeCriterion>
        <ProductCodeCriterion>snowboard</ProductCodeCriterion>
    </Filter>
</ProductQuery>
```

=== "JSON"

    ```json
    {
        "ProductQuery": {
            "Filter": {
                "ProductCodeCriterion": [
                    "ski",
                    "snowboard"
                ]
            }
        }
    }
    ```
