---
description: Personalization server can use external information about the items. Use HTTP methods to create, update or get items from the data store.
---

# Content API

Apart from the [events]([[= user_doc =]]/personalization/event_types) collected by the Personalization client, 
the Personalization server can use external information about the products.
This information must be uploaded to the Personalization server by the administrator 
of the website.

The following information can be loaded to the recommendation solution:

- Product price - Products cheaper than the specified threshold can be filtered out from recommendations
- Availability timeframe - Certain products are be recommended only in the specified time window
- Custom attributes - You can group recommendations and narrow down the results, for example, to non-food products or to news that are related to the end user's city

For more information about personalization, see [Introduction](personalization.md) and [Best practices](recommendation_integration.md).

The Personalization client provides a REST interface that accepts items in XML format.
You can use the interface to post item information within the request's body into the store, 
and to display or update the items directly.

You can use HTTP methods to create, update or retrieve items that are in the data store.

!!! note "Authentication"

    For getting or posting content data, basic authentication is enabled by default.
    Use your customer ID and license key as username and password. 
    If authentication is enabled for recommendation requests and you want to change 
    this, contact support@ibexa.co.

## GET requests

Use the GET method to retrieve all information that is stored in the database 
for the given item ID:

`GET: https://admin.perso.ibexa.co/api/[customerid]/item/[itemtypeid]/[itemid]`

## POST requests

Use the POST request to create or update items with the given ID in the database:

`POST: https://admin.perso.ibexa.co/api/[customerid]/item`

A body of the request must contain a valid XML document.
Once uploaded, the item is scheduled to be inserted in the database, and it 
is not directly available.

## DELETE requests

Use the DELETE method to delete all information that is related to the given item ID. 

`DELETE: https://admin.perso.ibexa.co/api/[customerid]/item/[itemtypeid]/[itemid]?lang=<language_code>`

The item is scheduled to be removed from the database.

## Request parameters

The following call attributes are available:

| Parameter name | Description | Value |
|---|---|---|
| `customerid` |A customer ID (for example "00000"), as defined when [enabling Personalization](#multiple-website-hosting).| alphanumeric |
| `itemid` | A unique ID of the Content item/product. Used to identify the item in the database. | integer |
| `itemtypeid` | An ID of the type of Content item/product. In most cases, the value is 1 but you might have items/products of more than one type. | integer |
| `lang` | A [language code](languages.md) of the Content item/product (for example, "ger-DE"). This parameter is optional. | string |

### Request object format

An XML representation of the data object used for item import can look like this: 

``` xml
<items version="1">
    <!-- Version is mandatory and must always be set to 1 -->
    <item id="102" type="1">
        <description>the item's description</description>
        <price currency="EUR">122</price>
        <validfrom>2011-01-01T00:00:00</validfrom>
        <validto>2021-01-01T00:00:00</validto>
        <categorypaths>
            <categorypath>/8/4/5</categorypath>
            <categorypath>/84</categorypath>
            <categorypath>/1/847</categorypath>
        </categorypaths>
        <content>
            <content-data key="title">
                <![CDATA[ ... ]]>
            </content-data>
            <content-data key="abstract">
                <![CDATA[ ... ]]>
            </content-data>
        </content>
        <attributes>
            <!--  -->
            <attribute key="author" value="John Doe" />
            <attribute key="agency" value="dpa" />
            <attribute key="vendor" value="BOSCH" />
            <attribute key="weight" value="100" type="NUMERIC" />
        </attributes>
    </item>
</items>
```

!!! note "XML schema definition"

    The current schema that is used for interpreting the XML objects 
    can be seen [here](https://admin.perso.ibexa.co/api/00000/item/schema.xsd).

The following keys and attributes used in the XML object are available:

|Key/Attribute | Description | Type |
|--- | --- | --- |
| `id` | A unique ID of the item/product. This parameter is required. | integer |
| `type` | An ID of the type of item/product. This parameter is required. | integer |
| `description`| Additional information about the item. | alphanumeric |
| `currency` | Currency used for the price. By default, prices are expressed in EUR. | ISO 4217 |
| `price` | The item's price in the currency's fractional units (for example, cents).<br/>See below for more information. | integer |
| `validfrom` | Together with `validto`, defines the lifespan of an item.<br/>If NULL or not available, the item is considered valid immediately.<br/>See below for more information. | ISO 8601 |
| `validto` | Together with `validfrom`, defines the lifespan of an item.<br/>If NULL or not available, the item is considered valid indefinitely.<br/>See below for more information. | ISO 8601 |
| `categorypath` | A logical (website) navigation path through which the end user can reach the item/product in your website.<br/>You can define multiple paths for the product.| alphanumeric, separated with "/" ("%2F") characters |

!!! caution "Encoding limitation"

    Keys and their values can only contain letters, digits and underscore characters.
    Attribute keys are case-sensitive.

##### Currency

If the currency does not have a fractional unit, the main unit is used, 
for example 12 for 12 Japanese Yen.
To check whether the currency has fractional units, see the [ISO 4217 standard](https://en.wikipedia.org/wiki/ISO_4217#cite_note-ReferenceA-6).

##### Validity

Items with defined validity are recommended only in the specified timeframe. 
Values in the `validto` and `validfrom` attributes must follow the [XSD format](https://www.w3.org/TR/xmlschema-2/#dateTime) 
and do not include the time zone. 
Time zone is always your time zone.

##### Category path

With the data import interface, you can upload information about the paths 
to categories in which the product is located.
However, the category path can be also updated as a result of the "Click" events.
If you regularly upload product data, the "Click" event cannot contain the category 
path information.
Otherwise, the following negative side effects occur:

- Every new category path attached to the "Click" event is appended to a list of the categories of the product
- Imported product data overwrites the collected category paths

For example, when a product that is originally located under `Garden` is clicked 
in the "Hot Sellers" section, the category path `TopSeller` is sent.

#### Content items/products with no attributes

All the elements and attributes except the `type` and `id` are optional.
You can therefore upload a product without any additional information.
You do it, for example, when a random recommendation model is used 
or you want to want to apply ad-hoc boosting and filtering of recommendations.
As a result, the Personalization server randomly recommends the imported items/products.
This can prove useful for a news agency, where new items are published very often.

#### Custom attributes

You can also define custom attributes under the `<attributes>` key.
This section can only contain values that are distinct and used to build pre-filtered models.

By default, it is assumed that every attribute is of type "NOMINAL", which means that 
there is a limited set of values, and values of an attribute are treated as distinct 
when calculating the results of a content-based model.

If you have an attribute that is of type "NUMERIC", and you add another attribute 
of the same type, the Personalization server treats the two values as a range.

``` xml
<attribute key="size" value="4" type="NUMERIC" />
```

However, if the other attribute is of type "NOMINAL", they are both treated 
as different and have no "distance-based similarity".

Another typical example of a custom attribute is the color of an item. 
To upload the value to the data store, add the following line under the `<attributes>` key.

``` xml
<attribute key="color" value="green" />
```

You can have multiple attributes with the same name and different type. 
For example, `size` can be expressed as a number (40.5) or as a code ("L").

## Responses

### HTTP response codes

The following HTTP response codes are used by the recommendation controller:

|HTTP Status Code|Description|
|---|---|
|200 OK|The GET request was processed successfully.|
|202 Accepted|The POST or DELETE request was processed successfully.|
|400 Bad Request|Wrong request formatting. The XML content cannot be validated.|
|404 Not Found|The element requested by the GET or DELETE request was not found.|

## Transferring item identifiers

You could use the data import interface to help migrate the database, 
when it involves changing item IDs of items that are supported by the 
Personalization server.
If you transfer items from one ID to another, you can use the events recorded 
for "old" item IDs to calculate model results that present "new" IDs.

Use the following method to pass the XML object:

`POST: https://admin.perso.ibexa.co/api/[customerid]/transferitems`
`Content-Type=text/xml`

``` xml
<transfers>
    <transfer>
        <sourceitem id="1234" type="1"/>
        <targetitem id="6789" type="1"/>
    </transfer>
</transfers>
```

All related historical user data is rewritten to point to the new item.
The old item is wiped, including all attributes.

!!! note

    The attributes of the "old" item ID are not moved or merged, and if you 
    rely on attributes, for example, for filtering based on prices, 
    you must reimport the new item.
