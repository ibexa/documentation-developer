---
description: Use DDEV to run a cluster infrastructure locally.
---

# Clustering with DDEV

!!! caution

    Don't use this procedure in production.
    A staging environment for validation before production should exactly replicate the production environment.
    This is meant for development environment only.

This guide follows [Install with DDEV](install_with_ddev.md) and helps to extend the previous installation to locally replicate a production [cluster](clustering.md).

In contrast to a production cluster, this setup has only one front app server.
But the data sharing needed by a cluster of several servers can still be emulated.

The `ddev config --php-version` option should set the same PHP version as the production servers.

!!! tip

    - [`ddev describe`](https://ddev.readthedocs.io/en/latest/users/usage/commands/#describe) displays a cluster summary that include accesses from inside and outside DDEV services
    - [`ddev ssh`](https://ddev.readthedocs.io/en/latest/users/usage/commands/#ssh) opens a terminal inside a service
    - [`ddev exec`](https://ddev.readthedocs.io/en/latest/users/usage/commands/#exec) executes a command inside a service

   Discover more commands in [DDEV documentation](https://ddev.readthedocs.io/en/latest/users/usage/commands/).

To run an [[= product_name_cloud =]] project locally, you may refer to [DDEV and Ibexa Cloud](ddev_and_ibexa_cloud.md) instead.

## Install reverse proxy

### Varnish

The following sequence of commands:

1. Set some variables to distinguish Varnish versions, here for Varnish 7.1
2. Copy and customize VCL files in `.ddev/varnish/` (which will be mounted as `/etc/varnish/`)
    - set `web` container has the backend host and an invalidator (so back office can purge cache)
    - add "all IPs" CIDR notation to `debuggers` list to allow debugging info from any IP
    - on Varnish 7, enable logging of access control list matching for both `invalidators` and `debuggers` lists
      (new Varnish 7 syntax, it was enabled by default on previous versions)
3. Set the Varnish version to use and its demon starting parameters to use the files
4. Adds the Varnish container
5. Sets Varnish as the HTTP cache server
6. Restarts the DDEV cluster

```bash
VARNISH_VERSION=7.1
vcl_path=vcl_path
vcl_file=varnish7.vcl
mkdir -p .ddev/varnish
cp vendor/ibexa/http-cache/docs/varnish/vcl/$vcl_file .ddev/varnish/
sed 's/.host = "127.0.0.1";/.host = "web";/' vendor/ibexa/http-cache/docs/varnish/vcl/parameters.vcl > .ddev/varnish/parameters.vcl
sed -i '/^acl invalidators {$/a \\    "web";' .ddev/varnish/parameters.vcl
sed -i '/^acl debuggers {$/a \\    "0.0.0.0"/0; \/\/ debug from any IP' .ddev/varnish/parameters.vcl
if [[ $VARNISH_VERSION == 7.* ]]; then
  sed -i 's/acl invalidators {/acl invalidators +log {/' .ddev/varnish/parameters.vcl
  sed -i 's/acl debuggers {/acl debuggers +log {/' .ddev/varnish/parameters.vcl
fi
ddev dotenv set .ddev/.env.varnish --varnish-docker-image=varnish:$VARNISH_VERSION --varnish-varnishd-params " -p $vcl_path=/etc/varnish -f /etc/varnish/$vcl_file"

ddev get ddev/ddev-varnish

ddev config --web-environment-add HTTPCACHE_PURGE_SERVER=http://varnish
ddev config --web-environment-add HTTPCACHE_PURGE_TYPE=varnish
ddev config --web-environment-add TRUSTED_PROXIES=varnish

ddev restart
```

TODO: [Apache TRUSTED_PROXIES](https://github.com/ibexa/post-install/blob/main/resources/templates/apache2/vhost.template#L67)

To use Varnish 6.0LTS, set the following variables instead:

```bash
VARNISH_VERSION=6.0
vcl_path=vcl_dir
vcl_file=varnish6.vcl
```

The Varnish server replace the web server in some places.
If you run `ddev describe`, you can see that Varnish is now the one responding to DDEV domain `.ddev.site`
while the web server still replies to `127.0.0.1` with its own ports.

You can use `ddev varnishlog` command to monitor Varnish logs in real time.
Due to how parameters are passed to the container, you may have to wrap some parameters in quotes twice, for example, the purge request monitoring:

```bash
ddev varnishlog -q "'ReqMethod ~ PURGE.*'";
```

### Fastly

TODO: confirm and detail

For Fastly (as for [Ibexa Connect](https://doc.ibexa.co/projects/connect/en/latest/)), your instance must be visible from Internet.

To use [ngrok](https://ngrok.com/) alongside [`ddev share`](https://docs.ddev.com/en/stable/users/topics/sharing/#using-ddev-share-easiest) is probably the easiest way to achieve this.
TODO: Be very careful with closing ngrok tunnels when not needed anymore, to not communicate your ngrok URL to unintended people (don't use it for demo, don't store it on a Fastly or Ibexa Connect account used by too many people), etc.

## Install search engine

A [search engine](search_engines.md) can be added to the cluster.

### Elasticsearch

The following sequence of commands:

1. Adds the Elasticsearch container
2. Sets Elasticsearch as the search engine
3. Restarts the DDEV cluster and clears application cache
4. Injects the schema and reindexes the content

```bash
ddev add-on get ddev/ddev-elasticsearch
ddev config --web-environment-add SEARCH_ENGINE=elasticsearch
ddev config --web-environment-add ELASTICSEARCH_DSN=http://elasticsearch:9200
ddev restart
ddev php bin/console cache:clear
ddev php bin/console ibexa:elasticsearch:put-index-template
ddev php bin/console ibexa:reindex
```

You can now check whether Elasticsearch works.

For example, the `ddev exec curl -s "http://elasticsearch:9200/_count"` command checks whether the `web` server can access the `elasticsearch` server and displays the number of indexed documents.

For more information on topics such as memory management, see [ddev/ddev-elasticsearch README](https://github.com/ddev/ddev-elasticsearch).

See [Elasticsearch REST API reference](https://www.elastic.co/docs/reference/elasticsearch/rest-apis) for more request options, like, for example:

- [`_count`](https://www.elastic.co/docs/api/doc/elasticsearch/operation/operation-count), as seen above
- [`_cluster/health`](https://www.elastic.co/docs/api/doc/elasticsearch/operation/operation-cluster-health) (don't mind the "yellow" status which is normal in the absence of replicas in the DDEV container)
- [`_search?size=0"`](https://www.elastic.co/docs/api/doc/elasticsearch/operation/operation-search), which is another way to get document count

!!! tip

    You can use [`jq`](https://jqlang.org/) to format and colorize Elasticsearch REST API outputs.

### Solr

The following sequence of commands:

1. Adds the Solr container
2. Sets Solr as the search engine
3. Start the DDEV cluster to creates core config by combining default files and those provided by [[= product_name =]]
4. Restarts the DDEV cluster and clears application cache
5. Reindexes the content

```bash
ddev add-on get ddev/ddev-solr
ddev config --web-environment-add SEARCH_ENGINE=solr
ddev config --web-environment-add SOLR_DSN=http://solr:8983/solr
ddev config --web-environment-add SOLR_CORE=collection1
ddev start
mkdir .ddev/solr/configsets/collection1
ddev exec -s solr cp -R /opt/solr/server/solr/configsets/_default/conf/* /mnt/ddev_config/solr/configsets/collection1/
cp -R vendor/ibexa/solr/src/lib/Resources/config/solr/* .ddev/solr/configsets/collection1/
ddev restart
ddev php bin/console cache:clear
ddev php bin/console ibexa:reindex
```

You can now check whether Solr works.

For example, the `ddev exec curl -s http://solr:SolrRocks@solr:8983/api/cores/` command:

 - checks whether the `web` server can access the `solr` server
 - checks whether `collection1` exists and its status
 - displays `collection1`'s `numDocs` that shouldn't be zero if indexing worked correctly

You can access the Solr admin UI from the host by:

- running `ddev solr-admin` command
- accessing port 8983 on the same `.ddev.site` subdomain than the web server (you can use `ddev describe` to get this URL)

Use the credentials username `solr` and password `SolrRocks`.

For more information on topics such as available versions of Solr, see [ddev/ddev-solr README](https://github.com/ddev/ddev-solr).

## Share cache and sessions

You can add a [persistence cache pool](persistence_cache.md#persistence-cache-configuration) and a [session handler](sessions.md#session-handlers) to the cluster.

In the following examples:

- the same service is used to store both persistence cache and sessions
- the session handler is set on Symfony side, not on PHP side

### Install Redis

The following sequence of commands:

1. Adds the Redis container.
1. Set Redis as the cache pool.
1. Sets Redis as the session handler.
1. Changes `maxmemory-policy` from default `allkeys-lfu` to a [value accepted by the `RedisTagAwareAdapter`](https://github.com/symfony/cache/blob/5.4/Adapter/RedisTagAwareAdapter.php#L95).
1. Restarts the DDEV cluster and clears application cache.

```bash
ddev add-on get ddev/ddev-redis
ddev config --web-environment-add CACHE_POOL=cache.redis
ddev config --web-environment-add CACHE_DSN=redis
ddev config --web-environment-add SESSION_HANDLER_ID='Ibexa\\Bundle\\Core\\Session\\Handler\\NativeSessionHandler'
ddev config --web-environment-add SESSION_SAVE_PATH=tcp://redis:6379
sed -i 's/maxmemory-policy allkeys-lfu/maxmemory-policy volatile-lfu/' .ddev/redis/redis.conf;
ddev restart
ddev php bin/console cache:clear
```

You can now check whether Redis works.

For example, the `ddev redis-cli MONITOR` command returns outputs, for example, `"SETEX" "ezp:`, `"MGET" "ezp:`, `"SETEX" "PHPREDIS_SESSION:`, or `"GET" "PHPREDIS_SESSION:`, while navigating into the website, in particular the back office.

See [Redis commands](https://redis.io/docs/latest/commands/) for more details such as information about the [`MONITOR`](https://redis.io/docs/latest/commands/monitor/) command used in the previous example.
