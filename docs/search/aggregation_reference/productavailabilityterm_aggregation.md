---
description: ProductAvailabilityTerm
---

# ProductAvailabilityTerm

The ProductAvailabilityTermAggregation aggregates search results by product availability (available/unavailable).

## Arguments

- `name` - name of the Aggregation object

## Example

You can use this Aggregation over the REST API, in the `Aggregations` element of the payload
of the [`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request:

``` json
"ProductQuery": {
    "Aggregations": [
        {
            "ProductAvailabilityTerm": {
                "name": "availability"
            }
        }
    ]
}
```
