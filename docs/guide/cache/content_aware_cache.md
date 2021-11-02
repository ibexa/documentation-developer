# Content-aware HTTP cache

HTTP cache in [[= product_name =]] is aware of which content or entity it is connected to.
This awareness is accomplished by means of cache tagging. All supported reverse proxies are content-aware.

!!! note "Tag header is stripped in production for security reasons"

    For security reasons this header, and other internal cache headers,
    are stripped from output in production by the reverse proxy (in VCL for Varnish and Fastly).

## Understanding cache tags

Understanding tags is the key to making the most of `ezplatform-http-cache`.

Tags form a secondary set of keys assigned to every cache item, on top of the "primary key" which is the URI.
Like an index in a database, a tag is typically used for anything relevant that represents the given cache item.
Tags are used for cache invalidation.

For example, the system tags every article response, and when the article Content Type is updated,
it tells Varnish that all articles should be considered stale
and updated in the background when someone requests them.

Current content tags (and when the system purges on them):

- Content: `c<content-id>` - Purged on all smaller or larger changes to content (including its metadata, Fields and Locations).
- Content Type: `ct<content-type-id>` - Used when the Content Type changes, affecting content of its type.
- Location: `l<location-id>` - Used for clearing all cache relevant for a given Location.
- Parent Location: `pl<[parent-]location-id>` - Used for clearing all children of a Location (`pl<location-id>`), or all siblings (`pl<parent-location-id>`).
- Path: `p<location-id>` - For operations that change the tree itself, like move, remove, etc.
- Relation: `r<content-id>` - Only purged on when content updates are severe enough to also affect reverse relations.
- Relation location: `rl<location-id>` - Same as relation, but by Location ID.

!!! note "Automatic repository prefixing of cache tags"

    As [[= product_name =]] supports multi-repository (multi-database) setups that can have overlapping IDs,
    the shared HTTP cache systems need to distinguish tags relevant to the different content repositories.

    This is why in multi-repository setup you can see cache tags such as `1p2`.
    In this example `1` represents the index among configured repositories, meaning the second repository in the system.

    Tags are not prefixed for default repository (index "0").

### Troubleshooting - Cache header too long errors

In case of complex content, for example, Pages with many blocks, or RichText with a lot of embeds/links, 
you can encounter problems with too long cache header on responses. 
It happens because necessary cache entries may not be tagged properly. 
You may also see `502 Headers too long` errors, and webserver refusing to serve the page.

You can solve this issue in one of the following ways:

#### A. Configure allowing larger headers

Varnish configuration:

- [http_resp_hdr_len](https://varnish-cache.org/docs/6.0/reference/varnishd.html#http-resp-hdr-len) (default 8k, change to for example, 32k)
- [http_max_hdr](https://varnish-cache.org/docs/6.0/reference/varnishd.html#http-max-hdr) (default 64, change to for example, 128)
- [http_resp_size](https://varnish-cache.org/docs/6.0/reference/varnishd.html#http-resp-size) (default 23k, change to for example, 96k)
- [workspace_backend](https://varnish-cache.org/docs/6.0/reference/varnishd.html#workspace-backend) (default 64k, change to for example, 128k)

If you need to see these long headers in `varnishlog`, adapt the [vsl_reclen](https://varnish-cache.org/docs/6.0/reference/varnishd.html#vsl-reclen) setting.

Nginx has a default limit of 4k/8k when buffering responses:

- For [PHP-FPM](https://www.php.net/manual/en/install.fpm.php) setup using proxy module, configure [proxy_buffer_size](https://nginx.org/en/docs/http/ngx_http_proxy_module.html#proxy_buffer_size)
- For FastCGI setup using fastcgi module, configure [fastcgi_buffer_size](https://nginx.org/en/docs/http/ngx_http_fastcgi_module.html#fastcgi_buffer_size)

Fastly has a `Surrogate-Key` header limit of 16 kB, and this cannot be changed.

Apache has a [hard](https://github.com/apache/httpd/blob/5f32ea94af5f1e7ea68d6fca58f0ac2478cc18c5/server/util_script.c#L495) [coded](https://github.com/apache/httpd/blob/7e2d26eac309b2d79e467ef586526c10e0f226f8/include/httpd.h#L299-L303) limit of 8 kB, so if you face this issue consider using Nginx instead.

#### B. Limit tags header output by system

1\. For inline rendering just displaying the content name, image attribute, and/or link, it would be enough to:

- Look into how many inline (non ESI) render calls for content rendering you are doing, and see if you can organize it differently.
- Consider inlining the views not used elsewhere in the given template and [tagging the response in Twig](#response-tagging-in-twig) with "relation" tags.
    - (Optional) You can set reduced cache TTL for the given view, to reduce the risk of stale cache on subtree operations affecting the inlined content.

2\. You can opt in to set a max length parameter (in bytes) and corresponding ttl (in seconds) 
for cases when the limit is reached. The system will log a warning where the limit is reached, and when needed, you can optimize 
these cases as described above.

```yaml
parameters:
    # Warning, setting this means you risk losing tag information, risking stale cache. Here set below 8k:
    ezplatform.http_cache.tags.header_max_length: 7900
    # In order to reduce risk of stale cache issues, you should set a lower TTL here then globally (here set as 2h)
    ezplatform.http_cache.tags.header_reduced_ttl: 7200
```

## Response tagging done with content view

For content views response tagging is done automatically, and cache system outputs headers as follows:

```
HTTP/1.1 200 OK
Cache-Control: public, max-age=86400
xkey: ez-all c1 ct1 l2 pl1 p1 p2
```

If the given content has several Locations, you can see several `l<location-id>` and `p<location-id>` tags in the response.

!!! note "How response tagging for ContentView is done internally"

    In `ezplatform-http-cache` there is a dedicated response listener `HttpCacheResponseSubscriber` that checks if:
    
    - the response has attribute `view`
    - the view implements `Ibexa\Core\MVC\Symfony\View\CachableView`
    - cache is not disabled on the individual view

    If that checks out, the response is adapted with the following:
    
    - `ResponseCacheConfigurator` applies SiteAccess settings for enabled/disabled cache and default TTL.
    - `DispatcherTagger` dispatches the built-in ResponseTaggers which generate the tags as described above.

### The ResponseConfigurator

A `ReponseCacheConfigurator` configures an HTTP Response object, makes the response public, adds tags and sets the shared max age. 
It is provided to `ReponseTaggers` that use it to add the tags to the response.

The `ConfigurableResponseCacheConfigurator` (`ezplatform.view_cache.response_configurator`) follows the `view_cache` configuration and only enables cache if it is enabled in the configuration.

### Delegator and Value taggers

- Delegator taggers - extract another value or several from the given value and pass it on to another tagger. For example, a `ContentView` is covered both by the `ContentValueViewTagger` and `LocationValueViewTagger`, where the first extracts the Content from the `ContentView` and passes it to the `ContentInfoTagger`.
- Value taggers - extract the `Location` and pass it on to the `LocationViewTagger`.

## The DispatcherTagger

Accepts any value and passes it on to every tagger registered with the service tag `ezplatform.http_response_tagger`.

## Response tagging in controllers

For tagging needs in controllers, there are several options, here presented in recommended order:

1\. Reusing `DispatcherTagger` to pick correct tags.

Examples for tagging everything needed for content using the autowirable `ResponseTagger` interface:

``` php
/** @var \Ibexa\Contracts\HttpCache\ResponseTagger\ResponseTagger $responseTagger */

// If you have a View object you can simply call:
$responseTagger->tag($view);

// Or if you have content / Location object only, you can instead provide content info and Location:
$responseTagger->tag($contentInfo);
$responseTagger->tag($location);
```

2\. Use `ContentTagInterface` API for content related tags.

Examples for adding specific content tags using the autowireable `ContentTagInterface`:

``` php
/** @var \Ibexa\Contracts\HttpCache\Handler\ContentTagInterface $tagHandler */

// Example for tagging everything needed for Content:
$tagHandler->addContentTags([$content->id]);
$tagHandler->addLocationTags([$location->id]);
$tagHandler->addParentLocationTags([$location->parentLocationId]);
$tagHandler->addPathTags($location->path);
$tagHandler->addContentTypeTags([$content->getContentType()->id]);

// Example when using ESI as also shown below using FOS tag handler (there is also a method for relation locations):
$tagHandler->addRelationTags([33, 44]);
```

3\. Manually add tags yourself using low-level FOS `TagHandler`.

In PHP, FOSHttpCache exposes the `fos_http_cache.http.symfony_response_tagger` service which enables you to add tags to a response.

The following example adds minimal tags for when ID 33 and 34 are rendered in ESI,
but parent response needs these tags to get refreshed if they are deleted:

``` php
/** @var \FOS\HttpCacheBundle\Http\SymfonyResponseTagger $responseTagger */
$responseTagger->addTags([ContentTagInterface::RELATION_PREFIX . '33', ContentTagInterface::RELATION_PREFIX . '44']);
```

See [Tagging from code](https://foshttpcachebundle.readthedocs.io/en/2.8.0/features/tagging.html#tagging-and-invalidating-from-php-code) in FOSHttpCacheBundle doc.

4\. Use deprecated `X-Location-Id` header.

For custom or built-in controllers (e.g. REST) still using `X-Location-Id`, `XLocationIdResponseSubscriber` handles translating
this header to tags. It supports singular and comma-separated Location ID value(s):

```php
/** @var \Symfony\Component\HttpFoundation\Response $response */
$response->headers->set('X-Location-Id', 123);

// Alternatively using several Location ID values
$response->headers->set('X-Location-Id', '123,212,42');
```

!!! caution "X-Location-Id use is deprecated"

    `X-Location-Id` is deprecated and will be removed in future.
    For rendering content it is advised to refactor to use Content View,
    if not applicable `ContentTagInterface` or lastly manually output tags.

## Response tagging in templates

1\. `ez_http_cache_tag_location()`

For full content tagging when inline rendering, use the following:

``` html+twig
{{ ez_http_cache_tag_location(location) }}
```

2\. `ez_http_cache_tag_relation_ids()` or `ez_http_cache_tag_relation_location_ids()`

When you want to reduce the amount of tags, or the inline content is rendered using ESI, a minimum set of tags can be set:

``` html+twig
{{ ez_http_cache_tag_relation_ids(content.id) }}

{# Or using array for several values #}
{{ ez_http_cache_tag_relation_ids([field1.value.destinationContentId, field2.value.destinationContentId]) }}
```

3\. `{{ fos_httpcache_tag(['r33', 'r44']) }}`

As a last resort you can also use the following function from FOS which lets you set low level tags directly:

``` html+twig
{{ fos_httpcache_tag('r33') }}

{# Or using array for several values #}
{{ fos_httpcache_tag(['r33', 'r44']) }}
```

See [Tagging from Twig Templates](https://foshttpcachebundle.readthedocs.io/en/latest/features/tagging.html#tagging-from-twig-templates) in FOSHttpCacheBundle documentation.

## Tag purging

### Default purge tagging

`ezplatform-http-cache` uses Repository API event subscribers to listen to events emitted on Repository operations,
and depending on the operation triggers expiry on a specific tag or set of tags.

For example on the move Location event the following tags are purged:

```php
[
    // The tree itself being moved (all children will have this tag)
    ContentTagInterface::PATH_PREFIX . $event->getLocation()->id,
    // old parent
    ContentTagInterface::LOCATION_PREFIX . $event->getLocation()->parentLocationId,
    // old siblings
    ContentTagInterface::PARENT_LOCATION_PREFIX . $event->getLocation()->parentLocationId,
    // new parent
    ContentTagInterface::LOCATION_PREFIX . $event->getNewParentLocation()->id,
    // new siblings
    ContentTagInterface::PARENT_LOCATION_PREFIX . $event->getNewParentLocation()->id,
];
```

All event subscribers can be found in `ezplatform-http-cache/src/EventSubscriber/CachePurge`.

### Custom purging from code

While the system purges tags whenever API is used to change data, you may need to purge directly from code.
For that you can use the built-in purge client:

```php
/** @var \Ibexa\Contracts\HttpCache\PurgeClient\PurgeClientInterface $purgeClient */

// Example for purging by Location ID:
$purgeClient->purge([ContentTagInterface::LOCATION_PREFIX . $location->id]);

// Example for purging all cache for instance for full re-deploy cases, usually this triggers an expiry (soft purge):
$purgeClient->purgeAll();
```

### Purging from command line

Example for purging by Location and by Content ID:

```bash
bin/console fos:httpcache:invalidate:tag l44 c33
```

Example for purging by all cache:

```bash
bin/console fos:httpcache:invalidate:tag ez-all
```

!!! tip "Purge is done on the current Repository"

    Similarly to purging from code, the tags you purge on, are prefixed to match the currently configured SiteAccess. 
    When you use this command in combination with multi-repository setup, make sure to specify SiteAccess argument.
