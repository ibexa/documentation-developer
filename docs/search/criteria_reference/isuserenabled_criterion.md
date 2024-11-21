# IsUserEnabled Criterion

The [`IsUserEnabled` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-IsUserEnabled.html)
searches for User accounts that are enabled or disabled.

## Arguments

- (optional) `value` - bool representing whether to search for enabled (default `true`)
or disabled User accounts

## Example

### PHP

``` php
$query->query = new Criterion\IsUserEnabled();
```

### REST API

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