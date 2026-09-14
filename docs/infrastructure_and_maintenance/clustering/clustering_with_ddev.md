---
month_change: false
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

    - [`ddev describe`](https://docs.ddev.com/en/stable/users/usage/commands/#describe) displays a cluster summary that include accesses from inside and outside DDEV services
    - [`ddev ssh`](https://docs.ddev.com/en/stable/users/usage/commands/#ssh) opens a terminal inside a service
    - [`ddev exec`](https://docs.ddev.com/en/stable/users/usage/commands/#exec) executes a command inside a service

   Discover more commands in [DDEV documentation](https://docs.ddev.com/en/stable/users/usage/commands/).

## Install reverse proxy

A reverse proxy can be added to the cluster to enable [HTTP caching](http_cache.md).

### Varnish

The following sequence of commands:

1. Sets a variable with the desired Varnish version, here Varnish 7.1
2. Copies and customizes `parameters.vcl` file in `.ddev/varnish/` (which is mounted as `/etc/varnish/` into the container):
    - sets `web` container as the backend host and an invalidator (so back office can purge cache)
    - adds "all IPs" CIDR notation to `debuggers` list to allow debugging from any IP
    - on Varnish 7, enable logging of access control list matching for both `invalidators` and `debuggers` lists
      (new Varnish 7 syntax, it was enabled by default on previous versions)
3. Sets main `varnish*.vcl` file to use and "path to VCL directory" argument name depending on Varnish version
4. Copies the main VCL file to `.ddev/varnish/`
5. Sets the Varnish version to use and its demon starting parameters to use the files
6. Adds the Varnish container
7. Sets Varnish as the HTTP cache server
8. Restarts the DDEV cluster and clear the [[= product_name =]] cache

```bash
VARNISH_VERSION=7.1
mkdir -p .ddev/varnish
sed 's/.host = "127.0.0.1";/.host = "web";/' vendor/ibexa/http-cache/docs/varnish/vcl/parameters.vcl > .ddev/varnish/parameters.vcl
sed -i '/^acl invalidators {$/a \\    "web";' .ddev/varnish/parameters.vcl
sed -i '/^acl debuggers {$/a \\    "0.0.0.0"/0; \/\/ debug from any IP' .ddev/varnish/parameters.vcl
if [[ $VARNISH_VERSION == 7.* ]]; then
  sed -i 's/acl invalidators {/acl invalidators +log {/' .ddev/varnish/parameters.vcl
  sed -i 's/acl debuggers {/acl debuggers +log {/' .ddev/varnish/parameters.vcl
  vcl_path=vcl_path
  vcl_file=varnish7.vcl
elif [[ $VARNISH_VERSION == 6.* ]]; then
  vcl_path=vcl_dir
  vcl_file=varnish6.vcl
fi
cp vendor/ibexa/http-cache/docs/varnish/vcl/$vcl_file .ddev/varnish/
ddev dotenv set .ddev/.env.varnish --varnish-docker-image=varnish:$VARNISH_VERSION --varnish-varnishd-params " -p $vcl_path=/etc/varnish -f /etc/varnish/$vcl_file"

ddev add-on get ddev/ddev-varnish

ddev config --web-environment-add HTTPCACHE_PURGE_SERVER=http://varnish
ddev config --web-environment-add HTTPCACHE_PURGE_TYPE=varnish
ddev config --web-environment-add TRUSTED_PROXIES=varnish

ddev restart
ddev php bin/console cache:clear
```

To use Varnish 6.0LTS, set the following variable instead:

```bash
VARNISH_VERSION=6.0
```

If you're using [Apache as web server](install_with_ddev.md#switch-to-apache-and-its-virtual-host),
you must set `varnish` as a trusted proxy in `.ddev/apache/apache-site.conf` before restarting DDEV:

```bash
sed -i 's/#SetEnv TRUSTED_PROXIES ""/SetEnv TRUSTED_PROXIES "varnish"/' .ddev/apache/apache-site.conf

ddev restart
```

The Varnish server acts as the application’s primary entry point.
If you run `ddev describe`, you can see that Varnish is now the one responding to DDEV domain `.ddev.site`
while the web server still replies to `127.0.0.1` with its own ports.

You can see Varnish headers in HTTP responses, for example:

```console
% curl -s -c cookies.txt -b cookies.txt -I https://<your-project>.ddev.site:<https-port>/
HTTP/2 200 
server: Apache/2.4.65 (Debian)
vary: Origin,X-Editorial-Mode
via: 1.1 varnish (Varnish/7.1)
x-cache: HIT
x-cache-debug: 1
x-cache-hits: 5
x-cache-ttl: 87654.321
x-debug-token: 012345
x-debug-token-link: https://<your-project>.ddev.site:<https-port>//_profiler/012345
x-powered-by: Ibexa Experience v5
x-robots-tag: noindex
x-varnish: 12345 67890
xkey: ez-all c52 ct42 l2 pl1 p1 p2
content-length: 45678
```

You can see how the `web` server is responding to `varnish`:

```console
% curl -s -H "Surrogate-Capability: abc=ESI/1.0" http://127.0.0.1:<http-web-port>/product-catalog | grep 'esi:include'
            <esi:include src="/_fragment?_hash=…
```

To explore more the communication between the web server and Varnish, you can find other examples of requests done directly to the web server while impersonating Varnish in [Fetching user context hash](content_aware_cache.md#fetching-user-context-hash) and [Fetching HTML response](content_aware_cache.md#fetching-html-response).

You can use `ddev varnishlog` command to monitor Varnish logs in real time.
Due to how parameters are passed to the container, you may have to wrap some parameters in quotes twice, for example, the purge request monitoring:

```bash
ddev varnishlog -q "'ReqMethod ~ PURGE.*'";
```

For more information on topics such as available configurations, command lines, or monitoring, see [ddev/ddev-varnish README](https://github.com/ddev/ddev-varnish).

### Fastly

For Fastly (as for [[[= product_name_connect =]]]([[= connect_doc =]]/)), the instance must be visible from Internet.

To use [ngrok](https://ngrok.com/) alongside [`ddev share`](https://docs.ddev.com/en/stable/users/topics/sharing/#using-ddev-share-easiest) is probably the easiest way to achieve this.

Be careful when making a local development instance visible from the internet.
For example:

- close ngrok tunnels when not needed anymore
- keep your ngrok URL private and share it only with trusted recipients
- don't use it for live demo where the URL could be seen
- don't store it on a Fastly or [[= product_name_connect =]] accounts used by external people

See [Configure and customize Fastly](fastly.md) for the Fastly side.

## Install search engine

A [search engine](search_engines.md) can be added to the cluster.

### Elasticsearch

The installation of Elasticsearch within a DDEV stack is an adaptation of the [on-premise installation](install_elasticsearch.md) procedure using the [`ddev/ddev-elasticsearch` add-on](https://addons.ddev.com/addons/ddev/ddev-elasticsearch).

For example, the following sequence of commands:

1. Adds the Elasticsearch container
2. Sets the Elasticsearch version to 8 (default is 9 which is not supported, 7 is supported) - a full version number is required, see [Elasticsearch Docker image](https://hub.docker.com/_/elasticsearch)
3. Sets Elasticsearch as the search engine
4. Restarts the DDEV cluster and clears application cache
5. Injects the schema and reindexes the content

```bash
ddev add-on get ddev/ddev-elasticsearch
ddev dotenv set .ddev/.env.elasticsearch --elasticsearch-docker-image=elasticsearch:8.19.18
cp .ddev/elasticsearch/docker-compose.elasticsearch8.yaml .ddev/
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

The installation of Solr within a DDEV stack is an adaptation of the [on-premise installation](install_solr.md) procedure using the [`ddev/ddev-solr` add-on](https://addons.ddev.com/addons/ddev/ddev-solr).

For example, the following sequence of commands:

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

### Install Redis or Valkey

DDEV supports multiple Redis-compatible implementation, including Redis itself and Valkey.
You can switch between them using the `ddev redis-backend <backend>` command after adding the `ddev/ddev-redis` add-on.
For example, you can switch to Valkey by running `ddev add-on get ddev/ddev-redis; ddev redis-backend valkey/valkey:9`.
For more information, see [Swappable Redis backends](https://github.com/ddev/ddev-redis?tab=readme-ov-file#swappable-redis-backends) in DDEV's `dddev-redis` add-on documentation.

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

You can now check whether the data store backend works.

For example, the `ddev redis-cli MONITOR` command returns outputs, for example, `"SETEX" "ezp:`, `"MGET" "ezp:`, `"SETEX" "PHPREDIS_SESSION:`, or `"GET" "PHPREDIS_SESSION:`, while navigating into the website, in particular the back office.

See [Redis commands](https://redis.io/docs/latest/commands/) for more details such as information about the [`MONITOR`](https://redis.io/docs/latest/commands/monitor/) command used in the previous example.
