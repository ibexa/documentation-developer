---
description: Depth Sort Clause
---

# Depth Sort Clause

The `Location\Depth` Sort Clause sorts search results by the depth of the location in the content tree.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

In the REST API, this Sort Clause is called `LocationDepth`.
Use it in the `SortClauses` element of the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

=== "XML"

    ```xml
    <Query>
        <SortClauses>
            <LocationDepth>ascending</LocationDepth>
        </SortClauses>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "SortClauses": {
            "LocationDepth": "ascending"
        }
    }
    ```
