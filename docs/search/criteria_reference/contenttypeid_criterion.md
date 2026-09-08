---
description: ContentTypeId Search Criterion
---

# ContentTypeId Criterion

The `ContentTypeId` Search Criterion searches for content based on the ID of its content type.

## Arguments

- `value` - int(s) representing the content type ID(s)

## Example

### REST API

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
