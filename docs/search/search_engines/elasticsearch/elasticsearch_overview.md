---
description: Elasticsearch search engine overview.
---

# Elasticsearch search engine

Elasticsearch is an open-source, distributed, Java-based search engine that responds to queries in real-time and is scalable in reaction to changing processing needs.

Elasticsearch enables you to use filtering, query, query-time boosting, fulltext search, and aggregations.
It organizes data into documents, that then are grouped into indices.

As a result of having distributed architecture, Elasticsearch can analyze massive amounts of data with almost real-time performance.
Instead of searching text directly, it searches and index.
Thanks to this mechanism, it's able to achieve fast response.

For a detailed description of advanced settings that you might require in a specific production environment, see the documentation provided by Elastic.
Start with the [Set up Elasticsearch](https://www.elastic.co/guide/en/elasticsearch/reference/7.7/setup.html) section.

**Prerequisite**

To proceed you need to be familiar with how indexing, filtering and queries work.

## Update Elasticsearch schema

Whenever you make any changes in case of variables (for example, environmental ones) or configuration files, you need to erase Elasticsearch index, update the schema, and rebuild the index.

To delete the index, use the [delete index REST API](https://www.elastic.co/guide/en/elasticsearch/reference/7.17/indices-delete-index.html).
Use the commands as in the following example:

```bash
curl --request DELETE 'https://elasticsearch:9200/default_location*'
curl --request DELETE 'https://elasticsearch:9200/default_content*'
```

To update the schema and then reindex the search, use the following commands:

```bash
php bin/console ibexa:elasticsearch:put-index-template --overwrite
php bin/console ibexa:reindex
```
