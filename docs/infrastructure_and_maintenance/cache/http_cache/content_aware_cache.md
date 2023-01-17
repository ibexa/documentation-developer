---
description: Content-aware HTTP cache takes into account the content it is connected to.
---

# Content-aware HTTP cache

HTTP cache in [[= product_name =]] is aware of which content or entity it is connected to.
This awareness is accomplished by means of cache tagging. All supported reverse proxies are content-aware.

!!! note "Tag header is stripped in production for security reasons"

    For security reasons this header, and other internal cache headers,
    are stripped from output in production by the reverse proxy (in VCL for Varnish and Fastly).

## Cache tags

Understanding tags is the key to making the most ofIbexa's HTTP cache.

Tags form a secondary set of keys assigned to every cache item, on top of the "primary key" which is the URI.
Like an index in a database, a tag is typically used for anything relevant that represents the given cache item.
Tags are used for cache invalidation.

For example, the system tags every article response, and when the article Content Type is updated,
it tells Varnish that all articles should be considered stale
and updated in the background when someone requests them.

Current content tags (and when the system purges on them):

- Content: `c<content-id>` - Purged on all smaller or larger changes to content (including its metadata, Fields and Locations).
- Content Version: `cv<content-id>` - Purged when any version of Content is changed (for example, a draft is created or removed).
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

The content tags are returned in a header in the responses from [[= product_name =]]. The header name is dependent on
which HTTP Cache [[= product_name =]] is configured with:

- Symfony reverse proxy: `X-Cache-Tags`
- Varnish: `xkey`
- Fastly: `Surrogate-Key`

Examples:

- `X-Cache-Tags: ez-all,c52,ct42,l2,pl1,p1,p2,r56,r57`
- `xkey: ez-all c52 ct42 l2 pl1 p1 p2 r56 r57`
- `Surrogate-Key: ez-all c52 ct42 l2 pl1 p1 p2 r56 r57`

### Troubleshooting - Cache header too long errors

In case of complex content, for example, Pages with many blocks, or RichText with a lot of embeds/links, 
you can encounter problems with too long cache header on responses. 
It happens because necessary cache entries may not be tagged properly. 
You may also see `502 Headers too long` errors, and webserver refusing to serve the page.

You can solve this issue in one of the following ways:

#### A. Allow larger headers

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
    ibexa.http_cache.tags.header_max_length: 7900
    # In order to reduce risk of stale cache issues, you should set a lower TTL here then globally (here set as 2h)
    ibexa.http_cache.tags.header_reduced_ttl: 7200
```

## Response tagging with content view

For content views response tagging is done automatically, and cache system outputs headers as follows:

```
HTTP/1.1 200 OK
Cache-Control: public, max-age=86400
xkey: ez-all c1 ct1 l2 pl1 p1 p2
```

If the given content has several Locations, you can see several `l<location-id>` and `p<location-id>` tags in the response.

!!! note "How response tagging for ContentView is done internally"

    In `ibexa/http-cache` there is a dedicated response listener `HttpCacheResponseSubscriber` that checks if:
    
    - the response has attribute `view`
    - the view implements `Ibexa\Core\MVC\Symfony\View\CachableView`
    - cache is not disabled on the individual view

    If that checks out, the response is adapted with the following:
    
    - `ResponseCacheConfigurator` applies SiteAccess settings for enabled/disabled cache and default TTL.
    - `DispatcherTagger` dispatches the built-in ResponseTaggers which generate the tags as described above.

### ResponseConfigurator

A `ReponseCacheConfigurator` configures an HTTP Response object, makes the response public, adds tags and sets the shared max age. 
It is provided to `ReponseTaggers` that use it to add the tags to the response.

The `ConfigurableResponseCacheConfigurator` (`Ibexa\HttpCache\ResponseConfigurator\ConfigurableResponseCacheConfigurator`) follows the `view_cache` configuration and only enables cache if it is enabled in the configuration.

### Delegator and Value taggers

- Delegator taggers - extract another value or several from the given value and pass it on to another tagger. For example, a `ContentView` is covered both by the `ContentValueViewTagger` and `LocationValueViewTagger`, where the first extracts the Content from the `ContentView` and passes it to the `ContentInfoTagger`.
- Value taggers - extract the `Location` and pass it on to the `LocationViewTagger`.

## DispatcherTagger

Accepts any value and passes it on to every tagger registered with the service tag `ibexa.cache.http.response.tagger`.

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

The following example adds minimal tags when ID 33 and 34 are rendered in ESI,
but parent response needs these tags to get refreshed if they are deleted:

``` php
/** @var \FOS\HttpCacheBundle\Http\SymfonyResponseTagger $responseTagger */
$responseTagger->addTags([ContentTagInterface::RELATION_PREFIX . '33', ContentTagInterface::RELATION_PREFIX . '34']);
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

1\. `ibexa_http_cache_tag_location()`

For full content tagging when inline rendering, use the following:

``` html+twig
{{ ibexa_http_cache_tag_location(location) }}
```

2\. `ibexa_http_cache_tag_relation_ids()` or `ibexa_http_cache_tag_relation_location_ids()`

When you want to reduce the amount of tags, or the inline content is rendered using ESI, a minimum set of tags can be set:

``` html+twig
{{ ibexa_http_cache_tag_relation_ids(content.id) }}

{# Or using array for several values #}
{{ ibexa_http_cache_tag_relation_location_ids([field1.value.destinationContentId, field2.value.destinationContentId]) }}
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

### Default tag purging

`ibexa/http-cache` uses Repository API event subscribers to listen to events emitted on Repository operations,
and depending on the operation triggers expiry on a specific tag or set of tags.
All event subscribers can be found in `ezplatform-http-cache/src/EventSubscriber/CachePurge`.

### Tags purged on publish event

Below is an example of a Content structure. The tags which the content view controller adds to each location are
also listed

```
   - [Home] (content-id=52, location-id=2)
     ez-all c52 ct42 l2 pl1 p1 p2
     |
     - [Parent1](content-id=53, location-id=20)
       ez-all c53 ct1 l20 pl2 p1 p2 p20
       |
       - [Child](content-id=55, location-id=22)
         ez-all c55 ct1 l22 pl20 p1 p2 p20 p22
     - [Parent2](content-id=54, location-id=21)
       ez-all c55 ct1 l22 pl2 p1 p2 p22
```

In the event when a new version of `Child` is published, the following keys are purged:

- `c55`, because Content `[Child]` was changed
- `r55`, because cache for any object that has a relation to Content `[Child]` should be purged
- `l22`, because Location `[Child]` has changed ( that would be location holding content-id=55)
- `pl22`, because cache for children of `[Child]` should be purged
- `rl22`, because cache for any object that has a relation to Location `[Child]` should be purged
- `l20`, because cache for parent of `[Child]` should be purged
- `pl20`, because cache for siblings of `[Child]` should be purged

In summary, HTTP Cache for any location representing `[Child]`, any Content that relates to the Content `[Child]`, the 
location for `[Child]`, any children of `[Child]`, any Location that relates to the Location `[Child]`, location for
`[Parent1]`, any children on `[Parent1]`.
Effectively, in this example HTTP cache for `[Parent1]` and `[Child]` will be cleared.


### Tags purged on move event

With the same Content structure as above, the `[Child]` location is moved below `[Parent2]`.

The new structure will then be:
```
   - [Home] (content-id=52, location-id=2)
     ez-all c52 ct42 l2 pl1 p1 p2
     |
     - [Parent1](content-id=53, location-id=20)
       ez-all c53 ct1 l20 pl2 p1 p2 p20
     - [Parent2](content-id=54, location-id=21)
       ez-all c55 ct1 l22 pl2 p1 p2 p22
       |
       - [Child](content-id=55, location-id=22)
         ez-all c55 ct1 l22 pl21 p1 p2 p21 p22
```

The following keys will be purged during the move:
- `l20`, because cache for previous parent of `[Child]` should be purged (`[Parent1]`)
- `pl20`, because cache for children of `[Parent1]` should be purged
- `l21`, because cache for new parent of `[Child]` should be purged (`[Parent2]`)
- `pl21`, because cache for all children of new parent (`[Parent2]`) should be purged
- `p22`, because cache for any element below `[Child]` should be purged (because path has changed)

In other words, HTTP Cache for `[Parent1]`, children of `[Parent1]` ( if any ), `[Parent2]`, children of `[Parent2]` ( if any ),
`[Child]` and any subtree below `[Child]`.

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

## Testing and debugging HTTP cache

It is important to test your code in an environment which is as similar as your production environment as possible. That
means that if only are testing locally using the default Symfony Reverse proxy when your are going to use Varnish or
Fastly in production, you are likely ending up some (bad) surprises. Due to the symfony reverse proxy's lack of support for ESIs, it behaves
quite different from Varnish and Fastly in some aspects.
If you are going to use Varnish in production, make sure you also test your code with Varnish.
If you are going to use Fastly in production, testing with Fastly in your developer install is likely not feasible
(you're local development environment must then be accessible for Fastly). Testing with Varnish instead will in most
cases do the job. But if you need to change the varnish configuration to make your site work, be aware that Varnish and Fastly uses different dialects, and
that .vcl code for Varnish V6.x will likely not work as-is on Fastly.

This section describes to how to debug problems related to HTTP cache. 
	In order to that, you must be able to look both at
	responses and headers [[= product_name =]] sends to HTTP cache, and not so much at responses and headers
	the HTTP cache sends to the client (web browser).
	It means you must be able to send requests to your origin (web server) that do not go through Varnish or Fastly.
	If you run Nginx and Varnish on premise, you should know what host and port number both Varnish and Nginx runs on. If you
	perform tests on Fastly enabled environment on Ibexa Cloud provided by Platform.sh, you need to use the Platform.sh
	Dashboard to obtain the endpoint for Nginx.

The following example shows how to debug and check why Fastly does not cache the front page properly. 
If you run the command multiple times:

`curl -IXGET https://www.staging.foobar.com.us-2.platformsh.site`

it always outputs:

```
HTTP/2 200
(...)
x-cache: MISS
```

### Nginx endpoint on Platform.sh

#### Finding Nginx endpoint for environments located on the grid

To find the Nginx point, first, you need to know in which region your project is located. To do that, go to the Platform.sh dashboard.
To find a valid route, click an element in the **URLs** drop-down for the specified environment and select the route.
A route may look like this:
`https://www.staging.foobar.com.us-2.platformsh.site/`

In this case the region is `us-2` and you can find the public IP list on [Platform.sh documentation page](https://docs.platform.sh/development/public-ips.html)
Typically, you can add a `gw` to the hostname and use nslookup to find it.

```bash
    $ nslookup
    > gw.us-2.platformsh.site
   (...)
   Address:  1.2.3.4
```

You can also use the [Platform.sh CLI command](https://docs.platform.sh/development/cli.html) to find [the endpoint](https://docs.platform.sh/domains/steps/dns.html?#where-should-the-cname-point-to):

```bash
    $ platform environment:info edge_hostname
```

#### Finding Nginx endpoint on dedicated cloud

If you have a dedicated 3-node cluster on Platform.sh, the procedure for getting the endpoint to environments that are 
located on that cluster (`production` and sometimes also `staging`) is slightly different.
In the **URLs** drop-down in the Platform.sh dashboard, find the route that has the format 
`somecontent.[clusterid].ent.platform.sh/`, for example, `myenvironment.abcdfg2323.ent.platform.sh/`

The endpoint in case has the format `c.[clusterid].ent.platform.sh`, for example, `c.asddfs2323.ent.platform.sh/`
Next, use nslookup to find the IP:

```bash
    $ nslookup
    > c.asddfs2323.ent.platform.sh
   (...)
   Address:  1.2.3.4
```

### Fetching user context hash

As explained in [User Context Hash caching](context_aware_cache.md#user-context-hash-caching), the HTTP cache indexes the cache based on the
user-context-hash. Users with the same user-context-hash here the same cache (as long as [[= product_name =]]
responds with `Vary: X-Context-User-Hash`).

In order to simulate the requests the HTTP cache sends to [[= product_name =]], you need this user-context-hash.
To obtain it, use `curl`.

```bash
    $ curl -IXGET --resolve www.staging.foobar.com.us-2.platformsh.site:443:1.2.3.4 --header "Surrogate-Capability: abc=ESI/1.0" --header "accept: application/vnd.fos.user-context-hash" --header "x-fos-original-url: /" https://www.staging.foobar.com.us-2.platformsh.site/_fos_user_context_hash
```

Some notes about each of these parameters:
- `-IXGET`, one of many ways to tell curl that we want to send a GET request, but we are only interested in outputting the headers
- `--resolve www.staging.foobar.com.us-2.platformsh.site:443:1.2.3.4`
  - We tell curl not to do a DNS lookup for `www.staging.foobar.com.us-2.platformsh.site`. We do that because in our case
    that will resolve to the Fastly endpoint, not our origin (nginx)
  - We specify `443` because we are using `https`
  - We provide the IP of the nginx endpoint at platform.sh (`1.2.3.4` in this example)
- `--header "Surrogate-Capability: abc=ESI/1.0"`, strictly speaking not needed when fetching the user-context-hash, but this tells [[= product_name =]] that client understands ESI tags.
  It is good practice to always include this header when imitating the HTTP Cache.
- `--header "accept: application/vnd.fos.user-context-hash"` tells [[= product_name =]] that the client wants to receive the user-context-hash
- `--header "x-fos-original-url: /"` is required by the fos-http-cache bundle in order to deliver the user-context-hash
- `https://your-page-blah-blah.us-2.platformsh.site/_fos_user_context_hash` : here we use the hostname we earlier told
  curl how to resolve using `---resolve`. `/_fos_user_context_hash` is the route to the controller that are able to
  deliver the user-context-hash.
- You may also provide the session cookie (`--cookie ".....=....") for a logged-in-user if you are interested in
  the x-user-context-hash for a different user but anonymous

The output for this command should look similar to this:
```
    HTTP/1.1 200 OK
    Server: nginx/1.20.0
    Content-Type: application/vnd.fos.user-context-hash
    Transfer-Encoding: chunked
    Connection: keep-alive
    X-User-Context-Hash: daea248406c0043e62997b37292bf93a8c91434e8661484983408897acd93814
    Cache-Control: max-age=600, public
    Date: Tue, 31 Aug 2021 13:35:00 GMT
    Vary: Origin
    Vary: cookie
    Vary: authorization
    X-Cache-Debug: 1
    Surrogate-Key: ez-user-context-hash ez-all fos_http_cache_hashlookup-
```

The header `X-User-Context-Hash` is the one of the interest here, but you may also note the `Surrogate-Key` which
holds the [cache tags](#cache-tags).

### Fetching HTML response

Now you have the user-context-hash, and you can ask origin for the actual resource you are after:

```bash
    $ curl -IXGET --resolve www.staging.foobar.com.us-2.platformsh.site:443:1.2.3.4 --header "Surrogate-Capability: abc=ESI/1.0" --header "x-user-context-hash: daea248406c0043e62997b37292bf93a8c91434e8661484983408897acd93814" https://www.staging.foobar.com.us-2.platformsh.site/
```

The output :
```
HTTP/1.1 200 OK
Server: nginx/1.20.0
Content-Type: text/html; charset=UTF-8
Transfer-Encoding: chunked
Connection: keep-alive
Cache-Control: public, s-maxage=86400
Date: Wed, 01 Sep 2021 07:18:27 GMT
X-Cache-Debug: 1
Vary: X-User-Context-Hash
Vary: X-Editorial-Mode
Surrogate-Control: content="ESI/1.0"
Surrogate-Key: ez-all c52 ct42 l2 pl1 p1 p2 r56 r57
```

The `Cache-Control` header tells the HTTP cache to store the result in the cache for 1 day (86400 seconds)
The `Vary: X-User-Content-Hash` header tells the HTTP cache that this cache element may be used for all users which has
the given `x-user-hash` (`daea248406c0043e62997b37292bf93a8c91434e8661484983408897acd93814`).
The document might also be removed from the cache by purging any of the keys provided in the `Surrogate-Key` header.

So back to the original problem here. This resource is for some reason not cached by Fastly ( remember the
`x-cache: MISS` we started with). But origin says this page can be cached for 1 day. How can that be?
The likely reason is that this page also contains some ESI fragments and that one or more of these are not cachable.

So, first let's see if there are any ESIs here. We remove the `-IXGET` options (in order to see content of the response,
not only headers) to curl and search for esi:

```bash
    $ curl --resolve www.staging.foobar.com.us-2.platformsh.site:443:1.2.3.4 --header "Surrogate-Capability: abc=ESI/1.0" --header "x-user-context-hash: daea248406c0043e62997b37292bf93a8c91434e8661484983408897acd93814" https://www.staging.foobar.com.us-2.platformsh.site/ | grep esi
```

The output is :

```HTML
    <esi:include src="/_fragment?_hash=B%2BLUWB2kxTCc6nc5aEEn0eEqBSFar%2Br6jNm8fvSKdWU%3D&_path=locationId%3D2%26contentId%3D52%26blockId%3D11%26versionNo%3D3%26languageCode%3Deng-GB%26serialized_siteaccess%3D%257B%2522name%2522%253A%2522site%2522%252C%2522matchingType%2522%253A%2522default%2522%252C%2522matcher%2522%253Anull%252C%2522provider%2522%253Anull%257D%26serialized_siteaccess_matcher%3Dnull%26_format%3Dhtml%26_locale%3Den_GB%26_controller%3DEzSystems%255CEzPlatformPageFieldTypeBundle%255CController%255CBlockController%253A%253ArenderAction" />
    <esi:include src="/_fragment?_hash=egcfVhka%2Beo80g%2B6ztYi12ebiaWfoWwKIACmSWVRqjI%3D&_path=locationId%3D2%26contentId%3D52%26blockId%3D12%26versionNo%3D3%26languageCode%3Deng-GB%26serialized_siteaccess%3D%257B%2522name%2522%253A%2522site%2522%252C%2522matchingType%2522%253A%2522default%2522%252C%2522matcher%2522%253Anull%252C%2522provider%2522%253Anull%257D%26serialized_siteaccess_matcher%3Dnull%26_format%3Dhtml%26_locale%3Den_GB%26_controller%3DEzSystems%255CEzPlatformPageFieldTypeBundle%255CController%255CBlockController%253A%253ArenderAction" />
    <esi:include src="/_fragment?_hash=lnKTnmv6bb1XpaMPWRjV3sNazbn9rDXskhjGae1BDw8%3D&_path=locationId%3D2%26contentId%3D52%26blockId%3D13%26versionNo%3D3%26languageCode%3Deng-GB%26serialized_siteaccess%3D%257B%2522name%2522%253A%2522site%2522%252C%2522matchingType%2522%253A%2522default%2522%252C%2522matcher%2522%253Anull%252C%2522provider%2522%253Anull%257D%26serialized_siteaccess_matcher%3Dnull%26_format%3Dhtml%26_locale%3Den_GB%26_controller%3DEzSystems%255CCustomBundle%255CController%255CFooController%253A%253AcustomAction" />
```

Now, investigate the response of each of these ESI fragments to understand what is going on. It is important to
put that URL in single quotes as the URLS to the ESIs include special characters that can be interpreted by the
shell.

#### 1st ESI

```bash
    $ curl -IXGET --resolve www.staging.foobar.com.us-2.platformsh.site:443:1.2.3.4 --header "Surrogate-Capability: abc=ESI/1.0" --header "x-user-context-hash: daea248406c0043e62997b37292bf93a8c91434e8661484983408897acd93814" 'https://www.staging.foobar.com.us-2.platformsh.site/_fragment?_hash=B%2BLUWB2kxTCc6nc5aEEn0eEqBSFar%2Br6jNm8fvSKdWU%3D&_path=locationId%3D2%26contentId%3D52%26blockId%3D11%26versionNo%3D3%26languageCode%3Deng-GB%26serialized_siteaccess%3D%257B%2522name%2522%253A%2522site%2522%252C%2522matchingType%2522%253A%2522default%2522%252C%2522matcher%2522%253Anull%252C%2522provider%2522%253Anull%257D%26serialized_siteaccess_matcher%3Dnull%26_format%3Dhtml%26_locale%3Den_GB%26_controller%3DEzSystems%255CEzPlatformPageFieldTypeBundle%255CController%255CBlockController%253A%253ArenderAction'
```

You can also note that this ESI is handled by a controller in the `EzPlatformPageFieldTypeBundle` bundle provided by [[= product_name =]].

The output is:

```
HTTP/1.1 200 OK
Server: nginx/1.20.0
Content-Type: text/html; charset=UTF-8
Transfer-Encoding: chunked
Connection: keep-alive
Cache-Control: public, s-maxage=86400
Date: Wed, 01 Sep 2021 07:51:40 GMT
Vary: Origin
Vary: X-User-Context-Hash
Vary: X-Editorial-Mode
X-Cache-Debug: 1
Surrogate-Key: ez-all c52 l2
```

The headers here look correct and do not indicate that this ESI will not be cached by the HTTP cache
The second ESI has a similar response.

#### 3rd ESI

```bash
    $ curl -IXGET --resolve www.staging.foobar.com.us-2.platformsh.site:443:1.2.3.4 --header "Surrogate-Capability: abc=ESI/1.0" --header "x-user-context-hash: daea248406c0043e62997b37292bf93a8c91434e8661484983408897acd93814" 'https://www.staging.foobar.com.us-2.platformsh.site//_fragment?_hash=lnKTnmv6bb1XpaMPWRjV3sNazbn9rDXskhjGae1BDw8%3D&_path=locationId%3D2%26contentId%3D52%26blockId%3D13%26versionNo%3D3%26languageCode%3Deng-GB%26serialized_siteaccess%3D%257B%2522name%2522%253A%2522site%2522%252C%2522matchingType%2522%253A%2522default%2522%252C%2522matcher%2522%253Anull%252C%2522provider%2522%253Anull%257D%26serialized_siteaccess_matcher%3Dnull%26_format%3Dhtml%26_locale%3Den_GB%26_controller%3DEzSystems%255CCustomBundle%255CController%255CFooController%253A%253AcustomAction'
```

This ESI is handled by a custom `FooController::customAction` and the output of the command is:

Output:

```
HTTP/1.1 200 OK
Server: nginx/1.20.0
Content-Type: text/html; charset=UTF-8
Transfer-Encoding: chunked
Connection: keep-alive
Set-Cookie: eZSESSID21232f297a57a5a743894a0e4a801fc3=asrpqgmh5ll5ssseca3cov8er7; path=/; HttpOnly; SameSite=lax
Cache-Control: public, s-maxage=86400
Date: Wed, 01 Sep 2021 07:51:40 GMT
Vary: Origin
Vary: X-User-Context-Hash
Vary: X-Editorial-Mode
X-Cache-Debug: 1
Surrogate-Key: ez-all
```

The `Cache-Control` and `Vary` headers look correct. The request is handled by a custom controller and the `Surrogate-Key` only contains the default `ez-all` value. 
This is not a problem as long as the controller
does not return values from any Content in the [[= product_name =]] Repository. If it does, the controller should also add
the corresponding IDs to such objects in that header.

The `Set-Cookie` here may cause the problem. A ESI fragment should never set a cookie because:
- Clients will only receive the headers set in the "mother" document (the headers in the "/" response in this case).

- Only the content of ESIs responses will be returned to the client. **No headers set in the ESI response will ever reach the client**. ESI headers are only seen by the HTTP cache.
  
- Symfony reverse proxy does not support ESIs at all, and any ESI calls (`render_esi()`) will implicitly be replaced by
  sub-requests (`render()`). So any `Set-Cookie` **will** be sent to the client when using Symfony reverse proxy.
  
- Fastly will flag it resource as "not cachable" because it set a cookie at least once. Even though that endpoint.
  stops setting cookies, Fastly will still not cache that fragment. Any document referring to that ESI will be a `MISS`.
  Fastly cache needs to be purged (`Purge-all` request) in order to remove this flag.
  
- It means that it is not recommended to always initiate a session when loading the front page.

You must ensure that you do not unintendedly start a session in a controller used by ESIs, for example, when trying to access as session variable before a session has been initiated yet.
