---
description: Allows to track items using it ID. It covers many Content Types with the same ID configured for tracking.
---

# Tracking API

To provide recommendations, a tracking process needs to collect user behavior 
on the customer's site. 
The most popular user events are:

- Click - When a user opens a detail page.
- Buy/Consume - When a user buys an item or consumes content
- Rate - When a user likes, comments or rates an item
- Login - When a user logs in on a website
- Clickrecommended - When a user clicks a recommendation

For a complete list of events, see [Event types]([[= user_doc =]]/personalization/event_types) in the user documentation. 
Depending on the event type, some additional parameters, such as item price 
or user rating, must be provided.

Importing historical user data can help you reduce the delay in delivery of high 
quality recommendations. 
For more information, see [Importing historical user tracking data](importing_historical_user_tracking_data.md).

Apart from the tracking API, you can add tracking to the website by integrating 
a JavaScript library.
For more information, see [Tracking with yct.js](tracking_with_yct.md).

## Definitions

You can use the tracking API both in eCommerce and content publishing scenarios. 
eCommerce mostly uses the term "product", whereas the Publisher domain widely 
uses the terms "content", "article", "images" or "videos". 
Therefore, a generic term "item" is used instead to cover all the mentioned types. 
For further segmentation the term "item type" is used, which, in combination 
with the item ID itself, defines a domain specific object.

For example, an electronic product can be defined by item type "1" and item id "3298", 
while a textile product can be defined by item type "2" and item id "3298".

!!! note

    Usually only one item type is sufficient in the eCommerce business as each 
    product available in an eCommerce shop has a unique identifier.

|Domain|Item ID|Item Type|
|---|---|---|
|Content publishing|Article|ID of an article|
|Content publishing|Video|ID of a video|
|Content publishing|Photo Gallery|ID of a photo gallery|

Assuming the numbering of content is independent and the same item ID is used 
for two items of different item types, it is impossible to tell the difference 
if there is no segmentation by item types.

If an article, a video and a photo gallery have the same item ID, use different 
item types to separate the items that are tracked.
For example:

- item type "1" and itemid "29712" -> article
- item type "2" and itemid "29712" -> video
- item type "3" and itemid "29712" -> photo gallery

!!! note

    Even if item IDs cannot overlap in a customer's system, Ibexa recommends using 
    different item types to provide independent tracking and cross-item type recommendations, 
    such as, for example, "Users who read this article also watched these videos" 
    or "Users who liked this gallery also read these articles".

## Identifiers

### User identifier

High quality recommendations can only be delivered if the underlying data 
is correct and consistent. 
For consistent tracking it is crucial to choose and use a consistent identifier for a user. 
A user usually visits a website anonymously. 
Therefore, their identifier is either a first-party cookie or a session ID 
provided by the website. 
If there is no existing user ID handling that we can re-use, it is recommended that 
you use your own cookie and set the expiry date to at least 90 days from the last usage. 
If there is a login mechanism, the user is usually tracked with a temporary 
identifier before the login. 
Immediately after a successful login process a Login event must be sent.
At this point a [pseudonymous](https://eur-lex.europa.eu/legal-content/EN/TXT/HTML/?uri=CELEX:32016R0679&from=EN#d1e1489-1-1) user ID, 
for example, a system's internal registration id, must be used. 
After logout, the anonymous user ID can be used again.

!!! note

    The user identifier is required in tracking requests, otherwise it is discarded 
    from the tracking servers.

    If a browser has JavaScript or cookies disabled, make sure that you put some 
    "dummy" value as identifier in the tracking request to avoid losing tracking 
    information. 
    Even if the event is not user-specific, it is still useful for [popularity models]([[= user_doc =]]/personalization/recommendation_models/).

The Personalization server internally creates a hash of every user ID. 
The original ID is not saved. 
It is still possible that the original ID appears in the log files for the debugging 
purposes but log files are purged regularly. 
The user ID is case sensitive.

### Item identifiers

Persons responsible for the sales policy in place in your organization must decide 
what should be presented as recommendations on the website. 
In the eCommerce business you mostly have the possibility to track items based on:

- Stock Keeping Unit (SKU) or
- Universal Product Code (UPC)

The exact identifiers that are tracked are also recommended ("what-you-track-is-what-you-get"). 
By default, it is not possible to track SKUs but recommend UPCs. 
The following use case is typical for eCommerce business:

Customer A implements the Personalization server and decides to use the SKU 
as item identifiers and recommendable items. 
End users who browse through the shop probably get recommendations of 
the same item that is currently displayed but in a different size and/or color, 
a so-called "variant". 
The Personalization server does not recognize relations between items, therefore, 
every single SKU is used to calculate similarities between them. 
In the case of bestsellers, this could lead to the appearance of a shirt 
in size L on position 2 and the same shirt in size M on position 4.

Customer B decides to use the UPC as item identifiers. 
This results in recommendations that do not contain variations of the currently shown item. 
Therefore, the detail page of shirt X does not contain a recommendation 
for the same shirt in a different size. 
And the same shirt does not show up twice on a list of bestseller recommendations.

If the size of an item or the color is selectable on a detail page of an item, 
you may prefer to use the UPC. 
If recommendations of the same item in different sizes or colors are desired, 
you should use the SKU as item identifiers.

Remember to use the same identifier in all interactions between your website 
and the Personalization server, for example, when a user buys an item, 
clicks a recommendation or displays a product page.

## Request parameter categorypath

Category paths are logical tree structures that lead to items and are used for 
recommendation filtering. 
For example, "recommend only items from the same category".

During recommendation requests, the category path must always be provided.
The category path is a forward slash-separated list of categories from the root, for example, `%2FFoto%2FCameras%2FCompact%2FCanon`.
The initial slash (if present) is ignored. 
Like all other parameters, the category path must be URL-encoded and cannot contain backslashes.

The "categorypath" parameter offers the possibility to provide category-based 
recommendations without an explicit export of the structure of a customer's website. 
If enabled by Ibexa, it is used for on-the-fly updating of item categories. 
If an item is moved to another category, it is handled as present in both 
categories until the old category ages out or is forcibly deleted. 
Multiple category locations of an item (multi-homing) are therefore possible.

!!! note "Category paths"

    When you import your own item metadata by using the Personalization server 
    import interface, you might choose to not provide the category path 
    in the Click event. 
    Category path is required by default, contact Ibexa to change the default 
    configuration.

## Track events

!!! note

    Events are forwarded to the Personalization server with HTTP or HTTPS requests 
    (or [RESTful-Requests](https://en.wikipedia.org/wiki/Representational_state_transfer). 
    Both GET and POST methods are allowed for the event tracking. 
    Make sure that all embedded and query string parameters are URL encoded and 
    do not use a backslash [encoded as %5C\].

### Click event

When the end user opens an item/article detail, a Click events is sent. 
The Click event often provides additional information about the category 
structure of the website.

!!! note

    User IDs are not stored in the database. 
    They are irreversibly anonymized before saving to disk or building the 
    recommendation model.

The URL to track user clicks has the following format:

`GET https://event.perso.ibexa.co/api/[customerid]/click/[userid]/[itemtypeid]/[itemid]`


|Name|Description|Values|
|---|---|---|
|`customerid`|A customer ID (for example "00000"). Can be used to identify a website in installations that [hosts multiple SiteAccesses]([[= user_doc =]]/personalization/use_cases/#multiple-website-hosting).|alphanumeric|
|userid|A user's ID on the website of the customer. It could be an internal customer code, a session code or a cookie for anonymous users.|URL-encoded alphanumeric|
|`itemtypeid`|Item type ID.|1 to 2147483647|
|`itemid`|A unique ID of the item the user has clicked.</br>String-based identifiers are also supported as item IDs to track content on a website, but it is discouraged due to fraud and security issues. If you are unable to provide numeric identifiers for the tracking process, contact Ibexa for further information and implementation notes.|1 to 2147483647|

All embedded parameters are required for the request. 
Some optional request parameters can be set over query string parameters (GET parameters).

`GET https://event.perso.ibexa.co/api/[customerid]/click/[userid]/[itemtypeid]/[itemid]?parameter1=value1&parameter2=value2`

|Name|Description|Values|
|---|---|---|
|`categorypath`|The forward slash-separated path of categories of the item. Like all other parameters it must be URL-encoded, for example `%2FCameras%26Foto%2FCompact%20Cameras%2FCanon`.</br>For use cases, see [Category path filters]([[= user_doc =]]/personalization/filters/#category-path-filters) in the user documentation.|URL-encoded string.</br>Initial and trailing slashes are ignored: "/Cameras/" is the same as "Cameras".|

### Consume event

!!! note "eCommerce vs. content publishing"

    The Consume event is important for content publishing websites. 
    For eCommerce stores, this event is not required but can be used in custom implementations.

The event is sent when the end user stays on the page for a predefined period of time. 
It is then assumed that the user consumed the item (read an article or watched a video).

The URL has the following format:

`GET https://event.perso.ibexa.co/api/[customerid]/consume/[userid]/[itemtypeid]/[itemid]`

All embedded parameters are the same as for a Click event. 
The following table lists the request parameters:

|Name|Description|Values|
|---|---|---|
|`percentage`|Informs how much of an item was consumed, for example, that an article was read only in 20%, a movie was watched in 90% or someone finished 3/4 of all levels of a game.|0-100|

The logic for calculating the percentage is defined by the implementation. 
For articles, this could be by scrolling down, for a movie/video based on the 
consumption part. 
You must decide what 100% consumption means. 
For example, a movie contains end titles that are almost never consumed.
Therefore, they should not be part of the percentage calculation.

The simplest implementation for articles is a JavaScript timer, which sends this 
event after a predefined time has elapsed (and the user did not leave the page). 
The timespan after that the event is triggered should be dependent on the content, 
for example, it could be 30 seconds for a small newspaper article or a timespan 
calculated by the amount of words.

!!! note "Incremental tracking of consume events"

    Consume events for a user can be sent incrementally as the recommender uses 
    only the highest percentage rate. For example, if a user watches a movie, 
    the website could send Consume events in 10% steps to avoid losing tracking 
    information when the browser window is forcibly closed.

### Buy event

As the name suggests, this event is used when an end user buys an item. 
It must be sent to the event tracker at the end of a successful check-out process 
to ensure that no further action of the user can result in an abort.

The URL has the following format: 

`GET https://event.perso.ibexa.co/api/[customerid]/buy/[userid]/[itemtypeid]/[itemid]?fullprice=2.50EUR&quantity=4`

In addition to the fact that an item is bought, this event should provide information 
about the product price and quantity.

|Name|Description|Values|
|---|---|---|
|`quantity`|The number of products a user has bought. Default value is "1". You can send n events instead of setting this parameter to n. This parameter is optional.|integer (default is "1")|
|`fullprice`|A price for a single product. It contains the price in decimal format plus the currency ISO 4217 code. If the price has a decimal part, the point must be used. There can be no space between price and currency. This parameter is optional.|currency, for example "12.45EUR" or "456JPY"|

For example, if a user bought 4 pens for 10 Euros, `fullprice` can be set to "2.50EUR" 
and `quantity` can be set to 4.

The Buy event is only relevant if the user is charged per product, like in a classic shop. 
If products are sold on a subscription basis, or the web presence is ad-sponsored, 
this event type is not applicable.

#### Prices in a Buy event

Every Buy event can contain a price. 
If the price is set, it is stored with the event and used for calculating the 
revenue for statistics. 
The price must be a price the user paid for the item, including all taxes and discounts. 

If product price filtering is activated, the information provided over the product 
import is used. 
For more information, see [Content API](content_api.md).

The currency is stored with the price and normalized only when statistic information 
is requested. 
It is often a good choice to select a base currency and convert prices before 
sending the buy event. 
The price attached to a buy event never overwrites the price which was defined 
in an item import.

### Login event

Recommendations rely on the fact that user actions can be correlated over a longer 
period of time. 
Moreover, recommendations similar to "users who viewed this product ultimately 
bought it" require correlating Click events with subsequent Buy events. 
In general, users tend to browse a website anonymously and add products to their 
shopping cart. 
Up to this point, a user is identified by a visit-scoped variable (for example, 
a session ID or a first party cookie). 
During the check-out of the shopping cart, a user probably logs in to an existing account. 
As a result, the user identifier changes from an anonymous visit-scoped ID 
(sourceuserid) to a pseudonymous, persistent account ID (targetuserid). 
You should correlate both IDs to correlate the Buy events (account ID) with 
the preceding Click events (visit-scoped ID). 
The Login event serves exactly this purpose.

The format of the URL is: 

`GET https://event.perso.ibexa.co/api/[customerid]/login/[sourceuserid]/[targetuserid]`

|Name|Description|Values|
|---|---|---|
|sourceuserid|User identifier valid up to now(usually some anonymous session ID)|URL-encoded alphanumeric|
|targetuserid|User identifier valid from now on (usually an account ID or login name)|URL-encoded alphanumeric|

### Basket event

The Basket event can be used to add products to a user's shopping cart. 
This event is especially useful if anonymized checkout is allowed or no recurring 
user identification is possible. 
By using the shopping cart products as input for getting recommendations, problems 
with an empty profile or no buy history for the user can be solved. 
The more valuable Basket events instead of recent user clicks can be used to provide 
personalized recommendations. 
It also happens quite often that users "store" products on their shopping wishlist 
and plan to buy them later. 
With the help of this information, personalized shopping cart-based recommendations 
can be provided in the whole shop.

`GET https://event.perso.ibexa.co/api/[customerid]/basket/[userid]/[itemtypeid]/[itemid]`

There are no query string parameters for this event. 

### Rate event

Publishers, media or shops often allow commenting/rating products, articles or movies. 
If a user comments on an item, it indicates a special interest in this topic that has 
to be treated separately.

The format of the URL is:

`GET https://event.perso.ibexa.co/api/[customerid]/rate/[userid]/[itemtypeid]/[itemid]?rating=50`

This can also be used for explicit ratings like a five-star rating for hotels. 
A predefined rating can be submitted when the user comments on an item.

|Name|Description|Values|
|---|---|---|
|`rating`|The rating a user gives an item. The rating value is normalized during the calculation of rate-based recommendations. Therefore, there is no need to use the full scale of 0-100 but it needs to be consistent.|integer from 0 to 100|

### Blacklist event

If a website offers a link or button that allows feedback similar to "do not 
recommend this product to me anymore", a user could express that they have bought 
it already in another shop.

The format of the URL is:

`GET https://event.perso.ibexa.co/api/[customerid]/blacklist/[userid]/[itemtypeid]/[itemid]`

There are no query string parameters for this event. 

## Tracking events based on recommendations

Tracking events based on integrated recommendations are the only way to measure 
success of recommendations. 
It is crucial to inform the Personalization server about which recommendations 
were shown and what recommendations were clicked. 
Otherwise, reliable statistics cannot be calculated and used to check against 
the customer's KPIs.

A recommendation response already includes the requests to generate a Clickrecommended 
or Rendered event. 
They are used and executed when a recommendation is clicked/accepted or a recommendation 
is shown. 
Sending Rendered events causes as many requests as recommendations to be displayed, 
a Clickrecommended event is usually sent only once (when a user clicks on 
a specific recommendation item).

Example of a recommendation response:

``` jsonp
"recommendationItems": [
    {
      "relevance": 23,
      "itemType": 1,
      "itemId": 100175717,
      "origin": {
        "itemIds" : [10, 11], // these are the items that the recommendations are based on (context or user history items), multiple values are possible
        "itemType" : 1,
        "source" : "REQUEST" // Possible options: REQUEST (parameter "contextitems") or CLICK, CONSUME, BUY, BASKET, RATE (user history)
      },
      "category" : "Men/Shirts", // Provided only, if category suggestion is requested
      "links" : {
         "clickRecommended" : "//event.perso.ibexa.co/clickrecommended/johndoe/1/100175717?scenario=also_clicked&modelId=37",
         "rendered" : "//event.perso.ibexa.co/rendered/johndoe/1/100175717"
      },
```

In the `links` field, the delivered request string is visible, which is executed 
when the end user displays or clicks a recommendations. 
See [Recommendation API](recommendation_api.md) for more details.

You can still implement the traditional way as mentioned below but it is strongly 
recommended against this. 
If you do so, remember to examine it together with the Ibexa team because it is 
crucial for statistical analysis.

### Clickrecommended event

When the end users clicks a recommendation, the following event is sent 
to gather statistics related to the acceptance of recommendations. 

The URL has the following format:

`GET https://event.perso.ibexa.co/api/[customerid]/clickrecommended/[userid]/[itemtypeid]/[itemid]?scenario=<scenarioid>`

The embedded parameters are the same as for a Click event. 

The request parameters are:

|Name|Description|Values|
|---|---|---|
|`scenario`|Name of the scenario, where recommendations originated from. This parameter is required.|URL-encoded alphanumeric|

The scenario parameter identifies the originating scenario to gain detailed statistics 
about the scenario that motivated the user to click on a recommendation. 
This information comes with the recommendation from the recommendation controller. 

The event is used for providing statistics about how often recommendations of 
the configured recommendation scenario were accepted or considered as useful by users. 

### Rendered event

This event sent when the website uses the recommendation provided by the recommendation 
engine and renders it on the webpage. 
In combination with a predefined threshold, it allows the recommender engine to 
exclude this item from future results and avoid recommending the same item to the 
same user multiple times during a session.

The URL for a Rendered event has the following format:

`GET https://event.perso.ibexa.co/api/[customerid]/rendered/[userid]/[itemtypeid]/[itemid[,itemid]]`

The Rendered event has the same embedded parameters as the Click event, except 
for the item ID. 
It is common that recommendations are rendered as a block with multiple items. 
To save traffic and reduce latency, you can bundle multiple recommendations in one request. 
Several item IDs must be comma-separated.

## Tracking event examples

Below are examples for the translation of user actions on a website into tracking requests.

User "Js79009234YU7" navigates to an item 123 of type 1, located under `Shoes/Children`:

`GET https://event.perso.ibexa.co/api/00000/click/Js79009234YU7/1/123?categorypath=%2FShoes%2FChildren`

Products 128, 129 and 155 of type 1 are rendered as recommendations for user "Js79009234YU7". 
Recommendations were delivered by the scenario "also\_bought":

`GET https://event.perso.ibexa.co/api/00000/rendered/Js79009234YU7/1/128,129,155`

User clicks a recommended product 155 that was delivered by the scenario "also\_bought":

`GET https://event.perso.ibexa.co/api/00000/clickrecommended/Js79009234YU7/1/155?scenario=also_bought`

User "Js79009234YU7" has watched a video 452 (all videos are item type "3"):

`GET https://event.perso.ibexa.co/api/00000/consume/Js79009234YU7/3/452`

User "Js79009234YU7" has watched 60 percent of a video 466:

`GET https://event.perso.ibexa.co/api/00000/consume/Js79009234YU7/3/452?percentage=60`

User "Js79009234YU7" puts products 128 and 129 into the cart.

`GET https://event.perso.ibexa.co/api/00000/basket/Js79009234YU7/1/128`

`GET https://event.perso.ibexa.co/api/00000/basket/Js79009234YU7/1/129`

To buy selected products, user "Js79009234YU7" logs in and obtains an internal 
identifier (for example, the registration ID) "johndoe" from the site. 

`GET https://event.perso.ibexa.co/api/00000/login/Js79009234YU7/johndoe`

The user buys two products from the cart: product 128 (one piece for the price 
  of EUR 19.99) and product 129 (2 pieces for the price of EUR 4.44 each).

`GET https://event.perso.ibexa.co/api/00000/buy/johndoe/1/128?quantity=1&fullprice=19.99EUR`
`GET https://event.perso.ibexa.co/api/00000/buy/johndoe/1/129?quantity=2&fullprice=4.44EUR`

User "johndoe" likes the product 133 and wants to rate it with 5 stars.

`GET https://event.perso.ibexa.co/api/00000/rate/Js79009234YU7/1/133?rating=5`

### Response handling

The following HTTP response codes are used by the event tracker.  

|HTTP Status Code|Description|
|---|---|
|200 OK</br>204 No Content|Request was successfully processed.|
|400 Bad Request</br>414 Request-URI Too Long|The request is wrongly formatted. See response body for more information.|
|401 Unauthorized|Invalid authentication credentials.|
|403 Forbidden|Access denied (not implemented yet).|
|404 Not Found|The customer ID was not found. The event code was not found.|
|500 Internal Server Error|Unspecified error. Contact Ibexa if this error reoccurs frequently.|

In case of errors, the body of the response contains human-readable error messages. 
Human-readable error messages can be changed and should not be used for automated processing.
