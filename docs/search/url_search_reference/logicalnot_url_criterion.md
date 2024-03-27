# LogicalNot Criterion

The [`LogicalNot` URL Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-URL-Query-Criterion-LogicalNot.html)
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
