---
description: IsUserBased Search Criterion
edition: commerce
---

# IsUserBased Criterion

The [`IsUserBased` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-IsUserBased.html) searches for content that plays the role of a User account.

!!! note

    In the default setup only the user content type is treated as user accounts.
    However, you can also [set other content types to be treated as such](repository_configuration.md#user-identifiers).

## Arguments

- (optional) `value` - bool representing whether to search for User-based (default `true`)
or non-User-based content

## Limitations

The `IsUserBased` Criterion isn't available in Solr or Elasticsearch engines.

## Example

### PHP

``` php
$query->query = new Criterion\IsUserBased();
```

### REST API

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