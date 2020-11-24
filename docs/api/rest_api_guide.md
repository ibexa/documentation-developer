# REST API Guide

The REST API v2 introduced in [[= product_name =]] allows you to interact with an [[= product_name =]] installation using the HTTP protocol, following a [REST](http://en.wikipedia.org/wiki/Representational_state_transfer) interaction model.

## REST API reference

See [REST API reference](https://doc.ezplatform.com/rest-api-reference) for detailed information about
REST API resources and endpoints.

!!! tip

    For more information see a [presentation about [[= product_name =]] APIs](https://alongosz.github.io/ezconf2018-api/).

## Accessing the REST API

The REST API is available at the URI `/api/ezp/v2` . HTTPS is available as long as your server is properly configured. Refer to the [Getting started with the REST API](#getting-started-with-the-rest-api) section below to start using the API.

## Basics

REST (REpresentational State Transfer) is a web services architecture that follows the HTTP Protocol very closely. The [[= product_name =]] REST API supports both [JSON](http://www.json.org/) and [XML](http://www.w3.org/XML/) in terms of format.

### Resources

The API provides a set of URIs, each of them identifying and providing access to operations on a certain resource. For instance, the URI `/content/objects/59` will allow you to interact with the Content item with ID 59, while `/content/types/1` will allow you to interact with the Content Type with ID 1.

### HTTP methods

It uses HTTP methods ( **`GET`** , **`POST`** , **`PUT`** , **`DELETE`** , etc.), as well as HTTP headers to specify the type of request. Depending on the used HTTP verb, different actions will be possible. Example:

|Action|Description|
|------|-----------|
|`GET  /content/objects/2`| Provides you with data about Content item \#2|
|`PATCH  /content/objects/2`| Updates the Content item \#2's metadata (section, main language, main location...)|
|`DELETE  /content/objects/2`| Deletes Content item \#2|
|`COPY  /content/objects/2`| Creates a copy of this Content|

!!! note "Caution with custom HTTP verbs"

    Using custom HTTP verbs, those besides the standard (GET, POST, PUT, DELETE, OPTIONS, TRACE), can cause issues with several HTTP proxies, network firewall/security solutions and simpler web servers. To avoid issues with this REST API allows you to set these using a HTTP header instead using HTTP verb POST. Example: `X-HTTP-Method-Override: PUBLISH`

### Media type headers

On top of methods, HTTP request headers will allow you to personalize the request's behavior. On every resource, you can use the Accept header to indicate which format you want to communicate in, JSON or XML. This header is also used to specify the response type you want the server to send when multiple ones are available.

-   `Accept: application/vnd.ez.api.Content+xml` to get **Content** (full data, fields included) as **XML**
-   `Accept: application/vnd.ez.api.ContentInfo+json` to get **ContentInfo** (metadata only) as **JSON**

!!! note "More information"

    [REST specifications chapter "Media Types"](https://github.com/ezsystems/ezpublish-kernel/blob/v8.0.0-beta5/doc/specifications/rest/REST-API-V2.rst#media-types)

### Other headers

Other headers will be used in HTTP requests for specifying: the siteaccess to interact with and [authentication credentials](general_rest_usage.md#rest-api-authentication).

Responses returned by the API will also use custom headers to indicate information about the executed operation.

## Getting started with the REST API

### Installation

No special preparations are necessary to use the REST API. As long as your [[= product_name =]] is correctly configured, the REST API is available on your site using the URI `/api/ezp/v2/`. If you have installed [[= product_name =]] in a subfolder, prepend the path with this subfolder: `http://example.com/sub/folder/ezpublish/api/ezp/v2/`.

!!! note

    Please note that the `/api/ezp/v2` prefix will be used in all REST hrefs, but not in URIs.

### Configuration

#### Authentication

As explained in more detail in the [authentication page](general_rest_usage.md#rest-api-authentication), two authentication methods are currently supported: session and basic. By default, session authentication is the active mode, it uses a session cookie. The alternative, basic auth authentication requires a login / password to be sent using basic HTTP authentication.

To enable basic auth based authentication, you need to edit `config/packages/security.yaml` and uncomment the configuration block about REST

**security.yaml**

```yaml
security:
    # ...
    firewalls:
        # ...
        ezpublish_rest:
            pattern: ^/api/ezp/v2
            ezpublish_http_basic:
                realm: eZ Platform REST API
```

### Testing the API

A standard web browser is not sufficient to fully test the API. You can, however, try opening the root resource with it, using the session authentication: `http://example.com/api/ezp/v2/`. Depending on how your browser understands XML, it will either download the XML file, or open it in the browser.

To test further, you can use browser extensions, like [Advanced REST client for Chrome](https://chrome.google.com/webstore/detail/advanced-rest-client/hgmloofddffdnphfgcellkdfbfbjeloo) or [RESTClient for Firefox](https://addons.mozilla.org/firefox/addon/restclient/), or dedicated tools. For command line users, [HTTPie](https://github.com/jkbr/httpie) is a good tool.

#### JavaScript example

One of the main reasons for this API is to help implement JavaScript / AJAX interaction. You can see here an example of an AJAX call that retrieves ContentInfo (e.g. metadata) for a Content item:

**REST API with JavaScript**

```javascript
<pre id="rest-output"></pre>
<script>
var resource = '/api/ezp/v2/content/objects/59',
    log = document.getElementById('rest-output'),
    request = new XMLHttpRequest();

log.innerHTML = "Loading the content info from " + resource + "...";

request.open('GET', resource, true);
request.onreadystatechange = function () {
    if ( request.readyState === 4 ) {
        log.innerHTML = "HTTP response from " + resource + "\n\n" + request.getAllResponseHeaders() + "\n" + request.responseText;
    }
};
request.setRequestHeader('Accept', 'application/vnd.ez.api.ContentInfo+json');
request.send();
</script>
```

In order to test it, just save this code to some test.html file in the web folder of your [[= product_name =]] installation. If you use the rewrite rules, don't forget to allow this file to be served directly.

If necessary, substitute `59` with the Content item ID of an item from your database. You will get the ContentInfo for item 59 in JSON encoding.

Note that by default, session authentication is used. This means that the session cookie will be transparently sent together with the request, and every AJAX call will have the same permissions as the currently logged in user.
