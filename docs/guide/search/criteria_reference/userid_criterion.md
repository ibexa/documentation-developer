# UserId Criterion

The [`UserIdentifier` Search Criterion](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/Query/Criterion/UserId.php)
searches for content based on the User ID.

## Arguments

- `value` - int(s) representing the User ID(s).

## Limitations

The `UserIdentifier` Criterion is not available in Elastic search engine.

## Example

``` php
$query->query = new Criterion\UserId([14]);
```
