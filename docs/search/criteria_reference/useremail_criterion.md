# UserEmail Criterion

The [`UserEmail` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-UserEmail.html)
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