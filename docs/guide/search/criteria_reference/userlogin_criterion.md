# UserLogin Criterion

The [`UserLogin` Search Criterion](https://github.com/ezsystems/ezpublish-kernel/blob/v8.0.0-beta3/eZ/Publish/API/Repository/Values/Content/Query/Criterion/UserLogin.php)
searches for content based on the User ID.

## Arguments

- `value` - string(s) representing the User logins(s).
- `operator` - operator constant (IN, EQ, LIKE).

## Example

``` php
$query->query = new Criterion\UserLogin(['johndoe']);
```
