---
description: DateModified Sort Clause
---

# DateModified Sort Clause

The `DateModified` Sort Clause sorts search results by the date and time of the last modification of a content item.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

## Example

You can use this Sort Clause over the REST API, in the `SortClauses` element of the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

=== "XML"

    ```xml
    <Query>
        <SortClauses>
            <DateModified>ascending</DateModified>
        </SortClauses>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "SortClauses": {
            "DateModified": "ascending"
        }
    }
    ```
