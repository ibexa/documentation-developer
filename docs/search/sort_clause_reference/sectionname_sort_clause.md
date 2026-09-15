---
description: SectionName Sort Clause
---

# SectionName Sort Clause

The `SectionName` Sort Clause sorts search results by the Section name of the content items.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

You can use this Sort Clause over the REST API, in the `SortClauses` element of the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

=== "XML"

    ```xml
    <Query>
        <SortClauses>
            <SectionName>ascending</SectionName>
        </SortClauses>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "SortClauses": {
            "SectionName": "ascending"
        }
    }
    ```
