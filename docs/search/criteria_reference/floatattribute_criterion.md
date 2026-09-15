---
description: FloatAttribute Search Criterion
---

# FloatAttribute Criterion

The `FloatAttribute` Search Criterion searches for products by the value of their float attribute.

## Arguments

- `identifier` - string representing the attribute
- `value` - string representing the attribute value

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request:

=== "XML"

    ```xml
    <ProductQuery>
        <Query>
            <FloatAttributeCriterion>
                <identifier>length</identifier>
                <value>16.5</value>
            </FloatAttributeCriterion>
        </Query>
    </ProductQuery>
    ```

=== "JSON"

    ```json
    {
        "ProductQuery": {
            "Query": {
                "FloatAttributeCriterion": {
                    "identifier": "length",
                    "value": 16.5
                }
            }
        }
    }
    ```
