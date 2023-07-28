# UserId Criterion

The [`UserId` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/UserId.php)
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