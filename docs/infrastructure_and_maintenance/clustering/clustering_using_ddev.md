---
description: Use DDEV to run a cluster infrastructure locally.
---

# Clustering with DDEV

!!! caution

    Do not use this procedure in production.
    A staging environment for validation before production should exactly replicate the production environment.
    This is meant for development environment only.

This guide follows [Install with DDEV](install_using_ddev.md) and helps to extend the previous installation to locally replicate a production [cluster](clustering.md).

In contrast to a production cluster, this setup has only one front app server.
But the data sharing needed by a cluster of several servers can still be emulated.

The `ddev config --php-version` option should set the same PHP version as the production servers.

!!! tip
 
    - [`ddev describe`](https://ddev.readthedocs.io/en/latest/users/usage/commands/#describe) displays a cluster summary that include accesses from inside and outside DDEV services
    - [`ddev ssh`](https://ddev.readthedocs.io/en/latest/users/usage/commands/#ssh) opens a terminal inside a service
    - [`ddev exec`](https://ddev.readthedocs.io/en/latest/users/usage/commands/#exec) executes a command inside a service

   Discover more commands in [DDEV documentation](https://ddev.readthedocs.io/en/latest/users/usage/commands/).

To run an Ibexa Cloud project locally, you may refer to [Ibexa Cloud and DDEV](ibexa_cloud_and_ddev.md) instead.

## Install search engine

A [search engine](search_engines.md) can be added to the cluster.

### Elasticsearch

The following commands:

1. adds the Elasticsearch container,
1. sets it up as the search engine,
1. restarts the DDEV cluster and clear application cache,
1. then injects the schema and reindex the content.

```bash
ddev get ddev/ddev-elasticsearch
ddev config --web-environment-add SEARCH_ENGINE=elasticsearch
ddev config --web-environment-add ELASTICSEARCH_DSN=http://elasticsearch:9200
ddev restart
ddev php bin/console cache:clear
ddev php bin/console ibexa:elasticsearch:put-index-template
ddev php bin/console ibexa:reindex
```

You can now check whether Elasticsearch works.

For example, `ddev exec curl -s "http://elasticsearch:9200/_count"`

- tests that the `web` server is accessing the `elasticsearch` server,
- displays the number of indexed documents.

See [ddev/ddev-elasticsearch README](https://github.com/ddev/ddev-elasticsearch) for more information on topics such as memory management.

See [Elasticsearch REST API reference](https://www.elastic.co/guide/en/elasticsearch/reference/current/rest-apis.html) for more request possibilities like

- the [`_count`](https://www.elastic.co/guide/en/elasticsearch/reference/current/search-count.html) from the above test,
- or [`_cluster/health`](https://www.elastic.co/guide/en/elasticsearch/reference/current/cluster-health.html) (don't mind the "yellow" status),
- or [`_search?size=0"`](https://www.elastic.co/guide/en/elasticsearch/reference/current/search-search.html) (which is another way to get document count).

!!! tip

    You can use [`jq`](https://jqlang.github.io/jq/) to format and colorize Elasticsearch REST API outputs.

### Solr

To simplify the installation of Solr, you can use the `ibexa/ddev-solr` add-on:

```bash
ddev get ibexa/ddev-solr
ddev restart
```

You can now check whether Solr works.

For example, `ddev exec curl -s http://solr:8983/api/cores/`

- tests that the `web` server is accessing the `solr` server,
- tests `collection1` existence and status,
- displays `collection1`'s `numDocs` that shouldn't be zero if indexing worked correctly. 

You can access the Solr admin UI from the host by using port 8983 on the same `.ddev.site` subdomain as the front. Use `ddev describe` to get that URL.

## Share cache and sessions

You can add a [persistence cache pool](persistence_cache.md#persistence-cache-configuration) and a [session handler](sessions.md#session-handlers) to the cluster.

In the following examples:

- the same service is used to store both persistence cache and sessions,
- the session handler is set on Symfony side, not on PHP side.

### Install Redis

The following command lines

1. add the Redis container,
1. set up Redis as the cache pool,
1. set up Redis as the session handler,
1. change `maxmemory-policy` from default `allkeys-lfu` to a [value accepted by the `RedisTagAwareAdapter`](https://github.com/symfony/cache/blob/5.4/Adapter/RedisTagAwareAdapter.php#L95),
1. restart the DDEV cluster and clear application cache.

```bash
ddev get ddev/ddev-redis
ddev config --web-environment-add CACHE_POOL=cache.redis
ddev config --web-environment-add CACHE_DSN=redis
ddev config --web-environment-add SESSION_HANDLER_ID='Ibexa\\Bundle\\Core\\Session\\Handler\\NativeSessionHandler'
ddev config --web-environment-add SESSION_SAVE_PATH=tcp://redis:6379
sed -i 's/maxmemory-policy allkeys-lfu/maxmemory-policy volatile-lfu/' .ddev/redis/redis.conf;
ddev restart
ddev php bin/console cache:clear
```

You can now check whether Redis works.

For example, `ddev redis-cli MONITOR` outputs such as `"SETEX" "ezp:`, `"MGET" "ezp:`, `"SETEX" "PHPREDIS_SESSION:`, `"GET" "PHPREDIS_SESSION:`, etc. while navigating into the website, in particular the Back Office.

See [Redis commands](https://redis.io/commands/) for more details such as information about the [`MONITOR`](https://redis.io/commands/monitor/) command used in the previous example.

### Install Memcached

First, if not already there, append the following [new service](https://doc.ibexa.co/en/latest/infrastructure_and_maintenance/sessions/#handling-sessions-with-memcached) to `config/services.yaml`:

```yaml
    app.session.handler.native_memcached:
        class: Ibexa\Bundle\Core\Session\Handler\NativeSessionHandler
        arguments:
            - '%session.save_path%'
            - memcached
```

Second, install and set up the add-on.
The following sequence of commands:

1. add the Memcached container,
1. set up Memcached as the cache pool,
1. set up Memcached as the session handler,
1. restart the DDEV cluster and clear application cache.

```bash
ddev get ddev/ddev-memcached
ddev config --web-environment-add CACHE_POOL=cache.memcached
ddev config --web-environment-add CACHE_DSN=memcached
ddev config --web-environment-add SESSION_HANDLER_ID=app.session.handler.native_memcached
ddev config --web-environment-add SESSION_SAVE_PATH=memcached:11211
ddev restart
ddev php bin/console cache:clear
```

You can now check whether everything went right.

For example, `watch 'ddev exec netcat -w1 memcached 11211 <<< "stats" | grep "cmd_.et "'`

- tests that the `web` service accesses the `memcached` service,
- displays the increase of `cmd_get` and `cmd_set` while navigating into the website.
