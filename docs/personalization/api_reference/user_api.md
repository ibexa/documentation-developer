---
description: Use HTTP methods to correlate metadata with user data and combine users into clusters of certain type.
---

# User API

When generating recommendations, it is useful to have the ability to correlate metadata 
with user data and combine users into clusters of certain type.
Such metadata can be gender, ZIP code, discount rate, etc. 
You can use the following user metadata import format to enrich the tracked data with information that cannot be calculated and must be provided by the end-user. 

If you plan to import user metadata, contact support@ibexa.co to ensure that you are compliant with privacy regulations.

!!! note "Authentication"

    For importing metadata, basic authentication is enabled by default.
    Use your customer ID and license key as username and password. 
    If authentication is enabled for recommendation requests and you want change this, contact support@ibexa.co.
    
## GET requests

Use the following request to fetch user attributes for the specified users:

`GET: https://import.perso.ibexa.co/api/[customerid]/[source]/user/[userid[,userid[...]]]`

User data is returned as an XML object.
Make sure that you use the **HTTP Content-Type=text/xml** header.

## POST requests

Use the following request to update the specified user's attribute set:

`POST: https://import.perso.ibexa.co/api/[customerid]/[source]/user`

## Request parameters

For the requests to function, you must provide the following parameters:

|Parameter|Description|Value|
|---|---|---|
|`customerid`|A customer ID (for example "00000"), as defined when [enabling Personalization](enable_personalization.md#set-up-customer-credentials). Can be used to identify a website in installations that [hosts multiple SiteAccesses]([[= user_doc =]]/personalization/use_cases/#multiple-website-hosting).|alphanumeric|
|`source`|An ID of the source of the specified user's metadata.|alphanumeric|
|`userid`|An ID of the tracked user in the website (for example, an internal customer code, a session code or a cookie for anonymous users.|alphanumeric|
  
!!! caution "Parameter encoding limitations"

      All parameters must be URL-encoded (see RFC 3986) and cannot contain slash, backslash or space 
      characters.
      
##### Source

The `source` parameter defines the system that stores the specified user's metadata. 
If you have multiple source systems for updating user attributes, 
for example, a registration service, where users define their gender and age, 
or an application that integrates with Facebook to source the brands the user "liked" in your shop, 
every new upload of attributes will replace the attribute set that already exists 
for the same user/source pair.

If you need to get all the available attributes for all sources, apply the `allSources` query string parameter, for example:

`GET: https://import.perso.ibexa.co/api/00000/facebook/user/CUSTOMER_1234?allSources=true`

When you do that, and the source returned is different from the source passed in the request (in this case, "facebook"), an additional attribute `source` is added to the XML object.

##### User ID

User ID is a case-sensitive combination of characters.
If transferred as part of the URL, the attribute must be URL-encoded. 
If transferred in the XML object, the attribute must be XML-encoded.

For example:

| User ID             | URL encoded             | XML encoded               |
|---------------------|-------------------------|---------------------------|
| `Customer<12.2014>` | `Customer%3C12.2014%3E` | `Customer&lt;12.2014&gt;` |


## DELETE request

Use the following request to run an opt-out option to delete the user and all data related to this user. After this request, the user is deleted from the database.
 
`DELETE: https://admin.perso.ibexa.co/api/[customerid]/user/[userid[,userid[...]]]`

## Responses

### Response object format

For an example of user metadata, see the following XML code. 
The attribute keys and values are chosen at random.

``` xml
<users>
  <user id="YOUR_CUSTOMER_ID">
    <attributes>
      <attribute key="country" value="DE"  type="NOMINAL"/>
      <attribute key="discountrate" value="2" type="NUMERIC"/>
      <attribute key="wants" value="I am looking for good products here" type="TEXT"/>
      <attribute key="type" value="reseller"/>
      <attribute key="favorite_film_genre" value="comedy"/>
      <attribute key="favorite_film_genre" value="horror"/>
      <attribute key="favorite_film_genre" value="animation"/>
    </attributes>
  </user>
</users>
```

Attribute keys are POSIX alphanumeric codes that can consist of the following characters: `\[A-Z\]`, `\[0-9\]`, `"\_"` and `"-"`. 
Attribute keys are case sensitive.

The following attribute types are supported:

- DATE - An XSD-formatted date, for example, "2014-08-07"
- DATETIME - An XSD-formatted time without a time zone, for example, "2014-08-07T14:43:12"
- NOMINAL - A value from a fixed length list, for example "gender" or "favorite film genre". If you do not set the attribute type, this is the default value
- NUMERIC - A decimal value, for example, "1.23" or "-2345"
- TEXT - A longer text, usually free form
