# UserEmail Criterion

The [`UserEmail` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/UserEmail.php)
searches for content based on the email assigned to the User account.

## Arguments

- `value` - string(s) representing the User email(s)
- (optional) `operator` - operator constant (IN, EQ, LIKE)

## Limitations

Solr search engine and Elasticsearch support IN and EQ operators only.

## Example

### PHP

``` php
$query->query = new Criterion\UserEmail(['johndoe']);
```

``` php
$query->query = new Criterion\UserEmail('nospam*', Criterion\Operator::LIKE);
```

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <UserEmailCriterion>j.black*</UserEmailCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "UserEmailCriterion": "j.black*"
        }
    }
    ```