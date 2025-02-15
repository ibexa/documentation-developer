---
description: Ibexa DXP architecture is structured in multiple layers connected by APIs.
---

# Architecture

[[= product_name =]] architecture is based on the philosophy to **use APIs** that is maintained in the long term.
This **makes upgrades easier and provides lossless couplings** between all parts of the architecture, at the same time improving the migration capabilities of the system.

The structure of an [[= product_name =]] app is based on the Symfony framework but content management functions rely on the public PHP API.
Other applications integrate with [[= product_name =]] via REST API, which also relies on the public PHP API.

![Architecture](architecture.png "Architecture")

The architecture of [[= product_name =]] is layered and uses clearly defined APIs between the layers.

| Layer                                               | Description                                                                                                                                                                                    |
|-----------------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| [Back office](back_office_configuration.md)         | Back office contains all the necessary parts to run the [[= product_name =]] back office interface.                                                                                            |
| [HTTP Cache](http_cache.md))                        | Symfony HTTP cache is used to manage content "view" cache with an expiration model. In addition it is extended by using FOSHttpCache to add several advanced features.                         |
| [Controllers](controllers.md)                       | Controllers created by you to read information from a Request object, create and return a Response objects.                                                                                    |
| [Twig templates](twig_function_reference.md)        | Set of custom and built-in Twig templates. User interfaces are developed with the Twig template engine and query the public PHP API directly.                                                  |
| [REST API v2](rest_api_usage.md)                    | The REST API v2 enables you to interact with an [[= product_name =]] installation through the HTTP protocol, following a REST interaction model.                                                 |
| [GraphQL](graphql.md)                               | GraphQL for [[= product_name =]] exposes the domain model using the repository, based on content type groups, content types and field definitions.                                             |
| [Public PHP API](php_api.md)                        | Public PHP API exposes the repository which enables you to create, read, update, manage and delete all objects available in [[= product_name =]].                                              |
| Business Logic                                      | The business logic is defined in the kernel. This business logic is exposed to applications via an API. It is used to organize development of the user interface layer.                        |
| SPI                                                 | Service Provider Interface which defines contracts for implementing various parts of the system, including persistence layer (`SPI\Persistence`), custom field types, custom limitations, and more. |
| [Persistence cache](persistence_cache.md)           | The implementation of SPI\Persistence that decorates the main backend implementation.                                                                                                          |
| [Search](search.md)                                 | Search API that allows both full-text search and querying the content.                                                                                                                         |
| [SQL Storage Engine](legacy_search_overview.md)     | Legacy search engine is SQL-based and uses Doctrine's database connection.                                                                                                                     |
| [Solr Storage Engine](solr_overview.md)             | Transparent drop-in replacement for the SQL-based Legacy search engine.                                                                                                                        |
| [IO](file_management.md#native-io-handler)          | The IO API is organized around two types of handlers, both used by the IOService.                                                                                                              |
| [IO Handler](clustering.md#dfs-io-handler)          | The IO Handler manipulates metadata, making up for the potential inconsistency of network-based filesystems.                                                                                   |
| [Recommendation](enable_personalization.md)         | Recommendation API.                                                                                                                                                                            |
| [Personalization server](enable_personalization.md) | Personalization server allows displaying recommendations on the website.                                                                                                                       |
