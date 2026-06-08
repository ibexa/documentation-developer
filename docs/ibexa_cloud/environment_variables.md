---
description: Automatically generated environment variables based on Ibexa Cloud relationships and routes.
---

# Environment variables on Ibexa Cloud

[[= product_name_cloud =]] automatically generates environment variables based on the configuration of relationships and routes in Upsun.
It parses `PLATFORM_RELATIONSHIPS` and `PLATFORM_ROUTES` environment variables and exposes them as application-specific variables.

Environment variable prefixes are created by converting relationship names to uppercase and replacing hyphens with underscores.

When multiple endpoints are defined for a single relationship, numerical indices are used for all entries except the first one, for example: `SOLR`, `SOLR_1`, `SOLR_2`.
When multiple services of the same type are present, environment variables are exposed for each service accordingly based on their relationship names.

!!! caution "Environment variables in configuration files"

    To prevent Symfony container initialization failures, you must define placeholder values for [[= product_name_cloud =]] environment variables in your `.env` file when referencing them in configuration files.

    Do it only for the variables that are required for the Symfony container to build.

    For example, if your `doctrine.yaml` uses a [database variable](#database-variables) created for a relationship named `pgsql`:

    ``` yaml
    doctrine:
        dbal:
            url: '%env(resolve:PGSQL_URL)%'
    ```

    You must define a placeholder value in `.env`:

    ``` env
    PGSQL_URL="placeholder"
    ```

    The actual value of the environment variable is provided by [[= product_name_cloud =]] at runtime.
    The placeholder in `.env` is only required to prevent Symfony container compilation errors during build.

## Relationship naming conventions

You can choose relationship names freely in `.platform.app.yaml` for most services.

The only required names are:

- `dfs_database` - DFS database (required for DFS functionality)
- `redissession` or `valkeysession` - Redis/Valkey for sessions (required for dedicated session storage)

Common relationship name include:

- `database` - main application database
- `rediscache` - Redis for cache
- `elasticsearch` - Elasticsearch search service
- `solr` - Solr search service

## Database variables

For MySQL and PostgreSQL databases, the following variables are generated based on the relationship name (for example, `database`):

- `{RELATIONSHIP_NAME}_URL` - full database URL with charset and server version
- `{RELATIONSHIP_NAME}_USER` / `{RELATIONSHIP_NAME}_USERNAME` - database user
- `{RELATIONSHIP_NAME}_PASSWORD` - database password
- `{RELATIONSHIP_NAME}_HOST` - database host
- `{RELATIONSHIP_NAME}_PORT` - database port
- `{RELATIONSHIP_NAME}_NAME` / `{RELATIONSHIP_NAME}_DATABASE` - database name
- `{RELATIONSHIP_NAME}_DRIVER` - database driver
- `{RELATIONSHIP_NAME}_SERVER` - database server

For example, for a relationship called `database`, the environment variables are named `DATABASE_URL`, `DATABASE_HOST`, `DATABASE_USER`, etc.

For more information about database configuration, see [Databases](databases.md).

## DFS database variables

When using [distributed file storage (DFS) that uses a separate database](clustering.md#dfs-io-handler), you must use the relationship name `dfs_database`.
In addition to the database variables listed above, additional DFS-specific variables are available when `PLATFORMSH_DFS_NFS_PATH` is set:

- `DFS_NFS_PATH` - NFS path for DFS storage
- `DFS_DATABASE_CHARSET` - database character set
- `DFS_DATABASE_COLLATION` - database collation

## Cache variables

For Redis and Valkey cache services, you can use the following variables:

- `{RELATIONSHIP_NAME}_URL`
- `{RELATIONSHIP_NAME}_HOST`
- `{RELATIONSHIP_NAME}_PORT`
- `{RELATIONSHIP_NAME}_SCHEME`

In addition, you can use the following global variables:

- `CACHE_POOL` - `cache.redis` for both Redis and Valkey
- `CACHE_DSN` - cache connection string

For more information about persistence cache configuration, see [Persistence cache](persistence_cache.md).

## Session variables

For Redis-based session storage, the following variables are available.

- `SESSION_HANDLER_ID` - session handler class name
- `SESSION_SAVE_PATH` - Redis connection in `host:port` format

The system looks for relationships named `redissession` or `valkeysession` first.
If not found, it uses the first available Redis-compatible service.

For more information about session configuration, see [Sessions](sessions.md).

## Search engine variables

### Solr

For Solr search engine configuration, you can use the following variables:

- `SEARCH_ENGINE` - set to `solr`
- `SOLR_DSN` - Solr connection string
- `SOLR_CORE` - Solr core name
- `{RELATIONSHIP_NAME}_HOST`
- `{RELATIONSHIP_NAME}_PORT`
- `{RELATIONSHIP_NAME}_NAME` / `{RELATIONSHIP_NAME}_DATABASE`

For more information, see [Solr search engine](solr_overview.md).

### Elasticsearch

For Elasticsearch search engine configuration, you can use the following variables:

- `SEARCH_ENGINE` - set to `elasticsearch`
- `ELASTICSEARCH_DSN` - Elasticsearch connection string
- `{RELATIONSHIP_NAME}_URL`
- `{RELATIONSHIP_NAME}_HOST`
- `{RELATIONSHIP_NAME}_PORT`
- `{RELATIONSHIP_NAME}_SCHEME`

For more information, see [Elasticsearch](elasticsearch_overview.md).

## HTTP cache variables (Varnish)

For Varnish-based HTTP caching, the following variables are available.

- `HTTPCACHE_PURGE_TYPE` - set to `varnish`
- `HTTPCACHE_PURGE_SERVER` - Varnish server address
- `HTTPCACHE_VARNISH_INVALIDATE_TOKEN` - token for cache invalidation

For more information about HTTP cache and Varnish configuration, see [HTTP cache](http_cache.md).
