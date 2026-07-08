---
month_change: false
description: Elasticsearch search engine overview.
---

# Elasticsearch search engine

Elasticsearch is an open-source, distributed, Java-based search engine that responds to queries in real-time and is scalable in reaction to changing processing needs.

Elasticsearch enables you to use filtering, query, query-time boosting, full-text search, and aggregations.
It organizes data into documents, that then are grouped into indices.

As a result of having distributed architecture, Elasticsearch can analyze massive amounts of data with almost real-time performance.
Instead of searching text directly, it searches and index.
Thanks to this mechanism, it's able to achieve fast response.

For a detailed description of advanced settings that you might require in a specific production environment, see the documentation provided by Elastic:

- Elasticsearch 7: [Set up Elasticsearch](https://www.elastic.co/guide/en/elasticsearch/reference/7.7/setup.html)
- Elasticsearch 8: [Set up Elasticsearch](https://www.elastic.co/guide/en/elasticsearch/reference/8.19/setup.html)

**Prerequisite**

To proceed you need to be familiar with how indexing, filtering and queries work.

## Update Elasticsearch schema

Whenever you make any changes in case of variables (for example, environmental ones) or configuration files, you need to erase Elasticsearch index, update the schema, and rebuild the index.

[[% include 'snippets/elasticsearch_clear_index.md' %]]
