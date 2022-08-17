---
description: REST API response code defines the status of the received response.
---

# REST Responses

## Response code

The following list of available HTTP response status codes gives an overview of the meaning of each code.
For code details per resource, see the [REST API reference](../rest_api_reference/rest_api_reference.html).

| Code  | Message                | Description                                                                                                                                                                                                                                                  |
|-------|------------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `200` | OK                     | The resource has been found.                                                                                                                                                                                                                                 |
| `201` | Created                | The request to create a new item has succeeded; the response `Location` header indicates where you can find the created item.                                                                                                                                |
| `204` | No Content             | The request has succeeded and there is no additional information in the response header or body (for example when publishing or deleting).                                                                                                                   |
| `301` | Moved Permanently      | The resource should not be accessed this way; the response `Location` header indicates the proper way.                                                                                                                                                       |
| `307` | Temporary Redirect     | The resource is available at another URL considered as its main; the response `Location` header indicates this main URL.                                                                                                                                     |
| `400` | Bad Request            | The input (payload) doesn't have the proper schema for the resource.                                                                                                                                                                                         |
| `401` | Unauthorized           | The user does not have the permission to make this request.                                                                                                                                                                                                  |
| `403` | Forbidden              | The user has the permission but action can't be performed because of Repository logic (for example, when trying to create an item with an already existing ID or identifier, when attempting to update a version in another state than draft).               |
| `404` | Not Found              | The requested object (or a request data like the parent of a new item) hasn't been found.                                                                                                                                                                    |
| `405` | Method Not Allowed     | The requested resource does not support the HTTP verb that was used.                                                                                                                                                                                         |
| `406` | Not Acceptable         | The request's `Accept` header is not supported.                                                                                                                                                                                                              |
| `409` | Conflict               | The request is in conflict with another part of the repository (for example, trying to create a new item with an identifier already used).                                                                                                                   |
| `415` | Unsupported Media Type | The request payload media type doesn't match the media type specified in the request header.                                                                                                                                                                 |
| `500` | Internal Server Error  | The server encountered an unexpected condition, usually an exception, which prevents it from fulfilling the request, like database down, permissions or configuration error.                                                                                 |
| `501` | Not Implemented        | Returned when the requested method has not yet been implemented. For [[= product_name =]], most of Users, User groups, Content items, Locations and Content Types have been implemented. Some of their methods, as well as other features, may return a 501. |

## Response headers

A resource's response may contain metadata in its HTTP headers.

!!! note

    For information about the `Allow` response header, see the [`OPTIONS` method](rest_requests.md#options-method).

### Content-Type header

When a response contains an actual HTTP body, the `Content-Type` header specifies what the body contains.
The `Content-Type` header's value is a [media type](rest_requests.md#media-types), like with the request `Accept` and `Content-Type` headers.

For example, the first following request without an `Accept` header returns a default format indicated in the response `Content-Type` header, while the second request shows that the response is in the requested format.

```
GET /content/objects/52 HTTP/1.1
```

```
HTTP/1.1 200 OK
Content-Type: application/vnd.ibexa.api.ContentInfo+xml
```

```
GET /content/objects/52 HTTP/1.1
Accept: application/vnd.ibexa.api.Content+json
```

```
HTTP/1.1 200 OK
Content-Type: application/vnd.ibexa.api.Content+json
```

### Accept-Patch header

When available, the `Accept-Patch` tells how the received item could be modified with `PATCH`.

The following examples also shows that the format (XML or JSON) is adapted:

```
GET /content/objects/52 HTTP/1.1
```

```
HTTP/1.1 200 OK
Content-Type: application/vnd.ibexa.api.ContentInfo+xml
Accept-Patch: application/vnd.ibexa.api.ContentUpdate+xml
```

```
GET /content/objects/52 HTTP/1.1
Accept: application/vnd.ibexa.api.Content+json
```

```
HTTP/1.1 200 OK
Content-Type: application/vnd.ibexa.api.Content+json
Accept-Patch: application/vnd.ibexa.api.ContentUpdate+json
```

Those example `Accept-Path` headers above indicate that the content could be modified by sending a [ContentUpdateStruct](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/ContentUpdateStruct.php) in XML or JSON.

### Location header

For example, [creating content](../rest_api_reference/rest_api_reference.html#managing-content-create-content-type) and [getting a Content item's current version](../rest_api_reference/rest_api_reference.html#managing-content-get-current-version)
both send a `Location` header to provide you with the requested resource's ID.

Those particular headers generally match a specific list of HTTP response codes.
`Location` is mainly sent alongside `201 Created`, `301 Moved permanently`, `307 Temporary redirect responses`.

In the following example, the Content item's remote ID 34720ff636e1d4ce512f762dc638e4ac corresponds to the ID 52:

```
GET /content/objects?remoteId=34720ff636e1d4ce512f762dc638e4ac" HTTP/1.1
```

```
HTTP/1.1 307 Temporary Redirect
Location: /content/objects/52
```

In the following example, an erroneous slash has been added to demonstrate the 301 case:

```
GET /content/objects?remoteId=34720ff636e1d4ce512f762dc638e4ac" HTTP/1.1
```

```
HTTP/1.1 301 Moved Permanently
Location: /content/objects?remoteId=34720ff636e1d4ce512f762dc638e4ac
```

cURL can follow those redirections. On CLI, there is the `--location` option (or its shorthand `-L`).
In PHP, you can achieve the same effect with `CURLOPT_FOLLOWLOCATION`.
The following command-line example follows the two redirections above and the `Accept` header is propagated:

```shell
curl --head --location --header "Accept: application/vnd.ibexa.api.Content+json" "https://api.example.com/api/ibexa/v2/content/objects/?remoteId=34720ff636e1d4ce512f762dc638e4ac"
```

```
HTTP/1.1 200 OK
Content-Type: application/vnd.ibexa.api.Content+json
```

### Cross-origin

[Cross-Origin Resource Sharing (CORS)](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing) can allow the REST API to be reached from a page on another domain.

!!! tip "More information about CORS"

    - [CORS' W3C specification](http://www.w3.org/TR/cors/)
    - [Overview of CORS on developer.mozilla.org](https://developer.mozilla.org/en-US/docs/HTTP/Access_control_CORS)

CORS support is provided by the third party [nelmio/cors-bundle](https://packagist.org/packages/nelmio/cors-bundle). You can read more about it in [NelmioCorsBundle's README](https://github.com/nelmio/NelmioCorsBundle/blob/master/README.md).

Using CORS is not limited to REST API resources and can be used for any resource of the platform.

The CORS bundle adds an `Access-Control-Allow-Origin` header to the response.

#### Configuration

To enable CORS, add regular expression for an allowed domain using the `.env` variable `CORS_ALLOW_ORIGIN`.

For example, to allow the JS test above to be executed alongside this page, you could add the following to an `.env` file (like the `.env.local`): `CORS_ALLOW_ORIGIN=^https?://doc.ibexa.co`.

To add several domains, filter on URIs, or change the default (like not allowing all the methods),
refer to [NelmioCorsBundle Configuration Documentation](https://github.com/nelmio/NelmioCorsBundle/blob/master/README.md#configuration)
to learn how to edit `config/packages/nelmio_cors.yaml`.

## Response body

The Response body is often a serialization in XML or JSON of an object as it could be retrieved using the Public PHP API.

For example, the resource `/content/objects/52` with the `Accept: application/vnd.ibexa.api.Content+xml` header returns a serialized version of a [ContentInfo](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/ContentInfo.php) object.

```shell
curl https://api.example.com/content/objects/52 --header 'Accept: application/vnd.ibexa.api.ContentInfo+xml';
```

```xml
<?xml version="1.0" encoding="UTF-8"?>
<Content media-type="application/vnd.ibexa.api.ContentInfo+xml" href="/api/ibexa/v2/content/objects/52" remoteId="34720ff636e1d4ce512f762dc638e4ac" id="52">
  <ContentType media-type="application/vnd.ibexa.api.ContentType+xml" href="/api/ibexa/v2/content/types/42"/>
  <Name>Ibexa Digital Experience Platform</Name>
  <TranslatedName>Ibexa Digital Experience Platform</TranslatedName>
  <Versions media-type="application/vnd.ibexa.api.VersionList+xml" href="/api/ibexa/v2/content/objects/52/versions"/>
  <CurrentVersion media-type="application/vnd.ibexa.api.Version+xml" href="/api/ibexa/v2/content/objects/52/currentversion"/>
  <Section media-type="application/vnd.ibexa.api.Section+xml" href="/api/ibexa/v2/content/sections/1"/>
  <MainLocation media-type="application/vnd.ibexa.api.Location+xml" href="/api/ibexa/v2/content/locations/1/2"/>
  <Locations media-type="application/vnd.ibexa.api.LocationList+xml" href="/api/ibexa/v2/content/objects/52/locations"/>
  <Owner media-type="application/vnd.ibexa.api.User+xml" href="/api/ibexa/v2/user/users/14"/>
  <lastModificationDate>2015-09-17T09:22:23+00:00</lastModificationDate>
  <publishedDate>2015-09-17T09:22:23+00:00</publishedDate>
  <mainLanguageCode>eng-GB</mainLanguageCode>
  <currentVersionNo>1</currentVersionNo>
  <alwaysAvailable>true</alwaysAvailable>
  <isHidden>false</isHidden>
  <status>PUBLISHED</status>
  <ObjectStates media-type="application/vnd.ibexa.api.ContentObjectStates+xml" href="/api/ibexa/v2/content/objects/52/objectstates"/>
</Content>
```

The response body XML can contain two types of nodes:

- Final nodes that fully give an information as a scalar value;
- Reference nodes which link to `href` where a new resource of a given `media-type` can be explored if you need to know more.
