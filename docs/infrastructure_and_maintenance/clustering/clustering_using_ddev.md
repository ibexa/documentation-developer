---
description: When you want to run locally a cluster infrastructure using DDEV.
---

# Clustering using DDEV

This guide follows [Getting started: Install using DDEV](../../getting_started/install_using_ddev.md) and helps to extend the previous installation to replicate locally a production [cluster](clustering.md).

!!! caution

    This is not to be used in production.
    And a staging environment for validation before production should replicat exactly the production environment.
    This is meant for development environment only.

TODO: Detail validation tests more

`ddev describe` can be used to get a summary of the cluster including accesses from inside and outside DDEV containers.

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
ddev exec php bin/console cache:clear
ddev exec php bin/console ibexa:elasticsearch:put-index-template
ddev exec php bin/console ibexa:reindex
```

You can now check that everything went right with, for example, `ddev exec curl -s "http://elasticsearch:9200/_count"`.

### Solr

TODO: Update add-on name after it has been moved to a more official repository.

To ease the installation of Solr, the specific add-on `ibexa-yuna/ddev-solr` can be used:

```bash
ddev get ibexa-yuna/ddev-solr
ddev restart
```

You can now test that Solr works properly with, for example, `ddev exec curl -s http://solr:8983/api/cores/` and check `collection1` status.

## Share persistence cache and sessions

A [persistence cache pool](../cache/persistence_cache.md#persistence-cache-configuration) and a [session handler](../sessions.md#session-handlers) can be added to the cluster.

The same service will be used to store both persistence cache and sessions.

The session handler will be set on Symfony side. TODO: It's possible to set session handlers on [PHP/PHP-FPM side](https://www.php.net/manual/en/session.configuration.php#ini.session.save-handler); Still, is this remark relevant?

### Install Redis

The following command lines

1. add the Redis container,
1. set up Redis as the cache pool,
1. set up Redis as the session handler,
1. restart the DDEV cluster and clear application cache.

```bash
ddev get ddev/ddev-redis
ddev config --web-environment-add CACHE_POOL=cache.redis
ddev config --web-environment-add CACHE_DSN=redis
ddev config --web-environment-add SESSION_HANDLER_ID='Ibexa\\Bundle\\Core\\Session\\Handler\\NativeSessionHandler'
ddev config --web-environment-add SESSION_SAVE_PATH=tcp://redis:6379
ddev restart
ddev exec php bin/console cache:clear
```

You can now check that everything went right.
For example, `ddev redis-cli MONITOR` will show some `"SETEX" "ezp:`, `"MGET" "ezp:`, `"SETEX" "PHPREDIS_SESSION:`, `"GET" "PHPREDIS_SESSION:`, etc. while navigating into the website, in particular the Back Office.

### Install Memcached

First, append the following [new service](https://doc.ibexa.co/en/latest/infrastructure_and_maintenance/sessions/#handling-sessions-with-memcached) to `config/config/services.yaml`:

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
ddev exec php bin/console cache:clear
```

You can now check that everything went right.
For example, `watch 'ddev exec --raw telnet memcached 11211 <<< "stats" | grep "cmd_.et "'` will display the increase of `cmd_get` and `cmd_set` while navigating into the website.

## TODO: Share binary files

TODO: To be closer to a production cluster, to simulate the binary file sharing could be useful

## Going further

TODO: Version control DDEV config, use .env.local, import db and binary contents
