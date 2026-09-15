---
description: IsUserEnabled Search Criterion
month_change: false
---

# IsUserEnabled Criterion

The `IsUserEnabled` Search Criterion searches for user accounts that are enabled or disabled.

## Arguments

- (optional) `value` - bool representing whether to search for enabled (default `true`) or disabled user accounts

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

=== "XML"

    ```xml
    <Query>
        <Filter>
            <IsUserEnabledCriterion>true</IsUserEnabledCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "IsUserEnabledCriterion": "true"
        }
    }
    ```
