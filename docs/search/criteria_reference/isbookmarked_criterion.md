---
description: IsBookmarked Search Criterion
month_change: false
---

# IsBookmarked Criterion

The [`IsBookmarked` Search Criterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-Location-IsBookmarked.html)
searches for location based on whether it's added to a list of Favourites or not.
It works with current user reference.

This Criterion is available only for location Search.

## Arguments

- `value` - bool representing whether to search for a location that is added (default `true`) or not added (`false`) to the Favourites list

## Example

### PHP

``` php
[[= include_code('code_samples/search/location/isbookmarked_criterion.php', 3, remove_indent=True) =]]
```

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
