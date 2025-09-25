---
description: MatchAll Search Criterion
---

# MatchAll Criterion

The [`MatchAll` Search Criterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-MatchAll.html) is an auxiliary Criterion that returns all search results.
It's used internally when no filter or query is provided on a Query object.

The Criterion takes no arguments.

## Arguments

This criterion does not require any arguments.

## Limitations

`MatchAll` can be used on all search engines.

## Example

### PHP

```php
$query->query = new Criterion\MatchAll();
```
