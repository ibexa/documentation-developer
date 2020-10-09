# User API

!!! note

    All the features described in this chapter are available only for the advanced edition of the Recommender Engine.

    **BASIC Authentication** is enabled by default. Use the customerid/mandator as username and the license key as password. The license key is displayed in the upper right in the Admin GUI ([https://admin.yoochoose.net](https://admin.yoochoose.net/)) after logging in with your registration credentials.

It is useful to add metadata to users in order to classify them and attach them to user-type clusters. We provide the following "user metadata" import format in order to enrich tracked user data with information that cannot be calculated from their behavior but only provided by a customer itself. An example for this metadata could be "gender", "postal code", "discount rate", etc. 

!!! note

    Please contact <support@yoochoose.com> if you are planning to import user metadata in order to be compliant with privacy regulations.

Following is an example user metadata in xml format. All attribute keys and values are chosen arbitrarily.

``` xml
<users>
  <user id="CUSTOMER_1234">
    <attributes>
      <attribute key="country" value="DE"  type="NOMINAL"/>    <!-- NOMINAL is a default value -->
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

The following request is used to fetch user attributes for the specified users:

`GET: https://import.yoochoose.net/api/[customerid]/[source]/user/[userid[,userid[...]]]`

The following URL is used to update the set of the user attributes:

`POST: https://import.yoochoose.net/api/[customerid]/[source]/user`

The users are provided in the specified XML format (do not forget the **HTTP Content-Type=text/xml** header).

## User ID

User ID is any character combination. User IDs are case sensitive.

!!! caution

    Because of transferring as part of an URL in the event tracking it is recommended to **avoid space character and slashes** (both forward and back slashes). Apache web-servers (and products based on this Apache project) have very sophisticated and non-transparent rules for handling slashes in URLs.

If transferred in the URL, the user ID must be URL-encoded. If transferred in the XML attribute it must be XML-encoded, like this:

| User ID             | URL encoded             | XML encoded               |
|---------------------|-------------------------|---------------------------|
| `Customer<12.2014>` | `Customer%3C12.2014%3E` | `Customer&lt;12.2014&gt;` |

#### Key

The attribute key is a POSIX alphanumeric code \[A-Z\], \[0-9\] plus "\_" and "-". Attribute keys are case sensitive.

## Attribute Type

Following types are supported:

- NUMERIC - Decimal value like "1.23" or "-2345". 
- NOMINAL - A value from a fixed length list like "gender" or "favorite film genre". *It is a default value.*
- TEXT - Longer, usually free entered text
- DATE - XSD-formatted date like "2014-08-07"
- DATETIME - XSD-formatted time without a time zone like "2014-08-07T14:43:12"

## Source

The "source" is used to define the view on the specified user. If you have multiple sources/systems for updating user attributes like e.g.:

- registration service to set the gender and age of the user
- Facebook-linked application to set the favorite brands the user "liked" in your shop,

every new upload of attributes will **replace** the previous attribute set of **the same user and the same source**.

If you need to get all the available attributes for all sources, use query string parameter `allSources`:

`GET: https://import.yoochoose.net/api/0000/facebook/user/CUSTOMER_1234?allSources`

In this case an additional XML-attribute "source" will be added if the source is different from the source provided in the request ("facebook" in the example above).
