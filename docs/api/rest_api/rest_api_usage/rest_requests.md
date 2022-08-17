---
description: REST API requests can have a generic or a custom header. It defines additional options in the request, such as the accepted Content Type of response.
---

# REST requests

## Request method

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
For method action details per resource, see the [REST API reference](../rest_api_reference/rest_api_reference.html).

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

### OPTIONS method

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

## Request headers

You can use the following HTTP headers with a REST request:

- [`Accept`](https://tools.ietf.org/html/rfc2616#section-14.1) describing the desired response type and format;
- [`Content-Type`](https://toos.ietf.org/html/rfc2616#section-14.17) describing the payload type and format;
- [`X-Siteaccess`](#siteaccess) specifying the target SiteAccess;
- `X-HTTP-Method-Override` allowing to pass a custom method while using `POST` method as previously seen in [HTTP method](#request-method).
- [`Destination`](#destination) specifying where to move an item

Other headers related to authentication methods can be found in [REST API authentication](rest_api_authentication.md).

### SiteAccess

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

### Media types

On top of methods, HTTP request headers allow you to personalize the request's behavior.
On every resource, you can use the `Accept` header to indicate which format you want to communicate in, JSON or XML.
This header is also used to specify the response type you want the server to send when multiple types are available.

-   `Accept: application/vnd.ibexa.api.Content+xml` to get `Content` (full data, Fields included) as **[XML](http://www.w3.org/XML/)**
-   `Accept: application/vnd.ibexa.api.ContentInfo+json` to get `ContentInfo` (metadata only) as **[JSON](http://www.json.org/)**

Media types are also used with the [`Content-Type` header](rest_responses.md#content-type-header) to characterize a [request body](#request-body) or a [response body](rest_responses.md#response-body).
See [Creating content with binary attachments](#creating-content-with-binary-attachments) below.
Also see [Creating session](rest_api_authentication.md#creating-session) examples.

If the resource only returns one media type, it is also possible to skip it and to just specify the format using `application/xml` or `application/json`.

A response indicates `href`s to related resources and their media types.

### Destination

The `Destination` request header is the request counterpart of the `Location` response header.
It is used for a `COPY`, `MOVE` or `SWAP` operation to indicate where the resource should be moved, copied to or swapped with by using the ID of the parent or target Location.

Examples of such requests are:

- [copying a Content](../rest_api_reference/rest_api_reference.html#managing-content-copy-content);
- [moving a Location and its subtree](../rest_api_reference/rest_api_reference.html#managing-content-move-subtree)
- [swapping a Location with another](../rest_api_reference/rest_api_reference.html#managing-content-swap-location)

## Request body

You can pass some short scalar parameters in the URIs or as GET parameters, but other resources need heavier structured payloads passed in the request body,
in particular the ones to create (`POST`) or update (`PATCH`) items.
In the [REST API reference](../rest_api_reference/rest_api_reference.html), request payload examples are given when needed.

One example is the [creation of an authentication session](rest_api_authentication.md#establishing-a-session).

When creating a Content item, a special payload is needed if the ContentType has some [Image](imagefield.md) or [BinaryFile](binaryfilefield.md) Fields as files need to be attached. See the example of a [script uploading images](#creating-content-with-binary-attachments) below.

When searching for Content items (or Locations), the query grammar is also particular. See the [Search section](#search-view) below.

### Creating content with binary attachments

The example below is a command-line script to upload images.

This script:

- receives an image path and optionally a name as command-line arguments,
- uses the [HTTP basic authentication](rest_api_authentication.md#http-basic-authentication), if it is enabled,
- creates a draft in the /Media/Images folder by posting (`POST`) data to [`/content/objects`](../rest_api_reference/rest_api_reference.html#managing-content-create-content-item),
- and, publishes (`PUBLISH`) the draft through [`/content/objects/{contentId}/versions/{versionNo}`](../rest_api_reference/rest_api_reference.html#managing-content-publish-a-content-version).

=== "XML"

    ``` php
    [[= include_file('code_samples/api/rest_api/create_image.xml.php', 0, None, '    ') =]]
    ```

=== "JSON"

    ``` php
    [[= include_file('code_samples/api/rest_api/create_image.json.php', 0, None, '    ') =]]
    ```

### Search (`/views`)

The `/views` route allows you to [search in the repository](search.md). It works similarly to its [PHP API counterpart](search_api.md).

The model allows combining criteria using the logical operators `AND`, `OR` and `NOT`.

Almost all [Search Criteria](search_criteria_reference.md#search-criteria) are available in REST API. The suffix `Criterion` is added when used with REST API.

Almost all [Sort Clauses](sort_clause_reference.md#sort-clauses) are available too. They require no additional prefix or suffix.

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
