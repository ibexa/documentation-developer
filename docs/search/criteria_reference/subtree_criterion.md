---
description: Subtree Search Criterion
---

# Subtree Criterion

The `Subtree` Search Criterion searches for content based on its location ID subtree path.
It returns the content item and all the content items below it in the subtree.

## Arguments

- `value` - string(s) representing the pathstring(s) to search for

## Example

=== "XML"

    ```xml
    <Query>
        <Filter>
            <SubtreeCriterion>/1/2/71/</SubtreeCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "SubtreeCriterion": "/1/2/71/"
        }
    }
    ```
