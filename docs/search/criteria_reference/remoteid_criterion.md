# RemoteId / ContentRemoteId Criterion

The [`RemoteId` / `ContentRemoteId` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-RemoteId.html)
searches for content based on its remote content ID.

## Arguments

- `value` - string(s) representing the remote IDs

## Example

### PHP

``` php
$query->query = new Criterion\RemoteId('abab615dcf26699a4291657152da4337');
```

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <ContentRemoteIdCriterion>abab615dcf26699a4291657152da4337</ContentRemoteIdCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ContentRemoteIdCriterion": "abab615dcf26699a4291657152da4337"
        }
    }
    ```