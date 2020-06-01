# LogicalNot Criterion

The [`LogicalNot` URL Criterion](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/URL/Query/Criterion/LogicalNot.php)
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
