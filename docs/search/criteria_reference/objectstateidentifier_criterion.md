---
description: ObjectStateIdentifier Search Criterion
---

# ObjectStateIdentifier Criterion

The `ObjectStateIdentifier` Search Criterion searches for content based on its object state identifier.

## Arguments

- `value` - string(s) representing the object state identifier(s)
- `target` - string representing the object state group

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

=== "XML"

    ```xml
    <Query>
        <Filter>
            <ObjectStateIdentifierCriterion>
                <value>not_locked</value>
                <target>ibexa_lock</target>
            </ObjectStateIdentifierCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    {
      "Query": {
        "Filter": {
          "ObjectStateIdentifierCriterion": {
            "value": "not_locked",
            "target": "ibexa_lock"
          }
        }
      }
    }
    ```
