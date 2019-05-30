# General REST usage


As explained in the [introduction](rest_api_guide.md), the REST API is based on a limited list of general principles:

-   each resource (URI) interacts with a part of the system (Content, URL aliases, User Groups, etc.),
-   for each resource, one or more HTTP methods are available, each having a different effect (DELETE a Content item, GET a URL Alias, GET a list of user groups, etc.),
-   media-type request headers indicate what kind of data type (Content / ContentInfo), and data format (JSON or XML), are expected as a response, and what can be requested.

## Anatomy of a REST call

### What we can learn from a GET request

This verb is used to query the API for information. It is one of the two operations web browsers implement, and the one most commonly used.

### Request

The only requirement for this verb is usually the resource URI, and the accept header. On top of that, cache request headers can be added, like `If-None-Match`, but those aren't fully implemented yet.

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
```

###### HTTP Code

The API responded here with a standard `200 OK` HTTP response code, which is the expected response code for a "normal" GET request. Some GET requests, like [getting a Content item's current version](https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/rest/REST-API-V2.rst#get-current-version), may reply with a `301 Moved permanently`, or `307 Temporary redirect` code.

Errors are indicated with HTTP error codes, like `404 Not Found`, or `500 Internal Server Error`. The [REST specifications](https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/rest/REST-API-V2.rst) provide the list of every HTTP response code you can expect from implemented resources.

###### Content-Type header

As long as a response contains an actual HTTP body, the Content Type header will be used to specify which Content Type is contained in the response. In that case:
- a ContentInfo: `Content-Type: application/vnd.ez.api.ContentInfo`
- a ContentInfo in XML format: `Content-Type: application/vnd.ez.api.ContentInfo+xml`

###### Accept-Patch header

It tells you that the received content can be modified by patching it with a [ContentUpdateStruct](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/ContentUpdateStruct.php) in XML format:

 `Accept-Patch: application/vnd.ez.api.ContentUpdate+xml;charset=utf8`

JSON would also work, with the proper format.

Above example shows that sending a PATCH `/content/objects/23` request with a [ContentUpdateStruct](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/ContentUpdateStruct.php) XML payload, will update this Content.

REST will use the `Accept-Patch` header to indicate how to **modify** the returned **data**.

###### Location header

Depending on the resource, request and response headers will vary. For instance:
 - [creating Content](https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/rest/REST-API-V2.rst#creating-content), or
 - [getting a Content item's current version](https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/rest/REST-API-V2.rst#get-current-version)

 will both send a **Location header** to provide you with the requested resource's ID.

Those particular headers generally match a specific list of HTTP response codes. Location is sent by `201 Created`, `301 Moved permanently`, `307 Temporary redirect responses`, etc. You can expect those HTTP responses to provide you with a Location header.

###### Destination header

This request header is the request counterpart of the Location response header. It is used in a COPY / MOVE operation, like [copying a Content item](https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/rest/REST-API-V2.rst#copy-content), on a resource to indicate where the resource should be moved to, using the ID of the destination.

#### Response body

Load ContentInfo response body, expand source:

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

The XML body is a serialized version of a [ContentInfo](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/ContentInfo.php) struct. Most REST API calls will involve exchanging XML / JSON representations of the public API.

The above example shows that Content item 23 can be modified by sending a `vendor/application/vnd.ez.ContentUpdate+xml`. This media type again matches a Value in the API, [ContentUpdateStruct](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/ContentUpdateStruct.php).

The REST API data structs mostly match a PHP Public API value object

#### Value objects representation

Value objects like [ContentInfo](https://github.com/ezsystems/ezp-next/blob/master/eZ/Publish/API/Repository/Values/Content/ContentInfo.php) feature two types of fields: basic, local fields (e.g. currentVersionNo, name) and foreign field(s) references (e.g. sectionId, mainLocationId).

Local fields will be represented in XML / JSON format with a primitive type (integer, string), while foreign key references will be represented as a link to another resource. This resource will be identified with its URI (`/content/objects/23/locations`), and the media-type that should be requested when calling that resource (`media-type="application/vnd.ez.api.LocationList+xml"`). Depending on how much data you need, you may choose to crawl those relations, or to ignore them.

##### XSD files

For each XML structure known to the REST API, you can find [XSD files](https://github.com/ezsystems/ezpublish-kernel/tree/master/doc/specifications/rest/xsd) in the XSD folder of the specifications. Those will allow you to validate your XML, and learn about every option those XML structures feature.

## Request parameters

Responses depend on:

-   The URI,
-   Request headers, like the Accept one.

URI parameters are of course also used. They usually serve as filters / options for the requested resource. For instance, they can be used to customize a list's offset/limit. To filter a list, specify which fields you want from a content etc. For almost all resources, those parameters must be provided as GET ones. Below request would return the 5 first relations for Version 2 of Content 59:

**GET request with limit parameter**

```
GET /content/objects/59/versions/2/relations&limit=5 HTTP/1.1
Accept: application/vnd.ez.api.RelationList+xml
```

**Working with value objects IDs**

Resources that accept a reference to another resource expect reference to be given as a REST ID, not a Public API ID. For example, the URI requesting list of users assigned to the role with ID 1 is:

`GET /api/ezp/v2/user/users?roleId=/api/ezp/v2/user/roles/1`

## Custom HTTP verbs

In addition to the usual GET, POST, PUT and DELETE HTTP verbs, the API supports a few custom ones: COPY, [MOVE](http://tools.ietf.org/html/rfc2518), [PATCH](http://tools.ietf.org/html/rfc5789) and PUBLISH. They should be recognized by most HTTP servers but there might be some that fail to recognize custom methods. If you face this situation, you can customize a standard verb (POST, PUT) with the `X-HTTP-Method-Override` header.

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

The REST API supports two authentication methods:

-   **Session-based authentication** is meant to be used for AJAX operations. It will let you re-use the visitor's session to execute operations with their permissions.
-   **Basic authentication** is often used when writing cross-server procedures, when one remote application executes operations on one/several eZ Platform instances (remote publishing, maintenance, etc).

Session-based is the default authentication method, as this is needed for UI.

### Session based authentication

This authentication method requires a Session cookie to be sent with each request.

If this authentication method is used with a web browser, this session cookie is automatically available as soon as your visitor logs in. Add it as a cookie to your REST requests, and the user will be authenticated.

#### Logging in

It is also possible to create a session for the visitor if they aren't logged in yet. This is done by sending a **`POST`** request to `/user/sessions`. Logging out is done using a **`DELETE`** request on the same resource.

**XML Example (session's creation)**

```
POST /user/sessions HTTP/1.1
Host: www.example.net
Accept: application/vnd.ez.api.Session+xml
Content-Type: application/vnd.ez.api.SessionInput+xml
```

```xml
<?xml version="1.0" encoding="UTF-8"?>
<SessionInput>
  <login>admin</login>
  <password>secret</password>
</SessionInput>
```

```
HTTP/1.1 201 Created
Location: /user/sessions/go327ij2cirpo59pb6rrv2a4el2
Set-Cookie: eZSSID=go327ij2cirpo59pb6rrv2a4el2; domain=.example.net; path=/; expires=Wed, 13-Jan-2021 22:23:01 GMT; HttpOnly
Content-Type: application/vnd.ez.api.Session+xml
```

```xml
<?xml version="1.0" encoding="UTF-8"?>
<Session href="/user/sessions/sessionID" media-type="application/vnd.ez.api.Session+xml">
  <name>eZSSID</name>
  <identifier>go327ij2cirpo59pb6rrv2a4el2</identifier>
  <csrfToken>23lkneri34ijajedfw39orj3j93</csrfToken>
  <User href="/user/users/14" media-type="vnd.ez.api.User+xml"/>
</Session>
```

**XML Example (logging in with active session)**

```
POST /user/sessions HTTP/1.1
Host: www.example.net
Accept: application/vnd.ez.api.Session+xml
Content-Type: application/vnd.ez.api.SessionInput+xml
Cookie: eZSSID=go327ij2cirpo59pb6rrv2a4el2
X-CSRF-Token: 23lkneri34ijajedfw39orj3j93
```

```xml
<?xml version="1.0" encoding="UTF-8"?>
<SessionInput>
  <login>admin</login>
  <password>secret</password>
</SessionInput>
```

```
HTTP/1.1 200 OK
Content-Type: application/vnd.ez.api.Session+xml
```

```xml
<?xml version="1.0" encoding="UTF-8"?>
<Session href="user/sessions/go327ij2cirpo59pb6rrv2a4el2/refresh" media-type="application/vnd.ez.api.Session+xml">
  <name>eZSSID</name>
  <identifier>go327ij2cirpo59pb6rrv2a4el2</identifier>
  <csrfToken>23lkneri34ijajedfw39orj3j93</csrfToken>
  <User href="/user/users/14" media-type="vnd.ez.api.User+xml"/>
</Session>
```

`csrfToken` is returned in the login response. It is important to keep the CSRF Token for the duration of the session as it needs to be sent with requests other than GET/HEAD when auth is set to session (in most cases it is).

More information can be found in [Session-based authentication chapter of the REST specifications](https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/rest/REST-API-V2.rst#session-based-authentication)

### HTTP Basic authentication

To enable HTTP basic authentication, you need to edit `app/config/security.yml`, and add/uncomment the following block. Note that this is enabled by default.

!!! caution

    Until [EZP-22192](https://jira.ez.no/browse/EZP-22192) is implemented, enabling basic authentication in REST will prevent PlatformUI from working.

**ezplatform.yml**

``` yaml
ezpublish_rest:
    pattern: ^/api/ezp/v2
    stateless: true
    ezpublish_http_basic:
        realm: eZ Publish REST API
```

Basic authentication requires the username and password to be sent *(username:password)*, based 64 encoded, with each request, as explained in [RFC 2617](http://tools.ietf.org/html/rfc2617).

Most HTTP client libraries as well as REST libraries support this method.

**Raw HTTP request with basic authentication**

```
GET / HTTP/1.1
Host: api.example.com
Accept: application/vnd.ez.api.Root+json
Authorization: Basic QWxhZGRpbjpvcGVuIHNlc2FtZQ==
```

### Error handling

Error handling in the REST API is fully based on HTTP error codes. As a web developer, you are probably familiar with the most common ones: `401 Unauthorized`, `404 Not Found` or `500 Internal Server Error`. The REST API uses those, along with a few more, to allow proper error handling.

The complete list of error codes used and the conditions in which they apply are specified in the [reference documentation](https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/rest/REST-API-V2.rst).

### General error codes

A few error codes apply to most resources (if they *are* applicable)

#### 500 Internal Server Error

The server encountered an unexpected condition, usually an exception, which prevented it from fulfilling the request: database down, permissions or configuration error.

#### 501 Not Implemented

Returned when the requested method has not yet been implemented. For eZ Platform, most of Users, User groups, Content items, Locations and Content Types have been implemented. Some of their methods, as well as other features, may return a 501.

#### 404 Not Found

Returned when the request failed because the request object was not found.

#### 405 Method Not Allowed

Returned when the requested REST API resource doesn't support the HTTP verb that was used.

#### 406 Not Acceptable

Returned when an accept header sent with the requested isn't supported.

#### Error handling in your REST implementation

It depends on your client implementation, to handle those codes by checking if an error code (4xx or 5xx) was returned instead of the expected 2xx or 3xx.

## REST API Countries list

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

**Countries list response headers**

```
HTTP/1.1 200
Content-Type: application/vnd.ez.api.CountriesList+xml
```

The HTTP response is a `200 OK` header and XML formatted country list with names and codes according to the ISO-3166 standard body. 

**ISO-3166 standard**

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
