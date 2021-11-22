# UserLogin Criterion

The [`UserLogin` Search Criterion](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/Query/Criterion/UserLogin.php)
searches for content based on the User ID.

## Arguments

- `value` - string(s) representing the User logins(s).
- `operator` - operator constant (IN, EQ, LIKE).

## Limitations

Solr search engine and Elasticsearch support IN and EQ operators only.

## Example

``` php
$query->query = new Criterion\UserLogin(['johndoe']);
```

``` php
$query->query = new Criterion\UserLogin('adm*', Criterion\Operator::LIKE);
```
