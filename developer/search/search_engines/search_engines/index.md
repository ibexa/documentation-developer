# Search engines

Learn about different search engines that are supported by Ibexa DXP.

Ibexa DXP enables you to use different search engines. Currently, they exist in their own Ibexa DXP Bundles:

1. [Legacy search engine](../legacy_search_engine/legacy_search_overview/index.md) - a database-powered search engine for basic needs.
2. [Solr](../solr_search_engine/solr_overview/index.md) - an integration providing better overall performance, better scalability and support for more advanced search capabilities.
3. [Elasticsearch](../elasticsearch/elasticsearch_overview/index.md) - a document-oriented engine providing even better performance and scalability.

## Search engines comparison

| Feature                     | Legacy Search Engine (SQL) | Solr | Elasticsearch             |
| --------------------------- | -------------------------- | ---- | ------------------------- |
| Filtering                   | Yes, limited\*             | Yes  | Yes                       |
| Query (filter with scoring) | Only filters, no scoring   | Yes  | Yes                       |
| Full-text search            | Yes, limited\*\*           | Yes  | Yes, limited              |
| Index-time boosting         | No                         | No   | Query-time boosting\*\*\* |
| Aggregations                | No                         | Yes  | Yes                       |

\* Usage of Criteria and Sort Clauses for fields doesn't perform well on medium to larger amount of data with Legacy Search Engine (SQL).

\*\* For more information about full-text search syntax support, see [Full-text Criterion](../../criteria_reference/fulltext_criterion/index.md).

\*\*\* Elasticsearch offers query-time boosting instead.
