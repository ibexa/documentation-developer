# LogicalAnd Criterion

The [`LogicalAnd` URL Criterion](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/URL/Query/Criterion/LogicalAnd.php)
matches a URL if all provided Criteria match.

## Arguments

- `criterion` - the set of Criteria combined by the logical operator

## Example

``` php
$query->filter = new Criterion\LogicalAnd(
    [
        new Criterion\Validity(true),
        new Criterion\Pattern('ibexa.co')
    ]
);
```
