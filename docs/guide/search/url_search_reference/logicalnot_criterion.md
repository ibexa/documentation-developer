# LogicalNot Criterion

The [`LogicalNot` URL Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/URL/Query/Criterion/LogicalNot.php)
matches a URL if the provided Criterion does not match.

It takes only one Criterion in the array parameter.

## Arguments

- `criterion` - represents the Criterion that should be negated

## Example

``` php
$query->filter = new Criterion\LogicalNot(
        new Criterion\Pattern('ibexa.co')
);
```
