# Reverse proxy

Before you start using Symfony reverse proxy, you must change your kernel to use `EzSystems\PlatformHttpCacheBundle\AppCache` instead of `Symfony\Bundle\FrameworkBundle\HttpCache\HttpCache`.

Next, to use Symfony reverse proxy, follow the [Symfony documentation](https://symfony.com/doc/current/http_cache.html#symfony-reverse-proxy).

## Use Varnish or Fastly

As [[= product_name =]] is built on top of Symfony, it uses standard HTTP cache headers.
By default, the Symfony reverse proxy is used to handle cache.
You can replace it with other reverse proxies, such as Varnish, or CDN like Fastly.

Using a different proxy is highly recommended as they provide better performance and more advanced features such as grace handling, configurable logic through VCL and much more.

!!! note

    Use of Varnish or Fastly is a requirement for a [Clustering](../clustering.md) setup, as Symfony Proxy does not support sharing cache between several application servers.

## Recommended VCL base files

For reverse proxies to work properly with your installation, you need to adapt one of the provided VCL files as the basis:

- [Varnish VCL xkey example](https://github.com/ezsystems/ezplatform-http-cache/blob/2.0/docs/varnish/vcl/varnish5.vcl)
- Fastly VCL can be found in `vendor/ezsystems/ezplatform-http-cache-fastly/fastly`

!!! tip

    When you extend [FOSHttpCacheBundle](https://foshttpcachebundle.readthedocs.io/en/2.9.1/),
    you can also adapt your VCL further with [FOSHttpCache documentation](http://foshttpcache.readthedocs.org/en/latest/varnish-configuration.html)
    to use additional features.

## Configure Varnish and Fastly

The configuration of [[= product_name =]] for using Varnish or Fastly requires a few steps, starting with configuring proxy.

### Configure Symfony front controller

Before you configure Symfony to [work behind a load balancer or a reverse proxy](https://symfony.com/doc/5.1/deployment/proxies.html),
make sure that [Symfony reverse proxy](#symfony-reverse-proxy) is enabled.

Set the following environment variable:
- `TRUSTED_PROXIES`: String with trusted IP, multiple proxies can be configured with a comma, for example, `TRUSTED_PROXIES="192.0.0.1,10.0.0.0/8"`

Add the trusted proxies to your configuration file:

``` yaml
framework:
    trusted_proxies: '%env(TRUSTED_PROXIES)%'
```

!!! caution "Careful when trusting dynamic IP using `REMOTE_ADDR` value or similar"

    On Platform.sh, Varnish does not have a static IP, like with [AWS LB](https://symfony.com/doc/5.1/deployment/proxies.html#but-what-if-the-ip-of-my-reverse-proxy-changes-constantly).
    For this reason, the `TRUSTED_PROXIES` env variable supports being set to value `REMOTE_ADDR`, which is equal to:
  
    ```php
    Request::setTrustedProxies([$request->server->get('REMOTE_ADDR')], Request::HEADER_X_FORWARDED_ALL);
    ```

    When trusting remote IP like this, make sure your application is only accessible through Varnish. 
    If it is accessible in other ways, this may result in trusting, for example, the IP of client browser instead, which would be a serious security issue.

    Make sure that **all** traffic always comes from the trusted proxy/load balancer,
    and that there is no other way to configure it.

For more information about setting these variables, see [Examples for configuring [[= product_name =]]](#examples-for-configuring-ibexa-dxp).

### Update YML configuration

Next, you need to tell [[= product_name =]] to use an HTTP-based purge client (specifically the FosHttpCache Varnish purge client),
and specify the URL that Varnish can be reached on (in `config/packages/ezplatform.yaml`):

| Configuration | Parameter| Environment variable| Possible values|
|---------|--------|--------|----------|
| `ezplatform.http_cache.purge_type` | `purge_type` | `HTTPCACHE_PURGE_TYPE` | local, varnish, fastly |
| `ezplatform.system.<scope>.http_cache.purge_servers` | `purge_server` | `HTTPCACHE_PURGE_SERVER` | Array of URLs to proxies when using Varnish or Fastly (`https://api.fastly.com`). |
| `ezplatform.system.<scope>.http_cache.varnish_invalidate_token` | `varnish_invalidate_token` | `HTTPCACHE_VARNISH_INVALIDATE_TOKEN` | (Optional) For token-based authentication. |
| `ezplatform.system.<scope>.http_cache.fastly.service_id` | `fastly_service_id` | `FASTLY_SERVICE_ID` | Service ID to authenticate with Fastly. |
| `ezplatform.system.<scope>.http_cache.fastly.key` | `fastly_key` | `FASTLY_KEY` | Service key/token to authenticate with Fastly. |

If you need to set multiple purge servers, configure them in the YAML configuration, 
instead of parameter or environment variable, as they only take single string value.

Example configuration for Varnish as reverse proxy, providing that [front controller has been configured](#configure-symfony-front-controller):

``` yaml
ezplatform:
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

    In setups where the Varnish server IP can change (for example, on Ibexa Cloud),
    you can use token-based cache invalidation through [`ez_purge_acl`](https://github.com/ezsystems/ezplatform-http-cache/blob/v2.1.0/docs/varnish/vcl/varnish5.vcl#L174).
 
    In such situation, use strong, secure hash and make sure to keep the token secret.

### Ensure proper Captcha behavior [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

If your installation uses Varnish and you want users to be able to configure and use Captcha in their forms, 
you must enable sending Captcha data as a response to an Ajax request. 
Otherwise, Varnish does not allow for the transfer of Captcha data to the form, and as a result, users see an empty image.

To enable sending Captcha over Ajax, add the following configuration to `config/packages/ezplatform.yaml`:

``` yaml
ezplatform:
    system:
        default:
            form_builder:
                captcha:
                    use_ajax: true
```

### Custom Captcha block [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

If you created a custom Captcha block for your site by overriding the default file (`vendor/gregwar/captcha-bundle/Resources/views/captcha.html.twig`),
you must make the following changes to the custom block template file:

- change the name of the block to `ajax_captcha_widget`
- include the JavaScript file:

``` js
{{ encore_entry_script_tags('ezplatform-form-builder-ajax-captcha-js', null, 'ezplatform') }}
```

- add a data attribute with a `fieldId` value:

``` js
data-field-id="{{ field.id }}"
```

As a result, your file should be similar to [this example.](https://github.com/ezsystems/ezplatform-form-builder/blob/master/src/bundle/Resources/views/themes/standard/fields/captcha.html.twig)

For more information about configuring Captcha fields, see [Captcha field](../../extending/extending_form_builder.md#captcha-field).

### Use Fastly as HttpCache proxy

[Fastly](https://www.fastly.com/) delivers Varnish as a CDN service and is supported with [[= product_name =]].
To learn how it works, see [Fastly documentation](https://docs.fastly.com/guides/basic-concepts/how-fastlys-cdn-service-works).

#### Configure Fastly in YML

``` yaml
ezplatform:
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

If you use Platform.sh, it is recommended to configure all environment variables through [Platform.sh variables](https://docs.platform.sh/frameworks/ibexa/fastly.html).
In [[= product_name =]], Varnish is enabled by default. To use Fastly, first you must 
[disable Varnish](https://docs.platform.sh/frameworks/ibexa/fastly.html#remove-varnish-configuration) 

#### Get Fastly service ID and API token

To get the service ID, log in to http://fastly.com. In the upper menu, click the **CONFIGURE** tab.
The service ID is displayed next to the name of your service on any page.

For instructions on how to generate a Fastly API token, see [the Fastly guide](https://docs.fastly.com/guides/account-management-and-security/using-api-tokens).
The API token needs the `purge_all` an `purge_select` scopes.

### Examples for configuring [[= product_name =]]

See below the most common configuration examples for the system, using environment variables.

Example for Varnish with the `.env` file:

``` bash
TRUSTED_PROXIES="127.0.0.1"
HTTPCACHE_PURGE_TYPE="varnish"
HTTPCACHE_PURGE_SERVER="http://varnish:80"
```

Example for Apache with `mod_env`:

```apacheconfig
SetEnv TRUSTED_PROXIES "127.0.0.1"
SetEnv HTTPCACHE_PURGE_TYPE varnish
SetEnv HTTPCACHE_PURGE_SERVER "http://varnish:80"
```

Example for Nginx:

```nginx
fastcgi_param TRUSTED_PROXIES "127.0.0.1";
fastcgi_param HTTPCACHE_PURGE_TYPE varnish;
fastcgi_param HTTPCACHE_PURGE_SERVER "http://varnish:80";
```

Example for Platform.sh:

You can configure environment variables through [Platform.sh variables](https://docs.platform.sh/frameworks/ibexa/fastly.html).

!!! tip

    For HTTP cache, you will most likely only use this for configuring Fastly for production and optionally staging,
    allowing `variables:env:` in `.platform.app.yaml` to, for example, specify Varnish or Symfony proxy as default for dev environment.

#### Example for Apache with Varnish

```apacheconfig
# mysite_com.conf

# Configure Varnish
SetEnv HTTPCACHE_PURGE_TYPE varnish
SetEnv HTTPCACHE_PURGE_SERVER "http://varnish:80"

# Configure IP of your Varnish server to be trusted proxy
# !! Replace IP with the real one used by Varnish
SetEnv TRUSTED_PROXIES "193.22.44.22"
```

#### Example for Nginx with Fastly

```nginx
# mysite_com.conf

# Configure Fastly
fastcgi_param HTTPCACHE_PURGE_TYPE fastly;
fastcgi_param HTTPCACHE_PURGE_SERVER "https://api.fastly.com";

# See above for obtaining service ID and application key/token
fastcgi_param FASTLY_SERVICE_ID "ID"
fastcgi_param FASTLY_KEY "token"
```

## Understand stale cache

Stale cache, or grace mode in Varnish, occurs when:
- Cache is served some time after the TTL expired.
- When the back-end server does not respond.

This has several benefits for high traffic installations to reduce load to the back end. 
Instead of creating several concurrent requests for the same page to the back end, 
the following happens when a page has been soft purged:

- Next request hitting the cache triggers an asynchronous lookup to the back end.
- If cache is still within grace period, first and subsequent requests for the content are served from cache,
and do not wait for the asynchronous lookup to finish.
- The back-end lookup finishes and refreshes the cache so any subsequent requests get a fresh cache.

By default, [[= product_name =]] always soft purges content on reverse proxies that support it (Varnish and Fastly),
with the following logic in the out-of-the-box VCL:

- Cache is within grace period.
- Either the server is not responding, or the request comes without a session cookie (anonymous user).

Serving grace is not always allowed by default because:

- It is a safe default. Even if just for anonymous users, stale cache can easily be confusing during acceptance testing.
- It means REST API, which is used by the Back Office, would serve stale data, breaking the UI.

!!! tip "Customizing stale cache handling"

    If you want to use grace handling for logged-in users as well, you can adapt the provided VCL to add a condition
    for opting out if the request has a cookie and the path contains REST API prefix to make sure the Back Office is not negatively affected.

    If you want to disable grace mode, you can adapt the VCL to do hard instead of soft purges, or set grace/stale time to `0s`.
