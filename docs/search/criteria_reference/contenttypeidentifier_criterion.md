---
description: ContentTypeIdentifier Search Criterion
---

# ContentTypeIdentifier Criterion

The `ContentTypeIdentifier` Search Criterion searches for content based on the identifier of its content type.

## Arguments

- `value` - string(s) representing the content type identifier(s)

## Example

### REST API

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
