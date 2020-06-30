# HTTP cache

!!! note "Documentation reflects ezplatform-http-cache v1.0 and up"

    This page reflects how `ezplatform-http-cache` v1.0 works, bundled with eZ Platform v2.5.9 and up.
    To learn how `ezplatform-http-cache` v0.9 works, see [eZ Platform 1.13LTS HttpCache documentation](https://doc.ezplatform.com/en/1.13/guide/http_cache/).


## Overview

eZ Platform provides out of the box highly advanced caching features needed for its own content views, taking advantage
of sophisticated techniques to make Varnish and Fastly act as the view cache for the system. This and other features
allow eZ Platform to be scaled up to serve high traffic websites and applications, which also have busy publishing activity
by large editorial teams.

This is done via its own [ezplatform-http-cache](https://github.com/ezsystems/ezplatform-http-cache) bundle, which extends [friendsofsymfony/http-cache-bundle](https://foshttpcachebundle.readthedocs.io/en/1.3/),
a Symfony community bundle that in turn extends [Symfony HTTP cache](http://symfony.com/doc/3.4/http_cache.html).

For content view responses coming from eZ Platform itself, this means:
- Cache is **[content-aware](#content-aware-http-cache)**, always kept up-to-date by invalidating using cache tags.
- Cache is **[context-aware](#context-aware-http-cache)**, to cache request for logged in users by varying on user _rights_.

All of this works across all the supported Reverse Proxies:
- Symfony HttpCache Proxy - limited to a single server, and limited performance/features
- [Varnish](https://varnish-cache.org/)
- [Fastly](https://www.fastly.com/) - Varnish based CDN service

All above mentioned features can be easily taken advantage of in custom controllers as well.

## Configuration

### Content view configuration

This is how cache can be configured in `ezplatform.yml`, globally for content views:

``` yaml
ezpublish:
    system:
        my_siteaccess:
            content:
                view_cache: true      # Activates HTTP cache for content
                ttl_cache: true       # Activates expiration based HTTP cache for content (very fast)
                default_ttl: 7200     # Number of seconds an HTTP response cache is valid (if ttl_cache is true, and if no custom s-maxage is set)
```

You may want to set a high default Time-To-Live (TTL) (`default_ttl`) to have a high cache hit ratio on your installation.
As the system takes care of purges, the cache shouldn't become stale with exception of "grace" handing in Varnish and Fastly.

### Cache header rules

However, a few redirect and error pages are served via the ContentView system.
If you set a high `default_ttl`, they could also be served from cache, which should be avoided.

To avoid this, installation ships with configuration to match those specific pages and set a much lower TTL.
[FOSHttpCacheBundle matching rules](http://foshttpcachebundle.readthedocs.io/en/1.3/reference/configuration/headers.html) feature  allows to specify a different TTL:

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

Similarly, to apply performance tuning to avoid crawlers affecting the setup too much, we also set up caching of generic 404s and similar error pages in the following way:

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

### Setting Time-To-Live value for Page blocks

For Page Builder coming with eZ Platform Enterprise, Block cache by default respects `$content.ttl_cache$` and `$content.default_ttl$` settings.
However, if the given block value has a since / till date,
this will be taken into account for the TTL calculation for the block and also for the whole page.

To overload this behavior, listen to [BlockResponseEvents::BLOCK_RESPONSE](extending/extending_page/#block-render-response),
and set priority to, for instance, `-200` to adapt what Page Field type does by default. E.g. in order to disable cache
for the block use `$event->getResponse()->setPrivate()`.


### When to use ESI

ESI are in theory great for splitting out the different parts of a web page into separate concerns that can be freely reused as pieces by Reverse proxy.

However in practice ESI requests means every request needs to start over from scratch, and while you can tune your system to reduce this, there will always be some overhead to this.

You'll face this overhead when:
- Cache is cold on all or some of the sub requests
- With Symfony Proxy _(AppCache)_ even some overhead on warm cache (hits) on all sub requests
- In development environment

It may differ depending on your system, but in general, we recommend to stay below 5 ESI
request per page and only use them for parts that will be the same across whole site or larger parts of it.

You should preferably *not* use ESI for parts that are effectively uncached, as it will cause your reverse proxy to
have to wait for backend and not be able to deliver cached pages directly.

!!! note "ESI limitations with URIElement siteaccess matcher"

    Note that sharing ESIs across SiteAccesses when using URI matching is not possible by design, as URI will
    contain the siteaccess name encoded into it's path info. (see [EZP-22535](https://jira.ez.no/browse/EZP-22535) for details).

## Using Varnish or Fastly

As eZ Platform is built on top of Symfony, it uses standard HTTP cache headers.
By default, the Symfony reverse proxy, written in PHP, is used to handle cache. But it can be easily replaced with reverse proxies like Varnish or CDN like Fastly.

This is highly recommended as they provide far better performance and more advance features like grace handling, configurable logic via VCL and much more.

!!! note

    Use of Varnish or Fastly is a requirement for a [Clustering](clustering.md) setup.

### Recommended VCL base files

For setup to work properly with eZ, you'll need to adapt one of the provided VCL files as a basis:

- [Varnish 5+ VCL xkey example](https://github.com/ezsystems/ezplatform-http-cache/blob/1.0/docs/varnish/vcl/varnish5.vcl)
- Fastly VCL can be found in `vendor/ezsystems/ezplatform-http-cache-fastly/fastly` on eZ Platform Enterprise installs.

!!! tip

    As we extend [FOSHttpCacheBundle](https://foshttpcachebundle.readthedocs.io/en/1.3/), you can consider adapting your VCL further according to [FOSHttpCache documentation](http://foshttpcache.readthedocs.org/en/latest/varnish-configuration.html) in order to use features supported by it.

### Configure eZ Platform

Configuring eZ Platform for Varnish or Fastly involves a few steps, starting with configuring proxy.

#### Configuring Symfony Front Controller

In a pure Symfony install you would normally adapt Front Controller (`web/app.php`) [in order to configure Symfony to work behind a Load Balancer or a Reverse Proxy](https://symfony.com/doc/3.4/deployment/proxies.html),
however in eZ Platform you can cover most use cases by setting supported environment variables using:
- `SYMFONY_HTTP_CACHE`: To enable(`"1"`) or disable(`"0"`) use of Symfony HttpCache reverse proxy
    - *Must* be disabled when using Varnish or Fastly.
    - If not set, it is automatically disabled for Symfony ENV `dev` for local development needs.
- `SYMFONY_TRUSTED_PROXIES`:  String with trusted IP, several can be configured with a comma, i.e. `SYMFONY_TRUSTED_PROXIES="192.0.0.1,10.0.0.0/8"`

!!! caution "Careful when trusting dynamic IP using TRUST_REMOTE value or similar"

    On Platform.sh, Varnish does not have a static IP, like with [AWS LB](https://symfony.com/doc/3.4/deployment/proxies.html#but-what-if-the-ip-of-my-reverse-proxy-changes-constantly).
    For this `SYMFONY_TRUSTED_PROXIES` env variable supports being set to value "TRUST_REMOTE", which effectively means:
    ```php
    Request::setTrustedProxies([$request->server->get('REMOTE_ADDR')], Request::HEADER_X_FORWARDED_ALL);
    ```

    When trusting remote IP like this, make sure your application is not also accessible in other ways than through
    Varnish, as it could mean you end up trusting i.e. IP of client browser instead which would be a serious security issue!

    In other words, only do this if you are certain **all** traffic will always come from the trused proxy/load-balancer,
    and there is no other way to configure it.


_See [Examples for configuring eZ Platform](#Examples-for-configuring-eZ-Platform) for how these variables can be set._


#### Update YML configuration

Secondly, you need to tell eZ Platform to use an HTTP-based purge client (specifically the FosHttpCache Varnish purge client),
and specify the URL Varnish can be reached on (in `ezplatform.yml`):


| Configuration | Parameter      | Environment variable     | Possible values             |
| ------------- |:--------------:|:------------------------:|:---------------------------:|
| ezpublish.http_cache.purge_type | `purge_type` | `HTTPCACHE_PURGE_TYPE` | local, varnish/http, fastly |
| ezpublish.system.(scope).http_cache.purge_servers | `purge_server`* | `HTTPCACHE_PURGE_SERVER`* | Array of URLs to proxies when using Varnish or Fastly (`https://api.fastly.com`) |
| ezpublish.system.(scope).http_cache.varnish_invalidate_token | `varnish_invalidate_token` | `HTTPCACHE_VARNISH_INVALIDATE_TOKEN` | (Optional) For token based authentication. |
| ezpublish.system.(scope).http_cache.fastly.service_id | `fastly_service_id` | `FASTLY_SERVICE_ID` | Service ID for authenticate with Fastly |
| ezpublish.system.(scope).http_cache.fastly.key | `fastly_key` | `FASTLY_KEY` | Service key/token for authenticate with Fastly |

_\* If you need to set multiple purge servers configure them in the YAML configuration, instead of parameter or environment variable as they only take single string value._


Example for configuring varnish as reverse proxy, [assuming front controller has been configured](#Configuring-Symfony-Front-Controller):
``` yaml
ezpublish:
    http_cache:
        purge_type: varnish

    system:
        # Assuming that my_siteaccess_group contains both your front-end and back-end SiteAccesses
        my_siteaccess_group:
            http_cache:
                # Fill in your Varnish server(s) address(es).
                purge_servers: [http://my.varnish.server:8081]
```

!!! note "Invalidating Varnish cache using tokens"

    In setups where the Varnish server IP can change (for example on platform.sh/eZ Platform Cloud),
    you can use token-based cache invalidation via [ez_purge_acl](https://github.com/ezsystems/ezplatform-http-cache/blob/v1.0.0/docs/varnish/vcl/varnish5.vcl#L160).

    In such a case use a strong, secure hash and make sure to keep the token secret.


!!! enterprise "Using Fastly as HttpCache proxy"

    [Fastly](https://www.fastly.com/) delivers Varnish as a CDN service and is supported with eZ Platform Enterprise. See [Fastly documentation](https://docs.fastly.com/guides/basic-concepts/how-fastlys-cdn-service-works) to read how it works.

    ##### Configuring Fastly in YML

    ``` yaml
    ezpublish:
        http_cache:
            purge_type: fastly

        system:
            # Assuming that my_siteaccess_group contains both your front-end and back-end SiteAccesses
            my_siteaccess_group:
                http_cache:
                    purge_servers: [https://api.fastly.com]
                    fastly:
                        # See below for obtaining these values
                        service_id: "ID"
                        key: "token"
    ```

    ##### Configuring Fastly using Environment variables

    *Example when using `.env` file*:
    ```shell script
    SYMFONY_HTTP_CACHE="0"

    HTTPCACHE_PURGE_TYPE="fastly"
    HTTPCACHE_PURGE_SERVER="https://api.fastly.com"

    # See below for obtaining service ID and application key/token
    FASTLY_SERVICE_ID="ID"
    FASTLY_KEY="token"
    ```

    Tip: As of eZ Enterprise v1.13.6 and v2.5.10, you no longer need to set `HTTPCACHE_PURGE_SERVER` if you set `purge_type`
    via `HTTPCACHE_PURGE_TYPE`. If you set `purge_type` by any other means, you will still need to set `purge_server` too.

    ##### Configuration Fastly on Platform.sh

    If using Platform.sh, it's best to configure all Environment variables via [Platform.sh variables](https://docs.platform.sh/frameworks/ez/fastly.html).
    You'll also need to [disable Varnish](https://docs.platform.sh/frameworks/ez/fastly.html#remove-varnish-configuration) which is enabled by default in provided configuration for Platform.sh.

    ##### Obtaining Fastly service ID and API token

    The service ID can be obtained by logging in on http://fastly.com and clicking `CONFIGURE` in the top menu,
    then `Show service ID` at the top left of the page.

    See [this Fastly guide](https://docs.fastly.com/guides/account-management-and-security/using-api-tokens) for
    instructions on how to generate a Fastly API token.
    The token needs `purge_select` and `purge_all` scope.


#### Examples for configuring eZ Platform

There are several ways to configure HttpCache, examples on configuring it via YML can be found above.

For configuring the system completely by environment variables, here are some of the most common:

*Example when using `.env` file*:
```shell script
SYMFONY_HTTP_CACHE="0"
SYMFONY_TRUSTED_PROXIES="127.0.0.1"
HTTPCACHE_PURGE_TYPE="varnish"
HTTPCACHE_PURGE_SERVER="http://varnish:80"
```

*Example for Apache with `mod_env`*:
```apacheconfig
SetEnv SYMFONY_HTTP_CACHE 0
SetEnv SYMFONY_TRUSTED_PROXIES "127.0.0.1"
SetEnv HTTPCACHE_PURGE_TYPE varnish
SetEnv HTTPCACHE_PURGE_SERVER "http://varnish:80"
```

*Example for Nginx*:
```nginx
fastcgi_param SYMFONY_HTTP_CACHE 0;
fastcgi_param SYMFONY_TRUSTED_PROXIES "127.0.0.1";
fastcgi_param HTTPCACHE_PURGE_TYPE varnish;
fastcgi_param HTTPCACHE_PURGE_SERVER "http://varnish:80";
```

*Example for Platform.sh*:
You can configure environment variables via [Platform.sh variables](https://docs.platform.sh/frameworks/ez/fastly.html).

TIP: For Http Cache, you'll most likely *only* going to use this for configuring Fastly for production and optionally staging,
allowing _variables:env:_ in `.platform.app.yaml` to i.e. specify varnish or Symfony proxy as default for dev environment.

##### Example for Apache + Varnish

```apacheconfig
    # mysite_com.conf

    # Force front controller (web/app.php) NOT to use Symfony's built-in reverse proxy.
    SetEnv SYMFONY_HTTP_CACHE 0

    # Configure Varnish
    SetEnv HTTPCACHE_PURGE_TYPE varnish
    SetEnv HTTPCACHE_PURGE_SERVER "http://varnish:80"

    # Configure IP of your Varnish server to be trusted proxy
    # !! Replace IP with the real one used by Varnish
    SetEnv SYMFONY_TRUSTED_PROXIES "193.22.44.22"
```

##### Example for Nginx + Fastly

```nginx
# mysite_com.conf

# Force front controller (web/app.php) NOT to use Symfony's built-in reverse proxy.
fastcgi_param SYMFONY_HTTP_CACHE 0;

# Configure Fastly
fastcgi_param HTTPCACHE_PURGE_TYPE fastly;
fastcgi_param HTTPCACHE_PURGE_SERVER "https://api.fastly.com";

# See above for obtaining service ID and application key/token
fastcgi_param FASTLY_SERVICE_ID "ID"
fastcgi_param FASTLY_KEY "token"
```

### Understanding Stale Cache

Stale cache, or Grace mode in Varnish, is when cache continues to be served when expired _(by means of TTL or "Soft purge")_, or when backend server is not responding.

This has several benefits for high traffic installations to reduce load to backend. Instead of creating several
concurrent requests for the same page to the backend, the following happens when a page has been soft purged:
- Next request hitting the cache will trigger an asynchronous lookup to a backend
- If cache is still within grace period, first and subsequent requests for the content will be served from cache, not wait for the asynchronous lookup to finish
- The backend lookup finishes and refreshed the cache so any subsequent requests gets fresh cache

By default eZ Platform always "Soft Purges" content on reverse proxies that supports it (Varnish and Fastly), with
the following logic in our out of the box VCL:
- Cache is within grace
- Either server is not responding, or request comes without session cookie (anonymous user)

Reason for not always serving grace by default is:
1. Safe default _(even if just for anonymous , stale cache can easily confuse your team during acceptance testing)_
2. It would also mean REST API, which is used by Admin UI, would serve stales data, breaking the UI.


!!! tip "Customizing stale cache handling"

    If you want to use grace handling also for logged in users, you can adapt the provided VCL to add condition for
    opting out if request has cookie *and* path contains REST API prefix to make sure Admin UI is not negatively affected.

    If you want to disable grace mode, you can adapt the VCL to do hard instead of soft purges, or set grace/stale time to `0s`.


## Context-aware HTTP cache

eZ Platform allows caching request made by logged in users, this is what we refer to as (user) context aware cache.

What it means is that HttpCache is unique per user permissions (roles and limitations), meaning there are variations of
cache shared only among users that have the exact same permissions. So if a user is browsing a list of for instance children locations,
the user will only see children locations he/she has access to even if the rendering of this is served from HttpCache.

This is accomplished by varying on a header called `X-User-Hash`, which the system populates on the request for you.
The logic for this _([see below](#Request-life-cycle-explained))_ is accomplished in our provided VCL for Varnish and Fastly.
Note: A similar but internal logic is done in the provided enhanced Symfony Proxy _(AppCache)_.

Originally a eZ Publish 5.x feature, this was contributed to FOSHttpCache (1.x) and today eZ Platform builds upon that.

!!! tip "Prepare your custom controllers for v3"

    In 2.5LTS (FOSHTTPCache 1.x) the system varies on this hash for **all** responses, not just built in eZ controllers (Content View, Page, ...).

    However:
    1. This becomes configurable in v3 (FOSHTTPCache 2.x), and we consider to disable it by default for better cache efficiency
    2. The header name changes to FOSHttpCache default one: `X-User-Context-Hash`

    So in any custom controller you have that relies on eZ user permissions, i.e. rendering eZ content, best practice is to explicitly vary:
    ```php
        // Inside a controller action, should be adapted to `X-User-Context-Hash` when upgrading to v3
        $response->setVary('X-User-Hash');
    ```

#### Request life-cycle explained

To expand on steps covered in [FOSHttpCacheBundle documentation on how user context feature works](https://foshttpcachebundle.readthedocs.io/en/1.3/features/user-context.html#how-it-works):

1. A client _(browser)_ requests URI `/foo`.
2. The caching proxy receives the request and holds it. It first sends a hash request to the applications's context hash route: `/_fos_user_context_hash`.
3. The application receives the hash request. An event subscriber _(`UserContextSubscriber`)_ aborts the request immediately after the Symfony firewall was applied.
   The application calculates the hash _(`HashGenerator`)_ and then sends a response with the hash in a custom header _(`X-User-Hash` in eZ Platform)_.
4. The caching proxy receives the hash response, copies the hash header to the client’s original request for `/foo` and restarts the modified original request.
5. If the response to `/foo` should differ per user context, the application sets a `Vary: X-User-Hash` header, which will make Proxy store the variations of this cache varying on the hash value.


The next time a request comes in from the same user, application lookup for the hash (step 3) won't happen anymore as the
hash lookup itself is cached by the cache proxy itself.


##### User Context Hash caching explained

Example of response sent to reverse proxy from `/_fos_user_context_hash` with [eZ Platform's default config](#Default-options-for-FOSHttpCacheBundle-defined-in-eZ-Platform):
```
HTTP/1.1 200 OK
X-User-Hash: <hash>
Content-Type: application/vnd.fos.user-context-hash
Cache-Control: public, max-age=600
Vary: Cookie, Authorization
```

As you can see, response is set to be cached for 10minutes. It varies on the `Cookie` header in order to be able to cache
it for the given user. For cache efficiency reasons our default VCL strips any other cookie then session cookies to make
this work.

It also varies on `Authorization` to cover any possible basic auth headers in case that is used over sessions for some requests.

!!! note "In case you experience problems with stale user hash"

    In case you notice issues with stale hash usage, before you disable this cache make sure login/logout always
    generates new session IDs and performs a full redirect in order to make sure no requests are being made using stale
    user context hashes.

!!! warning "Known limitations of the user context hash"

    If you are using URI-based SiteAccesses matching on a multi-repo installation (multiple databases). The default
    SiteAccess on the domain needs to point to the same repository (database), because `/_fos_user_context_hash` is not
    SiteAccess-aware by default (see `ezpublish.default_router.non_siteaccess_aware_routes` parameter). This in turn is
    because reverse proxy does not have knowledge about SiteAccesses and it's not passing the whole URL in order to be
    able to cache the user context hash response.

    Only known workaround would be to make it siteaccess aware, and have custom VCL logic tied to your siteaccess
    matching with Varnish/Fastly, in order to send siteaccess prefix as URI.

##### Default options for FOSHttpCacheBundle defined in eZ Platform

The following configuration is defined in eZ Platform by default for FOSHttpCacheBundle.
Typically, you should not override these settings unless you know what you are doing.

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
        # User context hash lookup is cached for 10min, to avoid a extra lookup for every request
        hash_cache_ttl: 600
        user_hash_header: X-User-Hash
```


#### How to Personalize Responses

Here are some generic recommendations on how to approach personalized content with eZ Platform / Symfony:

**1. ESI + Vary by Cookie**
- As default VCL strips everything but session cookie this means this will effectively be cached "per user".
   - _TIP: If you are on single server setup with neither Varnish nor Fastly, you can do the same cookie logic on the Web server instead._
- Low effort, and can be good enough for 1 fragment that are reused across whole site, for instance in header to show user name.

Example:
```php
    // Inside a custom controller action, or even a Content View controller
    $response->setVary('Cookie');
```


**2. Ajax/JS lookup to “uncached” custom Symfony Controller(s)**
- Does not consume memory in Varnish.
- Can optionally be cached with custom logic: Symfony Cache on server side and/or with client side caching techniques.
- Should be done as ajax/JS lookup to avoid the uncached request slowing down the whole delivery of Vanish if it’s done as ESI.
- Somewhat more effort depending on project requirements _(traffic load, …)_.


**3. Custom vary by logic, i.e. “X-User-Preference-Hash” inspired by X-User-Hash**
- Allows for fine-grained caching as you can explicitly vary on this in only the places that needs it.
- More effort _(controller + VCL logic + adapt own code)_, see below for how.


!!! tip "Dealing with Paywall use cases"

    If you need to handle a paywall on a per item basis, then you'll need to go a bit further by for instance doing a
    lookup to backend for each and every url where this is relevant.

    FOSHTTPCache documentation has an [example for how Paywall Authorization can be done](https://foshttpcache.readthedocs.io/en/1.4/user-context.html#alternative-for-paywalls-authorization-request).

##### Dos and don'ts when making custom vary by logic

Refer to [FOSHttpCacheBundle documentation on how user context hashes are generated](https://foshttpcachebundle.readthedocs.io/en/1.3/features/user-context.html#generating-hashes).

eZ Platform implements a custom context provider in order to make user context hash reflect the current User's permissions
and Limitations, this is needed given eZ's more complex permission model compared to Symfony's.
You can technically extend the user context hash by [implementing your own custom context provider(s)](https://foshttpcachebundle.readthedocs.io/en/1.3/reference/configuration/user-context.html#custom-context-providers),
however **this is strongly discouraged** as it will mean you'll increase amount of cache variations stored in Proxy for
every single cache item, lowering cache hit ratio and increasing memory use.

Instead, it's recommended you create your own hash header for use cases where you need it, this way only controllers / views
that really very by your custom logic will vary on it.

There are several ways you can do this, all from completely custom VCL logic and dedicated controller to respond with hash
to trusted proxy lookups, however this would mean additional lookup.


##### Example for custom vary by logic

So a clean way would be to "extend" `/_fos_user_context_hash` lookup to add another HTTP header with custom hash for your
needs, and adapt the user context hash VCL logic to use the additional header.

To avoid overloading any application code, we'll take advantage of Symfony's event system to do this cleanly:

1. Add a Response [event listener or subscriber](https://symfony.com/doc/3.4/event_dispatcher.html) to add your own hash to `/_fos_user_context_hash`:

```php
    public function addPreferenceHash(FilterResponseEvent $event)
    {
        $response = $event->getResponse();
        if ($response->headers->get('Content-Type') !== 'application/vnd.fos.user-context-hash') {
            return;
        }

        $response->headers->set('X-User-Preference-Hash', '<your-hash>');
    }
```

2. Adapt VCL logic to pass the header to requests:

```diff
@@ -174,6 +174,7 @@ sub ez_user_context_hash {
     if (req.restarts == 0
         && (req.http.accept ~ "application/vnd.fos.user-context-hash"
             || req.http.x-user-hash
+            || req.http.x-user-preference-hash
         )
     ) {
         return (synth(400, "Bad Request"));
@@ -263,12 +264,19 @@ sub vcl_deliver {
         && resp.http.content-type ~ "application/vnd.fos.user-context-hash"
     ) {
         set req.http.x-user-hash = resp.http.x-user-hash;
+        set req.http.x-user-preference-hash = resp.http.x-user-preference-hash;

         return (restart);
     }

     // If we get here, this is a real response that gets sent to the client.

+    // Remove the vary on user preference hash, no need to expose this publicly.
+    if (resp.http.Vary ~ "X-User-Preference-Hash") {
+        set resp.http.Vary = regsub(resp.http.Vary, "(?i),? *X-User-Preference-Hash *", "");
+        set resp.http.Vary = regsub(resp.http.Vary, "^, *", "");
+    }
+
     // Remove the vary on user context hash, this is nothing public. Keep all
     // other vary headers.
     if (resp.http.Vary ~ "X-User-Hash") {
```

3. Add `Vary` in your custom controller or content view controller:

```php
    $response->setVary('X-User-Preference-Hash');

    // If you _also_ need to very on eZ permissions, instead use:
    //$response->setVary(['X-User-Hash', 'X-User-Preference-Hash']);
```

## Content-aware HTTP cache

HttpCache in eZ Platform is "aware" about which content or entity it is connected to, this awareness is accomplished
by means of "cache tagging". All supported reverse proxies are content-aware.

!!! note "Tag header is stripped in production for security reasons"

    For security reasons this header, and other internal cache headers, are stripped from output in production for security
    reasons, by the reverse proxy _(in VCL for Varnish and Fastly)_.

### Understanding Cache tags

Understanding tags is the key to making the most of `ezplatform-http-cache`:

- Tags form a secondary set of keys assigned to every cache item, on top of the "primary key" which is the URI
- Like an index in a database, a tag is typically used for anything relevant, that represents the given cache item
- Tags are used for cache invalidation

As a practical example, system will tag every article response, and when the article Content Type is updated,
it will tell Varnish that all articles should be considered stale and be updated in the background
when someone requests them.

**Current content tags** _(and when the system purges on them)_:

- Content: `c<content-id>` - Purged on all smaller or larger changes to Content _(including it's meta data, fields and locations).
- Content Type: `ct<content-type-id>` - Used when the Content Type changes, affecting Content of its type.
- Location: `l<location-id>` - Used for clearing all cache relevant for a given Location.
- Parent Location: `pl<[parent-]location-id>` - Used for clearing all children of a location (`pl<location-id>`), or all siblings (`pl<parent-location-id>`).
- Path: `p<location-id>` - For operations that change the tree itself, like move, remove, etc.
- Relation: `r<content-id>` - Only purged on when content updates are severe enough to also affect reverse relations.
- Relation location: `rl<location-id>` - Same as relation, but by location id.


!!! note "Automatically repository prefixing of cache tags"

    As eZ Platform support multi repository _(aka multi database)_ setups, who can have overlapping id's. it's shared
    http cache sytems needs to distinguesh tags relevant to the different content reposioties.

    This is why in multi repository setup you'll see cache tags such as `1p2`. Where `1` represents the index among
    configured repositories, meaning the second repository in the system.

    Tags are _not_ prefixed for default repository _(index "0")_.

#### Troubleshooting - Cache header too long errors

In case of complex Content, for instance Landing Pages with many blocks, or RichText with a lot of embeds/links, you
might get into trouble with too long cache header on responses. Because of this, necessary cache entries may not be
tagged properly. You may also see `502 Headers too long` errors, and webserver refusing to serve the page.

Here are some options on how to solve this issue:

**A. Configure to allow larger header:**

*Varnish* config:
- [http_resp_hdr_len](https://varnish-cache.org/docs/6.0/reference/varnishd.html#http-resp-hdr-len) (default 8k, change to i.e. 32k)
- [http_max_hdr](https://varnish-cache.org/docs/6.0/reference/varnishd.html#http-max-hdr) (default 64, change to i.e. 128)
- [http_resp_size](https://varnish-cache.org/docs/6.0/reference/varnishd.html#http-resp-size) (default 23k, change to i.e. 96k)
- [workspace_backend](https://varnish-cache.org/docs/6.0/reference/varnishd.html#workspace-backend) (default 64k, change to i.e. 128k)
- Also to see these headers in the `varnishlog`, adapt [vsl_reclen](https://varnish-cache.org/docs/6.0/reference/varnishd.html#vsl-reclen)

*Nginx* has a default limit of 4k/8k when buffering responses:
- For [PHP-FPM](https://www.php.net/manual/en/install.fpm.php) setup using proxy module, configure [proxy_buffer_size](https://nginx.org/en/docs/http/ngx_http_proxy_module.html#proxy_buffer_size)
- For FastCGI setup using fastcgi module, configure [fastcgi_buffer_size](https://nginx.org/en/docs/http/ngx_http_fastcgi_module.html#fastcgi_buffer_size)

*Fastly* has a `Surrogate-Key` header limit of *16kb*, this can *not* be changed.

*Apache* has a [hard](https://github.com/apache/httpd/blob/5f32ea94af5f1e7ea68d6fca58f0ac2478cc18c5/server/util_script.c#L495) [coded](https://github.com/apache/httpd/blob/7e2d26eac309b2d79e467ef586526c10e0f226f8/include/httpd.h#L299-L303) limit of 8kb, so if you face this issue consider using nginx instead.

**B. Limit tags header output by system:**

(1) For inline rendering just displaying the content name, image attribute, and/or link, then it would be enough to:
- Look into how many inline _(non ESI)_ render calls for content rendering you are doing, and see if you can organize it differently.
- Consider to inline views not uses other places in template and [tag response in Twig](#Response-tagging-in-Twig) with "relation" tags.
    - Optionally: Set reduced cache TTL for the given view in order to reduce risk of stale cache on subtree operations affecting the inlined content.

(2) If that is not an option, you can opt-in to set a max length parameter _(in bytes)_ and corresponding ttl _(in seconds)_
for cases when the limit is reached. The system will log a warning for cases where the limit is reached so you can optimize
these cases as described above when needed.
```yaml
parameters:
    # Warning, setting this means you risk losing tag information, risking stale cache. Here set below 8k:
    ezplatform.http_cache.tags.header_max_length: 7900
    # In order to reduce risk of stale cache issues, you should set a lower TTL here then globally (here set as 2h)
    ezplatform.http_cache.tags.header_reduced_ttl: 7200
```

### Response tagging done with Content View

For Content views response tagging is done for you, and cache system will output headers like the following:
```
HTTP/1.1 200 OK
Cache-Control: public, max-age=86400
xkey: ez-all c1 ct1 l2 pl1 p1 p2
```

If the given content have several locations you'll see several `l<location-id>` and `p<location-id>` tags in the response.

!!! note "How response tagging for ContentView is done internally"

    In `ezplatform-http-cache` there is a dedicated response listener `HttpCacheResponseSubscriber` that checks if:
    - Response has attribute `view`
    - View implements `eZ\Publish\Core\MVC\Symfony\View\CachableView`
    - Cache is not disabled on the individual view

    If that checks out, the Response will be adapted with the following:
    - `ResponseCacheConfigurator` will apply site access settings for enabled/disabled cache and default TTL
    - `DispatcherTagger` will dispatch the built in ResponseTaggers which will generate the tags as described above.

    Further reading can be found in ezplatform-http-cache's `docs/response_taggers.md`.

### Response tagging in Controllers

For tagging needs in controllers, there are several options, here presented in recommended order:

1. **Reusing DispatcherTagger to get it to pick correct tags for you**

_Examples for tagging everything needed for Content using autowirable `ResponseTagger` interface:_
``` php
/** @var \EzSystems\PlatformHttpCacheBundle\ResponseTagger\ResponseTagger $responseTagger */

// If you have a View object you can simply call:
$responseTagger->tag($view);

// Or if you have Content / Location object only, you can instead provide content info and location:
$responseTagger->tag($contentInfo);
$responseTagger->tag($location);
```

2. **Use ContentTagInterface API for content related tags**

_Examples for adding specific content tags using autowireable `ContentTagInterface`:_
``` php
/** @var \EzSystems\PlatformHttpCacheBundle\Handler\ContentTagInterface $tagHandler */

// Example for tagging everything needed for Content:
$tagHandler->addContentTags([$content->id]);
$tagHandler->addLocationTags([$location->id]);
$tagHandler->addParentLocationTags([$location->parentLocationId]);
$tagHandler->addPathTags($location->path);
$tagHandler->addContentTypeTags([$content->getContentType()->id]);

// Example when using ESI as also shown below using FOS tag handler (there is also a method for relation locations):
$tagHandler->addRelationTags([33, 44]);
```

3. **Manually add tags yourself using low level FOS TagHandler**

In PHP, FOSHttpCache exposes the `fos_http_cache.handler.tag_handler` service which enables you to add tags to a response.

_Example for tagging minimal tags for when id 33 and 34 will be rendered in ESI, but parent response needs these tags to get refresh if they are deleted:_
``` php
/** @var \FOS\HttpCache\Handler\TagHandler $tagHandler */
$tagHandler->addTags([ContentTagInterface::RELATION_PREFIX . '33', ContentTagInterface::RELATION_PREFIX . '44']);
```

See [Tagging from code](http://foshttpcachebundle.readthedocs.io/en/1.3/features/tagging.html#tagging-from-code) in FOSHttpCacheBundle doc.

!!! caution

    Be aware that the service name and type hint will change once we move to FOSHttpCache 2.x, so in this case
    you can alternatively consider adding a tag in Twig template or using `X-Location-Id` for the time being.

4. **Use deprecated `X-Location-Id` header**

For custom or eZ controllers _(e.g. REST)_ still using `X-Location-Id`, `XLocationIdResponseSubscriber` handles translating
this header to tags for you. It supports singular and comma separated location id value(s):

```php
/** @var \Symfony\Component\HttpFoundation\Response $response */
$response->headers->set('X-Location-Id', 123);

// Alternatively using several location id values
$response->headers->set('X-Location-Id', '123,212,42');
```

!!! caution "X-Location-Id use is deprecated"

    `X-Location-Id` is deprecated and will be removed in future version. For rendering content it is advised to refactor
    to use Content View, if not applicable `ContentTagInterface` or lastly manually output tags.


### Response tagging in Templates

1. `ez_http_tag_location()`

For full content tagging when inline rendering, the following can be used:
``` html+twig
{{ ez_http_tag_location(location) }}
```


2. `ez_http_tag_relation_ids()` or `ez_http_tag_relation_location_ids()`

When either wanting to reduce the amount of tags, or the inline content is rendered using ESI a minimum set of tags can be set:
``` html+twig
{{ ez_http_tag_relation_ids(content.id) }}

{# Or using array for several values #}
{{ ez_http_tag_relation_ids([field1.value.destinationContentId, field2.value.destinationContentId]) }}
```


3. `{{ fos_httpcache_tag(['r33', 'r44']) }}`

As a last resort you can also use function from FOS which lets you set low level tags directly:
``` html+twig
{{ fos_httpcache_tag('r33') }}

{# Or using array for several values #}
{{ fos_httpcache_tag(['r33', 'r44']) }}
```

See [Tagging from Twig Templates](http://foshttpcachebundle.readthedocs.io/en/1.3/features/tagging.html#tagging-from-twig-templates) in FOSHttpCacheBundle doc.


### Tag purging

#### How purge tagging is done by default

This bundle uses Repository API Slots to listen to Signals emitted on Repository operations, and depending on the
operation triggers expiry on a specific tag or set of tags.

For example on Move Location Signal the following tags will be purged:

```php
/**
 * @param \eZ\Publish\Core\SignalSlot\Signal\LocationService\MoveSubtreeSignal $signal
 */
protected function generateTags(Signal $signal)
{
    return [
        // The tree itself being moved (all children will have this tag)
        ContentTagInterface::PATH_PREFIX            . $signal->locationId,
        // old parent
        ContentTagInterface::LOCATION_PREFIX        . $signal->oldParentLocationId,
        // old siblings
        ContentTagInterface::PARENT_LOCATION_PREFIX . $signal->oldParentLocationId,
        // new parent
        ContentTagInterface::LOCATION_PREFIX        . $signal->newParentLocationId,
        // new siblings
        ContentTagInterface::PARENT_LOCATION_PREFIX . $signal->newParentLocationId,
    ];
}
```

All Slots can be found in `ezplatform-http-cache/src/SignalSlot`.

#### Custom purging from code

While the system purges tags whenever API is used to change data, there are times you might have the need to purge directly from code.
For that you can use the built in purge client:

```php
/** @var \EzSystems\PlatformHttpCacheBundle\PurgeClient\PurgeClientInterface $purgeClient */

// Example for purging by Location ID:
$purgeClient->purge([ContentTagInterface::LOCATION_PREFIX . $location->id]);

// Example for purging all cache for instance for full re-deploy cases , usually this will trigger a expiry (soft purge):
$purgeClient->purgeAll();
```

#### Purging from command line

Example for purging by location and by content id:
```bash
bin/console fos:httpcache:invalidate:tag l44 c33
```

Example for purging by all cache:
```bash
bin/console fos:httpcache:invalidate:tag ez-all
```

!!! tip "Purge is done on current repository"

    Just like when purging from code, tags you purge on will be prefixed for you to match the currently configured
    siteaccess. So make sure to specify siteaccess argument when using this command in combination with multi repository
    setup.
