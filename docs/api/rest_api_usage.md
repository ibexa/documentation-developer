# REST API usage

The REST API in [[= product_name =]] allows you to interact with an [[= product_name =]] installation using the HTTP protocol,
following a [REST](http://en.wikipedia.org/wiki/Representational_state_transfer) interaction model.

Each resource (URI) interacts with a part of the system (content, users, search, and so on).
Every interaction with the Repository than you can do from Back Office or using the [Public PHP API](public_php_api.md) can also be done using the REST API.

The REST API uses HTTP methods (`GET`, `PUBLISH` , and so on), as well as HTTP headers to specify the type of request.

## URIs

The REST API is designed in such a way that the client can explore the Repository without constructing any URIs to resources.
Starting from the [root resource](#rest-root), every response includes further links (`href`) to related resources.

### URI prefix

[REST reference](rest_api_reference/rest_api_reference.html), for the sake of readability, uses no prefixes in the URIs.
In practice, the `/api/ibexa/v2` prefixes all REST hrefs.

This prefix immediately follows the domain, and you can't use the [`URIElement` SiteAccess matcher](../guide/multisite/siteaccess_matching.md#urielement).
If you need to the select a SiteAccess, see the [`X-Siteaccess` HTTP header](#siteaccess).

### URI parameters

URI parameters (query string) can be used on some resources.
They usually serve as options or filters for the requested resource.

As an example, the request below would paginate the results and return the first 5 relations for version 3 of the Content item 59:

```
GET /content/objects/59/versions/3/relations?limit=5 HTTP/1.1
Accept: application/vnd.ibexa.api.RelationList+xml
```

#### Working with value objects IDs

Resources that accept a reference to another resource expect the reference to be given as a REST URI, not a single ID.
For example, the URI requesting a list of user groups assigned to the role with ID 1 is:

```
GET /api/ibexa/v2/user/groups?roleId=/api/ibexa/v2/user/roles/1
```

### REST root

The `/` root route is answered by a reference list with the main resource routes and media-types.
It is presented in XML by default, but you can also switch to JSON output.

```shell
curl https://api.example.com/api/ibexa/v2/
curl -H "Accept: application/json" https://api.example.com/api/ibexa/v2/
```

### Country list

Alongside regular Repository interactions, there is a REST service providing a list of countries with their names, [ISO-3166](http://en.wikipedia.org/wiki/ISO_3166) codes and International Dialing Codes (IDC). It could be useful when presenting a country options list from any application.

This country list's URI is `/services/countries`.

The ISO-3166 country codes can be represented as:

- two-letter code (alpha-2) — recommended as the general purpose code
- three-letter code (alpha-3) — related to the country name
- three-digit numeric code (numeric-3) — useful if you need to avoid using Latin script

For details, see the [ISO-3166 glossary](http://www.iso.org/iso/home/standards/country_codes/country_codes_glossary.htm).

## Requests

### Request method

Depending on the HTTP method used, different actions will be possible on the same resource. Example:

| Action                                  | Description                                                          |
|-----------------------------------------|----------------------------------------------------------------------|
| `GET  /content/objects/2/version/3`     | Fetches data about version \#3 of Content item \#2                   |
| `PATCH  /content/objects/2/version/3`   | Updates the version \#3 draft of Content item \#2                    |
| `DELETE  /content/objects/2/version/3`  | Deletes the (draft or archived) version \#3 from Content item \#2    |
| `COPY  /content/objects/2/version/3`    | Creates a new draft version of Content item \#2 from its version \#3 |
| `PUBLISH  /content/objects/2/version/3` | Promotes the version \#3 of Content item \#2 from draft to published |
| `OPTIONS  /content/objects/2/version/3` | Lists all the methods usable with this resource, the 5 ones above    |

The following list of available methods gives an overview of the kind of action a method triggers on a resource, if available.
For method action details per resource, see the [REST API reference](rest_api_reference/rest_api_reference.html).

| HTTP method                                                | Status   | Description            | Safe |
|------------------------------------------------------------|----------|------------------------|------|
| [OPTIONS](https://tools.ietf.org/html/rfc2616#section-9.2) | Standard | List available methods | Yes  |
| [GET](https://tools.ietf.org/html/rfc2616#section-9.3)     | Standard | Collect data           | Yes  |
| [HEAD](https://tools.ietf.org/html/rfc2616#section-9.4)    | Standard | Check existence        | Yes  |
| [POST](https://tools.ietf.org/html/rfc2616#section-9.5)    | Standard | Create an item         | No   |
| [PATCH](http://tools.ietf.org/html/rfc5789)                | Custom   | Update an item         | No   |
| COPY                                                       | Custom   | Duplicate an item      | No   |
| [MOVE](http://tools.ietf.org/html/rfc2518)                 | Custom   | Move an item           | No   |
| SWAP                                                       | Custom   | Swap two Locations     | No   |
| PUBLISH                                                    | Custom   | Publish an item        | No   |
| [DELETE](https://tools.ietf.org/html/rfc2616#section-9.7)  | Standard | Remove an item         | No   |

!!! note "Caution with custom HTTP methods"

    Using custom HTTP methods can cause issues with several HTTP proxies, network firewall/security solutions and simpler web servers.
    To avoid issues with this, REST API allows you to set these using the HTTP header `X-HTTP-Method-Override` alongside the standard `POST` method
    instead of using a custom HTTP method. For example: `X-HTTP-Method-Override: PUBLISH`

    If applicable, both methods are always mentioned in the specifications.

Unsafe methods will require a CSRF token if [session-based authentication](rest_api_authentication.md#session-based-authentication) is used.

#### OPTIONS method

Any URI resource that the REST API responds to will respond to an `OPTIONS` request.

The response contains an [`Allow` header](https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.7), which lists the methods accepted by the resource.

```shell
curl -IX OPTIONS https://api.example.com/api/ibexa/v2/content/objects/1
```

```
OPTIONS /content/objects/1 HTTP/1.1
Host: api.example.com
```

```
HTTP/1.1 200 OK
Allow: PATCH,GET,DELETE,COPY
```

```shell
curl -IX OPTIONS https://api.example.com/api/ibexa/v2/content/locations/1/2
```

```
OPTIONS /content/locations/1/2 HTTP/1.1
Host: api.example.com
```

```
HTTP/1.1 200 OK
Allow: GET,PATCH,DELETE,COPY,MOVE,SWAP
```

### Request headers

You can use the following HTTP headers with a REST request:

- [`Accept`](https://tools.ietf.org/html/rfc2616#section-14.1) describing the desired response type and format;
- [`Content-Type`](https://toos.ietf.org/html/rfc2616#section-14.17) describing the payload type and format;
- [`X-Siteaccess`](#siteaccess) specifying the target SiteAccess;
- `X-HTTP-Method-Override` allowing to pass a custom method while using `POST` method as previously seen in [HTTP method](#request-method).
- [`Destination`](#destination) specifying where to move an item

Other headers related to authentication methods can be found in [REST API authentication](rest_api_authentication.md).

#### SiteAccess

In order to specify a SiteAccess when communicating with the REST API, provide a custom `X-Siteaccess` header.
Otherwise, the default SiteAccess is used.

The following example shows what could be a SiteAccess called `restapi` dedicated to REST API accesses:

```
GET / HTTP/1.1
Host: api.example.com
Accept: application/vnd.ibexa.api.Root+json
X-Siteaccess: restapi
```

One of the principles of REST is that the same resource (such as Content item, Location, Content Type) should be unique.
It allows caching your REST API using a reverse proxy such as Varnish.
If the same resource is available in multiple locations, cache purging is noticeably more complex.
This is why SiteAccess matching with REST is not enabled at URL level (or domain).

#### Media types

On top of methods, HTTP request headers allow you to personalize the request's behavior.
On every resource, you can use the `Accept` header to indicate which format you want to communicate in, JSON or XML.
This header is also used to specify the response type you want the server to send when multiple types are available.

-   `Accept: application/vnd.ibexa.api.Content+xml` to get `Content` (full data, Fields included) as **[XML](http://www.w3.org/XML/)**
-   `Accept: application/vnd.ibexa.api.ContentInfo+json` to get `ContentInfo` (metadata only) as **[JSON](http://www.json.org/)**

Media types are also used with the [`Content-Type` header](#content-type-header) to characterize a request payload.
See [Creating content with binary attachments](#creating-content-with-binary-attachments) below.
Also see [Creating session](rest_api_authentication.md#creating-session) examples.

If the resource only returns one media type, it is also possible to skip it and to just specify the format using `application/xml` or `application/json`.

A response indicates `href`s to related resources and their media types.

#### Destination

The `Destination` request header is the request counterpart of the `Location` response header.
It is used for a `COPY`, `MOVE` or `SWAP` operation to indicate where the resource should be moved, copied to or swapped with by using the ID of the parent or target Location.

Examples of such requests are:

- [copying a Content](rest_api_reference/rest_api_reference.html#managing-content-copy-content);
- [moving a Location and its subtree](rest_api_reference/rest_api_reference.html#managing-content-move-subtree)
- [swapping a Location with another](rest_api_reference/rest_api_reference.html#managing-content-swap-location)

### Request body

You can pass some short scalar parameters in the URIs or as GET parameters, but other resources need heavier structured payloads passed in the request body,
in particular the ones to create (`POST`) or update (`PATCH`) items.
In the [REST API reference](rest_api_reference/rest_api_reference.html), request payload examples are given when needed.

One example is the [creation of an authentication session](rest_api_authentication.md#establishing-a-session).

When creating a Content item, a special payload is needed if the ContentType has some [Image](field_types_reference/imagefield.md) or [BinaryFile](field_types_reference/binaryfilefield.md) Fields as files need to be attached. See the example of a [script uploading images](#creating-content-with-binary-attachments) below.

When searching for Content items (or Locations), the query grammar is also particular. See the [Search section](#search-view) below.

#### Creating content with binary attachments

The example below is a command-line script to upload images.

This script:

- receives an image path and optionally a name as command-line arguments,
- uses the [HTTP basic authentication](rest_api_authentication.md#http-basic-authentication), if it is enabled,
- creates a draft in the /Media/Images folder by posting (`POST`) data to [`/content/objects`](rest_api_reference/rest_api_reference.html#managing-content-create-content-item),
- and, publishes (`PUBLISH`) the draft through [`/content/objects/{contentId}/versions/{versionNo}`](rest_api_reference/rest_api_reference.html#managing-content-publish-a-content-version).

=== "XML"

    ``` php
    [[= include_file('code_samples/api/rest_api/create_image.xml.php', 0, None, '    ') =]]
    ```

=== "JSON"

    ``` php
    [[= include_file('code_samples/api/rest_api/create_image.json.php', 0, None, '    ') =]]
    ```

#### Search (`/view`)

The `/view` route allows you to [search in the repository](../guide/search/search.md). It works similarly to its [PHP API counterpart](public_php_api_search.md).

The model allows combining criteria using the logical operators `AND`, `OR` and `NOT`.

Almost all [Search Criteria](../guide/search/criteria_reference/search_criteria_reference.md#search-criteria) are available in REST API. The suffix `Criterion` is added when used with REST API.

Almost all [Sort Clauses](../guide/search/sort_clause_reference/sort_clause_reference.md#sort-clauses) are available too. They require no additional prefix or suffix.

The search request has a `Content-Type: application/vnd.ibexa.api.ViewInput+xml` or `+json` header to specify the format of its body's payload.
The root node is `<ViewInput>` and it has two mandatory children: `<identifier>` and `<Query>`.

You can add `version=1.1` to the `Content-Type` header to support the distinction between `ContentQuery` and `LocationQuery` instead of just `Query` which implicitly looks only for Content items.

The following examples search for `article` and `news` typed Content items everywhere or for Content items of all types directly under Location `123`. All those Content items must be in the `standard` Section.

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
    In JSON, if there is only one item in `SortClauses`, it can be passed directly without an array to wrap it.

You can omit logical operators. If Criteria are of mixed types, they are wrapped in an implicit `AND`.
If they are of the same type, they are wrapped in an implicit `OR`.

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

### Response code

The following list of available HTTP response status codes gives an overview of the meaning of each code.
For code details per resource, see the [REST API reference](rest_api_reference/rest_api_reference.html).

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

### Response headers

A resource's response may contain metadata in its HTTP headers.

!!! note
    For information about the `Allow` response header, see the [`OPTIONS` method](#options-method).

#### Content-Type header

When a response contains an actual HTTP body, the `Content-Type` header specifies what the body contains.
The `Content-Type` header's value is a [media type](#media-types), like with the `Accept` header.

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

#### Accept-Patch header

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

For example, [creating content](rest_api_reference/rest_api_reference.html#managing-content-create-content-type) and [getting a Content item's current version](rest_api_reference/rest_api_reference.html#managing-content-get-current-version)
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

### Response body

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

## Testing the API

A standard web browser is not sufficient to fully test the API.
You can, however, try opening the root resource with it, using the session authentication: `http://example.com/api/ibexa/v2/`.
Depending on how your browser understands XML, it either downloads the XML file, or opens it in the browser.

The following examples show how to interrogate the REST API using cURL, PHP or JS.

To test further, you can use browser extensions, like [Advanced REST client for Chrome](https://chrome.google.com/webstore/detail/advanced-rest-client/hgmloofddffdnphfgcellkdfbfbjeloo) or [RESTClient for Firefox](https://addons.mozilla.org/firefox/addon/restclient/), or dedicated tools. For command line users, [HTTPie](https://github.com/jkbr/httpie) is a good tool.

### CLI

For examples of using `curl`, refer to:

- [REST root](#rest-root)
- [OPTIONS method](#options-method)
- [Location header](#location-header)
- [ContentInfo body](#response-body)

### PHP

To test REST API with PHP, cURL can be used; open a PHP shell in a terminal with `php -a` and copy-paste this code into it:

```php
$resource = 'https://api.example.com/api/ibexa/v2/content/objects/52';
$curl = curl_init($resource);
curl_setopt_array($curl, [
    CURLOPT_HTTPHEADER => ['Accept: application/vnd.ibexa.api.ContentInfo+json'],
    CURLOPT_HEADERFUNCTION => function($curl, $header) {
        if (!empty($cleanedHeader = trim($header))) {
            var_dump($cleanedHeader);
        }
        return strlen($header);
    },
    CURLOPT_RETURNTRANSFER => true,
]);
var_dump(json_decode(curl_exec($curl), true));
```

`$resource` URI should be edited to address the right domain.

On a freshly installed Ibexa DXP, `52` is the Content ID of the home page. If necessary, substitute `52` with the Content ID of an item from your database.

For a content creation example using PHP, see [Creating content with binary attachments](#creating-content-with-binary-attachments)

### JS

The REST API can help you implement JavaScript / AJAX interaction.
The following example of an AJAX call retrieves `ContentInfo` (that is, metadata) for a Content item:

To test it, copy-paste this code into your browser console alongside a page from your website (to share the domain):

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

On a freshly installed Ibexa DXP, `52` is the Content ID of the home page. If necessary, substitute `52` with the Content ID of an item from your database.

You can edit the `resource` URI to address another domain, but cross-origin requests must be allowed first.

## Cross-origin requests

[Cross-Origin Resource Sharing (CORS)](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing) can allow the REST API to be reached from a page on another domain.

!!! tip "More information about CORS"

    - [CORS' W3C specification](http://www.w3.org/TR/cors/)
    - [Overview of CORS on developer.mozilla.org](https://developer.mozilla.org/en-US/docs/HTTP/Access_control_CORS)

CORS support is provided by the third party [nelmio/cors-bundle](https://packagist.org/packages/nelmio/cors-bundle). You can read more about it in [NelmioCorsBundle's README](https://github.com/nelmio/NelmioCorsBundle/blob/master/README.md).

Using CORS is not limited to REST API resources and can be used for any resource of the platform.

### Configuration

To enable CORS, add regular expression for an allowed domain using the `.env` variable `CORS_ALLOW_ORIGIN`.

For example, to allow the JS test above to be executed alongside this page, you could add the following to an `.env` file (like the `.env.local`): `CORS_ALLOW_ORIGIN=^https?://doc.ibexa.co`.

To add several domains, filter on URIs, or change the default (like not allowing all the methods),
refer to [NelmioCorsBundle Configuration Documentation](https://github.com/nelmio/NelmioCorsBundle/blob/master/README.md#configuration)
to learn how to edit `config/packages/nelmio_cors.yaml`.

## REST communication summary

* A REST route (URI) leads to a REST controller action. A REST route is composed of the root prefix (`ibexa.rest.path_prefix: /api/ibexa/v2`) and a resource path (for example, `/content/objects/{contentId}`).
* This controller action returns an `Ibexa\Rest\Value` descendant.
  - This controller action might use the `Request` to build its result according to, for example, GET parameters, the `Accept` HTTP header, or the request payload and its `Content-Type` HTTP header.
  - This controller action might wrap its return in a `CachedValue` which contains caching information for the reverse proxies.
* The `Ibexa\Bundle\Rest\EventListener\ResponseListener` attached to the `kernel.view event` is triggered, and passes the request and the controller action's result to the `AcceptHeaderVisitorDispatcher`.
* The `AcceptHeaderVisitorDispatcher` matches one of the `regexps` of an `ibexa.rest.output.visitor` service (an `Ibexa\Contracts\Rest\Output\Visitor`). The role of this `Output\Visitor` is to transform the value returned by the controller into XML or JSON output format. To do so, it combines an `Output\Generator` corresponding to the output format and a `ValueObjectVisitorDispatcher`. This `Output\Generator` is also adding the `media-type` attributes.
* The matched `Output\Visitor` uses its `ValueObjectVisitorDispatcher` to select the right `ValueObjectVisitor` according to the fully qualified class name (FQCN) of the controller result. A `ValueObjectVisitor` is a service tagged `ibexa.rest.output.value_object.visitor` and this tag has a property `type` pointing a FQCN.
* `ValueObjectVisitor`s will recursively help to transform the controller result thanks to the abstraction layer of the `Generator`.
* The `Output\Visitor` returns the `Response` to send back to the client.
