# LogicalNot Criterion

The [`LogicalNot` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/LogicalNot.php)
matches content URL if the provided Criterion does not match.

It takes only one Criterion in the array parameter.

## Arguments

- `criterion` - represents the Criterion that should be negated.

## Example

``` php
$query->filter = new Criterion\LogicalNot(
    new Criterion\ContentTypeIdentifier($contentTypeId)
);
```
