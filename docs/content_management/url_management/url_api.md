---
description: The PHP API URLService enables searching for external URLs used in tech text and URL Fields.
---

# URL API

[`URLService`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-URLService.html)
enables you to find, load and update external URLs used in RichText and URL Fields.

To view a list of all URLs, use [`URLService::findUrls`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-URLService.html#method_findUrls)

`URLService::findUrls` takes as argument a [`URLQuery`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-URL-URLQuery.html),
in which you need to specify:

- query filter e.g. Section
- Sort Clauses for URL queries
- offset for search hits, used for paging the results
- query limit. If value is `0`, search query will not return any search hits

```php
// ...
[[= include_file('code_samples/api/public_php_api/src/Command/FindUrlCommand.php', 7, 10) =]]
// ...
[[= include_file('code_samples/api/public_php_api/src/Command/FindUrlCommand.php', 41, 56) =]]
```

## URL search reference

For the reference of Search Criteria and Sort Clauses you can use in URL search,
see [URL Search Criteria](url_search_criteria.md) and [URL Sort Clauses](url_search_sort_clauses.md).
