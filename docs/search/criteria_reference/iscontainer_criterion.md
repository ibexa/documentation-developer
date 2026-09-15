---
description: IsContainer Search Criterion
month_change: false
---

# IsContainer Criterion

The `IsContainer` Search Criterion searches for content items based on whether they are containers (i.e., can contain other content items).

## Arguments

- `value` – boolean (optional, default: `true`). If `true`, searches for content that is a container. If `false`, searches for content that is not a container.

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

=== "XML"

    ```xml
    <Query>
        <Filter>
            <IsContainerCriterion>true</IsContainerCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "IsContainerCriterion": true
        }
    }
    ```
