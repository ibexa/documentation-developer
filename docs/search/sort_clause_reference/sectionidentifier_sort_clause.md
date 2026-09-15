---
description: SectionIdentifier Sort Clause
---

# SectionIdentifier Sort Clause

The `SectionIdentifier` Sort Clause sorts search results by the Section IDs of the content items.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

!!! note

    This Sort Clause uses the `descending` sort direction by default.

## Example

You can use this Sort Clause over the REST API, in the `SortClauses` element of the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

=== "XML"

    ```xml
    <Query>
        <SortClauses>
            <SectionIdentifier>ascending</SectionIdentifier>
        </SortClauses>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "SortClauses": {
            "SectionIdentifier": "ascending"
        }
    }
    ```
