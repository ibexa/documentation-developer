---
description: Learn about different search engines that are supported by Ibexa DXP.
---

# Search engines

[[= product_name =]] enables you to use different search engines.
Currently, they exist in their own [[= product_name =]] Bundles:

1.  [Legacy search engine](legacy_search_overview.md) - a database-powered search engine for basic needs.
1.  [Solr](solr_overview.md) - an integration providing better overall performance, better scalability and support for more advanced search capabilities.
1.  [Elasticsearch](elastic_search_overview.md) - a document-oriented engine providing even better performance and scalability.

## Search engines comparison

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