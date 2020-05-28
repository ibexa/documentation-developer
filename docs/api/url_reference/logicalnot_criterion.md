# LogicalNot Criterion

The [`LogicalNot` URL Criterion](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/URL/Query/Criterion/LogicalNot.php)
matches a URL if the provided criterion does not match.

It takes only one criterion in the array parameter.

## Arguments

- `criterion` - represents the criterion that should be excluded from the results

## Example

``` php
$query->filter = new Criterion\LogicalNot(
        new Criterion\Pattern('ibexa.co')
);
```
