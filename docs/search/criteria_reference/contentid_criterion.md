---
description: ContentId Search Criterion
---

# ContentId Criterion

The `ContentId` Search Criterion searches for content by its ID.

## Arguments

- `value` - int(s) representing the Content ID(s)

## Example

### REST API

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
