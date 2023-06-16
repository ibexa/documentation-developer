---
description: Ibexa DXP enables you to use Solr or Elasticsearch search engines, in addition to the built-in legacy search engine which has limited functionalities.
---

# Search engines

[[= product_name =]] enables you to use search engines.
Currently, they exist in their own [[= product_name =]] Bundles:

1.  [Legacy search engine](#legacy-search-engine) - a database-powered search engine for basic needs.
1.  [Solr](solr_search_engine.md) - an integration providing better overall performance, better scalability and support for more advanced search capabilities.
1.  [Elasticsearch](elasticsearch_search_engine.md) - a document-oriented engine providing even better performance and scalability.

## Search engine comparison

| Feature | Legacy Search Engine (SQL) | Solr | Elasticsearch |
| --- | --- | --- | --- |
| Filtering | Yes, limited\* | Yes | Yes |
| Query (filter with scoring) | Only filters, no scoring | Yes | Yes |
| Fulltext search | Yes, limited\*\* | Yes | Yes, limited |
| Index-time boosting | No | No | Query-time boosting\*\*\* |
| Aggregations | No | Yes | Yes |

\* Usage of Criteria and Sort Clauses for Fields does not perform well on medium to larger 
amount of data with Legacy Search Engine (SQL).

\*\* For more information about fulltext search syntax support, see [Fulltext Criterion](fulltext_criterion.md).

\*\*\* Elasticsearch offers query-time boosting instead.