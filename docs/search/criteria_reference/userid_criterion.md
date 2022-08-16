# UserId Criterion

The [`UserId` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/UserId.php)
searches for content based on the User ID.

## Arguments

- `value` - int(s) representing the User ID(s).

## Example

``` php
$query->query = new Criterion\UserId([14]);
```
