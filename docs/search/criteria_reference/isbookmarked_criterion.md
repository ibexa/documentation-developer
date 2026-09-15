---
description: IsBookmarked Search Criterion
month_change: false
---

# IsBookmarked Criterion

The `IsBookmarked` Search Criterion
searches for location based on whether it's bookmarked or not.
It works with current user reference.

This Criterion is available only for location Search.

## Arguments

- `value` - bool representing whether to search for bookmarked location (default `true`) or not bookmarked location (`false`)

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

=== "XML"

    ```xml
    <Query>
        <Filter>
            <IsBookmarkedCriterion>true</IsBookmarkedCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "IsBookmarkedCriterion": true
        }
    }
    ```
