---
description: Solr search engine overview.
---

# Solr search engine

[Solr search engine](https://github.com/ibexa/solr) allows you to use advanced search features: filtering, query, fulltext search, and aggregations.

When you enable Solr and re-index your content, all your existing Search queries by using `SearchService` are powered by Solr automatically.
This allows you to scale up your [[= product_name =]] installation and be able to continue development locally against SQL engine, and have a test infrastructure, Staging, and Prod powered by Solr.
By this, it also removes considerable load from your database.

For more information on the architecture of [[= product_name =]], see [Architecture](architecture.md).