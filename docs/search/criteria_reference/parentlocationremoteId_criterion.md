---
description: ParentLocationRemoteId Search Criterion
---

# ParentLocationRemoteId Criterion

The `ParentLocationRemoteId` Search Criterion searches for content based on the location remote ID of its parent.

## Arguments

- `value` - int(s) representing the parent location remote IDs

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

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
