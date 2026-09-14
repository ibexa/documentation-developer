---
description: UserId Search Criterion
---

# UserId Criterion

The `UserId` Search Criterion searches for content based on the User ID.

## Arguments

- `value` - int(s) representing the User ID(s)

## Example

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
