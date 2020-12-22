# Persistence cache

![SPI cache diagram](img/spi_cache.png)

## Layers

Persistence cache can best be described as an implementation of `SPI\Persistence` that decorates the main backend implementation, aka Storage Engine *(currently: "Legacy Storage Engine")*.

As shown in the illustration, this is done in the exact same way as the Event layer is a custom implementation of `API\Repository` decorating the main Repository.
In the case of Persistence Cache, instead of sending events on calls passed on to the decorated implementation, most of the load calls are cached, and calls that perform changes purge the affected caches.
Cache handlers *(Memcached, Redis, Filesystem, etc.)* can be configured using Symfony configuration.
For details on how to reuse this Cache service in your own custom code, see below.

## Transparent cache

With the persistence cache, just like with the HTTP cache, [[= product_name =]] tries to follow principles of transparent caching.
This can shortly be described as a cache which is invisible to the end user (admin/editors) of [[= product_name =]] where content
is always returned *fresh*. In other words, there should be no need to manually clear the cache like it was frequently
the case with eZ Publish 4.x. This is possible thanks to an interface that follows CRUD (Create Read Update Delete)
operations per domain.

## What is cached?

Persistence cache aims at caching most `SPI\Persistence` calls used in common page loads, including everything needed for permission checking and URL alias lookups.

Notes:

- [Cache tagging](https://symfony.com/doc/5.0/components/cache/cache_invalidation.html#using-cache-tags) is used in
  order to allow clearing cache by alternative indexes.
  For instance tree operations or changes to Content Types are
  examples of operations that also need to invalidate content cache by tags.
- Search is not defined as persistence and the queries themselves are not planned to be cached as they are too complex by design (full text, facets, etc.).
  Use [Solr](search/solr.md) which caches this for you to improve scale/performance, and to offload your database.

For further details on which calls are cached or not, see details in the [Symfony Web Debug Toolbar](devops.md#web-debug-toolbar)
which has info on cache use in two places:

- Symfony Cache tab: for Symfony Cache itself, the tab shows cache lookups to cache backends
- eZ Platform tab: shows calls made to database back end, and if they are cached or not

To see where and how to contribute additional caches, refer to the [source code](https://github.com/ezsystems/ezplatform-kernel/tree/v1.0.0/eZ/Publish/Core/Persistence/Cache).

## Persistence cache configuration

!!! note

    Current implementation uses Symfony cache. It technically supports the following cache backends:
    [APCu, Array, Chain, Doctrine, Filesystem, Memcached, PDO & Doctrine DBAL, Php Array, Proxy, Redis](https://symfony.com/doc/5.0/components/cache/cache_pools.html#creating-cache-pools).
    [[= product_name =]] officially supports only using Filesystem for single server and Redis or Memcached for clustered setups.

Use of Memcached or Redis as shared cache back end is a requirement for use in clustering setup.
For an overview of this feature, see [Clustering](clustering.md).
Filesystem adapters, for example, are **not** intended to be used over a shared filesystem.

**Cache service**

The underlying cache system is exposed as an `ezpublish.cache_pool` service, and can be reused by any other service as described in the [Using Cache service](#using-cache-service) section.

### Configuration

By default, configuration uses the `cache.tagaware.filesystem` service to store cache files.
The service is defined in `app/config/cache_pool/cache.tagaware.filesystem.yml`
to use [FilesystemTagAwareAdapter](https://github.com/ezsystems/ezplatform/blob/master/config/packages/cache_pool/cache.tagaware.filesystem.yaml#L8).
This service is loaded through `app/config/env/generic.php`.

You can select a different cache backend and configure its parameters in the relevant file in the `cache_pool` folder.

#### Multi Repository setup

You can [configure multisite to work with multiple Repositories](multisite.md#multisite-with-multiple-repositories).
Then, in `ezplatform.yaml` you can specify which cache pool you want to use on a SiteAccess or SiteAccess group level.

The following example shows use in a SiteAccess group:

``` yaml
ezplatform:
    system:
        # "site_group" refers to the group configured in site access
        site_group:
            # cache_pool is set to '%env(CACHE_POOL)%'
            # env(CACHE_POOL) is set to 'cache.tagaware.filesystem' (a Symfony service) by default, for more examples see app/config/cache_pool/*
            cache_service_name: '%cache_pool%'
```

!!! note "One cache pool for each Repository"

    If your installation has several Repositories *(databases)*, make sure every group of sites using different Repositories also uses a different cache pool.

#### In-Memory cache configuration

Persistence cache layer caches selected objects in-memory for a short time.
It avoids loading repeatedly the same data from e.g. a remote Redis instance, which can take up to 4-5ms per call due to the network latency and Redis instance load.
The cache is organized in 2 pools, one for metadata which is not updated frequently, and one for content related objects that is only meant as a short-lived burst cache.
Limit is organized using a [least frequently used (LFU)](https://en.wikipedia.org/wiki/Least_frequently_used) approach.
It makes sure repeatedly used objects will stay in-memory until expired, and those seldom used will be bulk evicted from cache every time the maximum number of cache items is reached.

This in-memory cache will be purged *(for the current PHP process)* when clearing it using any of the mentioned methods below.
For other processes, the object will be refreshed when it expires or evicted when it reaches the cache limits.

In-Memory cache is configured globally, and has the following default settings:

```yaml
parameters:
    # Config for metadata cache pool, here showing default config
    # ttl: Maximum number of  milliseconds objects are kept in-memory (3000ms = 3s)
    ezpublish.spi.persistence.cache.inmemory.ttl: 3000
    # limit: Maximum number of cache objects to place in-memory, to avoid consuming too much memory
    ezpublish.spi.persistence.cache.inmemory.limit: 100
    # enabled: Is the in-memory cache enabled
    ezpublish.spi.persistence.cache.inmemory.enable: true

    # Config for content cache pool, here showing default config
    ## WARNING: TTL is on purpose low to avoid getting outdated data in prod! For dev environment, you can safely increase it (e.g. by x3)
    ezpublish.spi.persistence.cache.inmemory.content.ttl: 300
    ezpublish.spi.persistence.cache.inmemory.content.limit: 100
    ezpublish.spi.persistence.cache.inmemory.content.enable: true
```

!!! caution "In-Memory cache is per-process"

    **TTL and Limit need to have a low value.** Setting limit high will increase memory use.
    High TTL value also increases exponentially risk for system acting on stale metadata (e.g. Content Type definitions).
    The only case where it is safe to increase these values is for dev environment with single concurrency on writes.
    In prod environment you should only consider reducing them if you have heavy concurrency writes.

### Redis

[Redis](http://redis.io/), an in-memory data structure store, is one of the supported cache solutions for clustering.
Redis is used via [Redis pecl extension](https://pecl.php.net/package/redis).

See [Redis Cache Adapter in Symfony documentation](https://symfony.com/doc/5.0/components/cache/adapters/redis_adapter.html#configure-the-connection)
for information on how to connect to Redis.

#### Supported Adapters

There are two Redis adapters available out of the box that fit different needs.

##### `Symfony\Component\Cache\Adapter\RedisTagAwareAdapter`

**Requirement**: Redis server configured with eviction [`maxmemory-policy`](https://redis.io/topics/lru-cache#eviction-policies):
`volatile-ttl`, `volatile-lru` or `volatile-lfu` (Redis 4.0+).
Use of LRU or LFU is recommended. It is also possible to use `noeviction`, but it is usually not practical.

**Pros**: It is typically faster than `RedisAdapter`, because fewer lookups needed to cache backend.

**Cons**: Consumes much more memory. To avoid situations where Redis stops accepting new cache
(warnings about `Failed to save key`), set aside enough memory for the Redis server.

##### `Symfony\Component\Cache\Adapter\RedisAdapter`

**Pros**: Uses a bit less memory than `RedisTagAwareAdapter`, so it eliminated the risk of stopping saving cache when there is not enough memory.

**Cons**: 1.5-2x more lookups to the back-end cache server then `RedisTagAwareAdapter`.
Depending on the number of lookups and latency to cache server this might affect page load time.

#### Adjusting configuration

Out of the box in `config/packages/cache_pool/cache.redis.yaml` you'll find a default example that can be used.

!!! note "Ibexa Cloud"

    For Ibexa Cloud/Platform.sh: This is automatically configured in `app/config/env/platformsh.php` if you have enabled Redis as `rediscache` Platform.sh service.

For anything else, you can enable it with environment variables detected automatically by `app/config/env/generic.php`.
For instance, if you set the following environment variables `export CACHE_POOL="cache.redis" CACHE_DSN="secret@example.com:1234/13"`, it will result in config like this:

``` yaml
services:
    cache.redis:
        # NOTE: This optimized Redis Adapter is avaiable as of 2.5LTS via https://github.com/ezsystems/symfony-tools
        class: Symfony\Component\Cache\Adapter\TagAware\RedisTagAwareAdapter
        parent: cache.adapter.redis
        tags:
            - name: cache.pool
              clearer: cache.app_clearer
              provider: 'redis://secret@example.com:1234/13'
              # Default CACHE_NAMESPACE value, see app/config/cache_pool/cache.redis.yaml for usage with e.g. multi repo.
              namespace: 'ez'
```

See `config/packages/ezplatform.yaml` and `config/packages/cache_pool/cache.redis.yaml` for further details on `CACHE_POOL`, `CACHE_DSN` and `CACHE_NAMESPACE`.

!!! caution "Clearing Redis cache"

    The regular `php bin/console cache:clear` command does not clear Redis persistence cache.
    Use a dedicated Symfony command to clear the pool you have configured: `php bin/console cache:pool:clear cache.redis`.

##### Redis Clustering

Persistence cache depends on all involved web servers, each of them seeing the same view of the cache because it's shared among them.
With that in mind, the following configurations of Redis are possible:

- [Redis Cluster](https://redis.io/topics/cluster-tutorial)
    - Shards cache across several instances in order to be able to cache more than memory of one server allows
    - Shard slaves can improve availability, however [they use asynchronous replication](https://redis.io/topics/cluster-tutorial#redis-cluster-consistency-guarantees) so they can't be used for reads
    - Unsupported Redis features that can affect performance: [pipelining](https://github.com/phpredis/phpredis/blob/develop/cluster.markdown#pipelining) and [most multiple key commands](https://github.com/phpredis/phpredis/blob/develop/cluster.markdown#multiple-key-commands)
- [Redis Sentinel](https://redis.io/topics/sentinel)
    - Provides high availability by providing one or several slaves (ideally 2 slaves or more, e.g. minimum 3 servers), and handle failover
    - [Slaves are asynchronously replicated](https://redis.io/topics/sentinel#fundamental-things-to-know-about-sentinel-before-deploying), so they can't be used for reads
    - Typically used with a load balancer (e.g. HAproxy with occasional calls to Redis Sentinel API) in the front in order to only speak to elected master
    - As of v3 you can also configure this [directly on the connection string](https://symfony.com/doc/current/components/cache/adapters/redis_adapter.html#configure-the-connection), **if** you use `Predis` instead of `php-redis` 

Several cloud providers have managed services that are easier to set up, handle replication and scalability for you, and might perform better. Notable services include:

- [Amazon ElastiCache](https://aws.amazon.com/elasticache/)
- [Azure Redis Cache](https://azure.microsoft.com/en-us/services/cache/)
- [Google Cloud Memorystore](https://cloud.google.com/memorystore/)

###### Ibexa Cloud / Platform.sh usage

!!! note "Ibexa Cloud"

    If you use Platform.sh Enterprise you can benefit from the Redis Sentinel across three nodes for great fault tolerance.
    Platform.sh Professional and lower versions offer Redis in single instance mode only.

### Memcached

[Memcached, a distributed caching solution](http://memcached.org/) is a cache solution that is supported for clustering use, as an alternative to Redis.

See [Memcached Cache Adapter in Symfony documentation](https://symfony.com/doc/5.0/components/cache/adapters/memcached_adapter.html#configure-the-connection)
for information on how to configure Memcached.


#### Supported Adapters

There is one Memcached adapter available out of the box.

##### `Symfony\Component\Cache\Adapter\MemcachedAdapter`

**Pros**: Memcached is able to handle much more concurrent load by design (multi threaded), and typically uses far less memory than Redis in general due to a simpler data structure.

**Cons**: 1.5-2x more lookups to the back-end cache server then `RedisTagAwareAdapter`. Depending on the number of lookups and latency to cache server this might affect page load time.

#### Adjusting configuration

Out of the box in `config/packages/cache_pool/cache.memcached.yaml` you'll find a default example that can be used.

!!! note "Ibexa Cloud"

    For Ibexa Cloud/Platform.sh: This is automatically configured in `config/env/platformsh.php` if you have enabled Memcached as `cache` Platform.sh service.

For anything else, you can enable it with environment variables detected automatically by `config/env/generic.php`.
For instance, if you set the following environment variables `export CACHE_POOL="cache.memcached" CACHE_DSN="user:pass@localhost?weight=33"`, it will result in config like this:

``` yaml
services:
    cache.memcached:
        parent: cache.adapter.memcached
        tags:
            - name: cache.pool
              clearer: cache.app_clearer
              provider: 'memcached://user:pass@localhost?weight=33'
              # Default CACHE_NAMESPACE value, see app/config/cache_pool/cache.redis.yaml for usage with e.g. multi repo.
              namespace: 'ez'
```

See `config/default_parameters.yaml` and `config/cache_pool/cache.memcached.yaml` for further details on `CACHE_POOL`, `CACHE_DSN` and `CACHE_NAMESPACE`.

!!! caution "Clearing Memcached cache"

    The regular `php bin/console cache:clear` command does not clear Memcached persistence cache.
    Use a dedicated Symfony command to clear the pool you have configured: `php bin/console cache:pool:clear cache.memcached`.


!!! caution "Connection errors issue"

    If Memcached does display connection errors when using the default (ascii) protocol, then switching to binary protocol *(in the configuration and Memcached daemon)* should resolve the issue.

!!! note

    Memcached must not be bound to the local address if clusters are in use, or user logins will fail.
    To avoid this, in `/etc/memcached.conf` take a look under `# Specify which IP address to listen on. The default is to listen on all IP addresses`

    For development environments, change the address below this comment in `/etc/memcached.conf` to `-l 0.0.0.0`

    For production environments, follow this more secure instruction from the Memcached man:

    > -l &lt;addr&gt;

    > Listen on &lt;addr&gt;; default to INADDR\_ANY. &lt;addr&gt; may be specified as host:port. If you don't specify a port number, the value you specified with -p or -U is used. You may specify multiple addresses separated by comma or by using -l multiple times. This is an important option to consider as there is no other way to secure the installation. Binding to an internal or firewalled network interface is suggested.

## Using Cache Service

Using the internal cache service allows you to use an interface and without caring whether the system is configured to place the cache in Memcached or on File system.
And as [[= product_name =]] requires that instances use a cluster-aware cache in Cluster setup, you can safely assume your cache is shared *(and invalidated)* across all web servers.

!!! note

    Current implementation uses a caching library implementing TagAwareAdapterInterface which extends `Psr\Cache\CacheItemPoolInterface`,
    and therefore is compatible with PSR-6.

!!! caution "Use unique vendor prefix for Cache key"

    When reusing the cache service within your own code, it is very important to not conflict with the cache keys used by others.
    That is why the example of usage below starts with a unique `myApp` key.
    For the namespace of your own cache, you must do the same.

#### Get Cache service

##### Via Dependency injection

In your Symfony services configuration you can simply define that you require the cache service in your configuration like so:

``` yaml
# yml configuration
    myApp.myService:
        class: '%myApp.myService.class%'
        arguments:
            - '@ezpublish.cache_pool'
```

This service is an instance of `Symfony\Component\Cache\Adapter\TagAwareAdapterInterface`, which extends the `Psr\Cache\CacheItemPoolInterface` interface with tagging functionality.

##### Via Symfony Container

Like any other service, it is also possible to get the cache service via container like so:

``` php
// Getting the cache service in PHP

/** @var \Symfony\Component\Cache\Adapter\TagAwareAdapterInterface */
$pool = $container->get('ezpublish.cache_pool');
```

### Using the cache service

Example usage of the cache service:

``` php
// Example
$cacheItem = $pool->getItem("myApp-object-${id}");
if ($cacheItem->isHit()) {
    return $cacheItem->get();
}

$myObject = $container->get('my_app.backend_service')->loadObject($id)
$cacheItem->set($myObject);
$cacheItem->tag(['myApp-category-' . $myObject->categoryId]);
$pool->save($cacheItem);

return $myObject;
```

For more info on usage, see [Symfony Cache's documentation](https://symfony.com/doc/5.0/components/cache.html).

### Clearing Persistence cache

Persistence cache prefixes it's cache using "ez-". Clearing persistence cache can thus be done in the following ways:

``` php
// To clear all cache (not recommended without a good reason)
$pool->clear();

// To clear a specific cache item (check source for more examples in eZ\Publish\Core\Persistence\Cache\*)
$pool->deleteItems(["ez-content-info-$contentId"]);

// Symfony cache is tag-based, so you can clear all cache related to a Content item like this:
$pool->invalidateTags(["content-$contentId"]);
```
