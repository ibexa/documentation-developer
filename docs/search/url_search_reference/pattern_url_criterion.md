# Pattern Criterion

The [`Pattern` URL Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-URL-Query-Criterion-SectionId.html)
matches URLs that contain the provided pattern.

## Arguments

- `pattern` - string representing the pattern that needs to be a part of the URL

## Example

``` php
$query->filter = new Criterion\Pattern('ibexa.co');
```
