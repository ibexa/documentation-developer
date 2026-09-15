---
description: DatePublished Sort Clause
---

# DatePublished Sort Clause

The `DatePublished` Sort Clause sorts search results by the date and time of the first publication of a content item.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

You can use this Sort Clause over the REST API, in the `SortClauses` element of the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

=== "XML"

    ```xml
    <Query>
        <SortClauses>
            <DatePublished>ascending</DatePublished>
        </SortClauses>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "SortClauses": {
            "DatePublished": "ascending"
        }
    }
    ```
