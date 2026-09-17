---
description: AttributeGroupIdentifier Search Criterion
---

# AttributeGroupIdentifier Criterion

The `AttributeGroupIdentifier` Search Criterion searches for products by the value of their attribute group identifier.

## Arguments

- `value` - string representing the attribute's identifier

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /product/catalog/attributes/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product-Attribute/operation/ibexa.product_catalog.rest.attributes.view) request:

=== "XML"

    ```xml
    <AttributeQuery>
        <Query>
            <AttributeGroupIdentifier>attribute_group</AttributeGroupIdentifier>
        </Query>
    </AttributeQuery>
    ```

=== "JSON"

    ```json
    {
      "AttributeQuery": {
        "Query": {
          "AttributeGroupIdentifier": "attribute_group"
        }
      }
    }
    ```
