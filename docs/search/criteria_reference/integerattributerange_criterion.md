---
description: IntegerAttributeRange Search Criterion
---

# IntegerAttributeRange Criterion

The `IntegerAttributeRange` Search Criterion searches for products by the range of values of their integer attribute.

## Arguments

- `identifier` - string representing the attribute
- `min` - indicating the beginning of the range
- `max` - indicating the end of the date range

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request:

=== "XML"

    ```xml
    <ProductQuery>
        <Query>
            <IntegerAttributeRangeCriterion>
                <identifier>length</identifier>
                <min>16</min>
                <max>25</max>
            </IntegerAttributeRangeCriterion>
        </Query>
    </ProductQuery>
    ```

=== "JSON"

    ```json
    {
        "ProductQuery": {
            "Query": {
                "IntegerAttributeRangeCriterion": {
                    "identifier": "length",
                    "min": 16,
                    "max": 25
                }
            }
        }
    }
    ```
