# Navigation cache [[% include 'snippets/commerce_badge.md' %]]

Navigation uses HTTP cache to store navigation, and stash cache to store generated URLs.

After an element is modified in the Back Office, it is added to the queue to be deleted from HTTP cache and stash cache.
See [Content cache refresh](../cache/content_cache_refresh/content_cache_refresh.md) for more information.

The top navigation and the left menu are cached using HTTP cache, with one cache per SiteAccess.

By default, navigation is cached by `user-hash` for 10 hours.

``` yaml
silver_eshop.default.http_cache:
    navigation:
        max_age: 36000
        vary: user-hash
```

When a Content item which is included in the navigation is modified, a content modification handler is triggered.
Make sure that a cron job is activated to refresh the cache if required:

`php bin/console silversolutions:cache:refresh --env=prod`

## Caching time

To change the navigation cache time, set the `router_cache_ttl` parameter (in seconds):

``` yaml
siso_core.default.router_cache_ttl: 86400
```

## Caching in debug mode

In some environments (e.g. dev) the HTTP caching is not active, so navigation is stored in the stash cache to improve performance.

To check if the debug mode is active, use the following parameter:

``` php
$isDebugEnabled = (bool) $this->container->getParameter('kernel.debug')
```

In other environments (e.g. prod) stash cache is not used.

Caching TTL can be configured in the following way:

``` yaml
parameters:    
    siso_core.default.nav_debug_env_ttl: 86400
```
