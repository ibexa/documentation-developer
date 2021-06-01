# Persistence cache

![SPI cache diagram](img/spi_cache.png)

## Layers

Persistence cache can best be described as an implementation of `SPI\Persistence` that decorates the main backend implementation *(currently: "Legacy Storage Engine")*.

As shown in the illustration, this is done in the exact same way as the SignalSlot feature is a custom implementation of `API\Repository` decorating the main Repository. In the case of Persistence Cache, instead of sending events on calls passed on to the decorated implementation, most of the load calls are cached, and calls that perform changes purge the affected caches. This is done using a Cache service which is provided by StashBundle; this Service wraps around the Stash library to provide Symfony logging / debugging functionality, and allows cache handlers *(Memcached, Redis, Filesystem, etc.)* to be configured using Symfony configuration. For how to reuse this Cache service in your own custom code, see below.

## Transparent cache

With the persistence cache, just like with the HTTP cache, eZ Platform tries to follow principles of "Transparent caching", this can shortly be described as a cache which is invisible to the end user and to the admin/editors of eZ Platform where content is always returned "fresh". In other words, there should be no need to manually clear the cache like it was frequently the case with eZ Publish 4.x. This is possible thanks to an interface that follows CRUD *(Create Read Update Delete)* operations per domain, and the fact that the number of other operations capable of affecting a certain domain is kept to a minimum.

### Entity stored only once

To make the transparent caching principle as effective as possible, entities are, as much as possible, only stored once in cache by their primary id. Lookup by alternative identifiers (`identifier`, `remoteId`, etc.) is only cached with the identifier as cache key and primary `id` as its cache value, and compositions *(list of objects)* usually keep only the array of primary IDs as their cache value.

This means a couple of things:

- Memory consumption is kept low
- Cache purging logic is kept simple (For example: `$sectionService->delete( 3 )` clears `section/3` cache entry)
- Lookup by `identifier` and list of objects needs several cache lookups to be able to assemble the result value
- Cache warmup usually takes several page loads to reach full as identifier is first cached, then the object

## What is cached?

Persistence cache aims at caching most `SPI\Persistence` calls used in common page loads, including everything needed for permission checking and URL alias lookups.

Notes:

- `UrlWildCardHandler` is not currently cached
- Currently in case of transactions this is handled very simply by clearing all cache on rollback, this can be improved in the future if needed.
- Some tree/batch operations will cause clearing all persistence cache, this will be improved in the future when we change to a cache service cable of cache tagging.
- Search is not defined as Persistence and the queries themselves are not planned to be cached. Use [Solr](search/solr.md) which does this for you to improve scale and offload your database.

*For further details on which calls are cached or not, and where/how to contribute additional caches, see the [source](https://github.com/ezsystems/ezpublish-kernel/tree/v6.13.6/eZ/Publish/Core/Persistence/Cache).*

## Persistence cache configuration

!!! note

    Current implementation uses a caching library called [Stash](http://stash.tedivm.com/) (via [StashBundle](https://github.com/tedivm/TedivmStashBundle)). Stash supports the following cache backends: FileSystem, Memcache, APC, Sqlite, Redis and BlackHole.

*Use of Memcached or Redis is a requirement for use in Clustering setup. For an overview of this feature, see [Clustering](clustering.md).*

!!! note

    When eZ Platform changes to another PSR-6 based cache system in the future, then configuration documented below will change.

**Cache service**

The cache system is exposed as a "cache" service, and can be reused by any other service as described in the [Using Cache service](#using-cache-service) section.

### Configuration

By default, configuration currently uses **FileSystem**, with `%kernel.cache_dir%/stash` to store cache files.

The configuration is placed in `app/config/config.yml` and looks like this:

``` yaml
# Default config.yml
stash:
    caches:
        default:
            drivers:
                - FileSystem
            inMemory: true
            registerDoctrineAdapter: false
```

!!! note "Note for inMemory cache with long running scripts"

    Use `inMemory` with caution, and avoid it completely for long running scripts for the following reasons:

    - It does not have any limits, so can result in the application running out of PHP memory.
    - Its cache pool is by design a PHP variable and is not shared across requests/processes/servers, so data becomes stale if any other concurrent activity happens towards the Repository.

#### Multi Repository setup

You can [configure multisite to work with multiple repositories](multisite.md#multisite-with-multiple-repositories).
Then, in `ezplatform.yml` you can specify which cache pool you want to use on a SiteAccess or SiteAccess group level.

The following example shows use in a SiteAccess group:

``` yaml
# ezplatform.yml site group setting
ezpublish:
    system:
        # "site_group" refers to the group configured in site access
        site_group:
            # "default" refers to the cache pool, the one configured on stash.caches above
            cache_pool_name: default
```

!!! note "One cache pool for each Repository"

    If your installation has several Repositories *(databases)*, make sure every group of sites using different Repositories also uses a different cache pool.

### Stash cache backend configuration

#### General settings

To check which cache settings are available for your installation, run the following command in your terminal:

``` bash
php app/console config:dump-reference stash
```

#### FileSystem

This cache backend uses the local filesystem, by default the Symfony cache folder. As this is per server, it does not support [multi-server (cluster) setups](clustering.md)!

!!! caution

    **We strongly discourage storing cache files on NFS**, as it defeats the purpose of the cache: speed.

##### Available settings

|Setting|Description|
|------|------|
|`path`|The path where the cache is placed; default is ``%kernel.cache_dir%/stash`, effectively `app/cache/<env>/stash`|
|`dirSplit`|Number of times the cache key should be split up to avoid having too many files in each folder; default is 2.|
|`filePermissions`|The permissions of the cache file; default is 0660.|
|`dirPermissions`|The permission of the cache file directories (see dirSplit); default is 0770.|
|`memKeyLimit`|Limit on how many key to path entries are kept in memory during execution at a time to avoid having to recalculate the path on key lookups; default is 200.|
|`keyHashFunction`|Algorithm used for creating paths; default is md5. Use crc32 on Windows to avoid path length issues.|

!!! note "Issues with Microsoft Windows"

    If you are using Windows, you may encounter an issue regarding **long paths for cache directory name**. The paths are long because Stash uses md5 to generate unique keys that are sanitized really quickly.

    Solution is to **change the hash algorithm** used by Stash.

    **Specifying key hash function**

    ``` yaml
    stash:
        caches:
            default:
                drivers:
                    - FileSystem
                inMemory: true
                registerDoctrineAdapter: false
                FileSystem:
                    keyHashFunction: 'crc32'
    ```

    You can also define the **path** where you want the cache files to be generated to be able to get even shorter system path for cache files.

#### FileSystem cache backend troubleshooting

By default, Stash Filesystem cache backend stores cache to a sub-folder named after the environment (i.e. `app/cache/dev`, `app/cache/prod`). This can lead to the following issue: if different environments are used for operations, persistence cache (manipulating content, mostly) will be affected and cache can become inconsistent.

To prevent this, there are 2 solutions:

##### 1. Manual

**Always** use the same environment, for web, command line, cronjobs etc.

##### 2. Share stash cache across Symfony environments (prod / dev / ..)

Either by using another Stash cache backend, or by setting Stash to use a shared cache folder that does not depend on the environment.

``` yaml
# ezplatform.yml
stash:
    caches:
        default:
            FileSystem:
                path: "%kernel.root_dir%/cache/common"
```

This will store stash cache to `app/cache/common.`

#### APC and APCu

This cache backend is using shard memory with APC's user cache feature. As this is per server, it does not support [multi-server (cluster) setups](clustering.md) .

!!! note "Not supported because of following limitation"

    As APC(u) user cache is not shared between processes, it is not possible to clear the user cache from CLI, even if you set `apc.enable_cli` to On. That is why publishing content from a command line script won't let you properly clear SPI Persistence cache.

Also note that the default value for `apc.shm_size` is 128MB. However, 256MB is recommended for APC to work properly. For more details refer to the [APC configuration manual](http://www.php.net/manual/en/apc.configuration.php#ini.apc.shm-size).

**Available settings**

|Setting||
|-----|-----|
| `ttl` | The time to live of the cache in seconds; default is 500 (8.3 minutes)                                                                         |
| `namespace` | A namespace to prefix cache keys with to avoid key conflicts with other eZ Platform sites on same eZ Platform installation; default is `null`. |

### Redis

This cache backend is using [Redis, a in-memory data structure store](http://redis.io/), via [Redis pecl extension](https://pecl.php.net/package/redis). This is an alternative cache solution for [multi-server (cluster) setups](clustering.md), besides using Memcached.

**Available settings**

|||
|------|------|
|`servers`|Array of Redis servers:</br>`server`: Host or IP of your Redis server</br>`port`: Port that Redis is listening to (default: 6379)</br>`ttl`: Optional float value of connection timeout in seconds</br>`socket`: Optional boolean value to specify if server refers to a socket (default: false)|
|`password`|Optional setting if there is a password to connection to a given Redis server in plain text over the network.|
|`database`|Optional setting to specify a given Redis database to use.|

**Example**

``` yaml
# config.yml example
stash:
    caches:
        default:
            drivers: [ Redis ]
            Redis:
                servers:
                    -
                        server: 'redis1.ez.no'
                        port: 6379
                    -
                        server: 'redis2.ez.no'
                        port: 6379
```

!!! caution "Clearing Redis cache"

    The regular `php app/console cache:clear` command does not clear Redis persistence cache.
    To clear it, use the console command shipped with Redis: `redis-cli flushall`.

!!! tip

    If you use the Redis cache driver and encounter problems with high memory consumption,
    you can use the following (non-SiteAccess-aware) settings:

    ``` yaml
    ezpublish:
        stash_cache:
            igbinary: true/false
            lzf: true/false
    ```

    - `ezpublish.stash_cache.igbinary` enables you to use the `igbinary` library to serialize objects stored in cache.
    - `ezpublish.stash_cache.lzf` enables you to use the `LZF` library to compress serialized objects stored in cache.

    After changing these settings you need to clear cache and purge Redis content (see above).

##### Redis Cluster

It is possible to set up and use Redis as a cluster. This configuration is more efficient and reliable for large installations. Redis Cluster can be configured in two ways, the first using [create-cluster script](https://redis.io/topics/cluster-tutorial) and the second using [Redis Sentinel](https://redis.io/topics/sentinel). If you use Platform.sh Enterprise you can benefit from the Redis Sentinel across three nodes for greater fault tolerance. Platform.sh Professional and lower versions offer Redis in single instance mode only. Configuration on eZ Platform / Symfony stays the same regardless of the Redis version, single instance mode or cluster mode.

### Memcache(d)

This cache backend is using [Memcached, a distributed caching solution](http://memcached.org/). This is the main supported cache solution for [multi server (cluster) setups](clustering.md), besides using Redis.

!!! note

    Stash supports both the [php-memcache](http://php.net/memcache) and [php-memcached](http://php.net/memcached) extensions. **However** only php-memcached is officially supported as php-memcache is missing many features and is less stable.

**Available settings**

|Setting|Description"
|------|------|
|`servers`|Array of Memcached servers, with host/IP, port and weight</br>`server`: Host or IP of your Memcached server</br>`port`: Port that Memcached is listening to (defaults to 11211)</br>weight: Weight of the server, when using several Memcached servers|
|`prefix_key`|A namespace to prefix cache keys with to avoid key conflicts with other eZ Platform sites on same eZ Platform installation (default is an empty string). Must be the same on all servers with the same installation. See [Memcached prefix_key option](http://www.php.net/manual/en/memcached.constants.php#memcached.constants.opt-prefix-key)|
|`compression`|default true. [See Memcached compression option](http://www.php.net/manual/en/memcached.constants.php#memcached.constants.opt-compression)|
|`libketama_compatible`|default false. See [Memcached libketama_compatible option](http://www.php.net/manual/en/memcached.constants.php#memcached.constants.opt-libketama-compatible)|
|`buffer_writes`|default false. See [Memcached buffer_writes option](http://www.php.net/manual/en/memcached.constants.php#memcached.constants.opt-buffer-writes)|
|`binary_protocol`|default false. See [Memcached binary_protocol option](http://www.php.net/manual/en/memcached.constants.php#memcached.constants.opt-binary-protocol)|
|`no_block`|default false. See [Memcached no_block option](http://www.php.net/manual/en/memcached.constants.php#memcached.constants.opt-no-block)|
|`tcp_nodelay`|default false. See [Memcached tcp_nodelay option](http://www.php.net/manual/en/memcached.constants.php#memcached.constants.opt-tcp-nodelay)|
|`connection_timeout`|default 1000. See [Memcached connection_timeout option](http://www.php.net/manual/en/memcached.constants.php#memcached.constants.opt-connection-timeout)|
|`retry_timeout`|default 0. See [Memcached retry_timeout option](http://www.php.net/manual/en/memcached.constants.php#memcached.constants.opt-memcached-timeout)|
|`send_timeout`|default 0. See [Memcached send_timeout option](http://www.php.net/manual/en/memcached.constants.php#memcached.constants.opt-send-timeout)|
|`recv_timeout`|default 0. See [Memcached recv_timeout option](http://www.php.net/manual/en/memcached.constants.php#memcached.constants.opt-recv-timeout)|
|`poll_timeout`|default 1000. See [Memcached poll_timeout option](http://www.php.net/manual/en/memcached.constants.php#memcached.constants.opt-poll-timeout)|
|`cache_lookups`|default false. See [Memcached cache_lookups option](http://www.php.net/manual/en/memcached.constants.php#memcached.constants.opt-cache-lookups)|
|`server_failure_limit`|default 0. See [PHP Memcached documentation](http://www.php.net/manual/en/memcached.constants.php#memcached.constants.opt-server-failure-limit)|
|`socket_send_size`|See [Memcached socket_send_size option](http://www.php.net/manual/en/memcached.constants.php#memcached.constants.opt-socket-send-size)|
|`socket_recv_size`|See [Memcached socket_recv_size option](http://www.php.net/manual/en/memcached.constants.php#memcached.constants.opt-socket-recv-size)|
|`serializer`|See [Memcached serializer option](http://www.php.net/manual/en/memcached.constants.php#memcached.constants.opt-serializer)|
|`hash`|See [Memcached hash option](http://www.php.net/manual/en/memcached.constants.php#memcached.constants.opt-hash)|
|`distribution`|Specifies the method of distributing item keys to the servers. See [Memcached distribution option](http://www.php.net/manual/en/memcached.constants.php#memcached.constants.opt-distribution) \*|

\* All settings except `servers` are only available with memcached PHP extension. See [more information on these settings and which version of php-memcached they are available in](http://php.net/Memcached).

When using Memcache cache backend, you *may* use inMemory to reduce network traffic as long as you are aware of its limitations mentioned above. However you should disable in web servers where there is concurrency on updates, for instance on dedicated editorial server.

#### Example with Memcache(d)

Note that `app/config/config.yml` contains the default stash configuration. To apply the configuration below, make sure you update the existing configuration, or remove it if you want to use another configuration file.

``` yaml
stash:
    caches:
        default:
            drivers: [ Memcache ]
            inMemory: true
            registerDoctrineAdapter: false
            Memcache:
                prefix_key: ezdemo_
                retry_timeout: 1
                servers:
                    -
                        server: 127.0.0.1
                        port: 11211
```

!!! caution "Connection errors issue"

    If Memcached does display connection errors when using the default (ascii) protocol, then switching to binary protocol *(in the stash configuration and Memcached daemon)* should resolve the issue.

## Using Cache Service

Using the internal cache service allows you to use an interface and without caring whether the system is configured to place the cache in Memcached or on File system.
And as eZ Platform requires that instances use a cluster-aware cache in Cluster setup, you can safely assume your cache is shared *(and invalidated)* across all web servers.

!!! caution "Use unique vendor prefix for Cache key"

    When reusing the cache service within your own code, it is very important to not conflict with the cache keys used by others.
    That is why the example of usage below starts with a unique `myApp` key.
    For the namespace of your own cache, you must do the same.
    So never clear cache using the cache service without your key specified, otherwise you'll clear all cache.

#### Get Cache service

##### Via Dependency injection

In your Symfony services configuration you can simply define that you require the "cache" service in your configuration like so:

``` yaml
# yml configuration
    myApp.myService:
        class: '%myApp.myService.class%'
        arguments:
            - '@ezpublish.cache_pool'
```

The "cache" service is an instance of the following class: `Tedivm\StashBundle\Service\CacheService`

##### Via Symfony Container

Like any other service, it is also possible to get the "cache" service via container like so:

``` php
// Getting the cache service in PHP

/** @var $cacheService \Tedivm\StashBundle\Service\CacheService */
$cacheService = $container->get('ezpublish.cache_pool');
```

### Using the cache service

Example usage of the cache service:

``` php
// Example
    $cacheItem = $cacheService->getItem('myApp', 'object', $id);
    $myObject = $cacheItem->get();
    if ($cacheItem->isMiss()) {
        $myObject = $container->get('my_app.backend_service')->loadObject($id)
        $cacheItem->set($myObject);
    }
    return $myObject;
```

For more info on usage, see [Stash's documentation](http://stash.tedivm.com/).

### Clearing Persistence cache

Persistence cache uses a separate Cache Pool decorator which by design prefixes cache keys with "ez\_spi". Clearing persistence cache can thus be done in the following way:

``` php
// getting the cache service in php

/** @var $cacheService \eZ\Publish\Core\Persistence\Cache\CacheServiceDecorator */
$cacheService = $container->get('ezpublish.cache_pool.spi.cache.decorator');
 
// To clear all cache
$cacheService->clear();
 
// To clear a specific cache item (check source code in eZ\Publish\Core\Persistence\Cache\*Handlers for further info)
$cacheService->clear('content', 'info', $contentId);

// Stash cache is hierarchical, so you can clear all content/info cache like so:
$cacheService->clear('content', 'info');
```
