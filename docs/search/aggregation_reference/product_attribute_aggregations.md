---
description: Product attribute aggregations aggregate search results by the value of the product's attributes.
---

# Product attribute aggregations

Product attribute aggregations aggregate search results by the value of the product's attributes.

You use them over the REST API, in the `Aggregations` element of the payload of the
[`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request.

Depending on the attribute type, the following aggregations are available:

| Name | Type | Based on attribute type |
|---|---|---|
| `AttributeBooleanTerm` | Term | Checkbox |
| `AttributeColorTerm` | Term | Color |
| `AttributeFloatRange` | Range | Float |
| `AttributeFloatStats` | Stats | Float |
| `AttributeIntegerRange` | Range | Integer |
| `AttributeIntegerStats` | Stats | Integer |
| `AttributeSelectionTerm` | Term | Selection |

## Arguments

- `name` - name of the Aggregation
- `attributeDefinitionIdentifier` - identifier of the attribute

Range aggregations (`AttributeFloatRange` and `AttributeIntegerRange`) additionally take:

- `ranges` - array of ranges that define the borders of the specific range sets

## Example

``` json
"ProductQuery": {
    "Aggregations": [
        {
            "AttributeSelectionTerm": {
                "name": "size",
                "attributeDefinitionIdentifier": "size"
            }
        },
        {
            "AttributeIntegerRange": {
                "name": "length",
                "attributeDefinitionIdentifier": "length",
                "ranges": [
                    {
                        "from": null,
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
