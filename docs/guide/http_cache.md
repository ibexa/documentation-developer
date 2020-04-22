# HTTP cache

## Content cache

eZ Platform uses [Symfony HTTP cache](http://symfony.com/doc/5.0/http_cache.html) to manage content "view" cache with an [expiration model](http://symfony.com/doc/5.0/http_cache.html#expiration-caching).
In addition it is extended (using FOSHttpCache) to add several advanced features.
For content coming from eZ Platform itself, the following applies:

- To be able to always keep cache up to date, cache is **content-aware**.
This enables updates to content to trigger cache invalidation.
    - Uses a custom `X-Location-Id` header, which both Symfony and Varnish proxy are able to invalidate cache on
    (for details see [Cache purging](#cache-purging).)
- To be able to also cache requests by logged-in users, cache is **[context-aware](#context-aware-http-cache)**.
    - Uses a custom Vary header `X-User-Context-Hash` to allow pages to vary by user rights
    (not by unique user, which is better served by browser cache.)

### Cache and expiration configuration

This is how cache can be configured in `config/packages/ezplatform.yaml`:

``` yaml
ezplatform:
    system:
        my_siteaccess:
            content:
                view_cache: true      # Activates HTTP cache for content
                ttl_cache: true       # Activates expiration based HTTP cache for content (very fast)
                default_ttl: 60       # Number of seconds an HTTP response cache is valid (if ttl_cache is true, and if no custom s-maxage is set)
```

#### Cache and expiration configuration for error pages

You may want to set a high `default_ttl` to have a high cache hit ratio on your installation.
As the system takes care of purges, the cache rarely becomes stale.

However, a few redirect and error pages are served via the ContentView system.
If you set a high `default_ttl`, they could also be served from cache, which should be avoided.
You should set those specific pages to a much lower TTL.
For this you can use the [FOSHttpCacheBundle matching rules](http://foshttpcachebundle.readthedocs.io/en/1.3/reference/configuration/headers.html) feature to specify a different TTL:

``` yaml
fos_http_cache:
    cache_control:
        rules:
            # Make sure cacheable (fresh) responses from eZ Platform which are errors/redirects get lower TTL than default_ttl
            -
                match:
                    match_response: 'response.isFresh() && ( response.isServerError() || response.isClientError() || response.isRedirect() )'
                headers:
                    overwrite: true
                    cache_control:
                        max_age: 5
                        s_maxage: 20
```

Similarly, if you want to apply performance tuning to avoid crawlers affecting the setup too much, you can also set up caching of generic 404s and similar error pages in the following way:

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

### Making your controller response content-aware

Sometimes you need your controller's cache to be invalidated at the same time as specific content changes (i.e. [ESI sub-requests with `render` twig helper](http://symfony.com/doc/5.0/http_cache/esi.html), for a menu for instance). To be able to do that, you need to add `X-Location-Id` header to the response object:

``` php
use Symfony\Component\HttpFoundation\Response;

// Inside a controller action
// "Connects" the response to location #123 and sets a max age (TTL) of 1 hour.
$response = new Response();
$response->headers->set('X-Location-Id', 123);
$response->setSharedMaxAge(3600);
```

### Making your controller response context-aware

If the content you're rendering depends on a User's permissions, then you should make the response context-aware:

``` php
use Symfony\Component\HttpFoundation\Response;

// Inside a controller action
// Tells proxy configured to support this header to take the rights of a user (user hash) into account for the cache
$response = new Response();
$response->setVary('X-User-Context-Hash');
```

## Cache purging

The Content cache purge (invalidate) mechanism is used when publishing content from the UI or from a container-aware script
This results in cache being invalidated either in the built-in Symfony reverse proxy, or on the much faster Varnish reverse proxy.

Note that if you use a non-reverse proxy that does not support purge headers,
shared content will stay in the cache for the whole duration defined by `s-maxage`,
without the possibility of clearing it.

eZ Platform returns content-related responses with an `X-Location-Id` header.
The responses are stored together by the configured HTTP cache.
This allows you to clear (invalidate) HTTP cache representing specifically a given Content item.
On publishing the content, a cache purger is triggered with the content ID in question,
which in turn figures out affected Locations based on [HTTP cache tag](#http-cache-tagging) logic.
The returned Location IDs are sent for purge using the selected purge type.

### Purge types

#### Symfony Proxy: Local purge type

By default, invalidation requests will be emulated and sent to the Symfony proxy cache store.
In `config/packages/ezplatform.yaml`:

``` yaml
ezplatform:
    http_cache:
        purge_type: local
```

#### Varnish: HTTP purge type

With Varnish you can configure one or several servers that should be purged over HTTP.
This purge type is asynchronous, and flushed by the end of Symfony kernel-request/console cycle (during the terminate event).
Settings for purge servers can be configured per SiteAccess group or SiteAccess:

``` yaml
ezplatform:
    http_cache:
        purge_type: http

    system:
        my_siteacess:
            http_cache:
                purge_servers: ['http://varnish.server1', 'http://varnish.server2', 'http://varnish.server3']
```

!!! tip "Environment Variables"

    eZ Platform uses environment variables by default, so you can define those values in the environment.
    See [Update your Virtual Host](#update-your-virtual-host)

For further information on setting up Varnish, see [Using Varnish](#using-varnish).

### Purging

While purging on content, updates are handled for you.
On actions against the eZ Platform APIs, there are times you might have to purge manually.

#### Purge by command with Symfony proxy

Symfony proxy stores its cache in the Symfony cache directory, so a regular `cache:clear` commands will clear it:

``` bash
php bin/console --env=prod cache:clear
```

#### Purge by HTTP BAN request on Varnish

If you use Varnish and need to purge content directly, use the following examples to see how this is done internally by the FOSPurgeClient, and in turn FOSHttpCache Varnish proxy client:

For purging all:

```
BAN / HTTP 1.1
Host: localhost
X-Location-Id: .*
```

Or with given Location IDs (here 123 and 234):

```
BAN / HTTP 1.1
Host: localhost
X-Location-Id: ^(123|234)$
```

### Using Varnish

As eZ Platform is built on top of Symfony, it uses standard HTTP cache headers.
By default the Symfony reverse proxy, written in PHP, is used to handle cache, but it can be easily replaced with any other reverse proxy like Varnish.

!!! note

    Use of Varnish is a requirement for a [Clustering](clustering.md) setup.

#### Recommended VCL base files

For Varnish to work properly with eZ, you'll need to use one of the provided files as a basis:

- [Varnish 5 VCL example](https://github.com/ezsystems/ezplatform-http-cache/blob/master/docs/varnish/vcl/varnish5.vcl)

!!! note

    HTTP cache management is done with the help of [FOSHttpCacheBundle](http://foshttpcachebundle.readthedocs.org/). You may need to tweak your VCL further on according to [FOSHttpCache documentation](http://foshttpcache.readthedocs.org/en/latest/varnish-configuration.html) in order to use features supported by it.

#### Configure eZ Platform

##### Update your Virtual Host

You need to tell the PHP process that you are behind a Varnish proxy and not the built-in Symfony HTTP Proxy.
If you use fastcgi/fpm you can pass these directly to PHP process, but in all cases you can also specify them in your web server config.

###### On Apache

```
# my_virtualhost.conf

<VirthualHost *:80>
    # Configure your VirtualHost with rewrite rules and stuff

    # Force front controller NOT to use built-in reverse proxy.
    SetEnv SYMFONY_HTTP_CACHE 0
    SetEnv HTTPCACHE_PURGE_TYPE http
    SetEnv HTTPCACHE_PURGE_SERVER "http://varnish:80"

    # Configure IP of your Varnish server to be trusted proxy
    # Replace fake IP address below by your Varnish IP address
    SetEnv SYMFONY_TRUSTED_PROXIES "193.22.44.22"
</VirtualHost>
```

###### On nginx

```
# mysite.com

fastcgi_param SYMFONY_HTTP_CACHE 0;
fastcgi_param HTTPCACHE_PURGE_TYPE http;
fastcgi_param HTTPCACHE_PURGE_SERVER "http://varnish:80";

# Configure IP of your Varnish server to be trusted proxy
# Replace fake IP address below by your Varnish IP address
fastcgi_param SYMFONY_TRUSTED_PROXIES "193.22.44.22";
```

!!! caution "Trusted proxies when using SSL offloader / loadbalancer in combination with Varnish"

    If your installation works behind Varnish and SSL offloader (like HAProxy), you need to add `127.0.0.1` to `SYMFONY_TRUSTED_PROXIES`.
    Otherwise, you might notice incorrect schema (`http` instead of `https`) in the URLs for the images or other binary files
    when they are rendered inline by Symfony *(as used by file-based field templates)*, as opposed to via ESI.

#### Update YAML configuration

Secondly, you need to tell eZ Platform to use an HTTP-based purge client (specifically the FosHttpCache Varnish purge client),
and specify the URL Varnish can be reached on:

The following configuration is not required as eZ Platform will read the environment variables set above.

``` yaml
ezplatform:
    http_cache:
        purge_type: http

    system:
        # Assuming that my_siteaccess_group contains both your front-end and back-end SiteAccesses
        my_siteaccess_group:
            http_cache:
                # Fill in your Varnish server(s) address(es).
                purge_servers: [http://my.varnish.server:8081]
```

!!! note "Multiple Purge Servers"

    If you need to set multiple purge servers, then you need to configure them in the YAML file.

!!! enterprise

    #### Serving Varnish through Fastly

    [Fastly](https://www.fastly.com/) delivers Varnish as a service. See [Fastly documentation](https://docs.fastly.com/guides/basic-concepts/how-fastlys-cdn-service-works) to read how it works.

    #### Configuring Fastly

    ##### purge_type

    To use Fastly, set `purge_type` to `fastly`.

    ##### purge_server

    `purge_server` must be set to `https://api.fastly.com`.

    Both `purge_type` and `purge_server` can be set in one of the following ways:

    - in `config/packages/ezplatform.yaml`
    - by adding the parameter `purge_type` or `purge_server` respectively in `config/packages/ezplatform.yaml`
    - by setting the `HTTPCACHE_PURGE_TYPE` environment variable.

    It is recommended to use either `config/services.yaml` or the environment variable.

    As of eZ Enterprise v1.13.6 and v2.5.9, you no longer need to set `HTTPCACHE_PURGE_SERVER` if you set `purge_type`
    via `HTTPCACHE_PURGE_TYPE`. If you set `purge_type` by any other means, you will still need to set `purge_server` too.

    Note that in `config/ezplatform.yaml`, the `purge_servers` setting is an array
    while the `HTTPCACHE_PURGE_SERVER` environment variable should be a string.

    ##### Fastly service ID and API token

    You also need to provide your Fastly service ID and API token in the configuration.

    The service ID can be obtained by logging in on http://fastly.com and clicking `CONFIGURE` in the top menu,
    then `Show service ID` at the top left of the page.

    See [this Fastly guide](https://docs.fastly.com/guides/account-management-and-security/using-api-tokens) for
    instructions on how to generate a Fastly API token.
    The token needs `purge_select` and `purge_all` scope.

    You may specify service ID and token:

    - using the `service_id` and `key` settings (sub elements of "fastly") in `config/packages/ezplatform.yaml`
    - by setting the parameters `fastly_service_id` and `fastly_key` in `config/packages/ezplatform-http-cache-fastly.yaml`
    - by setting the environment variables `FASTLY_SERVICE_ID` and `FASTLY_KEY`

    Unless you need different settings per SiteAccess it is recommended to either use `config/packages/ezplatform.yaml`
    or the environment variables.

    ##### Clear the cache

    ``` bash
    php app/console cache:clear -vv --env=prod;
    ```

    #### Configuration on Platform.sh

    If using Platform.sh, it's best to configure the Fastly credentials via [Platform.sh variables](https://docs.platform.sh/frameworks/ez/fastly.html).
    You'll also need to [disable Varnish](https://docs.platform.sh/frameworks/ez/fastly.html#remove-varnish-configuration) which is enabled by default in provided configuration for Platform.sh.
    See the [Platform.sh Professional documentation](https://docs.platform.sh/frameworks/ez.html)
    for running eZ Platform Enterprise on Platform.sh.  If using Platform.sh Enterprise see the [Platform.sh Enterprise Documentation](https://ent.docs.platform.sh/frameworks/ez.html).

!!! enterprise

    ### Setting Time-To-Live value for Page blocks

    Block cache by default respects `$content.ttl_cache$` and `$content.default_ttl$` settings.
    However, if the given block value has a since / till date,
    this will be taken into account for the TTL calculation for the block and also for the whole page.

    To overload this behavior, listen to [BlockResponseEvents::BLOCK_RESPONSE](extending/extending_page/#block-render-response),
    and set prioroty to for instance `-200` to adapt what Page Field type does by default. E.g. in order to disable cache
    for the block use `$event->getResponse()->setPrivate()`.

!!! note "Invalidating Varnish cache using tokens"

    In setups where the Varnish server IP can change (for example on platform.sh/eZ Platform Cloud),
    you can use token-based cache invalidation via [ez_purge_acl](https://github.com/ezsystems/ezplatform-http-cache/blob/master/docs/varnish/vcl/varnish5.vcl#L174).

    In such a case use a strong, secure hash and make sure to keep the token secret.

## Context-aware HTTP cache

As it is based on Symfony, eZ Platform uses HTTP cache extended with features like content awareness.
However, this cache management is only available for anonymous users due to HTTP restrictions.

It is possible to make HTTP cache vary thanks to the `Vary` response header,
but this header can only be based on one of the request headers (e.g. `Accept-Encoding`).
Thus, to make the cache vary on a specific context (for example a hash based on User Roles and Limitations),
this context must be present in the original request.

As the response can vary on a request header, the base solution is to make the kernel do a sub-request
in order to retrieve the user context hash (aka user hash).
Once the user hash has been retrieved, it's injected in the original request in the `X-User-Context-Hash` custom header,
making it possible to *vary* the HTTP response on this header:

``` php
<?php
use Symfony\Component\HttpFoundation\Response;

// ...

// Inside a controller action
$response = new Response();
$response->setVary('X-User-Context-Hash');
```

[FOSHttpCacheBundle's user context feature](http://foshttpcachebundle.readthedocs.org/en/latest/features/user-context.html) is activated by default.

Name of the [user hash header is configurable in FOSHttpCacheBundle](http://foshttpcachebundle.readthedocs.org/en/latest/reference/configuration/user-context.html). By default eZ Platform sets it to `**X-User-Context-Hash**`.

This solution is [implemented in Symfony reverse proxy ](http://foshttpcachebundle.readthedocs.org/en/latest/features/symfony-http-cache.html) and is also accessible to [dedicated reverse proxies like Varnish](http://foshttpcache.readthedocs.org/en/latest/varnish-configuration.html).

!!! note

    Note that sharing ESIs across SiteAccesses is not possible by design
    (see [EZP-22535](https://jira.ez.no/browse/EZP-22535) for technical details).

!!! tip "Vary by User"

    In cases where you need to deliver content uniquely to a given user,
    and you cannot use JavaScript and cookie values, hinclude, or disable cache,
    you can vary the response by cookie:

    ``` php
    $response->setVary('Cookie');
    ```

    Unfortunately this is not optimal as it will by default vary by all cookies,
    including those set by add trackers, analytics tools, recommendation services, etc.
    However, as long as your application backend does not need these cookies,
    you can solve this by stripping everything but the session cookie.
    Example for Varnish can be found in the default VCL examples in part dealing with User Hash,
    for single-server setup this can easily be accomplished in Apache or nginx as well.

#### HTTP cache clearing

As eZ Platform uses [FOSHttpCacheBundle](http://foshttpcachebundle.readthedocs.org/), this impacts the following features:

- HTTP cache purge
- User context hash

Varnish proxy client from the FOSHttpCache library is used for clearing eZ Platform's HTTP cache, even when using Symfony HTTP cache.
A single `BAN` request is sent to registered purge servers, containing an `X-Location-Id` header.
This header contains all Location IDs for which objects in cache need to be cleared.

#### Workflow

Refer to [FOSHttpCacheBundle documentation on how user context feature works](http://foshttpcachebundle.readthedocs.org/en/latest/features/user-context.html#how-it-works).

#### User hash generation

Refer to [FOSHttpCacheBundle documentation on how user hashes are generated](http://foshttpcachebundle.readthedocs.org/en/latest/features/user-context.html#generating-hashes).

eZ Platform already interferes with the hash generation process by adding the current User's permissions and Limitations. You can also interfere in this process by [implementing custom context provider(s)](http://foshttpcachebundle.readthedocs.org/en/latest/reference/configuration/user-context.html#custom-context-providers).

!!! tip

    [Examples of user hash generation](https://github.com/ezsystems/ezplatform/tree/master/doc/varnish/vcl)

##### New anonymous `X-User-Context-Hash`

The anonymous `X-User-Context-Hash` is generated based on the `anonymous user`, `group` and `role`.

If you need to find out the anonymous `X-User-Context-Hash`:

1\. Connect to your server (*shh* should be enough)

2\. Add `<your-domain.com>` to your `/etc/hosts` file

3\. Execute the following command:

`curl -I -H "Accept: application/vnd.fos.user-context-hash" http://<your-domain.com>/_fos_user_context_hash`

Remember that you have to send this request to the backend, not to Varnish.

You should get a result like this:

```
HTTP/1.1 200 OK
Date: Mon, 03 Oct 2016 15:34:08 GMT
Server: Apache/2.4.18 (Ubuntu)
X-Powered-By: PHP/7.0.8-0ubuntu0.16.04.2
X-User-Context-Hash: b1731d46b0e7a375a5b024e950fdb8d49dd25af85a5c7dd5116ad2a18cda82cb
Cache-Control: max-age=600, public
Vary: Cookie,Authorization
Content-Type: application/vnd.fos.user-context-hash
```

4\. Restart the Varnish server.

##### Known limitations of the user hash generation

If you are using URI-based SiteAccesses matching, the default SiteAccess on the domain needs to point to the same repository, because `/_fos_user_context_hash` is not SiteAccess-aware by default (see `ezpublish.default_router.non_siteaccess_aware_routes` parameter). Varnish does not have knowledge about SiteAccesses, so it won't be able to get user content hash if the default SiteAccess relies on URI.  

##### Default options for FOSHttpCacheBundle defined in eZ Platform

The following configuration is defined in eZ Platform by default for FOSHttpCacheBundle.
You may override these settings.

``` yaml
fos_http_cache:
    proxy_client:
        # "varnish" is used, even when using Symfony HTTP cache.
        default: varnish
        varnish:
            # Means http_cache.purge_servers defined for current SiteAccess.
            servers: ['$http_cache.purge_servers$']

    user_context:
        enabled: true
        # User context hash is cached during 10min
        hash_cache_ttl: 600
```

## HTTP cache tagging

`ezplatform-http-cache` enables HTTP cache tagging.
This allows you to add tags to cached content, which simplifies selective cache invalidation.

### Using tags

Understanding tags is the key to making the most of `ezplatform-http-cache`:

- Tags form a secondary set of keys assigned to every cache item, on top of the "primary key" which is the URI
- Like an index in a database, a tag is typically used for anything relevant that represents the given cache item
- Tags are used for cache invalidation

As a practical example, you can tag every article response, and when the article Content Type is updated,
you can tell Varnish that all articles should be considered stale and be updated in the background
when someone requests them.

#### Available tags

- `content-<content-id>` - Used on anything that is affected by changes to content, that is content itself, Locations, and so on.
- `content-type-<content-type-id>` - For use when the Content Type changes, affecting content of its type.
- `location-<location-id>` - Used for clearing all cache relevant for a given Location.
- `parent-<parent-location-id>` - Useful for clearing all children of a parent, or in all siblings.
- `path-<location-id>` - For operations that change the tree itself, like move, remove, etc.
- `relation-<content-id>` - For use when updates affect their all reverse relations.
Note that the system does not add this tag to responses itself, just purges if present.
Response tagging using this tag is currently meant to be done inline in the template logic / views
based on your decision.

!!! tip "Troubleshooting - content tagged by a big number of tags (too long headers)"

    In case of complex content, for instance Landing Pages with many blocks, you might get into trouble with too long response `xkey` header. Because of this, necessary cache entries may not be tagged properly. You will also see `502 Headers too long` errors.
    If this is the case, customize the following runtime settings on your Varnish instance(s):

    - [http_resp_hdr_len](https://varnish-cache.org/docs/6.0/reference/varnishd.html#http-resp-hdr-len) (e.g. 32k)
    - [http_max_hdr](https://varnish-cache.org/docs/6.0/reference/varnishd.html#http-max-hdr) (e.g. 128)
    - [http_resp_size](https://varnish-cache.org/docs/6.0/reference/varnishd.html#http-resp-size) (e.g. 64k)
    - [workspace_backend](https://varnish-cache.org/docs/6.0/reference/varnishd.html#workspace-backend) (e.g. 128k)

    If you need to see these long headers in the `varnishlog` adapt the [vsl_reclen](https://varnish-cache.org/docs/5.1/reference/varnishd.html#vsl-reclen) setting.

### Response tagging process

#### For Content View

For Content View there is a dedicated response listener `HttpCacheResponseSubscriber`
that triggers a set of Response taggers responsible for translating info from the objects
involved in generating the view to corresponding tags as listed above.
These can be found in `ezplatform-http-cache/src/ResponseTagger`.

#### For responses with X-Location-Id

For custom or eZ Platform controllers still using `X-Location-Id`, a dedicated response listener
`XLocationIdResponseSubscriber` handles translating this to tags so the cache can be properly invalidated by this bundle.

!!! note

    This is currently marked as deprecated. For rendering content it is advised to refactor to use Content View.
    For other needs there is an FOS tag handler for Twig and PHP that can be used.

#### For custom needs with FOSHttpCache (tagging Relations and more)

For custom needs, including template logic for eZ Platform's Content Relations which is here used as an example, there are two ways
to tag your responses.

##### In Twig

In Twig, you can make sure a response is tagged correctly by using the following Twig operator in your template:

``` html+twig
{{ fos_httpcache_tag('relation-33') }}

{# Or using array for several values #}
{{ fos_httpcache_tag(['relation-33', 'relation-44']) }}
```

See [Tagging from Twig Templates](http://foshttpcachebundle.readthedocs.io/en/1.3/features/tagging.html#tagging-from-twig-templates) in FOSHttpCacheBundle doc.

##### In PHP

In PHP, FOSHttpCache exposes the `fos_http_cache.handler.tag_handler` service which enables you to add tags to a response:

``` php
/** @var \FOS\HttpCache\Handler\TagHandler $tagHandler */
$tagHandler->addTags(['relation-33', 'relation-44']);
```

See [Tagging from code](http://foshttpcachebundle.readthedocs.io/en/1.3/features/tagging.html#tagging-from-code) in FOSHttpCacheBundle doc.

!!! caution

    Be aware that the service name and type hint will change once we move to FOSHttpCache 2.x, so in this case
    you can alternatively consider adding a tag in Twig template or using `X-Location-Id` for the time being.

### How purge tagging is done

This bundle uses Repository API Event Subscribers to listen to Events emitted on Repository operations,
and depending on the operation triggers expiry on a specific tag or set of tags.

For example on Move Location Event the following tags will be purged:

```php
[
    // The tree itself being moved (all children will have this tag)
    'path-' . $event->getLocation()->id,
    // old parent
    'location-' . $event->getLocation()->parentLocationId,
    // old siblings
    'parent-' . $event->getLocation()->parentLocationId,
    // new parent
    'location-' . $event->getNewParentLocation()->id,
    // new siblings
    'parent-' . $event->getNewParentLocation()->id,
];
```

All Event Subscribers can be found in `ezplatform-http-cache/src/EventSubscriber/CachePurge`.

#### ResponseTagger API

Response Taggers take a `Response`, a `ResponseConfigurator` and any value object,
and add tags to the Response based on the value.

##### Example

This adds the `content-<contentId>`, `location-<mainLocationId>` and `content-type-<contentTypeId>` tags
to the Response:

```php
$contentInfoResponseTagger->tag($response, $configurator, $contentInfo);
```

##### ResponseConfigurator

A `ResponseCacheConfigurator` configures an HTTP Response object:
makes the response public, adds tags, sets the shared max age, etc.
It is provided to `ResponseTaggers` that use it to add the tags to the Response.

The `ConfigurableResponseCacheConfigurator` (`ezplatform.view_cache.response_configurator`)
is configured in `view_cache` and only enables cache if it is enabled in the configuration.

##### Delegator and Value Taggers

Even though they share the same API, Response Taggers are of two types, reflected by their namespace:
Delegator and Value.

Delegator Taggers will extract another value, or several, from the given value, and pass it on to another tagger.
For instance, a `ContentView` is covered by both the `ContentValueViewTagger` and the `LocationValueViewTagger`.
The first will extract the `Content` from the `ContentView`, and pass it to the `ContentInfoTagger`.
The second will extract the `Location`, and pass it to the `LocationViewTagger`.

##### Dispatcher Tagger

While it is more efficient to use a known tagger directly, sometimes you don't know what object you want to tag with.
The Dispatcher `ResponseTagger` will accept any value, and will pass it to every tagger registered with the service tag
`ezplatform.http_response_tagger`.
