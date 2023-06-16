---
description: Legacy search engine overview.
---

# Legacy search engine

Legacy search engine is the default search engine, it is SQL-based and uses Doctrine's database connection.
Its connections are defined in the same way as for storage engine, and no further specific configuration is needed.
Legacy search engine is not intended in production.

!!! tip

    The features and performance of Legacy search engine are limited.
    If you have specific search or performance needs you should look towards using [Solr](solr_search_engine.md)
    or [Elasticsearch](elasticsearch_search_engine.md).
    
    Using the Legacy search engine disables most shop features, such as product search.