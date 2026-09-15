---
description: ContentTypeId Search Criterion
---

# ContentTypeId Criterion

The `ContentTypeId` Search Criterion searches for content based on the ID of its content type.

## Arguments

- `value` - int(s) representing the content type ID(s)

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

=== "XML"

    ```xml
    <Query>
        <Filter>
            <ContentTypeIdCriterion>44</ContentTypeIdCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ContentTypeIdCriterion": 44
        }
    }
    ```
