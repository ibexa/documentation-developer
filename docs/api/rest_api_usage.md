# REST API usage

TODO: Introduction? Do not explain what REST is, only the specificity of Ibexa DXP's REST API

The REST API v2 introduced in [[= product_name =]] allows you to interact with an [[= product_name =]] installation using the HTTP protocol, following a [REST](http://en.wikipedia.org/wiki/Representational_state_transfer) interaction model.

The REST API uses HTTP methods ( **`GET`** , **`POST`** , **`DELETE`** , etc.), as well as HTTP headers to specify the type of request.

## HTTP verbs
https://doc.ibexa.co/en/latest/api/rest_api_guide/#http-methods
https://doc.ibexa.co/en/latest/api/general_rest_usage/#custom-http-verbs

TODO: Is PUT used?? What about HEAD? or TRACE?
TODO: "Verb" VS "Method"; Why our doc uses "verb" while others like RFCs use "method"? Even in `X-HTTP-Method-Override`…

Depending on the used HTTP verb (or method), different actions will be possible on the same resource. Example:

| Action                                  | Description                                                          |
|-----------------------------------------|----------------------------------------------------------------------|
| `GET  /content/objects/2/version/3`     | Fetches data about version \#3 of Content item \#2                   |
| `PATCH  /content/objects/2/version/3`   | Updates the version \#3 draft of Content item \#2                    |
| `DELETE  /content/objects/2/version/3`  | Deletes the (draft or archived) version \#3 from Content item \#2    |
| `COPY  /content/objects/2/version/3`    | Creates a new draft version of Content item \#2 from its version \#3 |
| `PUBLISH  /content/objects/2/version/3` | Promotes the version \#3 of Content item \#2 from draft to published |
| `OPTIONS  /content/objects/2/version/3` | Lists all the verbs usable with this resource, the 5 ones above      |

The following list of available verbs just give a quick hint of the action a verb will trigger on a resource if available. For action details, see the [REST API reference](rest_api_reference/rest_api_reference.html).

| HTTP verb/method                                           |          | Description                                                        |
|------------------------------------------------------------|----------|--------------------------------------------------------------------|
| [GET](https://tools.ietf.org/html/rfc2616#section-9.3)     | Standard | To collect data                                                    |
| [POST](https://tools.ietf.org/html/rfc2616#section-9.5)    | Standard | To send a payload to create an item (content, session, role, etc.) |
| [PATCH](http://tools.ietf.org/html/rfc5789)                | Custom   | To send a payload to update an item                                |                            
| COPY                                                       | Custom   | To duplicate an item                                               |
| [MOVE](http://tools.ietf.org/html/rfc2518)                 | Custom   | To move an item (Location, etc)                                    |                           
| PUBLISH                                                    | Custom   | To publish an item                                                 |
| [DELETE](https://tools.ietf.org/html/rfc2616#section-9.7)  | Standard | To remove an item                                                  |
| [OPTIONS](https://tools.ietf.org/html/rfc2616#section-9.2) | Standard | To list available verb for a resource                              |

!!! note "Caution with custom HTTP verbs"

    Using custom HTTP verbs can cause issues with several HTTP proxies, network firewall/security solutions and simpler web servers. To avoid issues with this, REST API allows you to set these using the HTTP header `X-HTTP-Method-Override` along standard `POST` instead of using a custom HTTP verb. Example: `X-HTTP-Method-Override: PUBLISH`

If applicable, both methods are always mentioned in the specifications.

### OPTIONS requests
https://doc.ibexa.co/en/latest/api/rest_api_best_practices/#options-requests
TODO: Needed or table above is enough?

Any URI resource that the REST API responds to will respond to an OPTIONS request.

The response contains an `Allow` header, that as specified in [chapter 14.7 of RFC 2616](https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.7) lists the methods accepted by the resource.

```
OPTIONS /content/objects/1 HTTP/1.1
Host: api.example.net
```

```
HTTP/1.1 200 OK
Allow: PATCH,GET,DELETE,COPY
```

## Headers
https://doc.ibexa.co/en/latest/api/rest_api_guide/#other-headers

TODO: Intro listing the main headers: `Accept` describing the response type and format, `Content-Type` describing the payload type and format, `X-Siteaccess` specifying the target SiteAccess, `X-HTTP-Method-Override` allowing to pass a verb while using `POST` method as previously seen  

### SiteAccess
https://doc.ibexa.co/en/latest/api/general_rest_usage/#specifying-siteaccess
https://doc.ibexa.co/en/latest/api/rest_api_best_practices/#specifying-siteaccess

In order to specify a SiteAccess when communicating with the REST API, provide a custom `X-Siteaccess` header.
If it is not provided, the default SiteAccess is used.

Example:

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
TODO: Notice that to login (at least with a session), anonymous must have user/login. `X-Siteaccess: admin` is not a good example as anonymous will probably never has the right to log into it. (`User 'anon.' doesn't have user/login permission to SiteAccess 'admin'`)

### Media types
https://doc.ibexa.co/en/latest/api/rest_api_guide/#media-type-headers
https://doc.ibexa.co/en/latest/api/rest_api_best_practices/#media-types

On top of methods, HTTP request headers will allow you to personalize the request's behavior. On every resource, you can use the Accept header to indicate which format you want to communicate in, JSON or XML. This header is also used to specify the response type you want the server to send when multiple ones are available.

-   `Accept: application/vnd.ibexa.api.Content+xml` to get **Content** (full data, fields included) as **[XML](http://www.w3.org/XML/)**
-   `Accept: application/vnd.ibexa.api.ContentInfo+json` to get **ContentInfo** (metadata only) as **[JSON](http://www.json.org/)**

Each XML media type has a unique name, e.g. `application/vnd.ibexa.api.User+xml`.
The returned XML response conforms with the complex type definition with a name, e.g. `vnd.ibexa.api.User` in the `user.xsd` XML schema definition file (see `User_`).

To derive the implicit schema of the JSON from the XML schema a uniform transformation from XML to JSON is performed as shown below.

TODO: This concept transformation could be followed with a real example?

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

Different schemas that induce different media types on resource can be used to allow making specific representations optimized for purposes of clients.
It is possible to make e.g. a new schema for mobile devices for retrieving an article.

TODO: Where this schema should be stored?
TODO: Are `xmlns` and `targetNamespace` up-to-date?
TODO: Could be part of, or referenced by, rest_api_customization_and_extension.md

```xml
<?xml version="1.0" encoding="UTF-8"?>
<xsd:schema version="1.0" xmlns:xsd="http://www.w3.org/2001/XMLSchema"
  xmlns="http://ez.no/API/Values" targetNamespace="http://ez.no/API/Values">
  <xsd:include schemaLocation="CommonDefinitions.xsd" />
  <xsd:complexType name="vnd.ibexa.api.MobileContent">
    <xsd:complexContent>
      <xsd:extension base="ref">
        <xsd:all>
          <xsd:element name="Title" type="xsd:string" />
          <xsd:element name="Summary" type="xsd:string" />
        </xsd:all>
      </xsd:extension>
    </xsd:complexContent>
  </xsd:complexType>
  <xsd:element name="MobileContent" type="vnd.ibexa.api.MobileContent"/>
</xsd:schema>
```

So that:

```
GET /content/objects/23 HTTP/1.1
Accept: application/vnd.ibexa.api.MobileContent+xml
```

Returns:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<MobileContent href="/content/objects/23" media-type="application/vnd.ibexa.api.MobileContent+xml">
  <Title>Title</Title>
  <Summary>This is a summary</Summary>
</MobileContent>
```

In this specification, only the standard schemas and media types are defined (see `InputOutput_`).
If there is only one media type defined for XML or JSON, it is also possible to specify `application/xml` or `application/json`.

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
