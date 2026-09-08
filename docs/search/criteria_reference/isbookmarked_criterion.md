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

### REST API

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
