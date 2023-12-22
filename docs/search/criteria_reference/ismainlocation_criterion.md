# IsMainLocation Criterion

The [`IsMainLocation` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-LanguageCode.html)
searches for Locations based on whether they are the main Location of a Content item or not.

This Criterion is available only for Location Search.

## Arguments

- `value` - `IsMainLocation::MAIN` (0) or `IsMainLocation::NOT_MAIN` (1),
representing whether to search for a main or not main Location

## Example

### PHP

``` php
$query->query = new Criterion\Location\IsMainLocation(IsMainLocation::MAIN);
```
