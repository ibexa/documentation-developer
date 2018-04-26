# Persistence cache

![SPI cache diagram](img/spi_cache.png)

## Layers

Persistence cache can best be described as an implementation of `SPI\Persistence` that decorates the main backend implementation *(currently: "Legacy Storage Engine")*.

As shown in the illustration, this is done in the exact same way as the SignalSlot feature is a custom implementation of `API\Repository` decorating the main Repository. In the case of Persistence Cache, instead of sending events on calls passed on to the decorated implementation, most of the load calls are cached, and calls that perform changes purge the affected caches. Cache handlers *(Memcached, Redis, Filesystem, etc.)* can configured using Symfony configuration. For how to reuse this Cache service in your own custom code, see below.

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
- Search is not defined as Persistence and the queries themselves are not planned to be cached. Use [Solr](solr.md) which does this for you to improve scale and offload your database.

*For further details on which calls are cached or not, and where/how to contribute additional caches, check out the [source](https://github.com/ezsystems/ezpublish-kernel/tree/master/eZ/Publish/Core/Persistence/Cache).*

## Persistence cache configuration

!!! note

    Current implementation uses Symfony cache. It technically supports the following cache backends:
    [APCu, Array, Chain, Doctrine, Filesystem, Memcached, PDO & Doctrine DBAL, Php Array, Proxy, Redis](https://symfony.com/doc/current/components/cache/cache_pools.html#creating-cache-pools).
    We recommend using Redis for clustering and Filesystem for single server.

*Use of Memcached or Redis is a requirement for use in Clustering setup. For an overview of this feature, see [Clustering](clustering.md).*

!!! note

    When eZ Platform changes to another PSR-6 based cache system in the future, then configuration documented below will change.

**Cache service**

The cache system is exposed as a "cache" service, and can be reused by any other service as described in the [Using Cache service](repository.md#using-cache-service) section.

### Configuration

By default, configuration currently uses **FileSystem** to store cache files, which is defined in [`default_parameters.yml`](https://github.com/ezsystems/ezplatform/blob/2.0/app/config/default_parameters.yml#L22).
You can select a different cache backend and configure it's parameters in the relevant file in the `cache_pool` folder.

#### Multi Repository setup

In `ezplatform.yml` you can specify which cache pool you want to use on a SiteAccess or SiteAccess group level. The following example shows use in a SiteAccess group:

``` yaml
# ezplatform.yml site group setting
ezpublish:
    system:
        # "site_group" refers to the group configured in site access
        site_group:
            # by default cache service is set to cache.app via parameter '%env(CACHE_POOL)%'
            cache_service_name: '%env(CACHE_POOL)%'
```

!!! note "One cache pool for each Repository"

    If your installation has several Repositories *(databases)*, make sure every group of sites using different Repositories also uses a different cache pool.

### Redis

This cache backend is using [Redis, a in-memory data structure store](http://redis.io/), via [Redis pecl extension](https://pecl.php.net/package/redis). This is an alternative cache solution for [multi-server (cluster) setups](clustering.md), besides using Memcached.

See [Redis Cache Adapter in Symfony documentation](https://symfony.com/doc/3.4/components/cache/adapters/redis_adapter.html#configure-the-connection)
for information on how to configure Redis.

!!! note

    To use this, you need to set `cache_service_name` to `cache.redis`.

**Example**

``` yaml
services:
    cache.redis:
        parent: cache.adapter.redis
        tags:
            - name: cache.pool
              clearer: cache.app_clearer
              provider: 'redis://secret@example.com:1234/13'
```

!!! caution "Clearing Redis cache"

    The regular `php app/console cache:clear` command does not clear Redis persistence cache.
    To clear it, use the console command shipped with Redis: `redis-cli flushall`.

##### Redis Cluster

It is possible to set up and use Redis as a cluster. This configuration is more efficient and reliable for large installations. Redis Cluster can be configured in two ways, the first using [create-cluster script](https://redis.io/topics/cluster-tutorial) and the second using [Redis Sentinel](https://redis.io/topics/sentinel). If you use Platform.sh Enterprise you can benefit from the Redis Sentinel across three nodes for greater fault tolerance. Platform.sh Professional and lower versions offer Redis in single instance mode only. Configuration on eZ Platform / Symfony stays the same regardless of the Redis version, single instance mode or cluster mode.

### Memcached

This cache backend is using [Memcached, a distributed caching solution](http://memcached.org/). This is the main supported cache solution for [multi server (cluster) setups](clustering.md), besides using Redis.

See [Memcached Cache Adapter in Symfony documentation](https://symfony.com/doc/3.4/components/cache/adapters/memcached_adapter.html#configure-the-connection)
for information on how to configure Memcached.

!!! note

    To use this, you need to set `cache_service_name` to `cache.memcached`.

Example:

``` yaml
services:
    cache.memcached:
        parent: cache.adapter.memcached
        tags:
            - name: cache.pool
              clearer: cache.app_clearer
              provider: 'memcached://user:pass@localhost?weight=33'
```

!!! caution "Connection errors issue"

    If Memcached does display connection errors when using the default (ascii) protocol, then switching to binary protocol *(in the configuration and Memcached daemon)* should resolve the issue.

## Using Cache Service

Using the internal cache service allows you to use an interface and to not have to care whether the system has been configured to place the cache in Memcached or on File system. And as eZ Platform requires that instances use a cluster-aware cache in Cluster setup, you can safely assume your cache is shared *(and invalidated)* across all web servers.

!!! note

    Current implementation uses a caching library called TagAwareAdapter which implements `Psr\Cache\CacheItemPoolInterface`,
    and therefore is compatible with PSR-6.

!!! caution "Use unique vendor prefix for Cache key"

    When reusing the cache service within your own code, it is very important to not conflict with the cache keys used by others. That is why the example of usage below starts with a unique `myApp` key. For the namespace of your own cache, you must do the same! So never clear cache using the cache service without your key specified, otherwise you'll clear all cache.

#### Get Cache service

##### Via Dependency injection

In your Symfony services configuration you can simply define that you require the "cache" service in your configuration like so:

``` yaml
# yml configuration
    myApp.myService:
        class: %myApp.myService.class%
        arguments:
            - @ezpublish.cache_pool
```

The "cache" service is an instance of `Symfony\Component\Cache\Adapter\TagAwareAdapter` and implements the `Psr\Cache\CacheItemPoolInterface` interface.

##### Via Symfony Container

Like any other service, it is also possible to get the "cache" service via container like so:

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

For more info on usage, take a look at [Symfony Cache's documentation](https://symfony.com/doc/3.4/components/cache.html).

### Clearing Persistence cache

Persistence cache uses a separate Cache Pool decorator which by design prefixes cache keys with "ez\_spi". Clearing persistence cache can thus be done in the following way:

``` php
// getting the cache service in php

/** @var $cacheService \eZ\Publish\Core\Persistence\Cache\CacheServiceDecorator */
$cacheService = $container->get('ezpublish.cache_pool.spi.cache.decorator');
 
// To clear all cache (not recommended without a good reason)
$pool->clear();

// To clear a specific cache item (check source for more examples in eZ\Publish\Core\Persistence\Cache\*)
$pool->deleteItems(["ez-content-info-$contentId"]);

// Symfony cache is tag-based, so you can clear all cache related to a Content item like this:
$pool->invalidateTags(["content-$contentId"]);
```
