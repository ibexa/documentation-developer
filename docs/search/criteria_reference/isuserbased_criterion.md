---
description: IsUserBased Search Criterion
---

# IsUserBased Criterion

The `IsUserBased` Search Criterion searches for content that plays the role of a User account.

!!! note

    In the default setup only the user content type is treated as user accounts.

## Arguments

- (optional) `value` - bool representing whether to search for User-based (default `true`)
or non-User-based content

## Limitations

The `IsUserBased` Criterion isn't available in Solr or Elasticsearch engines.

## Example

=== "XML"

    ```xml
    <Query>
        <Filter>
            <IsUserBasedCriterion>false</IsUserBasedCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "IsUserBasedCriterion": "false"
        }
    }
    ```
