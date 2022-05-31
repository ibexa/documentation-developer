# REST API usage

The REST API v2 introduced in [[= product_name =]] allows you to interact with an [[= product_name =]] installation using the HTTP protocol, following a [REST](http://en.wikipedia.org/wiki/Representational_state_transfer) interaction model.

Each resource (URI) interacts with a part of the system (Content, User, Search, etc.).
Every interaction with the repository than you can do from Back Office or using the [Public PHP API](public_php_api.md) can also be done using the REST API. TODO: Is it actually true?

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
GET /content/objects/59/versions/3/relations?limit=5 HTTP/1.1
Accept: application/vnd.ibexa.api.RelationList+xml
```

#### Working with value objects IDs
https://doc.ibexa.co/en/latest/api/general_rest_usage/#working-with-value-objects-ids

Resources that accept a reference to another resource expect reference to be given as a REST URI, not a single ID.
For example, the URI requesting a list of user groups assigned to the role with ID 1 is:

```
GET /api/ibexa/v2/user/groups?roleId=/api/ibexa/v2/user/roles/1
```

### REST root

The `/` root route is answered by a cheat sheet with the main resource routes and media-types. In XML by default, it can also be switched to JSON output.

```shell
curl http://api.example.net/api/ibexa/v2/
curl -H "Accept: application/json" http://api.example.net/api/ibexa/v2/
```

### Country list
https://doc.ibexa.co/en/latest/api/general_rest_usage/#rest-api-countries-list

Alongside regular repository interactions, is a REST service providing a list of countries with their names, [ISO-3166](http://en.wikipedia.org/wiki/ISO_3166) codes and International Dialing Codes (IDC). It could be useful when presenting a country options list from any application.

This country list's URI is `/services/countries`.

The ISO-3166 country codes can be represented as:

- two-letter code (alpha-2) — recommended as the general purpose code
- three-letter code (alpha-3) — related to the country name
- three-digit numeric code (numeric-3) — useful if you need to avoid using Latin script

For details, see the [ISO-3166 glossary](http://www.iso.org/iso/home/standards/country_codes/country_codes_glossary.htm).

## Requests

### Request HTTP methods
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

    Using custom HTTP methods can cause issues with several HTTP proxies, network firewall/security solutions and simpler web servers. To avoid issues with this, REST API allows you to set these using the HTTP header `X-HTTP-Method-Override` along standard `POST` method instead of using a custom HTTP method. Example: `X-HTTP-Method-Override: PUBLISH`

If applicable, both methods are always mentioned in the specifications.

Not safe methods will require a CSRF token if [session-based authentication](rest_api_authentication.md#session-based-authentication) is used.

#### OPTIONS method
https://doc.ibexa.co/en/latest/api/rest_api_best_practices/#options-requests

Any URI resource that the REST API responds to will respond to an `OPTIONS` request.

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

### Request HTTP headers
https://doc.ibexa.co/en/latest/api/rest_api_guide/#other-headers

There are mainly four headers to specify a REST request:
- [`Accept`](https://tools.ietf.org/html/rfc2616#section-14.1) describing the response type and format;
- [`Content-Type`](https://toos.ietf.org/html/rfc2616#section-14.17) describing the payload type and format;
- `X-Siteaccess` specifying the target SiteAccess;
- `X-HTTP-Method-Override` allowing to pass a method while using `POST` method as previously seen in [HTTP methods](#request-http-methods).
- [`If-None-Match`](https://tools.ietf.org/html/rfc7232#section-3.2) reclaiming the cached response of a previously visited resource if still up-to-date using [HTTP Etag](https://tools.ietf.org/html/rfc7232#section-2.3). TODO: Is it usable or not enough implemented to be used?

Few other headers related to authentication methods can be found in [REST API authentication](rest_api_authentication.md).

#### SiteAccess
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

#### Media types
https://doc.ibexa.co/en/latest/api/rest_api_guide/#media-type-headers
https://doc.ibexa.co/en/latest/api/rest_api_best_practices/#media-types

On top of methods, HTTP request headers will allow you to personalize the request's behavior. On every resource, you can use the `Accept` header to indicate which format you want to communicate in, JSON or XML. This header is also used to specify the response type you want the server to send when multiple ones are available.

-   `Accept: application/vnd.ibexa.api.Content+xml` to get **Content** (full data, fields included) as **[XML](http://www.w3.org/XML/)**
-   `Accept: application/vnd.ibexa.api.ContentInfo+json` to get **ContentInfo** (metadata only) as **[JSON](http://www.json.org/)**

Media-types are also used with the `Content-Type` header to characterize a request payload. See Creating session [XML](rest_api_authentication.md#creating-session-xml-example) and [JSON](rest_api_authentication.md#creating-session-json-example) examples.

If the resource returns only deals with one media type, it is also possible to skip it and to just specify the format using `application/xml` or `application/json`.

A response indicates hrefs to related resources and their media-types.

#### Destination
https://doc.ibexa.co/en/latest/api/general_rest_usage/#destination-header

The `Destination` request header is the request counterpart of the `Location` response header.
It is used for a `COPY`, `MOVE` or `SWAP` operation on a resource to indicate where the resource should be moved, copied to or swapped with by using the ID of the parent or target location.

Examples of such requests are

- [copying a Content](rest_api_reference/rest_api_reference.html#managing-content-copy-content);
- [moving a Location and its subtree](rest_api_reference/rest_api_reference.html#managing-content-move-subtree)
- [swapping a Location with another](rest_api_reference/rest_api_reference.html#managing-content-swap-location)

### Request body

While some short scalar parameters can be passed in the URIs or as GET parameters, some resources needs heavier structured payloads passed in the request body, in particular the ones to create (`POST`) or update (`PATCH`) items.
In the [REST API reference](rest_api_reference/rest_api_reference.html), request payload examples are given when needed.

One example is the [creation of an authentication session](rest_api_authentication.md#establishing-a-session).

When creating a Content, the payload is particular if the ContentType has some [Image](field_types_reference/imagefield.md) or [BinaryFile](field_types_reference/binaryfilefield.md) fields as files need to be attached. See the example of a [script uploading images](#creating-content-with-binary-attachments) below.

When searching for Contents (TODO: or Locations), the query grammar is also particular. See the [Search section](#search) below.

#### Creating content with binary attachments
https://doc.ibexa.co/en/latest/api/creating_content_with_binary_attachments_via_rest_api/

The example below is a command-line script to upload images.

This script will

- receive an image path and optionally a name as command-line arguments,
- use the [HTTP basic authentication](rest_api_authentication.md#http-basic-authentication) assuming it is enabled,
- create a draft in the /Media/Images folder by `POST`ing data to [`/content/objects`](rest_api_reference/rest_api_reference.html#managing-content-create-content-item),
- and, `PUBLISH` the draft through [`/content/objects/{contentId}/versions/{versionNo}`](rest_api_reference/rest_api_reference.html#managing-content-publish-a-content-version).

=== "XML"

    ``` php
    [[= include_file('code_samples/api/rest_api/create_image.xml.php', 0, None, '    ') =]]
    ```

=== "JSON"

    ``` php
    [[= include_file('code_samples/api/rest_api/create_image.json.php', 0, None, '    ') =]]
    ```

#### Search (`/view`)
https://doc.ibexa.co/en/latest/api/general_rest_usage/#logical-operators

The `/view` route allow to [search in the repository](../guide/search/search.md). It works close to its [PHP API counterpart](public_php_api_search.md).

The model allows combining criteria using the logical operators `AND`, `OR` and `NOT`.

Almost all [search criteria](../guide/search/search_criteria_reference.md#search-criteria) are available on REST API. The suffix `Criterion` is added when used with REST API.
TODO: Rephrase. Maybe all criteria are available; CurrencyCode was the only one I didn't find on REST side on first quick check.

Almost all [sort clauses](../guide/search/sort_clause_reference.md#sort-clauses) are available too. No prefix ou suffix for them.
TODO: All sort clauses?

The search request HTTP header to type its body is `Content-Type: application/vnd.ibexa.api.ViewInput+xml` or `+json`.
The root node is `<ViewInput>` and it has two mandatory children: `<identifier>` and `<Query>`.
TODO: Even if mandatory, direct access to a view through its identifier is not implemented (501).

`version=1.1` can be added to the `Content-Type` header to support the distinction between `ContentQuery` and `LocationQuery` instead of just `Query` which implicitly looked only for Contents.
TODO: Where are `ContentQuery` and `LocationQuery` documented on PHP API side?

The following examples will search for `article` and `news` typed Contents everywhere, search for Contents of all types directly under Location `123`, all those Contents must be in the `standard` Section.

=== "XML"

    ```
    Content-Type: application/vnd.ibexa.api.ViewInput+xml
    ```

    ``` xml
    <?xml version="1.0" encoding="UTF-8"?>
    <ViewInput>
      <identifier>test</identifier>
      <Query>
        <Filter>
            <AND>
                <OR>
                    <ContentTypeIdentifierCriterion>article</ContentTypeIdentifierCriterion>
                    <ContentTypeIdentifierCriterion>news</ContentTypeIdentifierCriterion>
                    <ParentLocationIdCriterion>123</ParentLocationIdCriterion>
                </OR>
                <SectionIdentifierCriterion>standard</SectionIdentifierCriterion>
            </AND>
        </Filter>
        <limit>10</limit>
        <offset>0</offset>
        <SortClauses>
          <ContentName>ascending</ContentName>
        </SortClauses>
      </ContentQuery>
    </ViewInput>
    ```

=== "XML; 1.1"

    ```
    Content-Type: application/vnd.ibexa.api.ViewInput+xml; version=1.1
    ```

    ``` xml
    <?xml version="1.0" encoding="UTF-8"?>
    <ViewInput>
      <identifier>test</identifier>
      <ContentQuery>
        <Filter>
            <AND>
                <OR>
                    <ContentTypeIdentifierCriterion>article</ContentTypeIdentifierCriterion>
                    <ContentTypeIdentifierCriterion>news</ContentTypeIdentifierCriterion>
                    <ParentLocationIdCriterion>123</ParentLocationIdCriterion>
                </OR>
                <SectionIdentifierCriterion>standard</SectionIdentifierCriterion>
            </AND>
        </Filter>
        <limit>10</limit>
        <offset>0</offset>
        <SortClauses>
          <ContentName>ascending</ContentName>
        </SortClauses>
      </ContentQuery>
    </ViewInput>
    ```

=== "JSON"

    ```
    Content-Type: application/vnd.ibexa.api.ViewInput+json
    ```

    ``` json
    {
      "ViewInput": {
        "identifier": "test",
        "Query": {
          "Filter": {
            "AND": {
              "OR": {
                "ContentTypeIdentifierCriterion": [
                  "article",
                  "news"
                ],
                "ParentLocationIdCriterion": 123
              },
              "SectionIdentifierCriterion": "standard"
            }
          },
          "limit": "10",
          "offset": "0",
          "SortClauses": { "ContentName": "ascending" }
        }
      }
    }
    ```

=== "JSON; 1.1"

    ```
    Content-Type: application/vnd.ibexa.api.ViewInput+json
    ```

    ``` json
    {
      "ViewInput": {
        "identifier": "test",
        "ContentQuery": {
          "Filter": {
            "AND": {
              "OR": {
                "ContentTypeIdentifierCriterion": [
                  "article",
                  "news"
                ],
                "ParentLocationIdCriterion": 123
              },
              "SectionIdentifierCriterion": "standard"
            }
          },
          "limit": "10",
          "offset": "0",
          "SortClauses": { "ContentName": "ascending" }
        }
      }
    }
    ```

!!! note

    In JSON, the structure for `ContentTypeIdentifierCriterion` with multiple values has a slightly different format as keys must be unique.
    In JSON, if there is only one `SortClauses`, it can be passed directly without an array to wrap it.

Logical operators may be omitted. If criteria are of mixed types, they will be wrapped in an implicit `AND`. If they are of the same type, they will be wrapped in an implicit `OR`.

For example, the `AND` operator from previous example's `Filter` could be removed.

=== "XML Explicit `AND`"

    ``` xml
    <Filter>
        <AND>
            <OR>
                <ContentTypeIdentifierCriterion>article</ContentTypeIdentifierCriterion>
                <ContentTypeIdentifierCriterion>news</ContentTypeIdentifierCriterion>
                <ParentLocationIdCriterion>123</ParentLocationIdCriterion>
            </OR>
            <SectionIdentifierCriterion>standard</SectionIdentifierCriterion>
        </AND>
    </Filter>
    ```

=== "XML Implicit `AND`"

    ``` xml
    <Filter>
        <OR>
            <ContentTypeIdentifierCriterion>article</ContentTypeIdentifierCriterion>
            <ContentTypeIdentifierCriterion>news</ContentTypeIdentifierCriterion>
            <ParentLocationIdCriterion>123</ParentLocationIdCriterion>
        </OR>
        <SectionIdentifierCriterion>standard</SectionIdentifierCriterion>
    </Filter>
    ```

=== "JSON Explicit `AND`"

    ``` json
    "Filter": {
      "AND": {
        "OR": {
           "ContentTypeIdentifierCriterion": [
            "article",
            "news"
          ],
          "ParentLocationIdCriterion": 123
        },
        "SectionIdentifierCriterion": "standard"
      }
    },
    ```

=== "JSON Implicit `AND`"

    ``` json
    "Filter": {
      "OR": {
         "ContentTypeIdentifierCriterion": [
          "article",
          "news"
        ],
        "ParentLocationIdCriterion": 123
      },
      "SectionIdentifierCriterion": "standard"
    },
    ```

## Responses

### Response HTTP codes
https://doc.ibexa.co/en/latest/api/general_rest_usage/#http-code
https://doc.ibexa.co/en/latest/api/general_rest_usage/#general-error-codes

The following list of available HTTP response status codes just give a quick hint of the meaning of a code. For code details per resource, see the [REST API reference](rest_api_reference/rest_api_reference.html).

| Code  | Message                | Description                                                                                                                                                                                                                                                  |
|-------|------------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `200` | OK                     | The resource has been found.                                                                                                                                                                                                                                 |
| `201` | Created                | The request to create a new item has succeeded; the response `Location` header indicates when the created item could be consulted.                                                                                                                           |
| `204` | No Content             | The request has succeeded and there is nothing to say about it in the response header nor body (for example when publishing or deleting).                                                                                                                    |
| `301` | Moved Permanently      | The resource should not be accessed this way; the response `Location` header indicates the proper way.                                                                                                                                                       |
| `307` | Temporary Redirect     | The resource is available at another URL considered as its main; the response `Location` header indicates this main URL.                                                                                                                                     |
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

### Response HTTP headers
https://doc.ibexa.co/en/latest/api/general_rest_usage/#response-headers

The `Allow` response header for [`OPTIONS` method](#options-requests) was previously seen. Response to some other methods may have data indicated through their headers.

#### Content-Type header
https://doc.ibexa.co/en/latest/api/general_rest_usage/#content-type-header

As long as a response contains an actual HTTP body, the Content Type header will be used to specify which Content Type is contained in the response.

For example, the first following request without an `Accept` header will return a default format indicated in the response `Content-Type` header while the second request show that the response is in the asked format.

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

#### Accept-Patch header
https://doc.ibexa.co/en/latest/api/general_rest_usage/#accept-patch-header

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

#### Location header
https://doc.ibexa.co/en/latest/api/general_rest_usage/#location-header

For instance [creating Content](rest_api_reference/rest_api_reference.html#managing-content-create-content-type) and [getting a Content item's current version](rest_api_reference/rest_api_reference.html#managing-content-get-current-version)
will both send a `Location` header to provide you with the requested resource's ID.

Those particular headers generally match a specific list of HTTP response codes.
`Location` is mainly sent alongside `201 Created`, `301 Moved permanently`, `307 Temporary redirect responses`.

In the following example, the content object remote ID 34720ff636e1d4ce512f762dc638e4ac corresponds to the ID 52:

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

Notice that cURL can follow those redirections. On CLI, there is the `--location` option (or its shorthand `-L`); with PHP, is the `CURLOPT_FOLLOWLOCATION`.
The following command-line example follows the two redirections above and the `Accept` header is propagated:

```shell
curl --header "Accept: application/vnd.ibexa.api.Content+json" --head --location "http://api.example.com/api/ibexa/v2/content/objects/?remoteId=34720ff636e1d4ce512f762dc638e4ac"
```

```
HTTP/1.1 200 OK
Content-Type: application/vnd.ibexa.api.Content+json
```

### Response body
https://doc.ibexa.co/en/latest/api/general_rest_usage/#response-body

TODO

## Testing the API

TODO: There is something wrong with this title. "Usage examples"? "Short client implementation examples"?

A standard web browser is not sufficient to fully test the API. You can, however, try opening the root resource with it, using the session authentication: `http://example.com/api/ibexa/v2/`. Depending on how your browser understands XML, it will either download the XML file, or open it in the browser.

To test further, you can use browser extensions, like [Advanced REST client for Chrome](https://chrome.google.com/webstore/detail/advanced-rest-client/hgmloofddffdnphfgcellkdfbfbjeloo) or [RESTClient for Firefox](https://addons.mozilla.org/firefox/addon/restclient/), or dedicated tools. For command line users, [HTTPie](https://github.com/jkbr/httpie) is a good tool.

### CLI

Few `curl` command line examples have been previously shown
- [REST root](#rest-root)
- [OPTIONS method](#options-method)
- [Location header](#location-header)

### PHP

TODO: Just a GET

A content creation example using PHP is available above in [Creating content with binary attachments section](#creating-content-with-binary-attachments)

### JS
https://doc.ibexa.co/en/latest/api/rest_api_guide/#testing-the-api

One of the main reasons for this API is to help implement JavaScript / AJAX interaction. You can see here an example of an AJAX call that retrieves ContentInfo (e.g. metadata) for a Content item:

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

To possibly test it, just copy-paste this code into your browser console alongside a page from your website (to share the domain).

`resource` URI can be edited to address another domain.

On a freshly installed Ibexa DXP, `52` is the Content ID of the Front-Office home page. If necessary, substitute `52` with the Content ID of an item from your database.

### Cross-origin requests
https://doc.ibexa.co/en/latest/api/making_cross_origin_http_requests/

TODO: Related to "JS" example above or to "Requests" sections far above?
