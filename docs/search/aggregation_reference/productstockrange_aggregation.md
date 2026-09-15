---
description: ProductStockRangeAggregation
---

# ProductStockRangeAggregation

The ProductStockRangeAggregation aggregates search results by products' numerical stock.

## Arguments

- `name` - name of the Aggregation
- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

You can use this Aggregation over the REST API, in the `Aggregations` element of the payload
of the [`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request:

``` json
"ProductQuery": {
    "Aggregations": [
        {
            "ProductStockRange": {
                "name": "stock",
                "ranges": [
                    {
                        "from": 0,
                        "to": 10
                    },
                    {
                        "from": 10,
                        "to": null
                    }
                ]
            }
        }
    ]
}
```
