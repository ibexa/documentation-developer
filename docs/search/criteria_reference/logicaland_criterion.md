# LogicalAnd Criterion

The [`LogicalAnd` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/LogicalAnd.php)
matches content if all provided Criteria match.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator.

## Example

``` php
$query->query = new Criterion\LogicalAnd([
        new Criterion\ContentTypeIdentifier('article'),
        new Criterion\SectionIdentifier(['sports', 'news']);
    ]
);
```
