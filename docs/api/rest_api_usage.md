# REST API usage

TODO: Introduction? Do not explain what REST is, only the specificity of Ibexa DXP's REST API

The REST API v2 introduced in [[= product_name =]] allows you to interact with an [[= product_name =]] installation using the HTTP protocol, following a [REST](http://en.wikipedia.org/wiki/Representational_state_transfer) interaction model.

The REST API uses HTTP methods ( **`GET`** , **`POST`** , **`DELETE`** , etc.), as well as HTTP headers to specify the type of request.

## URIs
https://doc.ibexa.co/en/latest/api/rest_api_best_practices/#uris

The REST API is designed in such a way that the client doesn't need to construct any URIs to resources.
Starting from the root resources (`ListRoot_`) every response includes further links to related resources.
The URIs should be used directly as identifiers on the client side and the client should not construct any URIs by using an ID.

### URI prefix
https://doc.ibexa.co/en/latest/api/rest_api_best_practices/#uris-prefix

In [REST reference](rest_api_reference/rest_api_reference.html), for the sake of readability, there are no prefixes used in the URIs.
In practice, the `/api/ibexa/v2` prefixes all REST hrefs.

Remember that the URIs to REST resources should never be generated manually, but obtained from earlier REST calls.
TODO: Make sure this is demonstrated in "customization and extension" examples.

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

The following list of available methods just give a quick hint of the action a method will trigger on a resource if available. For action details, see the [REST API reference](rest_api_reference/rest_api_reference.html).

| HTTP method                                                |          | Description               |
|------------------------------------------------------------|----------|---------------------------|
| [OPTIONS](https://tools.ietf.org/html/rfc2616#section-9.2) | Standard | To list available methods |
| [GET](https://tools.ietf.org/html/rfc2616#section-9.3)     | Standard | To collect data           |
| [HEAD](https://tools.ietf.org/html/rfc2616#section-9.4)    | Standard | To check existence        |
| [POST](https://tools.ietf.org/html/rfc2616#section-9.5)    | Standard | To create an item         |
| [PATCH](http://tools.ietf.org/html/rfc5789)                | Custom   | To update an item         |                            
| COPY                                                       | Custom   | To duplicate an item      |
| [MOVE](http://tools.ietf.org/html/rfc2518)                 | Custom   | To move an item           |                           
| SWAP                                                       | Custom   | To swap two locations     |
| PUBLISH                                                    | Custom   | To publish an item        |
| [DELETE](https://tools.ietf.org/html/rfc2616#section-9.7)  | Standard | To remove an item         |

!!! note "Caution with custom HTTP methods"

    Using custom HTTP methods can cause issues with several HTTP proxies, network firewall/security solutions and simpler web servers. To avoid issues with this, REST API allows you to set these using the HTTP header `X-HTTP-Method-Override` along standard `POST` method instead of using a custom HTTP method. Example: `X-HTTP-Method-Override: PUBLISH`

If applicable, both methods are always mentioned in the specifications.

### OPTIONS requests
https://doc.ibexa.co/en/latest/api/rest_api_best_practices/#options-requests
TODO: Needed or table above is enough?

Any URI resource that the REST API responds to will respond to an OPTIONS request.

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

## Headers
https://doc.ibexa.co/en/latest/api/rest_api_guide/#other-headers

TODO: Intro listing the main headers: `Accept` describing the response type and format, `Content-Type` describing the payload type and format, `X-Siteaccess` specifying the target SiteAccess, `X-HTTP-Method-Override` allowing to pass a method while using `POST` method as previously seen  

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

On top of methods, HTTP request headers will allow you to personalize the request's behavior. On every resource, you can use the `Accept header to indicate which format you want to communicate in, JSON or XML. This header is also used to specify the response type you want the server to send when multiple ones are available.

-   `Accept: application/vnd.ibexa.api.Content+xml` to get **Content** (full data, fields included) as **[XML](http://www.w3.org/XML/)**
-   `Accept: application/vnd.ibexa.api.ContentInfo+json` to get **ContentInfo** (metadata only) as **[JSON](http://www.json.org/)**

TODO: media-types are also used with `Content-Type` header to characterize the payload.

Each XML media type has a unique name, e.g. `application/vnd.ibexa.api.User+xml`.
The returned XML response conforms with the complex type definition with a name, e.g. `vnd.ibexa.api.User` in the `user.xsd` XML schema definition file (see `User_`).

If there is only one media type defined for XML or JSON, it is also possible to specify `application/xml` or `application/json`.

To derive the implicit schema of the JSON from the XML schema a uniform transformation from XML to JSON is performed as shown below.

TODO: Could this concept transformation be followed with a real example?
TODO: Is it still true? The Ibexa\Rest\Output\Generator\Json is directly used by Visitors to transform Values to a Json object and Response.

```xml
<test attr1="attr1">
   <value attr2="attr2">value</value>
   <simpleValue>45</simpleValue>
   <fields>
     <field>1</field>
     <field>2</field>
   </fields>
</test>
```

Transforms to:

```json
{
  "test":{
    "_attr1":"attr1",
    "value":{
      "_attr2":"attr2",
      "#text":"value"
    },
    "simpleValue":"45",
    "fields": {
       "field": [ 1, 2 ]
    }
  }
}
```

## Creating content with binary attachments
https://doc.ibexa.co/en/latest/api/creating_content_with_binary_attachments_via_rest_api/
TODO: Other example of payload/body?

## HTTP error codes
https://doc.ibexa.co/en/latest/api/general_rest_usage/#general-error-codes

## Making cross-origin HTTP requests
https://doc.ibexa.co/en/latest/api/making_cross_origin_http_requests/

## Testing the API
https://doc.ibexa.co/en/latest/api/rest_api_guide/#testing-the-api
TODO: Earlier? Merged into another section? What about PHP example(s)?
