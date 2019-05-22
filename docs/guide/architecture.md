# Architecture

A motto for eZ architecture is to **use APIs** that will be maintained in the long term to **ease upgrades and provide lossless couplings** between all parts of the architecture, at the same time improving the migration capabilities of the system.

The structure of eZ Platform bundles is based on the Symfony framework
but content management functions rely on the Public API.
Other applications integrate with eZ Platform via REST API, which also relies on the Public API.

![Architecture](img/ez_platform_architecture.png "Architecture")

The architecture of eZ Platform is layered and uses clearly defined APIs between the layers.

|Layer|Description|
|-----|-----------|
|[Admin UI](extending_ez_platform.md#back-office-interface)|Admin UI together with Admin UI Modules contain all the necessary parts to run the eZ Platform Back Office interface.|
|[HTTP Cache](http_cache.md)|Symfony HTTP cache is used to manage content "view" cache with an expiration model. In addition it is extended by using FOSHttpCache to add several advanced features.|
|[eZ Controllers](controllers.md)|Controllers created by you to read information from a Request object, create and return a Response objects.|
|[Twig templates](twig_functions_reference.md)|Set of custom and built in Twig templates. User interfaces are developed using the Twig template engine but directly querying the Public API.|
|[REST API v2](../api/rest_api_guide.md)|The REST API v2 allows you to interact with an eZ Platform installation using the HTTP protocol, following a REST interaction model.|
|[GraphQL](../api/graphql.md)|GraphQL for eZ Platform exposes the domain model using the repository, based on content types groups, content types and fields definitions.|
|[Public API](../api/public_php_api.md)|Public API exposes a Repository which allows you to create, read, update, manage and delete all objects available in eZ Platform.|
|Business Logic|The business logic is defined in the kernel. This business logic is exposed to applications via an API. It is used to organize development of the user interface layer.|
|[SPI](repository.md#spi)|This layer is a split of the eZ Platform SPI (persistence interfaces).|
|[Persistence cache](persistence_cache.md)|The implementation of SPI\Persistence that decorates the main backend implementation.|
|[Search](search.md)|Search API that allows both full-text search and querying the content.|
|[SQL Storage Engine](search_engines.md#legacy-search-engine-bundle)|Legacy search engine is SQL-based and uses Doctrine's database connection.|
|[Solr Storage Engine](solr.md)|Transparent drop-in replacement for the SQL-based Legacy search engine powering eZ Platform Search API by default.|
|[IO](file_management.md#native-io-handler)|The IO API is organized around two types of handlers, both used by the IOService.|
|[IO Handler](clustering.md#dfs-io-handler)|The IO Handler manipulates metadata, making up for the potential inconsistency of network-based filesystems.|
|[Recommendations](personalization.md#enabling-recommendations)|Recommendation API.|
|[Recommender Engine](personalization.md#running-a-full-content-export)|Recommender Engine allows displaying recommendations on your website.|
