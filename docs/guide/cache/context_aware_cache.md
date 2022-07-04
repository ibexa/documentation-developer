---
description: Context-aware HTTP cache caches requests depending on the logged-in user context.
---

# Context-aware HTTP cache

[[= product_name =]] allows caching requests made by logged-in users.
This is called (user) context-aware cache.

It means that HTTP cache is unique per set of user permissions (Roles and Limitations), 
and there are variations of cache shared only among users that have the exact same permissions. 
So if a user browses a list of children Locations, they will only see children Locations 
they have access to, even if their rendering is served from HTTP cache.

This is accomplished by varying on a header called `X-Context-User-Hash`, which the system populates on the request.
The [logic for this](#request-lifecycle) is accomplished in the provided VCL for Varnish and Fastly.
A similar but internal logic is done in the provided enhanced Symfony Proxy (AppCache).

## Request lifecycle

This expands steps covered in [FOSHttpCacheBundle documentation on user context feature](https://foshttpcachebundle.readthedocs.io/en/2.8.0/features/user-context.html#how-it-works):

1. A client (browser) requests URI `/foo`.
1. The caching proxy receives the request and holds it. It first sends a hash request to the application's context hash route: `/_fos_user_context_hash`.
1. The application receives the hash request. An event subscriber (`UserContextSubscriber`) aborts the request immediately after the Symfony firewall is applied.
   The application calculates the hash (`HashGenerator`) and then sends a response with the hash in a custom header (`X-Context-User-Hash`).
1. The caching proxy receives the hash response, copies the hash header to the client's original request for `/foo` and restarts the modified original request.
1. If the response to `/foo` should differ per user context, the application sets a `Vary: X-Context-User-Hash` header, which will make Proxy store the variations of this cache varying on the hash value.

The next time a request comes in from the same user, application lookup for the hash (step 3) does not take place,
as the hash lookup itself is cached by the cache proxy as described below.

### User context hash caching

Example of a response sent to reverse proxy from `/_fos_user_context_hash` with [[[= product_name =]]'s default config](#default-options-for-FOSHttpCacheBundle-defined-in-ibexa-dxp):

```
HTTP/1.1 200 OK
X-Context-User-Hash: <hash>
Content-Type: application/vnd.fos.user-context-hash
Cache-Control: public, max-age=600
Vary: Cookie, Authorization
```

In the example above the response is set to be cached for 10 minutes.
It varies on the `Cookie` header in order to be able to cache it for the given user.
To optimize it, the default VCL strips any cookie other than session cookies to make this work.

It also varies on `Authorization` to cover any possible basic authorization headers in case that is used over sessions for some requests.

!!! note "Problems with stale user hash"

    If you notice issues with stale hash usage, before you disable this cache, make sure login or logout always 
    generates new session IDs and performs a full redirect to make sure no requests are being made using stale 
    user context hashes.

!!! caution "Limitations of the user context hash"

    If you use URI-based SiteAccess matching on a multi-repository installation (multiple databases), 
    the default SiteAccess on the domain needs to point to the same repository (database), 
    because `/_fos_user_context_hash` is not SiteAccess-aware by default (see 
    `ibexa.rest.default_router.non_siteaccess_aware_routes` parameter).
    This occurs because reverse proxy does not have knowledge about SiteAccesses 
    and it does not pass the whole URL to be able to cache the user context hash response.

    The only known workaround is to make it SiteAccess aware, and have custom VCL logic tied to your SiteAccess
    matching with Varnish/Fastly, to send the SiteAccess prefix as URI.

!!! caution "Default options for FOSHttpCacheBundle"

    The following configuration is defined by default for FOSHttpCacheBundle.
    You should not override these settings unless you know what you are doing.

    ``` yaml
    fos_http_cache:
        proxy_client:
            default: varnish
            varnish:
                http:
                    servers: ['$http_cache.purge_servers$']
                tag_mode: 'purgekeys'

        user_context:
            enabled: true
            hash_cache_ttl: 600
            # NOTE: These are also defined/used in AppCache, in Varnish VCL, and Fastly VCL
            session_name_prefix: eZSESSID
    ```

## Personalize responses

Here are some generic recommendations on how to approach personalized content with [[= product_name =]] / Symfony:

1\. ESI with vary by cookie:

Default VCL strips everything except session cookie, so this is effectively "per user".
If you are on single-server setup without Varnish or Fastly, you can use the same cookie logic on the web server instead.

This a low effort solution, and can be enough for one fragment that is reused across the whole site, 
for example, in header to show user name:

Example:

```php
    // Inside a custom controller action, or even a Content View controller
    $response->setVary('Cookie');
```

2\. Ajax/JS lookup to "uncached" custom Symfony controllers:

This method does not consume memory in Varnish. 
It can optionally be cached with custom logic: Symfony Cache on server side and/or with client side caching techniques. 
This should be done as Ajax/JS lookup to avoid the uncached request that slows down the whole delivery of Vanish if it is done as ESI.

This solution requires more effort depending on project requirements (traffic load, etc.).

3\. Custom vary by logic, for example, `X-User-Preference-Hash` inspired by `X-Context-User-Hash`:

This method allows for fine-grained caching as you can explicitly vary on this in only the places that need it.

This solution requires more effort (controller, VCL logic and adapting your own code), see the examples below.

!!! tip "Dealing with paywall use cases"

    If you need to handle a paywall on a per-item basis, or example, do a
    lookup to backend for each URL where this is relevant.

    You can find an example for paywall authorization in [FOSHTTPCache documentation.](https://foshttpcache.readthedocs.io/en/latest/user-context.html#alternative-for-paywalls-authorization-request)

### Best practices for custom vary by logic

For information on how user context hashes are generated, see [FOSHttpCacheBundle documentation](https://foshttpcachebundle.readthedocs.io/en/2.8.0/features/user-context.html#generating-hashes).

[[= product_name =]] implements a custom context provider in order to make user context hash reflect the current User's Roles and Limitations.
This is needed given [[= product_name =]]'s more complex permission model compared to Symfony's.

You can technically extend the user context hash by [implementing your own custom context provider(s)](https://foshttpcachebundle.readthedocs.io/en/latest/reference/configuration/user-context.html#custom-context-providers).
However, **this is strongly discouraged** as it means increasing the amount of cache variations
stored in proxy for every single cache item, lowering cache hit ratio and increasing memory use.

Instead, you can create your own hash header for use cases where you need it. 
This way only controllers and views that really vary by your custom logic will vary on it.

You can do it using several methods, ranging from completely custom VCL logic and dedicated controller to respond with hash 
to trusted proxy lookups, but this means additional lookups.

### Example for custom vary by logic

You can extend `/_fos_user_context_hash` lookup to add another HTTP header with custom hash for your
needs, and adapt the user context hash VCL logic to use the additional header.

To avoid overloading any application code, take advantage of Symfony's event system:

1\. Add a Response [event listener or subscriber](https://symfony.com/doc/5.1/event_dispatcher.html) to add your own hash to `/_fos_user_context_hash`:

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

2\. Adapt VCL logic to pass the header to requests:

```diff
@@ -174,6 +174,7 @@ sub ez_user_context_hash {
     if (req.restarts == 0
         && (req.http.accept ~ "application/vnd.fos.user-context-hash"
             || req.http.X-Context-User-Hash
+            || req.http.x-user-preference-hash
         )
     ) {
         return (synth(400, "Bad Request"));
@@ -263,12 +264,19 @@ sub vcl_deliver {
         && resp.http.content-type ~ "application/vnd.fos.user-context-hash"
     ) {
         set req.http.X-Context-User-Hash = resp.http.X-Context-User-Hash;
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
     if (resp.http.Vary ~ "X-Context-User-Hash") {
```

3\. Add `Vary` in your custom controller or content view controller:

```php
$response->setVary('X-User-Preference-Hash');

// If you _also_ need to vary on eZ permissions, instead use:
//$response->setVary(['X-Context-User-Hash', 'X-User-Preference-Hash']);
```
