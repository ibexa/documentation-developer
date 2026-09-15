---
description: Subtree Search Criterion
---

# Subtree Criterion

The `Subtree` Search Criterion searches for content based on its location ID subtree path.
It returns the content item and all the content items below it in the subtree.

## Arguments

- `value` - string(s) representing the pathstring(s) to search for

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

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
