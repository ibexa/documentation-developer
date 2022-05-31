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

!!! note "More information"

    For more information, see [Media Types](rest_api_best_practices.old.md#media-types).

### Other headers

Other headers will be used in HTTP requests for specifying: the siteaccess to interact with and [authentication credentials](general_rest_usage.old.md#rest-api-authentication).

Responses returned by the API will also use custom headers to indicate information about the executed operation.

## Getting started with the REST API

### Installation

No special preparations are necessary to use the REST API. As long as your [[= product_name =]] is correctly configured, the REST API is available on your site using the URI `/api/ibexa/v2/`. If you have installed [[= product_name =]] in a subfolder, prepend the path with this subfolder: `http://example.com/sub/folder/ezpublish/api/ibexa/v2/`.

!!! note

    Please note that the `/api/ibexa/v2` prefix will be used in all REST hrefs, but not in URIs.

### Configuration

#### Authentication

### Testing the API

#### JavaScript example

**REST API with JavaScript**

TODO: Check if it works. Is `request.withCredentials = true;` needed?
Note that by default, session authentication is used. This means that if you use this example from a page on the same server, the session cookie will be transparently sent together with the request, and every AJAX call will have the same permissions as the currently logged in user.
