# REST API best practices

This page refers to [REST API reference](rest_api_reference/rest_api_reference.html), where you can find detailed information about
REST API resources and endpoints.

## Specifying SiteAccess

In order to specify a SiteAccess when communicating with the REST API, provide a custom `X-Siteaccess` header.
If it is not provided, the default SiteAccess is be used.

Example:

```
GET / HTTP/1.1
Host: api.example.com
Accept: application/vnd.ibexa.api.Root+json
X-Siteaccess: admin
```

## Media types

The methods on resources provide multiple media types in their responses.
A media type can be selected in the `Accept` header.
Each XML media type has a unique name, e.g. `application/vnd.ibexa.api.User+xml`.
The returned XML response conforms with the complex type definition with a name, e.g. `vnd.ibexa.api.User` in the `user.xsd` XML schema definition file (see `User_`).

To derive the implicit schema of the JSON from the XML schema a uniform transformation from XML to JSON is performed as shown below.

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

## URIs

The REST API is designed in such a way that the client doesn't need to construct any URIs to resources.
Starting from the root resources (`ListRoot_`) every response includes further links to related resources.
The URIs should be used directly as identifiers on the client side and the client should not construct any URIs by using an ID.

### URIs prefix

In [REST API reference](rest_api_reference/rest_api_reference.html), for the sake of readability, there are no prefixes used in the URIs.
In practice, the `/api/ibexa/v2` prefixes are all REST hrefs.

Remember that the URIs to REST resources should never be generated manually, but obtained from earlier REST calls.

### OPTIONS requests

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
