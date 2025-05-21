---
description: You can use Symfony HttpCache Proxy, Varnish or Fastly as reverse proxies with Ibexa DXP.
month_change: false
---

# Reverse proxy

## Using Symfony reverse proxy

To use the Symfony reverse proxy, you must change your `public/index.php` front controller script and wrap `Ibexa\Bundle\HttpCache\AppCache` instead of `Symfony\Bundle\FrameworkBundle\HttpCache\HttpCache` around the kernel.

```diff
--- a/public/index.php
+++ b/public/index.php
@@ -1,9 +1,11 @@
 <?php

 use App\Kernel;
+use Ibexa\Bundle\HttpCache\AppCache;

 require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

 return function (array $context) {
-    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
+    return new AppCache(new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']));
 };
```

!!! caution

    Don't enable the Symfony reverse proxy in `public/index.php` if you intend to use Varnish or Fastly.
    You may only use one HTTP cache at a time.

## Using Varnish or Fastly

As [[= product_name =]] is built on top of Symfony, it uses standard HTTP cache headers.
By default, the Symfony reverse proxy is used to handle cache.
You can replace it with other reverse proxies, such as Varnish, or CDN like Fastly.

Using a different proxy is highly recommended as they provide better performance and more advanced features such as grace handling, configurable logic through VCL and much more.

!!! note

    Use of Varnish or Fastly is a requirement for a [clustering](clustering.md) setup, as Symfony Proxy doesn't support sharing cache between several application servers.

## VCL base files

For reverse proxies to work properly with your installation, you need to add the corresponding VCL files for your HTTP Cache.

- [Varnish VCL xkey example](https://github.com/ibexa/http-cache/blob/4.6/docs/varnish/vcl/varnish5.vcl)
- Fastly can be found in `vendor/ibexa/fastly/fastly`. You must install the following to use Fastly:
    - `ez_main.vcl` as the **main** custom VCL
    - `ez_user_hash.vcl` as another custom VCL
    - `snippet_re_enable_shielding.vcl` as snippet

The provided `.vcl` files work both with [Fastly Shielding](https://docs.fastly.com/en/guides/shielding) enabled and without it.
If you decide to use Fastly VCL, consider using [Fastly CLI](https://www.fastly.com/documentation/reference/tools/cli/#installing) with it to manage VCL files from the command line.
To learn more, see [Prepare to use Fastly locally](fastly.md#prepare-for-using-fastly-locally) and [Introduction to Fastly CLI](fastly.md#quick-introduction-to-fastly-cli).

!!! tip "Support for Fastly Shielding was added in [[= product_name =]] v3.3.24 and v4.1.6"

    When you extend [FOSHttpCacheBundle](https://foshttpcachebundle.readthedocs.io/en/latest/), you can also adapt your VCL further with [FOSHttpCache documentation](https://foshttpcache.readthedocs.io/en/latest/varnish-configuration.html) to use additional features.

## Configure Varnish and Fastly

The configuration of [[= product_name =]] for using Varnish or Fastly requires a few steps, starting with configuring proxy.

Failing to configure reverse proxies correctly may introduce several problems, including, but not limited to:

- [[= product_name =]] generating links with a wrong protocol schema (HTTP instead of HTTPS) if HTTPS termination is done before the web server due to the `X-Forward-Proto` headers being ignored
- [[= product_name =]] generating links with wrong port numbers due to the `X-Forward-Port` headers being ignored
- back office showing the login screen because JWT tokens aren't accepted due to the `X-Forward-For` headers being ignored

### Configure Symfony front controller

You need to consider your `TrustedProxy` configuration when you use Symfony [behind a load balancer or a reverse proxy]([[= symfony_doc =]]/deployment/proxies.html).

To configure trusted proxies, use [Symfony semantic configuration]([[= symfony_doc =]]/deployment/proxies.html#solution-settrustedproxies) under the `framework.trusted_proxies` [configuration key](configuration.md#configuration-files), for example:

``` yaml
framework:
    trusted_proxies: '192.0.0.1,10.0.0.0/8'
```

!!! caution "Careful when trusting dynamic IP that uses `REMOTE_ADDR` value or similar"

    On Platform.sh, Varnish doesn't have a static IP, like with [AWS LB]([[= symfony_doc =]]/deployment/proxies.html#but-what-if-the-ip-of-my-reverse-proxy-changes-constantly).
    For this reason, the `TRUSTED_PROXIES` env variable supports being set to value `REMOTE_ADDR`, which is equal to:

    ```php
    Request::setTrustedProxies([$request->server->get('REMOTE_ADDR')], Request::HEADER_X_FORWARDED_ALL);
    ```

    When trusting remote IP like this, make sure your application is only accessible through Varnish.
    If it's accessible in other ways, this may result in trusting, for example, the IP of client browser instead, which would be a serious security issue.

    Make sure that **all** traffic always comes from the trusted proxy/load balancer, and that there is no other way to configure it.

When using Fastly, you need to set `trusted_proxies` according to the [IP ranges used by Fastly](https://api.fastly.com/public-ip-list).

!!! tip

    You don't have to set `trusted_proxies` when using Fastly on Platform.sh.
    The Platform.sh router automatically changes the source IP of requests coming from Fastly, replacing the source IP with the actual client IP and removing any `X-FORWARD-...` header in the request before it reaches [[= product_name =]].

For more information about setting these variables, see [Configuration examples](#configuration-examples).

### Update YML configuration

Next, you need to tell [[= product_name =]] to use an HTTP-based purge client (specifically the FosHttpCache Varnish purge client), and specify the URL that Varnish can be reached on:

| Configuration | Parameter| Environment variable| Possible values|
|---------|--------|--------|----------|
| `ibexa.http_cache.purge_type` | `purge_type` | `HTTPCACHE_PURGE_TYPE` | local, varnish, fastly |
| `ibexa.system.<scope>.http_cache.purge_servers` | `purge_server` | `HTTPCACHE_PURGE_SERVER` | Array of URLs to proxies when using Varnish or Fastly (`https://api.fastly.com`). |
| `ibexa.system.<scope>.http_cache.varnish_invalidate_token` | `varnish_invalidate_token` | `HTTPCACHE_VARNISH_INVALIDATE_TOKEN` | (Optional) For token-based authentication. |
| `ibexa.system.<scope>.http_cache.fastly.service_id` | `fastly_service_id` | `FASTLY_SERVICE_ID` | Service ID to authenticate with Fastly. |
| `ibexa.system.<scope>.http_cache.fastly.key` | `fastly_key` | `FASTLY_KEY` | Service key/token to authenticate with Fastly. |

If you need to set multiple purge servers, configure them in the YAML configuration, instead of parameter or environment variable, as they only take single string value.

Example configuration for Varnish as reverse proxy, providing that [front controller has been configured](#configure-symfony-front-controller):

``` yaml
ibexa:
    http_cache:
        purge_type: varnish

    system:
        # Assuming that my_siteaccess_group contains both your front-end and back-end SiteAccesses
        my_siteaccess_group:
            http_cache:
                # Fill in your Varnish server(s) address(es).
                purge_servers: [http://my.varnish.server:8081]
```

#### Varnish and Basic Auth

If the Varnish server is protected by Basic Auth, specify the Basic Auth credentials within the `purge_servers` setting using the format:

``` yaml
            http_cache:
                purge_servers: [http://myuser:mypasswd@my.varnish.server:8081]
```

Varnish is enabled by default when using [[= product_name_cloud =]] and the `purge_servers` setting is set automatically. 
To enable Basic Auth on [[= product_name_cloud =]] when using Varnish, specify the credentials using the following environment variables to make sure that Varnish is reachable:

```
env:HTTPCACHE_USERNAME=myuser
env:HTTPCACHE_PASSWORD=mypasswd
```

If you want to use Basic Auth with Fastly on [[= product_name_cloud =]], please see [Enable basic-auth on Fastly](fastly.md#enable-basic-auth-on-fastly).

!!! note "Invalidating Varnish cache by using tokens"

    In setups where the Varnish server IP can change (for example, on [[= product_name_cloud =]]), you can use token-based cache invalidation through [`ez_purge_acl`](https://github.com/ibexa/http-cache/blob/4.6/docs/varnish/vcl/varnish5.vcl#L174).

    In such situation, use strong, secure hash and make sure to keep the token secret.

### Ensure proper Captcha behavior [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

If your installation uses Varnish and you want users to be able to configure and use Captcha in their forms, you must enable sending Captcha data as a response to an Ajax request.
Otherwise, Varnish doesn't allow for the transfer of Captcha data to the form, and as a result, users see an empty image.

To enable sending Captcha over Ajax, add the following configuration:

``` yaml
ibexa:
    system:
        default:
            form_builder:
                captcha:
                    use_ajax: true
```

### Update custom Captcha block [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

If you created a custom Captcha block for your site by overriding the default file (`vendor/gregwar/captcha-bundle/Resources/views/captcha.html.twig`), you must make the following changes to the custom block template file:

- change the name of the block to `ajax_captcha_widget`
- include the JavaScript file:

``` js
{{ encore_entry_script_tags('ibexa-form-builder-ajax-captcha-js', null, 'ibexa') }}
```

- add a data attribute with a `fieldId` value:

``` js
data-field-id="{{ field.id }}"
```

As a result, your file should be similar to the `vendor/ibexa/form-builder/src/bundle/Resources/views/themes/standard/fields/captcha.html.twig` file.

For more information about configuring Captcha fields, see [Captcha field](work_with_forms.md#captcha-field).

### Use Fastly as HttpCache proxy

[Fastly](https://www.fastly.com/) delivers Varnish as a CDN service and is supported with [[= product_name =]].
To learn how it works, see [Fastly documentation](https://docs.fastly.com/en/guides/using-fastlys-global-pop-network).

#### Configure Fastly in YML

``` yaml
ibexa:
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

#### Configure Fastly using environment variables

See the example below to configure Fastly with the `.env` file:

```
HTTPCACHE_PURGE_TYPE="fastly"
# Optional
HTTPCACHE_PURGE_SERVER="https://api.fastly.com"

# See below for obtaining service ID and application key/token
FASTLY_SERVICE_ID="ID"
FASTLY_KEY="token"
```

#### Configure Fastly on Platform.sh

If you use Platform.sh, it's recommended to configure all environment variables through [Platform.sh variables](https://docs.platform.sh/guides/ibexa/fastly.html).
In [[= product_name =]], Varnish is enabled by default. To use Fastly, first you must [disable Varnish](https://docs.platform.sh/guides/ibexa/fastly.html#remove-varnish-configuration).

#### Get Fastly service ID and API token

To get the service ID, log in to https://www.fastly.com/.
In the upper menu, click the **CONFIGURE** tab.
The service ID is displayed next to the name of your service on any page.

For instructions on how to generate a Fastly API token, see [the Fastly guide](https://docs.fastly.com/en/guides/using-api-tokens).
The API token needs the `purge_all` an `purge_select` scopes.

### Configuration examples

See below the most common configuration examples for the system, using environment variables.

Example for Varnish with the `.env` file:

``` bash
HTTPCACHE_PURGE_TYPE="varnish"
HTTPCACHE_PURGE_SERVER="http://varnish:80"
```

Example for Apache with `mod_env`:

```apacheconfig
SetEnv HTTPCACHE_PURGE_TYPE varnish
SetEnv HTTPCACHE_PURGE_SERVER "http://varnish:80"
```

Example for Nginx:

```nginx
fastcgi_param HTTPCACHE_PURGE_TYPE varnish;
fastcgi_param HTTPCACHE_PURGE_SERVER "http://varnish:80";
```

Example for Platform.sh:

You can configure environment variables through [Platform.sh variables](https://docs.platform.sh/guides/ibexa/fastly.html).

!!! tip

    For HTTP cache, you most likely only use this for configuring Fastly for production and optionally staging, allowing `variables:env:` in `.platform.app.yaml` to, for example, specify Varnish or Symfony proxy as default for dev environment.

#### Apache with Varnish

```apacheconfig
# mysite_com.conf

# Configure Varnish
SetEnv HTTPCACHE_PURGE_TYPE varnish
SetEnv HTTPCACHE_PURGE_SERVER "http://varnish:80"

# Configure IP of your Varnish server to be trusted proxy
# !! Replace IP with the real one used by Varnish
SetEnv TRUSTED_PROXIES "193.22.44.22"
```

#### Nginx with Fastly

```nginx
# mysite_com.conf

# Configure Fastly
fastcgi_param HTTPCACHE_PURGE_TYPE fastly;
fastcgi_param HTTPCACHE_PURGE_SERVER "https://api.fastly.com";

# See above for obtaining service ID and application key/token
fastcgi_param FASTLY_SERVICE_ID "ID"
fastcgi_param FASTLY_KEY "token"
```

## Stale cache

Stale cache, or grace mode in Varnish, occurs when:

- Cache is served some time after the TTL expired.
- When the back-end server doesn't respond.

This has several benefits for high traffic installations to reduce load to the back end.
Instead of creating several concurrent requests for the same page to the back end, the following happens when a page has been soft purged:

- Next request hitting the cache triggers an asynchronous lookup to the back end.
- If cache is still within grace period, first and subsequent requests for the content are served from cache, and don't wait for the asynchronous lookup to finish.
- The back-end lookup finishes and refreshes the cache so any subsequent requests get a fresh cache.

By default, [[= product_name =]] always soft purges content on reverse proxies that support it (Varnish and Fastly), with the following logic in the out-of-the-box VCL:

- Cache is within grace period.
- Either the server isn't responding, or the request comes without a session cookie (anonymous user).

Serving grace isn't always allowed by default because:

- It's a safe default. Even if for anonymous users, stale cache can be confusing during acceptance testing.
- It means REST API, which is used by the back office, would serve stale data, breaking the UI.

!!! tip "Customizing stale cache handling"

    If you want to use grace handling for logged-in users as well, you can adapt the provided VCL to add a condition for opting out if the request has a cookie and the path contains REST API prefix to make sure the back office isn't negatively affected.

    If you want to disable grace mode, you can adapt the VCL to do hard instead of soft purges, or set grace/stale time to `0s`.
