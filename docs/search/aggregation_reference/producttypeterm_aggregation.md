---
description: ProductTypeTerm
---

# ProductTypeTerm

The ProductTypeTermAggregation aggregates search results by the product type.

## Arguments

- `name` - name of the Aggregation object

## Example

You can use this Aggregation over the REST API, in the `Aggregations` element of the payload
of the [`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request:

``` json
"ProductQuery": {
    "Aggregations": [
        {
            "ProductTypeTerm": {
                "name": "product_types"
            }
        }
    ]
}
```
