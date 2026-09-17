---
description: RemoteId / ContentRemoteId Search Criterion
---

# RemoteId / ContentRemoteId Criterion

The `RemoteId` / `ContentRemoteId` Search Criterion
searches for content based on its remote content ID.

## Arguments

- `value` - string(s) representing the remote IDs

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

=== "XML"

    ```xml
    <Query>
        <Filter>
            <ContentRemoteIdCriterion>abab615dcf26699a4291657152da4337</ContentRemoteIdCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ContentRemoteIdCriterion": "abab615dcf26699a4291657152da4337"
        }
    }
    ```
