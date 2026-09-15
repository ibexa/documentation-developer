---
description: ColorAttribute Search Criterion
---

# ColorAttribute Criterion

The `ColorAttribute` Search Criterion searches for products by the value of their color attribute.

## Arguments

- `identifier` - string representing the attribute
- `value` - array of strings representing the attribute values

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request:

=== "XML"

    ```xml
    <ProductQuery>
        <Query>
            <ColorAttributeCriterion>
                <identifier>color</identifier>
                <value>#000000</value>
            </ColorAttributeCriterion>
        </Query>
    </ProductQuery>
    ```

=== "JSON"

    ```json
    {
      "ProductQuery": {
        "Query": {
          "ColorAttributeCriterion": {
                "identifier": "color",
                "value": ["#000000"]
            },
        }
      }
    }
    ```
