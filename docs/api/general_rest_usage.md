# General REST usage


As explained in the [introduction](rest_api_guide.md), the REST API is based on a very limited list of general principles:

-   each resource (uri) interacts with a part of the system (Content, URL aliases, User Groups, etc.),
-   for each resource, one or more verbs are available, each having a different effect (delete a Content item, get a URL Alias, list user groups, etc.),
-   media-type request headers indicate what type of data (Content / ContentInfo), and data format (JSON or XML), are expected as a response, and what can be requested.

## Anatomy of a REST call

### What we can learn from a GET request

This verb is used to query the API for information. It is one of the two operations web browsers implement, and the one most commonly used.

### Request

The only requirement for this verb is usually the resource URI, and the accept header. On top of that, cache request headers can be added, like `If-None-Match`, but those aren't fully implemented yet in eZ Publish 5.0.

**Load ContentInfo request**

```
GET /content/objects/23 HTTP/1.1
Accept: application/vnd.ez.api.ContentInfo+xml
```

#### Response headers

The API will reply with:

-   an **HTTP response code**,
-   a few **headers**,
-   the XML representation of the ContentInfo for content with ID 23 in XML format, as specified in the Accept header.

**Load ContentInfo response**

```
HTTP/1.1 200 OK
Accept-Patch: application/vnd.ez.api.ContentUpdate+xml;charset=utf8
Content-Type: application/vnd.ez.api.ContentInfo+xml
Content-Length: xxx
```

The length of our content, provided by the Content-Length header, isn't *that* useful.

###### HTTP Code

The API responded here with a standard 200 OK HTTP response code, which is the expected response code for a "normal" GET request. Some GET requests, like [getting a Content item's current version](https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/rest/REST-API-V2.rst#13241%C2%A0%C2%A0%C2%A0get-current-version), may reply with a 301 Moved permanently, or 307 Temporary redirect code.

Errors will be indicated with HTTP error codes, like 404 for Not Found, or 500 for Internal server error. The [REST specifications](https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/rest/REST-API-V2.rst) provide the list of every HTTP response code you can expect from implemented resources.

###### Content-Type header

As long as a response contains an actual HTTP body, the Content-Type header will be used to specify which Content-Type is contained in the response. In that case, a ContentInfo (`Content-Type: application/vnd.ez.api.ContentInfo`) in XML (`Content-Type: application/vnd.ez.api.ContentInfo+xml`)

###### Accept-Patch header

This is a very interesting one.

It tells us we can modify the received content by patching (`Accept-Patch: application/vnd.ez.api.ContentUpdate+xml;charset=utf8`) it with a [ContentUpdateStruct](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/ContentUpdateStruct.php) (`Accept-Patch: application/vnd.ez.api.ContentUpdate+xml;charset=utf8`) in XML (`Accept-Patch: application/vnd.ez.api.ContentUpdate+xml;charset=utf8`) format. Of course, JSON would also work, with the proper format.

This last part means that if we send a PATCH /content/objects/23 request with a [ContentUpdateStruct](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/ContentUpdateStruct.php) XML payload, we will update this Content.

REST will use the `Accept-Patch` header to indicate how to **modify** the returned **data**.

###### Other headers: Location

Depending on the resource, request & response headers will vary. For instance, [creating content](https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/rest/REST-API-V2.rst#13231%C2%A0%C2%A0%C2%A0creating-content), or [getting a Content item's current version](https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/rest/REST-API-V2.rst#13241%C2%A0%C2%A0%C2%A0get-current-version) will both send a `Location` header to provide you with the requested resource's ID.

Those particular headers generally match a specific list of HTTP response codes. Location is sent by `201 Created`, `301 Moved permanently,` `307 Temporary redirect responses`. This list isn't finished, but you can expect those HTTP responses to provide you with a Location header.

###### Other headers: Destination

This request header is the request counterpart of the Location response header. It is used in a COPY / MOVE operation, like [copying a Content item](https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/rest/REST-API-V2.rst#13236%C2%A0%C2%A0%C2%A0copy-content), on a resource to indicate where the resource should be moved to, using the ID of the destination.

#### Response body

**Load ContentInfo response body**  Expand source

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<Content href="/content/objects/23" id="23"
  media-type="application/vnd.ez.api.Content+xml" remoteId="qwert123">
  <ContentType href="/content/types/10" media-type="application/vnd.ez.api.ContentType+xml" />
  <Name>This is a title</Name>
  <Versions href="/content/objects/23/versions" media-type="application/vnd.ez.api.VersionList+xml" />
  <CurrentVersion href="/content/objects/23/currentversion"
    media-type="application/vnd.ez.api.Version+xml"/>
  <Section href="/content/sections/4" media-type="application/vnd.ez.api.Section+xml" />
  <MainLocation href="/content/locations/1/4/65" media-type="application/vnd.ez.api.Location+xml" />
  <Locations href="/content/objects/23/locations" media-type="application/vnd.ez.api.LocationList+xml" />
  <Owner href="/user/users/14" media-type="application/vnd.ez.api.User+xml" />
  <lastModificationDate>2012-02-12T12:30:00</lastModificationDate>
  <publishedDate>2012-02-12T15:30:00</publishedDate>
  <mainLanguageCode>eng-US</mainLanguageCode>
  <alwaysAvailable>true</alwaysAvailable>
</Content>
```

The XML body is a serialized version of a [ContentInfo](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/ContentInfo.php) struct. Most REST API calls will actually involve exchanging XML / JSON representations of the public API. This consistency, which we took very seriously, was a hard requirement for us, as it makes documentation much better by requiring *less* of it.

As explained above, the API has told us that we could modify content object 23 by sending a `vendor/application/vnd.ez.ContentUpdate+xml`. This media type again matches a Value in the API, [ContentUpdateStruct](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/ContentUpdateStruct.php).

The REST API data structs mostly match a PHP Public API value object

#### Value objects representation

Value objects like [ContentInfo](https://github.com/ezsystems/ezp-next/blob/master/eZ/Publish/API/Repository/Values/Content/ContentInfo.php) basically feature two types of fields: basic, local fields (modified, name...) and foreign field(s) references (sectionId, mainLocationId).

Local fields will be represented in XML / JSON with a primitive type (integer, string), while foreign key references will be represented as a link to another resource. This resource will be identified with its URI (`/content/objects/23/locations`), and the media-type that should be requested when calling that resource (`media-type="application/vnd.ez.api.LocationList+xml"`). Depending on how much data you need, you may choose to crawl those relations, or to ignore them.

XSD files

For each XML structure known to the REST API, you can find XSD files in the XSD folder of the specifications. Those will allow you to validate your XML, and learn about every option those XML structures feature.

<https://github.com/ezsystems/ezpublish-kernel/tree/master/doc/specifications/rest/xsd>

## Request parameters

So far, we have seen that responses will depend on:

-   The URI,
-   Request headers, like the Accept one

URI parameters are of course also used. They usually serve as filters / options for the requested resource. For instance, they can be used to customize a list's offset/limit, to filter a list, specify which fields you want from a content... For almost all resources, those parameters must be provided as GET ones. This request would return the 5 first relations for Version 2 of Content 59:

**GET request with limit parameter**

```
GET /content/objects/59/versions/2/relations&limit=5 HTTP/1.1
Accept: application/vnd.ez.api.RelationList+xml
```

Working with value objects IDs

Resources that accept a reference to another resource expect this reference to be given as a REST ID, not a Public API ID. As such, the URI to request users that are assigned the role with ID 1 would be `GET /api/ezp/v2/user/users?roleId=/api/ezp/v2/user/roles/1`.

## Custom HTTP verbs

In addition to the usual GET, POST, PUT and DELETE HTTP verbs, the API supports a few custom ones: COPY, MOVE (<http://tools.ietf.org/html/rfc2518>), PATCH (<http://tools.ietf.org/html/rfc5789>) and PUBLISH. While it should generally not be a problem, some HTTP servers may fail to recognize those. If you face this situation, you can customize a standard verb (POST, PUT) with the `X-HTTP-Method-Override` header.

**PATCH HTTP request**

```
POST /content/objects/59 HTTP/1.1
X-HTTP-Method-Override: PATCH
```

Both methods are always mentioned, when applicable, in the specifications.

## Specifying a siteaccess

One of the principles of REST is that the same resource (Content, Location, ContentType, etc.) should be unique. The purpose is mostly to make it simple to cache your REST API using a reverse proxy like Varnish. If the same resource is available at multiple locations, cache purging becomes much more complex.

Due to this, we decided not to enable siteaccess matching with REST. In order to specify a siteaccess when talking to the REST API, a custom header, `X-Siteaccess`, needs to be provided. If it isn't, the default one will be used:



**X-Siteaccess header example**

```
GET / HTTP/1.1
Host: api.example.com
Accept: application/vnd.ez.api.Root+json
X-Siteaccess: ezdemo_site_admin
```

## REST API Authentication

The REST API supports two authentication methods: session, and basic. 

-   **Session-based authentication** is meant to be used for AJAX operations. It will let you re-use the visitor's session to execute operations with their permissions.
-   **Basic authentication** is often used when writing cross-server procedures, when one remote application executes operations on one/several eZ Platform instances (remote publishing, maintenance, etc).

Session-based is the default authentication method, as this is needed for UI.

### Session based authentication

This authentication method requires a Session cookie to be sent with each request.

If this authentication method is used with a web browser, this session cookie is automatically available as soon as your visitor logs in. Add it as a cookie to your REST requests, and the user will be authenticated.

#### Logging in

It is also possible to create a session for the visitor if they aren't logged in yet. This is done by sending a **`POST`** request to `/user/sessions`. Logging out is done using a **`DELETE`** request on the same resource.

More information

[Session-based authentication chapter of the REST specifications](https://github.com/ezsystems/ezp-next/blob/master/doc/specifications/rest/REST-API-V2.rst#123%C2%A0%C2%A0%C2%A0session-based-authentication)

### HTTP Basic authentication

To enable HTTP Basic authentication, you need to edit app`/config/security.yml`, and add/uncomment the following block. Note that this is enabled by default.

**ezplatform.yml**

``` yaml
        ezpublish_rest:
            pattern: ^/api/ezp/v2
            stateless: true
            ezpublish_http_basic:
                realm: eZ Publish REST API
```

Basic authentication requires the username and password to be sent *(username:password)*, based 64 encoded, with each request, as explained in [RFC 2617](http://tools.ietf.org/html/rfc2617).

Most HTTP client libraries as well as REST libraries do support this method one way or another.

**Raw HTTP request with basic authentication**

```
GET / HTTP/1.1
Host: api.example.com
Accept: application/vnd.ez.api.Root+json
Authorization: Basic QWxhZGRpbjpvcGVuIHNlc2FtZQ==
```

### Error handling

Error handling in the REST API is fully based on HTTP error codes. As a web developer, you are probably familiar with the most common ones: 401 Unauthorized, 404 Not Found or 500 Internal Server Error. The REST API uses those, along with a few more, to allow proper error handling.

The complete list of error codes used and the conditions in which they apply are specified in the [reference documentation](https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/rest/REST-API-V2.rst).

### General error codes

A few error codes apply to most resources (if they *are* applicable)

#### 500 Internal Server Error

The server encountered an unexpected condition, usually an exception, which prevented it from fulfilling the request: database down, permissions or configuration error.

#### 501 Not Implemented

Returned when the requested method has not yet been implemented. As of eZ Publish 5.0, most of User, User group, Content, Location and Content Type have been implemented. Some of their methods, as well as other features, may return a 501.

#### 404 Not Found

Returned when the request failed because the request object was not found. You should be familiar with this one.

#### 405 Method Not Allowed

Returned when the requested REST API resource doesn't support the HTTP verb that was used.

#### 406 Not Acceptable

Returned when an accept header sent with the requested isn't supported.

### Error handling in your REST implementation

It is up to you, in your client implementation, to handle those codes by checking if an error code (4xx or 5xx) was returned instead of the expected 2xx or 3xx.

### REST API Countries list


Countries list is a REST service that gives access to an [ISO-3166](http://en.wikipedia.org/wiki/ISO_3166) formatted list of world countries. It is useful when presenting a country options list from any application.

### Get the list of countries

To send a GET request to the REST API Countries list, you have to provide the Content Type header `application/vnd.ez.api.CountriesList+xml`.

**Countries list request**

```
Resource: /api/ezp/v2/services/countries
Method: GET
Content-Type: application/vnd.ez.api.CountriesList+xml
```

#### Usage example

**Countries list request**

```
GET /api/ezp/v2/services/countries
Host: example.com
Accept: application/vnd.ez.api.CountriesList+xml
```

The HTTP response will it be with a 200 OK Header.

**Countries list response headers**

```
HTTP/1.1 200
Content-Type: application/vnd.ez.api.CountriesList+xml
```

And the body of the Response is XML formatted country list with names and codes according to the ISO-3166 standard. 

ISO-3166

The **country codes** can be represented either as a two-letter code (alpha-2) which is recommended as the general purpose code, a three-letter code (alpha-3) which is more closely related to the country name and a three digit numeric code (numeric-3) which can be useful if you need to avoid using Latin script.

See [the ISO-3166 glossary](http://www.iso.org/iso/home/standards/country_codes/country_codes_glossary.htm) for more information.


**Body XML Response**

``` xml
<CountriesList>
  <Country id="AF">
    <name>Afghanistan</name
    <alpha2>AF</alpha2>
    <alpha3>AFG</alpha3>
    <idc>93</idc>
  </Country>
  <Country id="AX">
    <name>Åland</name
    <alpha2>AX</alpha2>
    <alpha3>ALA</alpha3>
    <idc>358</idc>
  </Country>
  ...
</CountriesList>
```

 
