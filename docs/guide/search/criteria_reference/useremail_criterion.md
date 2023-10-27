# UserEmail Criterion

The [`UserEmail` Search Criterion](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/Query/Criterion/UserEmail.php)
searches for content based on the email assigned to the User account.

## Arguments

- `value` - string(s) representing the User email(s).
- `operator` - operator constant (IN, EQ, LIKE).

## Limitations

Solr search engine and Elasticsearch support IN and EQ operators only.

## Example

``` php
$query->query = new Criterion\UserEmail(['johndoe']);
```

``` php
$query->query = new Criterion\UserEmail('nospam*', Criterion\Operator::LIKE);
```
