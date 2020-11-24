# General REST usage

As explained in the [introduction](rest_api_guide.md), the REST API is based on a limited list of general principles:

- Each resource (URI) interacts with a part of the system (content, URL aliases, User Groups, etc.).
- For each resource, one or more HTTP methods are available. Each method has a different effect (DELETE a Content item, GET a URL Alias, GET a list of user groups, etc.).
- Media-type request headers indicate what kind of data type (Content / ContentInfo) and data format (JSON or XML) are expected as a response, and what can be requested.

## Anatomy of REST call

### GET request

The GET request is used to query the API for information. It is one of the two operations web browsers implement, and the one most commonly used.

### Request

The only requirement for this verb is usually the resource URI and the accept header.
On top of that, cache request headers can be added, like `If-None-Match`, but those are not fully implemented yet.

**Load ContentInfo request**

```
GET /content/objects/23 HTTP/1.1
Accept: application/vnd.ez.api.ContentInfo+xml
```

#### Response headers

The API response contains:

- HTTP response code
- headers
- XML representation of the ContentInfo for content with ID 23 in XML format as specified in the Accept header

**Load ContentInfo response**

```
HTTP/1.1 200 OK
Accept-Patch: application/vnd.ez.api.ContentUpdate+xml;charset=utf8
Content-Type: application/vnd.ez.api.ContentInfo+xml
```

###### HTTP code

The API responded here with a standard `200 OK` HTTP response code, which is the expected response code for a typical GET request.
Some GET requests, like [getting a Content item's current version,](https://ezsystems.github.io/ezplatform-rest-reference/#managing-content-get-current-version) may return a `301 Moved permanently` or `307 Temporary redirect` code.

Errors are indicated with HTTP error codes, e.g. `404 Not Found` or `500 Internal Server Error`.
The [REST reference](https://doc.ezplatform.com/rest-api-reference) provide the list of every HTTP response code you can expect from implemented resources.

###### Content-Type header

As long as a response contains an actual HTTP body, the Content Type header will be used to specify which Content Type is contained in the response. In that case:

- ContentInfo: `Content-Type: application/vnd.ez.api.ContentInfo`
- ContentInfo in XML format: `Content-Type: application/vnd.ez.api.ContentInfo+xml`

###### Accept-Patch header

It tells you that the received content can be modified by patching it with a [ContentUpdateStruct](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/ContentUpdateStruct.php) in XML format:

 `Accept-Patch: application/vnd.ez.api.ContentUpdate+xml;charset=utf8`

JSON would also work, with the proper format.

As the example above shows, sending a PATCH `/content/objects/23` request with a [ContentUpdateStruct](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/ContentUpdateStruct.php) XML payload will update this content.

REST will use the `Accept-Patch` header to indicate how to **modify** the returned **data**.

###### Location header

Depending on the resource, request and response headers will vary.

For instance [creating Content](https://ezsystems.github.io/ezplatform-rest-reference/#managing-content-create-content-type) and [getting a Content item's current version](https://ezsystems.github.io/ezplatform-rest-reference/#managing-content-get-current-version)
will both send a **Location header** to provide you with the requested resource's ID.

Those particular headers generally match a specific list of HTTP response codes.
Location is sent by `201 Created`, `301 Moved permanently`, `307 Temporary redirect responses`, etc. You can expect these HTTP responses to provide you with a Location header.

###### Destination header

This request header is the request counterpart of the Location response header.
It is used for a COPY or MOVE operation on a resource to indicate where the resource should be moved to by using the ID of the destination.
An example of such a request is [copying a Content item](https://ezsystems.github.io/ezplatform-rest-reference/#managing-content-copy-content).

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

The XML body is a serialized version of a [ContentInfo](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/ContentInfo.php) struct.
Most of the REST API calls will involve exchanging XML or JSON representations of the public API.

The example above shows that Content item 23 can be modified by sending a `vendor/application/vnd.ez.ContentUpdate+xml`.
This media type again matches a Value in the API, [ContentUpdateStruct](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/ContentUpdateStruct.php).

The REST API data structs mostly match a PHP Public API value object.

#### Value objects representation

Value objects like [ContentInfo](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/ContentInfo.php) feature two types of fields: 

- local fields (e.g. currentVersionNo, name)
- foreign field(s) references (e.g. sectionId, mainLocationId)

Local fields will be represented in XML / JSON format with a plain type (integer, string), while foreign key references will be represented as a link to another resource.
This resource will be identified with its URI (`/content/objects/23/locations`) and the media-type that should be requested when calling that resource (`media-type="application/vnd.ez.api.LocationList+xml"`).
Depending on how much data you need, you may choose to crawl those relations or to ignore them.

##### XSD files

For each XML structure known to the REST API, you can find [XSD files](https://github.com/ezsystems/ezpublish-kernel/tree/master/doc/specifications/rest/xsd) in the XSD folder of the specifications.
They will allow you to validate your XML and to learn about every option these XML structures feature.

## Request parameters

Responses depend on:

- URI
- request headers (e.g. ACCEPT)

The URI parameters are used as well.
They usually serve as filters / options for the requested resource.
For instance, they can be used to customize a list's offset/limit.
To filter a list, specify which fields you want from a content, etc.
For almost all resources, these parameters must be provided as GET. 

The example request below would return the first 5 relations for version 3 of the Content item 59:

**GET request with limit parameter**

```
GET /content/objects/59/versions/3/relations&limit=5 HTTP/1.1
Accept: application/vnd.ez.api.RelationList+xml
```

### Working with value objects IDs

Resources that accept a reference to another resource expect reference to be given as a REST ID, not as a Public API ID.
For example, the URI requesting a list of users assigned to the role with ID 1 is:

```
GET /api/ezp/v2/user/users?roleId=/api/ezp/v2/user/roles/1
```

## Custom HTTP verbs

In addition to the usual GET, POST, PUT, and DELETE HTTP verbs, the API supports a few custom ones: 

- COPY
- [MOVE](http://tools.ietf.org/html/rfc2518)
- [PATCH](http://tools.ietf.org/html/rfc5789)
- PUBLISH

They should be recognized by most of the HTTP servers. 
If the server does not recognize the custom methods you use, you can customize a standard verb (e.g. POST or PUT) with the `X-HTTP-Method-Override` header.

**PATCH HTTP request**

```
POST /content/objects/59 HTTP/1.1
X-HTTP-Method-Override: PATCH
```

If applicable, both methods are always mentioned in the specifications.

### Logical operators

When performing search endpoint (`/views`), the criteria model allows combining criteria using the following logical operators:

- `AND`
- `OR`
- `NOT`

By default, if multiple criteria are given, but not wrapped by any operator, the `AND` operator is used.

When using the same criterion for multiple times, the parser wraps it with the `OR` operator.
Note that making the `AND` query for different values of the same criterion type always returns zero results.

**Logical operators XML example**

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<ViewInput>
  <identifier>test</identifier>
  <ContentQuery>
    <Filter>
        <AND>
            <OR>
                <ContentTypeIdentifierCriterion>folder</ContentTypeIdentifierCriterion>
                <ContentTypeIdentifierCriterion>article</ContentTypeIdentifierCriterion>
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

**Logical operators JSON example**

``` json
{
  "ViewInput": {
    "identifier": "test",
    "ContentQuery": {
      "Filter": {
        "AND": {
          "OR": {
            "ContentTypeIdentifierCriterion": [
              "folder",
              "article"
            ]
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

    The structure for `ContentTypeIdentifierCriterion` with multiple values is slightly
    different in JSON format, because the parser expects keys to be unique.

## Specifying SiteAccess

One of the principles of REST is that the same resource (Content item, Location, Content Type, etc.) should be unique.
It allows caching your REST API using a reverse proxy like Varnish.
If the same resource is available in multiple locations, cache purging is noticeably more complex.

Consequently, SiteAccess matching with REST is not enabled.
In order to specify a SiteAccess when talking to the REST API, a custom `X-Siteaccess` header has to be provided. If not, the default one is used:

**X-Siteaccess header example**

```
GET / HTTP/1.1
Host: api.example.com
Accept: application/vnd.ez.api.Root+json
X-Siteaccess: ezdemo_site_admin
```

## REST API authentication

The REST API supports the following authentication methods:

- **Session-based authentication** for AJAX operations that lets you re-use the visitor's session to execute operations with their permissions.
- **Basic authentication** for writing cross-server procedures, when one remote application executes operations on one/several [[= product_name =]] instances (remote publishing, maintenance, etc).
- [**JWT authentication**](#jwt-authentication)

Session-based is the default authentication method as it is needed for UI.

!!! note "Limiting anonymous access to metadata over REST API"
    
    Some API endpoints accessible to the Anonymous User return metadata you might not want to expose, due to insufficient permission limitations.
    To prevent that, you can rely on the Symfony securing URL patterns mechanism called [access_control](https://symfony.com/doc/3.4/security/access_control.html).
    The example below shows you how to block listing Content Types for the non-authenticated users.
    
    **security.yml**
    ``` yaml
    security:
        access_control:
            - { path: '^/api/ezp/v2/content/types', roles: ROLE_USER }
    ```

### Session-based authentication

This authentication method requires a Session cookie to be sent with each request.

If this authentication method is used with a web browser, this session cookie is automatically available as soon as your visitor logs in.
Add it as a cookie to your REST requests, and the user will be authenticated.

#### Logging in

You can create a session for a visitor even if they are not logged in by sending the **`POST`** request to `/user/sessions`.
For logging out, use the **`DELETE`** request on the same resource.

**Creating session — XML example**

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

**Logging in with active session — XML example**

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

The `csrfToken` is returned in the login response.
It is important to keep the CSRF Token for the duration of the session as it needs to be sent with requests other than GET/HEAD when auth is set to session (in most cases it is).

For details, see [Session-based authentication](https://github.com/ezsystems/ezpublish-kernel/blob/v8.0.0-beta5/doc/specifications/rest/REST-API-V2.rst#session-based-authentication) in the REST specifications.

### HTTP basic authentication

To enable HTTP basic authentication, edit `config/packages/security.yaml`, and add/uncomment the following block. Note that this is enabled by default.

!!! caution

    Until [EZP-22192](https://jira.ez.no/browse/EZP-22192) is implemented, enabling basic authentication in REST will prevent PlatformUI from working.

``` yaml
ezpublish_rest:
    pattern: ^/api/ezp/v2
    stateless: true
    ezpublish_http_basic:
        realm: eZ Publish REST API
```

Basic authentication requires the username and password to be sent *(username:password)*, based 64 encoded, with each request.
For details, see [RFC 2617](http://tools.ietf.org/html/rfc2617).

Most HTTP client libraries as well as REST libraries support this method.

**Raw HTTP request with basic authentication**

```
GET / HTTP/1.1
Host: api.example.com
Accept: application/vnd.ez.api.Root+json
Authorization: Basic QWxhZGRpbjpvcGVuIHNlc2FtZQ==
```

### JWT authentication

After you [configure JWT authentication](../guide/security.md#jwt-authentication)
you can get the JWT token through the following request:

```
POST /user/token/jwt HTTP/1.1
Host: <yourdomain>
Accept: application/vnd.ez.api.JWT+xml
Content-Type: application/vnd.ez.api.JWTInput+xml
```

Provide the user name and password in the request body:

``` xml
<JWTInput>
    <password>publish</password>
    <username>admin</username>
</JWTInput>
```

### Error handling

Error handling in the REST API is fully based on the HTTP error codes.
The most common are: `401 Unauthorized`, `404 Not Found`, or `500 Internal Server Error`.
The REST API uses them along with a few more, to allow proper error handling.

For the complete list of error codes and the conditions in which they apply, see the [reference documentation.](https://doc.ezplatform.com/rest-api-reference)

### General error codes

A few error codes apply to most resources (if they *are* applicable):

|Error code|Error message|Description|
|----------|-----------|-------------|
|`404`|Not Found|Returned when the request failed because the request object was not found.|
|`405`|Method Not Allowed|Returned when the requested REST API resource does not support the HTTP verb that was used.|
|`406`|Not Acceptable|Returned when an accept header sent with the requested is not supported.|
|`500`|Internal Server Error|The server encountered an unexpected condition, usually an exception, which prevents it from fulfilling the request: database down, permissions or configuration error.|
|`501`|Not Implemented|Returned when the requested method has not yet been implemented. For [[= product_name =]], most of Users, User groups, Content items, Locations and Content Types have been implemented. Some of their methods, as well as other features, may return a 501.|

#### Error handling in your REST implementation

Depending on your client implementation, handle these codes by checking if an error code (4xx or 5xx) was returned instead of the expected 2xx or 3xx.

## REST API countries list

Countries list is a REST service that gives access to an [ISO-3166](http://en.wikipedia.org/wiki/ISO_3166) formatted list of world countries. It is useful when presenting a country options list from any application.

### Obtaining list of countries

To send a GET request to the REST API countries list, provide the Content Type header: `application/vnd.ez.api.CountriesList+xml`.

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

The **country codes** can be represented as:

- two-letter code (alpha-2) — recommended as the general purpose code
- three-letter code (alpha-3) — related to the country name
- three-digit numeric code (numeric-3) — useful if you need to avoid using Latin script

For details, see the [ISO-3166 glossary.](http://www.iso.org/iso/home/standards/country_codes/country_codes_glossary.htm)

**Body XML response**

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
