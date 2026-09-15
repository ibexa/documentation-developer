---
description: ProductPriceRangeAggregation
---

# ProductPriceRangeAggregation

The ProductPriceRangeAggregation aggregates search results by the value of the product's price.

## Arguments

- `name` - name of the Aggregation
- `currencyCode` - currency code of the price
- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

You can use this Aggregation over the REST API, in the `Aggregations` element of the payload
of the [`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request:

``` json
"ProductQuery": {
    "Aggregations": [
        {
            "ProductPriceRange": {
                "name": "price",
                "currencyCode": "EUR",
                "ranges": [
                    {
                        "from": 0,
                        "to": 100
                    },
                    {
                        "from": 100,
                        "to": null
                    }
                ]
            }
        }
    ]
}
```
