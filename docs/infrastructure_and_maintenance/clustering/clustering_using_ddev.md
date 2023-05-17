# Clustering using DDEV

## Install Elasticsearch

```bash
ddev get ddev/ddev-elasticsearch
ddev config --web-environment-add SEARCH_ENGINE=elasticsearch
ddev config --web-environment-add ELASTICSEARCH_DSN=http://elasticsearch:9200
ddev restart
ddev exec php bin/console cache:clear
ddev exec php bin/console ibexa:reindex
```

You can now check that everything went right with, for example, `ddev exec curl -s "http://elasticsearch:9200/_count"`.
TODO: Detail a bit more this validation test

## Install Redis or Memcached

### Install Redis

```bash
ddev get ddev/ddev-redis
ddev config --web-environment-add CACHE_POOL=cache.redis
ddev config --web-environment-add CACHE_DSN=redis
ddev restart
ddev exec php bin/console cache:clear
```

### Install Memcached

```bash
ddev get ddev/ddev-memcached
ddev config --web-environment-add CACHE_POOL=cache.memcached
ddev config --web-environment-add CACHE_DSN=memcached
ddev restart
ddev exec php bin/console cache:clear
```

## Install Varnish

```bash
ddev get ddev/ddev-varnish
TODO
ddev restart
```
