# General REST usage

## Anatomy of REST call

### GET request

### Request

#### Response headers

###### HTTP code

###### Content-Type header

###### Accept-Patch header

###### Location header

###### Destination header

#### Response body

#### Value objects representation

##### XSD files

## Request parameters

### Working with value objects IDs

## Custom HTTP verbs

### Logical operators

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
