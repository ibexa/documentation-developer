---
description: Configure HTTP cache for Ibexa DXP, including cache header rules and time-to-live. HTTP cache configuration is SiteAccess-aware.
---

# HTTP cache configuration

## Content view configuration

You can configure cache globally for content views in `config/packages/ibexa.yaml`:

``` yaml
ibexa:
    system:
        <scope>:
            content:
                # Activates HTTP cache for content
                view_cache: true
                # Activates expiration based HTTP cache for content (very fast)
                ttl_cache: true
                # Number of seconds an HTTP response cache is valid (if ttl_cache is true, and if no custom s-maxage is set)
                default_ttl: 7200
```

You may want to set a high default time to live (TTL) (`default_ttl`) to have a high cache hit ratio on your installation.
As the system takes care of purges, the cache should not become stale with the exception of grace handing in Varnish and Fastly.

## Cache header rules

A few redirect and error pages are served through the content view system. If you set a high `default_ttl`, they can also be served from cache.

To avoid this, the installation ships with configuration to match these specific situations and set a much lower TTL.
[FOSHttpCacheBundle matching rules](http://foshttpcachebundle.readthedocs.io/en/2.8.0/reference/configuration/headers.html) enables you to specify a different TTL:

``` yaml
fos_http_cache:
    cache_control:
        rules:
            # Make sure cacheable (fresh) responses from Ibexa DXP which are errors/redirects get lower TTL than default_ttl
            -
                match:
                    match_response: 'response.isFresh() && ( response.isServerError() || response.isClientError() || response.isRedirect() )'
                headers:
                    overwrite: true
                    cache_control:
                        max_age: 5
                        s_maxage: 20
```

Similarly, by default the performance tuning is applied to avoid crawlers affecting the setup too much, by caching of generic 404s and similar error pages in the following way:

``` yaml
fos_http_cache:
    cache_control:
        rules:
            # Example of performance tuning, force TTL on 404 pages to avoid crawlers, etc., taking too much load
            # Should not be set too high, as cached 404s can cause issues for future routes, URL aliases, wildcards, etc.
            -
                match:
                    match_response: '!response.isFresh() && response.isNotFound()'
                headers:
                    overwrite: true
                    cache_control:
                        public: true
                        max_age: 0
                        s_maxage: 20
```

## Time-to-live value for Page blocks

For the Page Builder, block cache by default respects `$content.ttl_cache$` and `$content.default_ttl$` settings.
However, if the given block value has a since or till date, 
it is taken into account for the TTL calculation for both the block and the whole page.

To overload this behavior, listen to [`BlockResponseEvents::BLOCK_RESPONSE`](page_events.md),
and set priority to `-200` to adapt what Page Field Type does by default.

For example, to disable cache for the block, use `$event->getResponse()->setPrivate()`.

## When to use ESI

[Edge Side Includes](https://symfony.com/doc/current/http_cache/esi.html) (ESI) can be used to split out the different parts of a web page into separate fragments that can be freely reused as pieces by reverse proxy.

In practice, with ESI, every sub-request is regenerated from application perspective. And while you can tune your system to reduce this, it always causes additional overhead in the following situations:

- When cache is cold on all or some of the sub-requests
- With Symfony Proxy (AppCache) there is always some overhead, even on warm cache (hits)
- In development environment

This may differ depending on your system, however, it is recommended to stay below 5 ESI 
requests per page and only using them for parts that are the same across the whole site or larger parts of it.

You should not use ESI for parts that are effectively uncached, 
because your reverse proxy has to wait for the back end and cannot deliver cached pages directly.

!!! note "ESI limitations with the URIElement SiteAccess matcher"

    Is is not possible to share ESIs across the SiteAccesses when using URI matching 
    as URI contains the SiteAccess name encoded in its path information.
