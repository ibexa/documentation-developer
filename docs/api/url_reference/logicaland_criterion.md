# LogicalAnd Criterion

The [`LogicalAnd` URL Criterion](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/URL/Query/Criterion/LogicalAnd.php)
matches a URL if all given criteria match.

## Arguments

- `criterion` - the set of criteria combined by the logical operator

## Example

``` php
$query->query = new Criterion\LogicalAnd([
        new Criterion\Validity(true),
        new Criterion\Pattern('ez.no')
    ]
);
```