# General REST usage

## Anatomy of REST call

### GET request

The GET request is used to query the API for information. It is one of the two operations web browsers implement, and the one most commonly used.
TODO: Not interesting trivia; probably already said somehow

### Request

The only requirement for this verb is usually the resource URI and the accept header.
On top of that, cache request headers can be added, like `If-None-Match`, but those are not fully implemented yet.

**Load ContentInfo request**

```
GET /content/objects/23 HTTP/1.1
Accept: application/vnd.ibexa.api.ContentInfo+xml
```

#### Response headers

The API response contains:

- HTTP response code
- headers
- XML representation of the ContentInfo for content with ID 23 in XML format as specified in the Accept header

**Load ContentInfo response**

```
HTTP/1.1 200 OK
Accept-Patch: application/vnd.ibexa.api.ContentUpdate+xml;charset=utf8
Content-Type: application/vnd.ibexa.api.ContentInfo+xml
```

###### HTTP code

The API responded here with a standard `200 OK` HTTP response code, which is the expected response code for a typical GET request.
Some GET requests, like [getting a Content item's current version,](rest_api_reference/rest_api_reference.html#managing-content-get-current-version) may return a `301 Moved permanently` or `307 Temporary redirect` code.

Errors are indicated with HTTP error codes, e.g. `404 Not Found` or `500 Internal Server Error`.
The [REST reference](rest_api_reference/rest_api_reference.html) provide the list of every HTTP response code you can expect from implemented resources.

###### Content-Type header

###### Accept-Patch header

###### Location header

###### Destination header

#### Response body

Load ContentInfo response body, expand source:

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<Content href="/content/objects/23" id="23"
  media-type="application/vnd.ibexa.api.Content+xml" remoteId="qwert123">
  <ContentType href="/content/types/10" media-type="application/vnd.ibexa.api.ContentType+xml" />
  <Name>This is a title</Name>
  <Versions href="/content/objects/23/versions" media-type="application/vnd.ibexa.api.VersionList+xml" />
  <CurrentVersion href="/content/objects/23/currentversion"
    media-type="application/vnd.ibexa.api.Version+xml"/>
  <Section href="/content/sections/4" media-type="application/vnd.ibexa.api.Section+xml" />
  <MainLocation href="/content/locations/1/4/65" media-type="application/vnd.ibexa.api.Location+xml" />
  <Locations href="/content/objects/23/locations" media-type="application/vnd.ibexa.api.LocationList+xml" />
  <Owner href="/user/users/14" media-type="application/vnd.ibexa.api.User+xml" />
  <lastModificationDate>2012-02-12T12:30:00</lastModificationDate>
  <publishedDate>2012-02-12T15:30:00</publishedDate>
  <mainLanguageCode>eng-US</mainLanguageCode>
  <alwaysAvailable>true</alwaysAvailable>
</Content>
```

The XML body is a serialized version of a [ContentInfo](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/ContentInfo.php) struct.
Most of the REST API calls will involve exchanging XML or JSON representations of the public API.

The example above shows that Content item 23 can be modified by sending a `vendor/application/vnd.ez.ContentUpdate+xml`.
TODO: Not the example just above but way more above (https://doc.ibexa.co/en/latest/api/general_rest_usage/#accept-patch-header)
This media type again matches a Value in the API, [ContentUpdateStruct](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/ContentUpdateStruct.php).

The REST API data structs mostly match a PHP Public API value object.

#### Value objects representation

Value objects like [ContentInfo](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/ContentInfo.php) feature two types of fields: 

- local fields (e.g. currentVersionNo, name)
- foreign field(s) references (e.g. sectionId, mainLocationId)

Local fields will be represented in XML / JSON format with a plain type (integer, string), while foreign key references will be represented as a link to another resource.
This resource will be identified with its URI (`/content/objects/23/locations`) and the media-type that should be requested when calling that resource (`media-type="application/vnd.ibexa.api.LocationList+xml"`).
Depending on how much data you need, you may choose to crawl those relations or to ignore them.

##### XSD files

For each XML structure known to the REST API, you can find [XSD files](https://github.com/ezsystems/ezpublish-kernel/tree/master/doc/specifications/rest/xsd) in the XSD folder of the specifications.
They will allow you to validate your XML and to learn about every option these XML structures feature.
TODO: Remove as obsolete

## Request parameters

### Working with value objects IDs

## Custom HTTP verbs

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

## REST API authentication

The REST API supports the following authentication methods:

- **Session-based authentication** for AJAX operations that lets you re-use the visitor's session to execute operations with their permissions.
- **Basic authentication** for writing cross-server procedures, when one remote application executes operations on one/several [[= product_name =]] instances (remote publishing, maintenance, etc).
- [**JWT authentication**](#jwt-authentication)

Session-based is the default authentication method as it is needed for UI.

!!! note "Limiting anonymous access to metadata over REST API"
    
    Some API endpoints accessible to the Anonymous User return metadata you might not want to expose, due to insufficient permission limitations.
    To prevent that, you can rely on the Symfony securing URL patterns mechanism called [access_control]([[= symfony_doc =]]/security/access_control.html).
    The example below shows you how to block listing Content Types for the non-authenticated users.
    
    **security.yml**
    ``` yaml
    security:
        access_control:
            - { path: '^/api/ibexa/v2/content/types', roles: ROLE_USER }
    ```

### Session-based authentication

#### Logging in

### HTTP basic authentication

### JWT authentication

### Error handling

Error handling in the REST API is fully based on the HTTP error codes.
The most common are: `401 Unauthorized`, `404 Not Found`, or `500 Internal Server Error`.
The REST API uses them along with a few more, to allow proper error handling.

For the complete list of error codes and the conditions in which they apply, see the [reference documentation](rest_api_reference/rest_api_reference.html).

### General error codes

#### Error handling in your REST implementation

Depending on your client implementation, handle these codes by checking if an error code (4xx or 5xx) was returned instead of the expected 2xx or 3xx.

## REST API countries list

TODO: What is the interest to have this feature here in addition to the API reference?

Countries list is a REST service that gives access to an [ISO-3166](http://en.wikipedia.org/wiki/ISO_3166) formatted list of world countries. It is useful when presenting a country options list from any application.

### Obtaining list of countries

To send a GET request to the REST API countries list, provide the Content Type header: `application/vnd.ibexa.api.CountriesList+xml`.

**Countries list request**

```
Resource: /api/ibexa/v2/services/countries
Method: GET
Content-Type: application/vnd.ibexa.api.CountriesList+xml
```

#### Usage example

**Countries list request**

```
GET /api/ibexa/v2/services/countries
Host: example.com
Accept: application/vnd.ibexa.api.CountriesList+xml
```

**Countries list response headers**

```
HTTP/1.1 200
Content-Type: application/vnd.ibexa.api.CountriesList+xml
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
