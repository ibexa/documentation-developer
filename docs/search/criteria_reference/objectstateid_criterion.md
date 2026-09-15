---
description: ObjectStateId Search Criterion
---

# ObjectStateId Criterion

The `ObjectStateId` Search Criterion searches for content based on its object state ID.

## Arguments

- `value` - int(s) representing the object state ID(s)

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

=== "XML"

    ```xml
    <Query>
        <Filter>
            <ObjectStateIdCriterion>1</ObjectStateIdCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ObjectStateIdCriterion": "1"
        }
    }
    ```
