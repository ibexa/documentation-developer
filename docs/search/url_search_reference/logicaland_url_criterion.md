# LogicalAnd Criterion

The [`LogicalAnd` URL Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-URL-Query-Criterion-LogicalAnd.html)
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
