---
description: The PHP API URLService enables searching for external URLs used in tech text and URL fields.
---

# URL API

`URLService`
enables you to find, load and update external URLs used in RichText and URL fields.

To view a list of all URLs, use `URLService::findUrls`

`URLService::findUrls` takes as argument a `URLQuery`,
in which you need to specify:

- query filter, for example, Section
- Sort Clauses for URL queries
- offset for search hits, used for paging the results
- query limit. If value is `0`, search query doesn't return any search hits

``` php
// ...
[[= include_file('code_samples/api/public_php_api/src/Command/FindUrlCommand.php', 5, 6) =]][[= include_file('code_samples/api/public_php_api/src/Command/FindUrlCommand.php', 7, 10) =]]
// ...
[[= include_file('code_samples/api/public_php_api/src/Command/FindUrlCommand.php', 34, 49) =]]
```

## URL search reference

For the reference of Search Criteria and Sort Clauses you can use in URL search,
see [URL Search Criteria](url_search_criteria.md) and [URL Sort Clauses](url_search_sort_clauses.md).
