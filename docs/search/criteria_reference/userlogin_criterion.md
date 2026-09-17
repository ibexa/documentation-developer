---
description: UserLogin Search Criterion
---

# UserLogin Criterion

The `UserLogin` Search Criterion searches for content based on the User ID.

## Arguments

- `value` - string(s) representing the User logins(s)
- (optional) `operator` - operator constant (IN, EQ, LIKE)

## Limitations

Only the `IN` and `EQ` operators are supported.

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

=== "XML"

    ```xml
    <Query>
        <Filter>
            <UserLoginCriterion>johndoe</UserLoginCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "UserLoginCriterion": "johndoe"
        }
    }
    ```
