# LogicalOr Criterion

The [`LogicalOr` URL Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/URL/Query/Criterion/LogicalOr.php)
matches a URL if at least one of the provided Criteria match.

## Arguments

- `criterion` - the set of Criteria combined by the logical operator

## Example

``` php
$query->filter = new Criterion\LogicalOr(
    [
        new Criterion\SectionIdentifier(['sports', 'news']),
        new Criterion\Pattern('ibexa.co')
    ]
);
```
