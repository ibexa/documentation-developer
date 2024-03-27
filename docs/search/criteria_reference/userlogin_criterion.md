# UserLogin Criterion

The [`UserLogin` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-UserLogin.html)
searches for content based on the User ID.

## Arguments

- `value` - string(s) representing the User logins(s)
- (optional) `operator` - operator constant (IN, EQ, LIKE)

## Limitations

Solr search engine and Elasticsearch support IN and EQ operators only.

## Example

### PHP

``` php
$query->query = new Criterion\UserLogin(['johndoe']);
```

``` php
$query->query = new Criterion\UserLogin('adm*', Criterion\Operator::LIKE);
```

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <UserLoginCriterion>johndoe</UserLoginCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "UserLoginCriterion": "johndoe"
        }
    }
    ```