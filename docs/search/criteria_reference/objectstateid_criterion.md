---
description: ObjectStateId Search Criterion
---

# ObjectStateId Criterion

The `ObjectStateId` Search Criterion searches for content based on its object state ID.

## Arguments

- `value` - int(s) representing the object state ID(s)

## Example

=== "XML"

    ```xml
    <Query>
        <Filter>
            <ObjectStateIdCriterion>1</ObjectStateIdCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ObjectStateIdCriterion": "1"
        }
    }
    ```
