---
description: FloatAttributeRange Search Criterion
---

# FloatAttributeRange Criterion

The `FloatAttributeRange` Search Criterion searches for products by the range of values of their float attribute.

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
            <FloatAttributeRangeCriterion>
                <identifier>length</identifier>
                <min>16.5</min>
                <max>25</max>
            </FloatAttributeRangeCriterion>
        </Query>
    </ProductQuery>
    ```

=== "JSON"

    ```json
    {
        "ProductQuery": {
            "Query": {
                "FloatAttributeRangeCriterion": {
                    "identifier": "length",
                    "min": 16.5,
                    "max": 25
                }
            }
        }
    }
    ```
