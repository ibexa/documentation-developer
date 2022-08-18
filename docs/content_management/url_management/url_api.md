---
description: The PHP API URLService enables searching for external URLs used in tech text and URL Fields.
---

# URL API

[`URLService`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/URLService.php)
enables you to find, load and update external URLs used in RichText and URL Fields.

To view a list of all URLs, use [`URLService::findUrls`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/URLService.php#L38)

`URLService::findUrls` takes as argument a [`URLQuery`,](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/URL/URLQuery.php)
in which you need to specify:

- query filter e.g. Section
- Sort Clauses for URL queries
- offset for search hits, used for paging the results
- query limit. If value is `0`, search query will not return any search hits

```php
// ...
[[= include_file('code_samples/api/public_php_api/src/Command/FindUrlCommand.php', 9, 12) =]]
// ...
[[= include_file('code_samples/api/public_php_api/src/Command/FindUrlCommand.php', 43, 58) =]]
```

## URL search reference

For the reference of Search Criteria and Sort Clauses you can use in URL search,
see [URL search reference](url_search_reference.md).
