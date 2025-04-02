---
description: IsMainLocation Search Criterion
---

# IsMainLocation Criterion

The [`IsMainLocation` Search Criterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-LanguageCode.html) searches for locations based on whether they're the main location of a content item or not.

This Criterion is available only for Location Search.

## Arguments

- `value` - `IsMainLocation::MAIN` (0) or `IsMainLocation::NOT_MAIN` (1),
representing whether to search for a main or not main location

## Example

### PHP

``` php
$query->query = new Criterion\Location\IsMainLocation(IsMainLocation::MAIN);
```
