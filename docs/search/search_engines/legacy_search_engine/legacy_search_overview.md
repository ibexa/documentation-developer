---
description: Legacy search engine overview.
---

# Legacy search engine

Legacy search engine is the default search engine. It is SQL-based and uses Doctrine's database connection.
The connections are defined in the same way as for storage engine, and no further specific configuration is needed.
Legacy search engine is recommended for basic needs and is not intended in production.
It allows you to use filtering and fulltext search, but with some limitations.
For more information, check [search engine comparison](search_engines.md#search-engine-comparison)

!!! tip

    The features and performance of Legacy search engine are limited.
    If you have specific search or performance needs, it is recommended to use [Solr](solr_overview.md)
    or [Elasticsearch](elastic_search_overview.md) instead.
    
    Using the Legacy search engine disables most shop features, such as product search.
