# REST API usage

TODO: Introduction? Do not explain what REST is, only the specificity of Ibexa DXP's REST API

The REST API v2 introduced in [[= product_name =]] allows you to interact with an [[= product_name =]] installation using the HTTP protocol, following a [REST](http://en.wikipedia.org/wiki/Representational_state_transfer) interaction model.

Each resource (URI) interacts with a part of the system (Content, User, etc.).

The REST API uses HTTP methods (`GET`, `PUBLISH` , etc.), as well as HTTP headers to specify the type of request.

## URIs
https://doc.ibexa.co/en/latest/api/rest_api_best_practices/#uris

The REST API is designed in such a way that the client can explore the repository without constructing any URIs to resources.
Starting from the [root resource](#rest-root), every response includes further links (`href`s) to related resources.

### URI prefix
https://doc.ibexa.co/en/latest/api/rest_api_best_practices/#uris-prefix

In [REST reference](rest_api_reference/rest_api_reference.html), for the sake of readability, there are no prefixes used in the URIs.
In practice, the `/api/ibexa/v2` prefixes all REST hrefs.

Remember that the URIs to REST resources should never be generated manually, but obtained from earlier REST calls.
TODO: Make sure this is demonstrated in "customization and extension" examples.

### Request parameters
https://doc.ibexa.co/en/latest/api/general_rest_usage/#request-parameters

URI parameters (query string) can be used on some resources.
They usually serve as options or filters for the requested resource.

As a pagination example, the request below would return the first 5 relations for version 3 of the Content item 59:

```
GET /content/objects/59/versions/3/relations&limit=5 HTTP/1.1
Accept: application/vnd.ibexa.api.RelationList+xml
```

#### Working with value objects IDs
https://doc.ibexa.co/en/latest/api/general_rest_usage/#working-with-value-objects-ids

Resources that accept a reference to another resource expect reference to be given as a REST URI, not a single ID.
For example, the URI requesting a list of user groups assigned to the role with ID 1 is:

```
GET /api/ibexa/v2/user/groups?roleId=/api/ibexa/v2/user/roles/1
```

## HTTP methods
https://doc.ibexa.co/en/latest/api/rest_api_guide/#http-methods
https://doc.ibexa.co/en/latest/api/general_rest_usage/#custom-http-verbs

Depending on the used HTTP method, different actions will be possible on the same resource. Example:

| Action                                  | Description                                                          |
|-----------------------------------------|----------------------------------------------------------------------|
| `GET  /content/objects/2/version/3`     | Fetches data about version \#3 of Content item \#2                   |
| `PATCH  /content/objects/2/version/3`   | Updates the version \#3 draft of Content item \#2                    |
| `DELETE  /content/objects/2/version/3`  | Deletes the (draft or archived) version \#3 from Content item \#2    |
| `COPY  /content/objects/2/version/3`    | Creates a new draft version of Content item \#2 from its version \#3 |
| `PUBLISH  /content/objects/2/version/3` | Promotes the version \#3 of Content item \#2 from draft to published |
| `OPTIONS  /content/objects/2/version/3` | Lists all the methods usable with this resource, the 5 ones above    |

The following list of available methods just give a quick hint of the kind of action a method will trigger on a resource if available. For method action details per resource, see the [REST API reference](rest_api_reference/rest_api_reference.html).

| HTTP method                                                | Status   | Description               | Safe |
|------------------------------------------------------------|----------|---------------------------|------|
| [OPTIONS](https://tools.ietf.org/html/rfc2616#section-9.2) | Standard | To list available methods | Yes  |
| [GET](https://tools.ietf.org/html/rfc2616#section-9.3)     | Standard | To collect data           | Yes  |
| [HEAD](https://tools.ietf.org/html/rfc2616#section-9.4)    | Standard | To check existence        | Yes  |
| [POST](https://tools.ietf.org/html/rfc2616#section-9.5)    | Standard | To create an item         | No   |
| [PATCH](http://tools.ietf.org/html/rfc5789)                | Custom   | To update an item         | No   |
| COPY                                                       | Custom   | To duplicate an item      | No   |
| [MOVE](http://tools.ietf.org/html/rfc2518)                 | Custom   | To move an item           | No   |
| SWAP                                                       | Custom   | To swap two locations     | No   |
| PUBLISH                                                    | Custom   | To publish an item        | No   |
| [DELETE](https://tools.ietf.org/html/rfc2616#section-9.7)  | Standard | To remove an item         | No   |

!!! note "Caution with custom HTTP methods"

    Using custom HTTP methods can cause issues with several HTTP proxies, network firewall/security solutions and simpler web servers. To avoid issues with this, REST API allows you to set these using the HTTP header `X-HTTP-Method-Override` along standard `POST` method instead of using a custom HTTP method. Example: `X-HTTP-Method-Override: PUBLISH`

If applicable, both methods are always mentioned in the specifications.

Not safe methods will require a CSRF token if [session-based authentication](rest_api_authentication.md#session-based-authentication) is used.

### OPTIONS requests
https://doc.ibexa.co/en/latest/api/rest_api_best_practices/#options-requests
TODO: Needed or table above is enough?

Any URI resource that the REST API responds to will respond to an OPTIONS request.
TODO: Is it true for custom route? How to make it true for customs?

The response contains an `Allow` header, as specified in [chapter 14.7 of RFC 2616](https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.7), which lists the methods accepted by the resource.

```shell
curl -IX OPTIONS http://api.example.net/api/ibexa/v2/content/objects/1
```

```
OPTIONS /content/objects/1 HTTP/1.1
Host: api.example.net
```

```
HTTP/1.1 200 OK
Allow: PATCH,GET,DELETE,COPY
```

```shell
curl -IX OPTIONS http://api.example.net/api/ibexa/v2/content/locations/1/2
```

```
OPTIONS /content/locations/1/2 HTTP/1.1
Host: api.example.net
```

```
HTTP/1.1 200 OK
Allow: GET,PATCH,DELETE,COPY,MOVE,SWAP
```

## Request HTTP headers
https://doc.ibexa.co/en/latest/api/rest_api_guide/#other-headers

There are mainly four headers to specify a REST request:
- `Accept` describing the response type and format;
- `Content-Type` describing the payload type and format;
- `X-Siteaccess` specifying the target SiteAccess;
- `X-HTTP-Method-Override` allowing to pass a method while using `POST` method as previously seen in [HTTP methods](http-methods).

Few other headers related to authentication methods can be found in [REST API authentication](rest_api_authentication.md).

### SiteAccess
https://doc.ibexa.co/en/latest/api/general_rest_usage/#specifying-siteaccess
https://doc.ibexa.co/en/latest/api/rest_api_best_practices/#specifying-siteaccess

In order to specify a SiteAccess when communicating with the REST API, provide a custom `X-Siteaccess` header.
If it is not provided, the default SiteAccess is used.

Example with what could be a SiteAccess called `restapi` dedicated to REST API accesses:

```
GET / HTTP/1.1
Host: api.example.com
Accept: application/vnd.ibexa.api.Root+json
X-Siteaccess: restapi
```

One of the principles of REST is that the same resource (Content item, Location, Content Type, etc.) should be unique.
It allows caching your REST API using a reverse proxy like Varnish.
If the same resource is available in multiple locations, cache purging is noticeably more complex.
This is why SiteAccess matching with REST is not enabled at URL level (nor domain).

TODO: This could be important to notice earlier that URIElement can't be used (e.g. http://localhost:8080/admin/api/ibexa/v2/user/sessions)

### Media types
https://doc.ibexa.co/en/latest/api/rest_api_guide/#media-type-headers
https://doc.ibexa.co/en/latest/api/rest_api_best_practices/#media-types

On top of methods, HTTP request headers will allow you to personalize the request's behavior. On every resource, you can use the `Accept` header to indicate which format you want to communicate in, JSON or XML. This header is also used to specify the response type you want the server to send when multiple ones are available.

-   `Accept: application/vnd.ibexa.api.Content+xml` to get **Content** (full data, fields included) as **[XML](http://www.w3.org/XML/)**
-   `Accept: application/vnd.ibexa.api.ContentInfo+json` to get **ContentInfo** (metadata only) as **[JSON](http://www.json.org/)**

Media-types are also used with the `Content-Type` header to characterize a request payload. See Creating session [XML](rest_api_authentication.md#creating-session-xml-example) and [JSON](rest_api_authentication.md#creating-session-json-example) examples.

If the resource returns only deals with one media type, it is also possible to skip it and to just specify the format using `application/xml` or `application/json`.

A response indicates hrefs to related resources and their media-types.

## REST root

The `/` root route is answered by a cheat sheet with the main resource routes and media-types. In XML by default, it can also be switched to JSON output.

```shell
curl http://api.example.net/api/ibexa/v2/
curl -H "Accept: application/json" http://api.example.net/api/ibexa/v2/
```

## Request payloads

Several resources need data.
While some short scalar parameters can be passed in the URIs or as GET parameters, some resources needs heavier structured payloads, in particular the ones to create (`POST`) or update (`PATCH`) items.
In the [REST API reference](rest_api_reference/rest_api_reference.html), request payload examples are given when needed.

One example is the [creation of an authentication session](rest_api_authentication.md#establishing-a-session).

When creating a Content, the payload can be complex if the ContentType has some [Image](field_types_reference/imagefield.md) or [BinaryFile](field_types_reference/binaryfilefield.md) fields. 

### Creating content with binary attachments
https://doc.ibexa.co/en/latest/api/creating_content_with_binary_attachments_via_rest_api/

The example below is a command-line script to upload images.

This script will
- receive an image path and optionally a name as command-line arguments,
- use the [HTTP basic authentication](rest_api_authentication.md#http-basic-authentication) assuming it is enabled,
- create a draft in the /Media/Images folder by `POST`ing data to [`/content/objects`](rest_api_reference/rest_api_reference.html#managing-content-create-content-item),
- and, `PUBLISH` the draft through [`/content/objects/{contentId}/versions/{versionNo}`](rest_api_reference/rest_api_reference.html#managing-content-publish-a-content-version).

=== "Using XML"

    ``` php
    [[= include_file('code_samples/api/rest_api/create_image.xml.php', 0, None, '    ') =]]
    ```

=== "Using JSON"

    ``` php
    [[= include_file('code_samples/api/rest_api/create_image.json.php', 0, None, '    ') =]]
    ```

## Response HTTP codes
https://doc.ibexa.co/en/latest/api/general_rest_usage/#response-headers
https://doc.ibexa.co/en/latest/api/general_rest_usage/#http-code
https://doc.ibexa.co/en/latest/api/general_rest_usage/#general-error-codes

The following list of available HTTP response status codes just give a quick hint of the meaning of a code. For code details per resource, see the [REST API reference](rest_api_reference/rest_api_reference.html).

| Code  | Message                | Description                                                                                                                                                                                                                                                  |
|-------|------------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `200` | OK                     | The resource has been found.                                                                                                                                                                                                                                 |
| `201` | Created                | The request to create a new item has succeeded.                                                                                                                                                                                                              |
| `204` | No Content             | The request has succeeded and there is nothing to say about it in the response header nor body (for example when publishing or deleting).                                                                                                                    |
| `301` | Moved Permanently      | The resource is available at another URL considered as its main.                                                                                                                                                                                             |
| `307` | Temporary Redirect     | The resource is available at another URL considered as its main.                                                                                                                                                                                             |
| `400` | Bad Request            | The input (payload) doesn't have the proper schema for the resource.                                                                                                                                                                                         |
| `401` | Unauthorized           | The user does not have the permission to make this request.                                                                                                                                                                                                  |
| `403` | Forbidden              | The user has the permission but action can't be done because of repository logic (for example, when trying to create an item with an already existing ID or identifier, when attempting to update a version in another state than draft).                    |
| `404` | Not Found              | The requested object (or a request data like the parent of a new item) hasn't been found.                                                                                                                                                                    |
| `405` | Method Not Allowed     | The requested resource does not support the HTTP verb that was used.                                                                                                                                                                                         |
| `406` | Not Acceptable         | The request `accept` header is not supported.                                                                                                                                                                                                                |
| `409` | Conflict               | TODO.                                                                                                                                                                                                                                                        |
| `412` | Precondition Failed    | TODO.                                                                                                                                                                                                                                                        |
| `415` | Unsupported Media Type | TODO.                                                                                                                                                                                                                                                        |
| `500` | Internal Server Error  | The server encountered an unexpected condition, usually an exception, which prevents it from fulfilling the request, like database down, permissions or configuration error.                                                                                 |
| `501` | Not Implemented        | Returned when the requested method has not yet been implemented. For [[= product_name =]], most of Users, User groups, Content items, Locations and Content Types have been implemented. Some of their methods, as well as other features, may return a 501. |

TODO: Continue

### Content-Type header
https://doc.ibexa.co/en/latest/api/general_rest_usage/#content-type-header

As long as a response contains an actual HTTP body, the Content Type header will be used to specify which Content Type is contained in the response. In that case:

- ContentInfo: `Content-Type: application/vnd.ibexa.api.ContentInfo`
- ContentInfo in XML format: `Content-Type: application/vnd.ibexa.api.ContentInfo+xml`

### Accept-Patch header
https://doc.ibexa.co/en/latest/api/general_rest_usage/#accept-patch-header

It tells you that the received content can be modified by patching it with a [ContentUpdateStruct](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/ContentUpdateStruct.php) in XML format:

`Accept-Patch: application/vnd.ibexa.api.ContentUpdate+xml;charset=utf8`

JSON would also work, with the proper format.

As the example above shows, sending a PATCH `/content/objects/23` request with a [ContentUpdateStruct](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/ContentUpdateStruct.php) XML payload will update this content.

REST will use the `Accept-Patch` header to indicate how to **modify** the returned **data**.

### Location header
https://doc.ibexa.co/en/latest/api/general_rest_usage/#location-header

Depending on the resource, request and response headers will vary.

For instance [creating Content](rest_api_reference/rest_api_reference.html#managing-content-create-content-type) and [getting a Content item's current version](rest_api_reference/rest_api_reference.html#managing-content-get-current-version)
will both send a **Location header** to provide you with the requested resource's ID.

Those particular headers generally match a specific list of HTTP response codes.
Location is sent by `201 Created`, `301 Moved permanently`, `307 Temporary redirect responses`, etc. You can expect these HTTP responses to provide you with a Location header.

### Destination header
https://doc.ibexa.co/en/latest/api/general_rest_usage/#destination-header

This request header is the request counterpart of the Location response header.
It is used for a COPY or MOVE operation on a resource to indicate where the resource should be moved to by using the ID of the destination.
An example of such a request is [copying a Content item](rest_api_reference/rest_api_reference.html#managing-content-copy-content).

## Making cross-origin HTTP requests
https://doc.ibexa.co/en/latest/api/making_cross_origin_http_requests/
TODO: Related to JS example below

## Testing the API

### PHP

TODO: Just a GET

A content creation example using PHP is available above in [Creating content with binary attachments section](#creating-content-with-binary-attachments)

### JS
https://doc.ibexa.co/en/latest/api/rest_api_guide/#testing-the-api

TODO: Earlier? Merged into another section?
