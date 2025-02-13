---
description: ParentLocationRemoteId Search Criterion
---

# ParentLocationRemoteId Criterion

The `ParentLocationRemoteId` Search Criterion searches for content based on the location remote ID of its parent.

## Arguments

- `value` - int(s) representing the parent location remote IDs


### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <ParentLocationRemoteIdCriterion>abab615dcf26699a4291657152da4337</ParentLocationRemoteIdCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ParentLocationRemoteIdCriterion": "abab615dcf26699a4291657152da4337"
        }
    }
    ```
