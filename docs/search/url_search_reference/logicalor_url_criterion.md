# LogicalOr Criterion

The [`LogicalOr` URL Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-URL-Query-Criterion-LogicalOr.html)
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
