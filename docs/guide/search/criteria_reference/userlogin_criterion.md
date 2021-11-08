# UserLogin Criterion

The [`UserLogin` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/UserLogin.php)
searches for content based on the User ID.

## Arguments

- `value` - string(s) representing the User logins(s).
- `operator` - operator constant (IN, EQ, LIKE).

## Limitations

The `UserLogin` Criterion is not available in Elastic search engine.

## Example

``` php
$query->query = new Criterion\UserLogin(['johndoe']);
```

``` php
$query->query = new Criterion\UserLogin('adm*', Criterion\Operator::LIKE);
```
