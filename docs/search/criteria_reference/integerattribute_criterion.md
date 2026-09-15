---
description: IntegerAttribute Search Criterion
---

# IntegerAttribute Criterion

The `IntegerAttribute` Search Criterion searches for products by the value of their integer attribute.

## Arguments

- `identifier` - string representing the attribute
- `value` - string representing the attribute value

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request:

=== "XML"

    ```xml
    <ProductQuery>
        <Query>
            <IntegerAttributeCriterion>
                <identifier>size</identifier>
                <value>38</value>
            </IntegerAttributeCriterion>
        </Query>
    </ProductQuery>
    ```

=== "JSON"

    ```json
    {
        "ProductQuery": {
            "Query": {
                "IntegerAttributeCriterion": {
                    "identifier": "size",
                    "value": 38
                }
            }
        }
    }
    ```
