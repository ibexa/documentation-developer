---
description: AttributeName Search Criterion
---

# AttributeName Criterion

The `AttributeName` Search Criterion searches for products by the value of their attribute name.

## Arguments

- `value` - string representing the attribute's name

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /product/catalog/attributes/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product-Attribute/operation/ibexa.product_catalog.rest.attributes.view) request:

=== "XML"

    ```xml
    <AttributeQuery>
        <Query>
            <AttributeNameCriterion>measure</AttributeNameCriterion>
        </Query>
    </AttributeQuery>
    ```

=== "JSON"

    ```json
    {
      "AttributeQuery": {
        "Query": {
          "AttributeNameCriterion": "measure"
        }
      }
    }
    ```
