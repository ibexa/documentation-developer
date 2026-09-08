---
description: ContentTypeGroupId Search Criterion
---

# ContentTypeGroupId Criterion

The `ContentTypeGroupId` Search Criterion searches for content based on the ID of its content type group.

## Arguments

- `value` - int(s) representing the content type group ID(s)

## Example

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <ContentTypeGroupIdCriterion>1</ContentTypeGroupIdCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ContentTypeGroupIdCriterion": [1, 2]
        }
    }
    ```

## Use case

You can use the `ContentTypeGroupId` Criterion to query all Media content items.
The default ID for the Media content type group is 3.
