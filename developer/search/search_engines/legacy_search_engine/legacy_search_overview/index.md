# Legacy search engine

Legacy search engine overview.

Legacy search engine is the default search engine. It's SQL-based and uses Doctrine's database connection. The connections are defined in the same way as for storage engine, and no further specific configuration is needed. Legacy search engine is recommended for basic needs and isn't intended in production. It allows you to use filtering and full-text search, but with some limitations.

For more information, check [search engine comparison](../../search_engines/index.md#search-engines-comparison)

> **Tip: Tip**
>
> The features and performance of Legacy search engine are limited. If you have specific search or performance needs, it's recommended to use [Solr](../../solr_search_engine/solr_overview/index.md) or [Elasticsearch](../../elasticsearch/elasticsearch_overview/index.md) instead.
>
> Using the Legacy search engine disables most shop features, such as product search.
