# UserId Criterion

The [`UserId` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-UserId.html)
searches for content based on the User ID.

## Arguments

- `value` - int(s) representing the User ID(s)

## Example

### PHP

``` php
$query->query = new Criterion\UserId([14]);
```

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <UserIdCriterion>14</UserIdCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "UserIdCriterion": "14"
        }
    }
    ```