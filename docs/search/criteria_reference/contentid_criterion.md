---
description: ContentId Search Criterion
---

# ContentId Criterion

The `ContentId` Search Criterion searches for content by its ID.

## Arguments

- `value` - int(s) representing the Content ID(s)

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

=== "XML"

    ```xml
    <Query>
        <Filter>
            <ContentIdCriterion>1,52</ContentIdCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ContentIdCriterion": "1,52"
        }
    }
    ```
