---
description: ContentTypeIdentifier Search Criterion
---

# ContentTypeIdentifier Criterion

The `ContentTypeIdentifier` Search Criterion searches for content based on the identifier of its content type.

## Arguments

- `value` - string(s) representing the content type identifier(s)

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

=== "XML"

    ```xml
    <Query>
        <Filter>
            <ContentTypeIdentifierCriterion>article</ContentTypeIdentifierCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ContentTypeIdentifierCriterion": "article"
        }
    }
    ```
