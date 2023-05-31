# Clustering using DDEV

This guide follows [Getting started: Install using DDEV](../../getting_started/install_using_ddev.md) and helps to extend the previous installation to replicate locally a production [cluster](clustering.md).

!!! caution

    This is not to be use in production.
    And a staging environment for validation before production should replicat exactly the production environment.
    This is meant for development environment only.

TODO: Detail validation tests more

## Install search engine

A [search engine](../../search/search_engines.md) can be added to the cluster.

### Elasticsearch

The following command lines will
add the Elasticsearch container,
set it as the search engine,
restart the DDEV cluster and clean its cache to be taken into account,
then inject the schema and reindex the content:

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

## Install persistence cache pool

A [persistence cache pool](../cache/persistence_cache.md) can be added to the cluster.

For Redis or Memcached, the command lines to add and set up the service are almost the same.
The corresponding container is added,
environment variables are set to use the dedicated configuration and set the service hostname,
then DDEV cluster is restarted and its cache cleaned.

### Install Redis

```bash
ddev get ddev/ddev-redis
ddev config --web-environment-add CACHE_POOL=cache.redis
ddev config --web-environment-add CACHE_DSN=redis
ddev restart
ddev exec php bin/console cache:clear
```

You can now check that everything went right with `ddev redis-cli MONITOR` then navigating into the website.

### Install Memcached

```bash
ddev get ddev/ddev-memcached
ddev config --web-environment-add CACHE_POOL=cache.memcached
ddev config --web-environment-add CACHE_DSN=memcached
ddev restart
ddev exec php bin/console cache:clear
```

You can now check that everything went right with `watch 'ddev exec --raw telnet memcached 11211 <<< stats'` then navigating into the website.

## TODO: Session: Install/Use Redis Memcached

## TODO: Install Varnish

```bash
ddev get ddev/ddev-varnish
TODO
ddev restart
```
