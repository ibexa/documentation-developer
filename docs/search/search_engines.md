---
description: Ibexa DXP enables you to use Solr or Elasticsearch search engines, in addition to the built-in legacy search engine which has limited functionalities.
---

# Search engines

Currently, the following search engines exist in their own [[= product_name =]] Bundles:

1.  [Legacy search engine](#legacy-search-engine), a database-powered search engine for basic needs.
1.  [Solr](solr_search_engine.md), an integration providing better overall performance, much better scalability and support for more advanced search capabilities.
1.  [Elasticsearch](elasticsearch_search_engine.md), available for [[= product_name_exp =]] customers, a document-oriented engine providing even better performance and scalability.

## Legacy search engine

Legacy search engine is the default search engine, it is SQL-based and uses Doctrine's database connection.
Its connections are defined in the same way as for storage engine, and no further specific configuration is needed.

!!! tip

    The features and performance of Legacy search engine are limited.
    If you have specific search or performance needs you should look towards using [Solr](solr_search_engine.md)
    or [Elasticsearch](elasticsearch_search_engine.md).
    
    Using the Legacy search engine disables most shop features, such as product search.

### Configuring Repository with Legacy search engine

Search can be configured independently from storage, and the following configuration example shows both the default values, and how you configure legacy as the search engine:

``` yaml
ibexa:
    repositories:
        main:
            storage:
                engine: legacy
                connection: default
            search:
                engine: legacy
                connection: default
```

## Search engine comparison

| Feature | Elasticsearch | Apache Solr | Legacy Search Engine (SQL) |
| --- | --- | --- | --- |
| Filtering | Yes | Yes | Yes, limited\* |
| Query (filter with scoring) | Yes | Yes | Only filters, no scoring |
| Fulltext search | Yes, limited | Yes | Yes, limited\*\* |
| Index-time boosting | \*\*\* | No | No |
| Aggregations | Yes | Yes | No |


\* Usage of Criteria and Sort Clauses for Fields does not perform well on medium to larger 
amount of data with Legacy Search Engine (SQL), use Solr for this.

\*\* For more information about fulltext search syntax support, see [Fulltext Criterion](fulltext_criterion.md).

\*\*\* Elasticsearch offers query-time boosting instead.
