---
description: Visibility Search Criterion
---

# Visibility Criterion

The `Visibility` Search Criterion searches for content based on whether it's visible or not.

This Criterion takes into account both hiding content and hiding locations.

When used with Content Search, the Criterion takes into account all assigned locations.
This means that hidden content is returned if it has at least one visible location.
Use Location Search to avoid this.

## Arguments

- `value` - Visibility constant (VISIBLE, HIDDEN)

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

=== "XML"

    ```xml
    <Query>
        <Filter>
            <VisibilityCriterion>HIDDEN</VisibilityCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "VisibilityCriterion": "HIDDEN"
        }
    }
    ```
