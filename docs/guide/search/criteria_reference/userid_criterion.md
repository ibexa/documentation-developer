# UserId Criterion

The [`UserIdentifier` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/UserId.php)
searches for content based on the User ID.

## Arguments

- `value` - int(s) representing the User ID(s).

## Limitations

The `UserIdentifier` Criterion is not available in Elastic search engine.

## Example

``` php
$query->query = new Criterion\UserId([14]);
```
