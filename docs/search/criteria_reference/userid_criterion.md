---
description: UserId Search Criterion
---

# UserId Criterion

The `UserId` Search Criterion searches for content based on the User ID.

## Arguments

- `value` - int(s) representing the User ID(s)

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

=== "XML"

    ```xml
    <Query>
        <Filter>
            <UserIdCriterion>14</UserIdCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "UserIdCriterion": "14"
        }
    }
    ```
