---
description: Path Sort Clause
---

# Path Sort Clause

The `Location\Path` Sort Clause sorts search results by the pathString of the location.

!!! note

    The `Location/Path` Sort Clause uses dictionary sorting.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

In the REST API, this Sort Clause is called `LocationPath`.
Use it in the `SortClauses` element of the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

=== "XML"

    ```xml
    <Query>
        <SortClauses>
            <LocationPath>ascending</LocationPath>
        </SortClauses>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "SortClauses": {
            "LocationPath": "ascending"
        }
    }
    ```
