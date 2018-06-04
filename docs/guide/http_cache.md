# HTTP cache

## Content cache

eZ Platform uses [Symfony HTTP cache](http://symfony.com/doc/2.8/http_cache.html) to manage content "view" cache with an [expiration model](http://symfony.com/doc/2.8/http_cache.html#expiration-caching).
In addition it is extended (using FOSHttpCache) to add several advanced features.
For content coming from eZ Platform itself, the following applies:

- To be able to always keep cache up to date, cache is **content-aware**.
This enables updates to content to trigger cache invalidation.
    - Uses a custom `X-Location-Id` header, which both Symfony and Varnish proxy are able to invalidate cache on
    (for details see [Cache purging](#cache-purging).)
- To be able to also cache requests by logged-in users, cache is **[context-aware](#context-aware-http-cache)**.
    - Uses a custom Vary header `X-User-Hash` to allow pages to vary by user rights
    (not by unique user, which is better served by browser cache.)

### Cache and expiration configuration

This is how cache can be configured in `ezplatform.yml`:

``` yaml
ezpublish:
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
                    match_response: "response.isFresh() && ( response.isServerError() || response.isClientError() || response.isRedirect() )"
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
                    match_response: "!response.isFresh() && response.isNotFound()"
                headers:
                    overwrite: true
                    cache_control:
                        public: true
                        max_age: 0
                        s_maxage: 20
```

### Making your controller response content-aware

Sometimes you need your controller's cache to be invalidated at the same time as specific content changes (i.e. [ESI sub-requests with `render` twig helper](http://symfony.com/doc/2.8/http_cache/esi.html), for a menu for instance). To be able to do that, you need to add `X-Location-Id` header to the response object:

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
$response->setVary('X-User-Hash');
```

## Smart HTTP cache clearing

Smart HTTP cache clearing refers to the ability to clear cache for Locations/Content that is in relation with the Content being currently cleared.

When published, any Content item usually has at least one Location, identified by its URL.
Because HTTP cache is bound to URLs, if a Content item is updated (a new version is published),
you want HTTP cache for all its Locations to be cleared, so the Content itself can be updated everywhere it is supposed to be displayed.

Sometimes, clearing cache for the Content item's Locations is not enough.
You can, for instance, have an excerpt of it displayed in a list from the parent Location, or from within a relation.
In this case, cache for the parent Location and/or the relation needs to be cleared as well (at least if ESI is not used).

### Smart cache clearing mechanism

Smart HTTP cache clearing is an event-based mechanism. Whenever a Content item needs its cache cleared, the cache purger service sends an `ezpublish.cache_clear.content` event (also identified by the `eZ\Publish\Core\MVC\Symfony\MVCEvents::CACHE_CLEAR_CONTENT` constant) and passes an `eZ\Publish\Core\MVC\Symfony\Event\ContentCacheClearEvent` event object. This object contains the `ContentInfo` object you need to clear the cache for. Every listener for this event can add Location objects to the *cache clear list*.

Once the event is dispatched, the purger passes collected Location objects to the purge client, which will effectively send the cache `BAN` request.

!!! note

    The event is dispatched with a dedicated event dispatcher, `ezpublish.http_cache.event_dispatcher`.

### Default behavior

By default, following Locations will be added to the cache clear list:

- All Locations assigned to a Content item (`AssignedLocationsListener`)
- Parent Location of all Content item's Locations (`ParentLocationsListener`)
- Locations for Content item's relations, including reverse relations (`RelatedLocationsListener`)

### Implementing a custom listener

By design, smart HTTP cache clearing is extensible. You can implement an event listener/subscriber to the `ezpublish.cache_clear.content` event and add Locations to the cache clear list.

#### Example

Here's a very simple custom listener example, adding an arbitrary Location to the list.

!!! caution

    Cache clear listener services **must** be tagged as `ezpublish.http_cache.event_subscriber` or `ezpublish.http_cache.event_listener`.

``` php
namespace Acme\AcmeTestBundle\EventListener;

use eZ\Publish\API\Repository\LocationService;
use eZ\Publish\Core\MVC\Symfony\Event\ContentCacheClearEvent;
use eZ\Publish\Core\MVC\Symfony\MVCEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ArbitraryLocationsListener implements EventSubscriberInterface
{
    /**
     * @var LocationService
     */
    private $locationService;

    public function __construct( LocationService $locationService )
    {
        $this->locationService = $locationService;
    }

    public static function getSubscribedEvents()
    {
        return [MVCEvents::CACHE_CLEAR_CONTENT => ['onContentCacheClear', 100]];
    }

    public function onContentCacheClear( ContentCacheClearEvent $event )
    {
        // $contentInfo is the ContentInfo object for the content being cleared.
        // You can extract information from it (e.g. ContentType from its contentTypeId), using appropriate Repository services.
        $contentInfo = $event->getContentInfo();

        // Adding arbitrary Locations to the cache clear list.
        $event->addLocationToClear( $this->locationService->loadLocation( 123 ) );
        $event->addLocationToClear( $this->locationService->loadLocation( 456 ) );
    }
}
```

``` php
parameters:
    acme.cache_clear.arbitrary_locations_listener.class: Acme\AcmeTestBundle\EventListener\ArbitraryLocationsListener

services:
    acme.cache_clear.arbitrary_locations_listener:
        class: %acme.cache_clear.arbitrary_locations_listener.class%
        arguments: [@ezpublish.api.service.location]
        tags:
            - { name: ezpublish.http_cache.event_subscriber }
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
On publishing the Content, a cache purger is triggered with the Content ID in question,
which in turn figures out affected Locations based on [smart HTTP cache clearing](#smart-http-cache-clearing) logic.
The returned Location IDs are sent for purge using the selected purge type.

### Purge types

#### Symfony Proxy: Local purge type

By default, invalidation requests will be emulated and sent to the Symfony proxy cache store.
In `ezplatform.yml`:

``` yaml
ezpublish:
    http_cache:
        purge_type: local
```

#### Varnish: HTTP purge type

With Varnish you can configure one or several servers that should be purged over HTTP.
This purge type is asynchronous, and flushed by the end of Symfony kernel-request/console cycle (during the terminate event).
Settings for purge servers can be configured per SiteAccess group or SiteAccess (in `ezplatform.yml`):

``` yaml
ezpublish:
    http_cache:
        purge_type: http

    system:
        my_siteacess:
            http_cache:
                purge_servers: ["http://varnish.server1", "http://varnish.server2", "http://varnish.server3"]
```

For further information on setting up Varnish, see [Using Varnish](#using-varnish).

### Purging

While purging on Content, updates are handled for you.
On actions against the eZ Platform APIs, there are times you might have to purge manually.

#### Manually from code

Manual purging from code uses the service also used internally for cache clearing on content updates
and takes [smart HTTP cache clearing](#smart-http-cache-clearing) logic into account:

``` yaml
// Purging cache based on Content ID, this will trigger cache clear of all Locations found by smart HTTP cache clearing
// typically self, parent, related, etc.
$container->get('ezpublish.http_cache.purger')->purgeForContent(55);
```

#### Manually by command with Symfony proxy

Symfony proxy stores its cache in the Symfony cache directory, so a regular `cache:clear` commands will clear it:

``` bash
php app/console --env=prod cache:clear
```

#### Manually by HTTP BAN request on Varnish

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

- [Varnish 3 VCL example](https://github.com/ezsystems/ezplatform/blob/1.7/doc/varnish/vcl/varnish3.vcl)
- [Varnish 4 VCL example](https://github.com/ezsystems/ezplatform/blob/1.7/doc/varnish/vcl/varnish4.vcl)

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

    # Configure IP of your Varnish server to be trusted proxy
    # Replace fake IP address below by your Varnish IP address
    SetEnv SYMFONY_TRUSTED_PROXIES "193.22.44.22"
</VirtualHost>
```

###### On nginx

```
# mysite.com

fastcgi_param SYMFONY_HTTP_CACHE 0;
# Configure IP of your Varnish server to be trusted proxy
# Replace fake IP address below by your Varnish IP address
fastcgi_param SYMFONY_TRUSTED_PROXIES "193.22.44.22";
```

!!! caution "Trusted proxies when using SSL offloader / loadbalancer in combination with Varnish"

    If your installation works behind Varnish and SSL offloader (like HAProxy), you need to add `127.0.0.1` to `SYMFONY_TRUSTED_PROXIES`.
    Otherwise, you might notice incorrect schema (`http` instead of `https`) in the URLs for the images or other binary files
    when they are rendered inline by Symfony *(as used by file-based field templates)*, as opposed to via ESI.

#### Update YML configuration

Secondly, you need to tell eZ Platform to use an HTTP-based purge client (specifically the FosHttpCache Varnish purge client),
and specify the URL Varnish can be reached on (in `ezplatform.yml`):

``` yaml
ezpublish:
    http_cache:
        purge_type: http

    system:
        # Assuming that my_siteaccess_group contains both your front-end and back-end SiteAccesses
        my_siteaccess_group:
            http_cache:
                # Fill in your Varnish server(s) address(es).
                purge_servers: [http://my.varnish.server:8081]
```

!!! enterprise

    ### Setting Time-To-Live value for Landing Page blocks

    Landing Page blocks are rendered using Edge Site Include which means you can set different TTL values for each Landing Page block type.
    The TTL setting is available in the configuration under a `ttl` key. The value has to be set in seconds:

    ``` yaml
    ez_systems_landing_page_field_type:
        blocks:
            block_type:
                ttl: 600
                views:
                    (...)
    ```

    `block_type` should be replaced with the actual block name, e.g. `embed`, `collection`, `schedule`, etc.
    In the example above `block_type` will be cached for 10 minutes.

    By default blocks are not cached (TTL = 0) for backwards compatibility reasons.

## Context-aware HTTP cache

As it is based on Symfony, eZ Platform uses HTTP cache extended with features like content awareness.
However, this cache management is only available for anonymous users due to HTTP restrictions.

It is possible to make HTTP cache vary thanks to the `Vary` response header,
but this header can only be based on one of the request headers (e.g. `Accept-Encoding`).
Thus, to make the cache vary on a specific context (for example a hash based on User Roles and Limitations),
this context must be present in the original request.

As the response can vary on a request header, the base solution is to make the kernel do a sub-request
in order to retrieve the user context hash (aka user hash).
Once the user hash has been retrieved, it's injected in the original request in the `X-User-Hash` custom header,
making it possible to *vary* the HTTP response on this header:

``` php
<?php
use Symfony\Component\HttpFoundation\Response;

// ...

// Inside a controller action
$response = new Response();
$response->setVary('X-User-Hash');
```

[FOSHttpCacheBundle's user context feature](http://foshttpcachebundle.readthedocs.org/en/latest/features/user-context.html) is activated by default.

Name of the [user hash header is configurable in FOSHttpCacheBundle](http://foshttpcachebundle.readthedocs.org/en/latest/reference/configuration/user-context.html). By default eZ Platform sets it to `**X-User-Hash**`.

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

    [Examples of user hash generation](https://github.com/ezsystems/ezplatform/tree/1.7/doc/varnish/vcl)

##### New anonymous `X-User-Hash`

The anonymous `X-User-Hash` is generated based on the `anonymous user`, `group` and `role`. The `38015b703d82206ebc01d17a39c727e5` hash that is provided in the link above will work only when these three variables are left unchanged. Once you change the default permissions and settings, the `X-User-Hash` will change and Varnish won't be able to effectively handle cache anymore.
In that case you need to find out the new anonymous `X-User-Hash` and change the VCL accordingly, else Varnish will return a no-cache header.

The easiest way to find the new hash is:

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
X-User-Hash: b1731d46b0e7a375a5b024e950fdb8d49dd25af85a5c7dd5116ad2a18cda82cb
Cache-Control: max-age=600, public
Vary: Cookie,Authorization
Content-Type: application/vnd.fos.user-context-hash
```

4\. Now, replace the existing `X-User-Hash` value with the new one:

```
# Note: This needs update every time anonymous user role assignments change.
set req.http.X-User-Hash = "b1731d46b0e7a375a5b024e950fdb8d49dd25af85a5c7dd5116ad2a18cda82cb";
```

5\. Restart the Varnish server.

##### New anonymous X-User-Hash based on `anonymous_user_id` setting

Since you can configure anonymous user per SiteAccess, you need to change the default `.vcl` template to be able to benefit from this functionality. This example assumes that your SiteAccesses are matched using `URIElement` matcher. You have to update `.vcl` configuration in case of other matchers like `Map\Host`.

!!! tip "Different anonymous user per SiteAccess"

    You can set different anonymous user per SiteAccess. You can find more information about this setting here: [anonymous_user_id](best_practices.md#anonymous_user_id)


``` yaml
# ezplatform.yml
    ezpublish:
        siteaccess:
            list: [site, eng, nor]
            match:
                URIElement: 1
        ...
        system:
            eng:
                anonymous_user_id: 15
            nor:
                anonymous_user_id: 16

```

You need to get the new X-User-Hash for every new anonymous user / anonymous users group. It is done in exactly the same way as described above ([User hash generation](http_cache.md#user-hash-generation)), but you have to remember to use SiteAccess URI element and an additional header which tells eZ Platform which URI it should take into account. For instance for `eng` SiteAccess:

  `curl -I -H "Accept: application/vnd.fos.user-context-hash" -H "x-fos-original-url: /eng/" http://<your-domain.com>/eng/_fos_user_context_hash`

  and for `nor` SiteAccess:

  `curl -I -H "Accept: application/vnd.fos.user-context-hash" -H "x-fos-original-url: /nor/" http://<your-domain.com>/nor/_fos_user_context_hash`

Let's assume, that the new X-User-Hashes are:
1. For `eng` SiteAccess: `baf9acf7ca78e370eac69f87f27e4ab8e674ced83750b4189e216cc05d2eb301`
2. For `nor` SiteAccess: `a33ba7050ec3b848b266ef187623417b88b9df4b90483b7ef6582aa54ee72ee7`

The next step is to update `ez_user_hash` sub-routine in the `.vcl` configuration as follow:
```
// Sub-routine to get client user hash, for context-aware HTTP cache.
sub ez_user_hash {

    // Prevent tampering attacks on the hash mechanism
    if (req.restarts == 0
        && (req.http.accept ~ "application/vnd.fos.user-context-hash"
            || req.http.x-user-hash
        )
    ) {
        return (synth(400));
    }

    if (req.restarts == 0 && (req.method == "GET" || req.method == "HEAD")) {
        // Get User (Context) hash, for varying cache by what user has access to.
        // https://doc.ez.no/display/EZP/Context+aware+HTTP+cache

        // Anonymous user w/o session => Use hardcoded anonymous hash to avoid backend lookup for hash
        if (req.http.Cookie !~ "eZSESSID" && !req.http.authorization) {
            // Request to eng siteaccess, so we should use other X-User-Hash for it
            if (req.url ~ "^/eng") {
                set req.http.X-User-Hash = "baf9acf7ca78e370eac69f87f27e4ab8e674ced83750b4189e216cc05d2eb301";
            }
            // Request to nor siteaccess, so we should use other X-User-Hash for it
            elseif (req.url ~ "^/nor") {
                set req.http.X-User-Hash = "a33ba7050ec3b848b266ef187623417b88b9df4b90483b7ef6582aa54ee72ee7";
            }
            else {
                // Note: You should then update it every time anonymous user rights change.
                set req.http.X-User-Hash = "38015b703d82206ebc01d17a39c727e5";
            }
        }
        // Pre-authenticate request to get shared cache, even when authenticated
        else {
            set req.http.x-fos-original-url    = req.url;
            set req.http.x-fos-original-accept = req.http.accept;
            set req.http.x-fos-original-cookie = req.http.cookie;
            // Clean up cookie for the hash request to only keep session cookie, as hash cache will vary on cookie.
            set req.http.cookie = ";" + req.http.cookie;
            set req.http.cookie = regsuball(req.http.cookie, "; +", ";");
            set req.http.cookie = regsuball(req.http.cookie, ";(eZSESSID[^=]*)=", "; \1=");
            set req.http.cookie = regsuball(req.http.cookie, ";[^ ][^;]*", "");
            set req.http.cookie = regsuball(req.http.cookie, "^[; ]+|[; ]+$", "");
            set req.http.accept = "application/vnd.fos.user-context-hash";
            set req.url = "/_fos_user_context_hash";

            // Force the lookup, the backend must tell how to cache/vary response containing the user hash
            return (hash);
        }
    }

    // Rebuild the original request which now has the hash.
    if (req.restarts > 0
        && req.http.accept == "application/vnd.fos.user-context-hash"
    ) {
        set req.url         = req.http.x-fos-original-url;
        set req.http.accept = req.http.x-fos-original-accept;
        set req.http.cookie = req.http.x-fos-original-cookie;
        unset req.http.x-fos-original-url;
        unset req.http.x-fos-original-accept;
        unset req.http.x-fos-original-cookie;

        // Force the lookup, the backend must tell not to cache or vary on the
        // user hash to properly separate cached data.

        return (hash);
    }
}
```

!!! tip "Upgrade your installation"
+
+    Consider upgrade to version 1.13 or newer because it doesn't require that much VCL changes to be able to benefit from `anonymous_user_id` setting while using Varnish.

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
            servers: [$http_cache.purge_servers$]

    user_context:
        enabled: true
        # User context hash is cached during 10min
        hash_cache_ttl: 600
        user_hash_header: X-User-Hash
```
