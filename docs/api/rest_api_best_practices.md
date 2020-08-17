# REST API best practices

## Specifying SiteAccess

In order to specify SiteAccess, when talking to the REST API, provide a custom header `X-Siteaccess`.
If it isn't provided, the default one will be used.

Example:

```
GET / HTTP/1.1
Host: api.example.com
Accept: application/vnd.ez.api.Root+json
X-Siteaccess: admin
```

## Media Types

The methods on resources provide multiple media types in their responses.
A media type can be selected in the Accept Header.
For each xml media type there is a unique name e.g. `application/vnd.ez.api.User+xml`. In this case the returned xml response
conforms with the complex type definition with name vnd.ez.api.User in the user.xsd (see User_) xml schema definition file.
Each JSON schema is implicit derived from the xml schema by making a uniform transformation from XML to JSON as shown below.

Example:

.. code:: xml
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

transforms to:

```javascript
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

Different schemas which induce different media types one on resource can be used to allow to make specific
representations optimized for purposes of clients.
It is possible to make a new schema for mobile devices for retrieving e.g. an article.

```xml
<?xml version="1.0" encoding="UTF-8"?>
<xsd:schema version="1.0" xmlns:xsd="http://www.w3.org/2001/XMLSchema"
  xmlns="http://ez.no/API/Values" targetNamespace="http://ez.no/API/Values">
  <xsd:include schemaLocation="CommonDefinitions.xsd" />
  <xsd:complexType name="vnd.ez.api.MobileContent">
    <xsd:complexContent>
      <xsd:extension base="ref">
        <xsd:all>
          <xsd:element name="Title" type="xsd:string" />
          <xsd:element name="Summary" type="xsd:string" />
        </xsd:all>
      </xsd:extension>
    </xsd:complexContent>
  </xsd:complexType>
  <xsd:element name="MobileContent" type="vnd.ez.api.MobileContent"/>
</xsd:schema>
```

so that

```
GET /content/objects/23 HTTP/1.1
Accept: application/vnd.ez.api.MobileContent+xml
```

returns:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<MobileContent href="/content/objects/23" media-type="application/vnd.ez.api.MobileContent+xml">
  <Title>Title</Title>
  <Summary>This is a summary</Summary>
</MobileContent>
```

However in this specification only the standard schemas and media types are defined (see InputOutput_).
If there is only one media type defined for xml or json, it is also possible to specify
application/xml or application/json.

## URIs

The REST API is designed so that the client need not construct any URIs to resources by itself.
Starting from the root resources (ListRoot_) every response includes further links to related resources.
The URIs should be used directly as identifiers on the client side and the client should not
construct an URI by using an id.

### URIs prefix

In this document, for the sake of readability, no prefix is used in the URIs. In real life, /api/ezp/v2
prefixes all REST hrefs.

Remember that URIs to REST resources should never be generated manually, but obtained from earlier REST
 calls.

## OPTIONS requests

Any resource URI the REST API responds to will respond to an OPTIONS request.

The Response will contain an Allow header, that as specified in chapter 14.7 of RFC 2616 will list the methods
accepted by the resource.

Example:

```
OPTIONS /content/objects/1 HTTP/1.1
Host: api.example.net

HTTP/1.1 200 OK
Allow: PATCH,GET,DELETE,COPY
```
