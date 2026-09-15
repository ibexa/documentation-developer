---
description: Priority Sort Clause
---

# Priority Sort Clause

The `Location\Priority` Sort Clause sorts search results by the priority of the location.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

In the REST API, this Sort Clause is called `LocationPriority`.
Use it in the `SortClauses` element of the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

=== "XML"

    ```xml
    <Query>
        <SortClauses>
            <LocationPriority>ascending</LocationPriority>
        </SortClauses>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "SortClauses": {
            "LocationPriority": "ascending"
        }
    }
    ```
