---
description: When you want to run locally a cluster infrastructure using DDEV.
---

# Clustering using DDEV

This guide follows [Getting started: Install using DDEV](../../getting_started/install_using_ddev.md) and helps to extend the previous installation to replicate locally a production [cluster](clustering.md).

Contrary to production cluster, there will be only one front app server. But the data sharing needed by a cluster of several servers can still be emulated.
TODO: Maybe a second `web` server can be added…?

The `ddev config --php-version` option should set the same PHP version as the production servers.

!!! caution

    This is not to be used in production.
    And a staging environment for validation before production should replicat exactly the production environment.
    This is meant for development environment only.

!!! tip
 
    - [`ddev describe`](https://ddev.readthedocs.io/en/latest/users/usage/commands/#describe) display a summary of the cluster including accesses from inside and outside DDEV services.
    - [`ddev ssh`](https://ddev.readthedocs.io/en/latest/users/usage/commands/#ssh) opens a terminal inside a service.
    - [`ddev exec`](https://ddev.readthedocs.io/en/latest/users/usage/commands/#exec) executes a command inside a service.

    [Discover more commands on DDEV documentation](https://ddev.readthedocs.io/en/latest/users/usage/commands/)

TODO: Document [`ddev get --remove`](https://ddev.readthedocs.io/en/latest/users/extend/additional-services/#viewing-and-removing-installed-add-ons) when DDEV 1.22 is out https://github.com/ddev/ddev/milestone/54

## TODO: Install Varnish

## Install search engine

A [search engine](../../search/search_engines.md) can be added to the cluster.

### Elasticsearch

The following command lines will

1. add the Elasticsearch container,
1. set it up as the search engine,
1. restart the DDEV cluster and clear application cache,
1. then inject the schema and reindex the content.

```bash
ddev get ddev/ddev-elasticsearch
ddev config --web-environment-add SEARCH_ENGINE=elasticsearch
ddev config --web-environment-add ELASTICSEARCH_DSN=http://elasticsearch:9200
ddev restart
ddev php bin/console cache:clear
ddev php bin/console ibexa:elasticsearch:put-index-template
ddev php bin/console ibexa:reindex
```

You can now check that Elasticsearch works properly.

For example, `ddev exec curl -s "http://elasticsearch:9200/_count"` will

- test that the `web` server is accessing `elasticsearch` server,
- display the number of indexed documents.

See [ddev/ddev-elasticsearch's README](https://github.com/ddev/ddev-elasticsearch) for more like memory management.

See [Elasticsearch REST API reference](https://www.elastic.co/guide/en/elasticsearch/reference/current/rest-apis.html) for more request possibilities like

- the [`_count`](https://www.elastic.co/guide/en/elasticsearch/reference/current/search-count.html) from the above test,
- or [`_cluster/health`](https://www.elastic.co/guide/en/elasticsearch/reference/current/cluster-health.html) (don't mind the "yellow" status),
- or [`_search?size=0"`](https://www.elastic.co/guide/en/elasticsearch/reference/current/search-search.html) (which is another way to get document count).

!!! tip

    [`jq`](https://jqlang.github.io/jq/) can be used to format and colorize Elasticsearch REST API outputs

### Solr

TODO: Update add-on name after it has been moved to official repository.

To ease the installation of Solr, the specific add-on `ibexa-yuna/ddev-solr` can be used:

```bash
ddev get ibexa-yuna/ddev-solr
ddev restart
```

You can now test that Solr works properly.

For example, `ddev exec curl -s http://solr:8983/api/cores/` will

- test that the `web` server is accessing `solr` server,
- test `collection1` existence and status,
- display `collection1`'s `numDocs` that should non-zero if indexing worked correctly. 

The Solr admin can be accessed from the host by using the port 8983 on the same `.ddev.site` subdomain than the front. Use `ddev describe` to have that URL.

## Share persistence cache and sessions

A [persistence cache pool](../cache/persistence_cache.md#persistence-cache-configuration) and a [session handler](../sessions.md#session-handlers) can be added to the cluster.

The same service will be used to store both persistence cache and sessions.

The session handler will be set on Symfony side. TODO: It's possible to set session handlers on [PHP/PHP-FPM side](https://www.php.net/manual/en/session.configuration.php#ini.session.save-handler); Still, is this remark relevant?

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

You can now check that Redis works properly.

For example, `ddev redis-cli MONITOR` will show some `"SETEX" "ezp:`, `"MGET" "ezp:`, `"SETEX" "PHPREDIS_SESSION:`, `"GET" "PHPREDIS_SESSION:`, etc. while navigating into the website, in particular the Back Office.

See [Redis commands](https://redis.io/commands/) for more details like about the [`MONITOR`](https://redis.io/commands/monitor/) used in the previous example.

### Install Memcached

First, if not already there, append the following [new service](https://doc.ibexa.co/en/latest/infrastructure_and_maintenance/sessions/#handling-sessions-with-memcached) to `config/config/services.yaml`:

```yaml
    app.session.handler.native_memcached:
        class: Ibexa\Bundle\Core\Session\Handler\NativeSessionHandler
        arguments:
            - '%session.save_path%'
            - memcached
```

Second, install and set up the add-on.
The following command lines

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

You can now check that everything went right.

For example, `watch 'ddev exec netcat -w1 memcached 11211 <<< "stats" | grep "cmd_.et "'` will

- test that the `web` service accesses the `memcached` service,
- display the increase of `cmd_get` and `cmd_set` while navigating into the website.

## Share binary files

[Binary file sharing](clustering.md#dfs-io-handler) can be implemented to be closer to a production cluster.

It requires Ibexa's recommenced Apache Virtual Host or Nginx Server Blocks to work. See [Install using DDEV / Webserver configuration](../../getting_started/install_using_ddev.md#webserver-configuration).
If [Nginx Server Blocks](../../getting_started/install_using_ddev.md#nginx-server-blocks) were previously set, replace `ibexa_rewrite_image_params` with `ibexa_rewrite_dfsimage_params` in `.ddev/nginx_full/ibexa.conf`.

The example below uses the same database for DXP content and DFS metadata (contrary to production recommendation).
The DFS directory (not shared among servers) is in the Docker volume shared by the DDEV container and the host.

```bash
ddev config --web-environment-add BINARY_DATA_HANDLER=dfs;
ddev config --web-environment-add DFS_NFS_PATH=/var/www/html/var/nfs;
```

To install existing contents from another instance (like in [Run an already existing project](../../getting_started/install_using_ddev.md#run-an-already-existing-project)), the `ezdfsfile` table must also be imported and the binary files copied into the `DFS_NFS_PATH`.

TODO: Needs https://github.com/ibexa/core/pull/182 to work

## Going further

TODO: Version control DDEV config, use .env.local, import db and binary contents
