# LogicalOr Criterion

The [`LogicalOr` Search Criterion](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/Query/Criterion/LogicalOr.php)
matches content if at least one of the provided Criteria matches.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator.

## Example

``` php
$query->filter = new Criterion\LogicalOr([
        new Criterion\ContentTypeIdentifier('article'),
        new Criterion\SectionIdentifier(['sports', 'news']);
    ]
);
```
