# Content API

## Insert XML Content

!!! note

    All features described in this chapter are available only for the advanced edition of the Recommender Engine.
    **BASIC Authentication** is enabled by default.
    Use the customerID as username and the license key as password.
    The license key is displayed in the upper right of the Admin GUI ([https://admin.yoochoose.net](https://admin.yoochoose.net/)) after logging in with your registration credentials.

The Recommender Engine needs updated information from the web presence of the customer to generate personalized recommendations for the user profile.
To get such information an event tracking process is required to collect events like clicks, purchases, consumes, etc.

In addition to events collected by the Recommender, the Recommender Engine can use external information about the products.
This information must be uploaded to the Recommender Engine by the website owner.
Here are some examples:

- **Product price** - Products cheaper than the specified threshold can be filtered out from recommendations.
- **Availability time period** - Products will be recommended only in the specified time window.
- **Custom attributes** - By using custom attributes it is possible to group recommendations and narrow the results. For example "I am interested only in non-food products" or "show me only news related to my city".

### XML Item Format

The XML format for an item import is the same for the PULL and PUSH interface. Here is an example:

``` xml
<items version="1">
    <!-- version is mandatory and always "1" -->
    <item id="102" type="1">
        <description>the item's description</description>
        <price currency="EUR">122</price>
        <!-- price in cents as integer value (e.g. EUR-Cent) -->
        <validfrom>2011-01-01T00:00:00</validfrom>
        <!-- items will be recommended only in the specified time window -->
        <validto>2021-01-01T00:00:00</validto>
        <categorypaths>
            <categorypath>/8/4/5</categorypath>
            <!-- one product can be in multiple categories -->
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
            <!-- this section should only contain values that are distinct and limited to build prefiltered models -->
            <attribute key="author" value="Max Mustermann" />
            <attribute key="agency" value="dpa" />
            <!-- If no type value is given, NOMINAL (a limited list of values) is assumed -->
            <attribute key="vendor" value="BOSCH" />
            <!-- if NUMERIC is chosen, the value must be numeric as well. -->
            <attribute key="weight" value="100" type="NUMERIC" />
        </attributes>
    </item>
</items>
```

#### Implicit vs. explicit update of category paths

Product attributes which can be uploaded through the data import interface include the path of the category/categories that the product is located in.
The category path can be also updated over the "click" events.
If the products are regularly uploaded over the data import interface, the click event should **not** contain the category path information.
E.g. a product is clicked in the "TopSeller" section and the category path `%2FTopSeller` is sent, which is mostly undesired as it is originally located under `%2FGarden%2F`.

Enabling both update ways for category path is possible, but it has the following side effects:

- Every new category path attached to the "click" event will be *appended* to the list of the categories of the product.
- The Product imported will *overwrite* the collected category paths.

!!! note "XML schema definition"

    The current schema can be seen under `https:// admin.yoochoose.net/api/00000/item/schema.xsd`

Following is a brief description of the attributes

|Name/Attribute|Description|Mandatory|Type|
|---|---|---|---|
|id|The item's id|yes|Integer|
|type|The item's type|yes|Integer|
|description|Additional information about the item|-|String|
|price|The item's price (e.g. in EUR cents)|-|Integer (see below)|
|currency|Currency used, by default EUR is assumed|-|ISO 4217|
|validfrom|Defines, together with validto, the "lifespan" of an item. If NULL or not available, the item is considered valid|-|ISO 8601 (see below)|
|validto|Defines, together with validfrom, the "lifespan" of an item. If NULL or not available, the item is considered valid|-|ISO 8601|
|categorypath|A logical (website) navigation path through which the item can be reached in the customer's system|-|String, separated with "%2F" (encoded /)|
|categoryid|The category ID. Deprecated. Use "categorypath" instead!|-|Integer|

#### Empty Products

All the elements and attributes except the item **type** and the item **id** are optional.
It is possible to upload a product without any additional information, e.g. if the random recommendation model is used or on-the-fly boosting and filtering of recommendations is intended to be used.
In this case the Recommendation Engine will randomly recommend the imported products even if they have to related events.
This is useful for a news agency, where new products (=news) are published very frequently.

#### Field Formats

The key attribute in the elements **attribute** and **content** must contain only letters, numbers and underscores.

Price is formatted as the amount of "cents", for example 1234 for 12 Euros and 34 Cents. If the currency doesn't contain the cent part, the main currency is used, for example 12 for 12 Japanese Yen.
See [ISO 4217](https://en.wikipedia.org/wiki/ISO_4217#cite_note-ReferenceA-6) to check if the selected currency has a "cents" part.

Validity Dates are formatted as specified in [XSD format](https://www.w3.org/TR/xmlschema-2/#dateTime) *without a time zone*. Time zone is the default timezone of the mandator which is used.

#### Attributes

It is also possible to define custom (numeric or nominal) attributes in the **&lt;attributes&gt;** section.
The default type of every attribute is "NOMINAL", i.e. the values of an attribute are treated as distinct when compared while calculating a content-based model (ADVANCED solution).
If you add another attribute in the attribute element named *type="NUMERIC"*, the recommender engine will treat the values as ranges.
This means that a size of 4 is closer to a size of 5 than to 1.
If the attribute price is of type NOMINAL, they are both just different and have no "distance-based similarity".

``` xml
<attribute key="size" value="4" type="NUMERIC" />
```

Another typical example is the color of an item. To insert it in the store, the following line should be a child of the &lt;attributes&gt; element.

``` xml
<attribute key="color" value="green" />
```

!!! caution

    Attribute keys are **case-sensitive**. It is possible to have multiple attributes with the same name and different type. For example, the size as a number (e.g., 40.5) and as a code ("L").

#### Content

You can load any content data in the content part of the item.
The content is used only for full text analysis models, it cannot be used in `<content-data key="abstract"> <![CDATA[ ... ]]></content-data>`.

### Push Interface

The Recommender provides a REST interface that accepts an item in XML-format.
The following URL describes the interface.

**`https://admin.yoochoose.net/api/[customerid]/item`**

It can be used to POST item information within the request's body into the store and to show, update or delete items directly.
The parameters that are used in the call are described in the table.

URL `https://admin.yoochoose.net/api/[customerid]/item/[itemtypeid]/[itemid]` is the direct link to fetch item data.

|Parameter name|Description|Values|
|---|---|---|
|`customerid`|This is a reference to the account of the customer. It will be provided by YOOCHOOSE.|String|
|`itemid`|A unique identifier for the item that is used as a reference to identify the item in the database of the customer.|Numeric|
|`itemtypeid`|Describes the type of the item id. Usually it is fixed to 1 but if the customer uses more than one type of items this has to refer to the corresponding item type.|Numeric|

Different HTTP-methods can be used to create, update, delete or retrieve items located in the YOOCHOOSE data store. The following table gives an overview of the different methods and their function.

|HTTP method|Description|Values|
|---|---|---|
|`POST`|If the body contains valid xml data, the item will be persisted. The item is not directly available but scheduled to be inserted. If the XML content cannot be validated, the server will send a Bad Request status code.|202 (Accepted)</br>400 (Bad Request)|
|`GET`|This method retrieves all information that is stored in the database for the given item id. If not found, the status code 404 is returned.|200 (OK)</br>404 (Not Found)|
|`DELETE`|Deletes all information that is related to the item id that has been sent. There is no need to send a body element. The item is not deleted directly but scheduled to be removed from the data store.|202 (Accepted)</br>404 (Not Found)|

The body of a request to import data using the above interface must contain a valid XML document.

## Transferring Item Identifiers

### Transfer items

The method transfers an item from one id to another ID.
The attributes of the old item are NOT moved or merged.
If you rely on attributes for e.g. filtering based on prices, the new item must be reimported.

All related historical user data is rewritten to point to the new item.
The old item is wiped, including all attributes.
The authentication is based on BASIC AUTH with customerId and license-key.

**`POST https://import.yoochoose.net/api/[customerid]/transferitems`**
`Content-Type=text/xml`

``` xml
<transfers>
    <transfer>
        <sourceitem id="1234" type="1"/>
        <targetitem id="6789" type="1"/>
    </transfer>
</transfers>
```
