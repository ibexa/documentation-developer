---
description: Ibexa DXP search functionalities allow working with three search engines and using search API to run complex and precise queries about content and products.
---

# Search

[[= product_name =]] exposes a very powerful [Search API](search_api.md), allowing both full-text search and querying the content Repository using several built-in Search Criteria and Sort Clauses. These are supported across different search engines, allowing you to plug in another search engine without changing your code.

[[= cards([
    "search/search_engines",
    "search/elasticsearch_search_engine",
    "search/solr_search_engine",
    "search/search_api",
    "search/search_criteria_and_sort_clauses",
    "search/extensibility/create_custom_search_criterion",
    "search/extensibility/create_custom_sort_clause",
    "search/extensibility/create_custom_aggregation",
], columns=4) =]]

## Reindexing

To (re)create or refresh the search engine index for configured search engines (per SiteAccess repository), use the `php bin/console ibexa:reindex` command.

Some examples of common usage:
```bash
# Reindex the whole index using parallel process (by default starts by purging the whole index)
# (with the 'auto' option which detects the number of CPU cores -1, default behavior)
php bin/console ibexa:reindex --processes=auto

# Refresh a part of the subtree (implies --no-purge)
php bin/console ibexa:reindex --subtree=2

# Refresh content updated since a date (implies --no-purge)
php bin/console ibexa:reindex --since=yesterday

# Refresh (or delete when not found) content by IDs (implies --no-purge)
php bin/console ibexa:reindex --content-ids=3,45,33
```

For further info on possible options, see `php bin/console ibexa:reindex --help`.

## Search view

You can extend the search view by overwriting or extending `Ibexa\Search\View\SearchViewFilter` and `Ibexa\Search\View\SearchViewBuilder`.
