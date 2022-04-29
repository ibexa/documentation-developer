# REST API Guide


## REST API reference

See [REST API reference](rest_api_reference/rest_api_reference.html) for detailed information about
REST API resources and endpoints.

!!! tip

    For more information see a [presentation about [[= product_name =]] APIs](https://alongosz.github.io/ezconf2018-api/).

## Accessing the REST API

The REST API is available under the URI prefix `/api/ibexa/v2`. HTTPS is available as long as your server is properly configured. Refer to the [Getting started with the REST API](#getting-started-with-the-rest-api) section below to start using the API.

### Resources

The API provides a set of URIs, each of them identifying and providing access to operations on a certain resource. For instance, the URI `/content/objects/59` will allow you to interact with the Content item with ID 59, while `/content/types/1` will allow you to interact with the Content Type with ID 1.

### HTTP methods


### Media type headers

On top of methods, HTTP request headers will allow you to personalize the request's behavior. On every resource, you can use the Accept header to indicate which format you want to communicate in, JSON or XML. This header is also used to specify the response type you want the server to send when multiple ones are available.

-   `Accept: application/vnd.ibexa.api.Content+xml` to get **Content** (full data, fields included) as **[XML](http://www.w3.org/XML/)**
-   `Accept: application/vnd.ibexa.api.ContentInfo+json` to get **ContentInfo** (metadata only) as **[JSON](http://www.json.org/)**

!!! note "More information"

    For more information, see [Media Types](rest_api_best_practices.md#media-types).

### Other headers

Other headers will be used in HTTP requests for specifying: the siteaccess to interact with and [authentication credentials](general_rest_usage.md#rest-api-authentication).

Responses returned by the API will also use custom headers to indicate information about the executed operation.

## Getting started with the REST API

### Installation

No special preparations are necessary to use the REST API. As long as your [[= product_name =]] is correctly configured, the REST API is available on your site using the URI `/api/ibexa/v2/`. If you have installed [[= product_name =]] in a subfolder, prepend the path with this subfolder: `http://example.com/sub/folder/ezpublish/api/ibexa/v2/`.

!!! note

    Please note that the `/api/ibexa/v2` prefix will be used in all REST hrefs, but not in URIs.

### Configuration

#### Authentication

### Testing the API

A standard web browser is not sufficient to fully test the API. You can, however, try opening the root resource with it, using the session authentication: `http://example.com/api/ibexa/v2/`. Depending on how your browser understands XML, it will either download the XML file, or open it in the browser.

To test further, you can use browser extensions, like [Advanced REST client for Chrome](https://chrome.google.com/webstore/detail/advanced-rest-client/hgmloofddffdnphfgcellkdfbfbjeloo) or [RESTClient for Firefox](https://addons.mozilla.org/firefox/addon/restclient/), or dedicated tools. For command line users, [HTTPie](https://github.com/jkbr/httpie) is a good tool.

#### JavaScript example

One of the main reasons for this API is to help implement JavaScript / AJAX interaction. You can see here an example of an AJAX call that retrieves ContentInfo (e.g. metadata) for a Content item:

**REST API with JavaScript**

```javascript
var resource = '/api/ibexa/v2/content/objects/52',
    request = new XMLHttpRequest();

request.open('GET', resource, true);
request.setRequestHeader('Accept', 'application/vnd.ibexa.api.ContentInfo+json');
request.onload = function () {
    console.log(request.getAllResponseHeaders(), JSON.parse(request.responseText));
};
request.send();
```

In order to test it, just copy-paste this code into your browser console alongside a page from your website.

If necessary, substitute `52` with the Content ID of an item from your database.

TODO: Check if it works. Is `request.withCredentials = true;` needed?
Note that by default, session authentication is used. This means that if you use this example from a page on the same server, the session cookie will be transparently sent together with the request, and every AJAX call will have the same permissions as the currently logged in user.
