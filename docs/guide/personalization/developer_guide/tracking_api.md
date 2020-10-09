# Tracking API

If you are interested in importing historical user data, see [Importing historical user tracking data](importing_historical_user_tracking_data.md) as well. It speeds up enabling high quality recommendations.

If you want to use a javascript library to add tracking into your website, see [Tracking with yct.js](tracking_with_yct.md).

In order to provide recommendations a tracking process needs to collect user behavior on the customer's site. Most popular examples of such events are:

- "Click", if a user opens a detail page
- "Buy" or "Consume", if a user buys an item or consumes in some other way (watches videos, reads articles, etc.)
- "Rate" if a user likes, comments or rates an item
- "Login" if a user logs in on a website and
- "Clickrecommended" if a user decides to click on a recommendation

See user guide chapter [4. Event Types](https://doc.ezplatform.com/projects/userguide/en/master/personalization/event_types.md) for a brief introduction to different types of events. Depending on the event type, some additional parameters like item price or user rating must be provided.

## Wording of products, articles and the generic term items

This documentation is primarily intended to be used for E-commerce and Publishers. It is hard to use generic wording in each domain as E-commerce mostly uses the term "product", whereas the Publisher domain widely uses the terms "content", "article", "images" or "videos". Because of this the generic term "item" will be used instead to cover all types, meaning "products", "content", "article", "images" or "videos". For further segmentation we use the term "itemtype" which in combination with the item ID itself defines a domain specific object.

The following tables show some examples of items that are defined by an item id and an item type:

|Domain||Item ID|Item Type|
|---|---|---|---|
|E-commerce|Product|id of a product|type of a product|

An electronic product could be defined by item type "1" and item id "3298"

A textile product could be defined by item type "2" and item id "3298"

!!! note

    Usually only one item type is sufficient in the E-commerce business as each product available in an E-commerce shop has a unique identifier (see also chapter Item Identifiers)

|Domain||Item ID|Item Type|
|---|---|---|---|
|Publisher|Article|id of an article|type of content|
|Publisher|Video|id of a video|type of content|
|Publisher|Photo Gallery|id of a photo gallery|type of content|

Assuming the numbering of content is independent and the same item ID is used twice but for different item types. It is therefore impossible to define the difference if there's no segmentation by item types.

If an article, a video and a photo gallery have the same item ID, e.g. 29712, we would use three different item types to separate the items that are tracked:

- item type "1" and itemid "29712" -> article
- item type "2" and itemid "29712" -> video
- item type "3" and itemid "29712" -> photo gallery

!!! note

    Even if item ids cannot overlap in a customer's system, we strongly recommend using different item types in order to provide independent tracking and cross-item type recommendations like "Users who read this article also watched these videos" or "Users who liked this gallery also read these articles".

## Identifiers

### User Identifier

High quality recommendations can only be delivered if the underlying data is correct and consistent. For consistent tracking it is crucial to choose and use a consistent identifier for a user. Usually a user visits a website as an anonymous user. Therefore their identifier is either own first-party cookie or a session ID provided by the website. If there's no existing user ID handling that we can re-use, we encourage using own cookie and setting the expiry date to at least 90 days from the last usage. If there's a login mechanism, the user is usually tracked with a temporary identifier before the login. Immediately after a successful login process a "login" event (see below) must be sent and from then on the pseudonymous user identifier (e.g. a system's internal registration id) must be continuously used. After (automatic) logout, the anonymous user id can be used again.

!!! note

    The user identifier is required in tracking requests, otherwise it is discarded from the tracking servers.

    If a browser has JavaScript or cookies disabled, please verify that you put some "dummy" value as identifier in the tracking request to avoid losing tracking information. Even if the event is not user-specific, it is still useful for popularity models (e.g. Topsellers, see [6. Recommendation Models](https://doc.ezplatform.com/projects/userguide/en/master/personalization/recommendation_models.md)).

Internally the recommendation engine creates a hash of every user ID. The original ID is not saved. It is still possible that the original ID appears in the log files for debug purposes but log files are are purged regularly. The user ID is case sensitive.

### Item Identifiers

As a customer or, more precisely, the specialty department you need to evaluate what should be presented as recommendations on your site. In the E-commerce business you mostly have the possibility to track items based on:

- **Stock Keeping Unit** (SKU) or
- **Master Item Identifier** (MII)

The exact identifiers that are tracked will also be recommended ("*what-you-track-is-what-you-get"*). By default it is not possible to track SKUs but recommend MIIs. Following is an example of a typical decision case in the E-commerce business:

Customer A implements the YOOCHOOSE Recommender Engine and decides to use the **SKU** as item identifiers and recommendable items. What could happen is that users browsing through the shop **will probably get recommendations of the same item that is currently displayed but in a different size and/or color, a so-called "variant"**. As the Recommender Engine doesn't know anything about the relations between items, every single SKU is used to calculate similarities between them. In the case of bestsellers, this could lead to the appearance of a shirt in size L on position 2 and the same shirt in size M on position 4.

Customer B decides to use the **MII** as item identifiers. This will lead to recommendations **that will not contain variations of the currently shown item**. In this case it could not happen that on the detail page of shirt X the same shirt in a different size is recommended. In the case of bestsellers it is therefore not possible to have the same shirt on two positions in the list of recommendations.

If the *size of an item or the color is selectable* on a detail page of an item, you may prefer to use the MII. If recommendations of the *same item in different sizes or colors* are desired, you should use the SKU as item identifiers.

Remember to use the same identifiers in all interactions between your site and the recommendation engine, e.g. if a user buys an item, a recommendation is clicked or displayed etc.

## Request Parameter categorypath

The category path is the logical tree structure which leads to an item and is used for recommendation filtering. For example "recommend only items from the same category".

During recommendation requests the category path must always be provided! The category path is a forward slash-separated list of categories from the root, such as: "%2FFoto%2FCameras%2FCompact%2FCanon". The first slash (if set) is ignored. Like all other parameters, the category path must be URL-encoded and due to a limitation of the HTTP server must not contain backslashes.

The "categorypath" parameter plays an important role as it offers the possibility to provide category-based recommendations without an explicit export of the structure of a customer's website. If enabled by YOOCHOOSE it is used for on-the-fly updating of item categories. If an item is moved to another category, it will be handled as being in both categories until the old category ages out or is forcibly deleted. Multiple category locations of an item (multi-homing) are therefore possible.

!!! note "|Category Paths"

    If you import your own item metadata over the recommendation engine import interface, you do not necessarily need to provide the category path in the "click" event. As this is activated by default, please contact <support@yoochoose.com> to set the desired configuration.

## Tracking Events

!!! note

    Events are forwarded to the Recommendation System engine using "http" or "https" requests, so-called [RESTful-Requests](https://en.wikipedia.org/wiki/Representational_state_transfer). Both GET and POST methods are allowed for the event tracking. Make sure that all embedded and query string parameters are URL encoded (see [RFC 3986](https://tools.ietf.org/html/rfc3986)). Due to a restriction of the used HTTP server, it is not allowed to use a backslash \[encoded as %5C\] in the embedded parameters (the context path of the URL).

### Click Event

If a user opens an item/article detail, a "Click" events needs to be sent. Often "Click" events also provide information about the category structure of websites.

!!! note

    We do not store the user ID itself in the database. All user IDs are non-reversibly anonymized before the user profile is stored to the disk or the recommendation models are built.

The URL to track user clicks has the following format:

`GET https://event.yoochoose.net/api/[customerid]/click/[userid]/[itemtypeid]/[itemid]`


|Name|Description|Values|
|---|---|---|
|customerid|Your customer ID, a.k.a. "mandator ID" (for example "00000").|alphanumeric|
|userid|A user's ID on the website of the customer. It could be an internal customer code, a session code or a cookie for anonymous users. See chapter "Request Format and Parameters" below in this document for more information on user ID.|URL-encoded alphanumeric|
|itemtypeid|Item type ID. See the chapter Item Type ID for more information. See chapter "Request Format and Parameters" bellow in this document for more information to the item type ID.|1 – 5|
|itemid|Unique ID of the item the user has clicked.</br>Product IDs based on string identifiers: We also support string identifiers for item IDs to track content on a website but it is discouraged due to fraud and security issues. If you are not able to provide numeric identifiers for the tracking process, please get in touch with us under support@yoochoose.com for further information and implementation notes.|1 to 2147483647|

All embedded parameters are required for the request. Some optional request parameters can be set over query string parameters (GET parameters).

`GET https://event.yoochoose.net/api/[customerid]/click/[userid]/[itemtypeid]/[itemid]?parameter1=value1&parameter2=value2`

|Name|Description|Values|
|---|---|---|
|categorypath|The forward slash-separated path of categories of the item. Like all other parameters it must be URL-encoded, for example `%2FCameras%26Foto%2FCompact%20Cameras%2FCanon`</br>See chapter [Category Filter](https://doc.ezplatform.com/projects/userguide/en/master/personalization/filters.md#category-filter) of the user guide for additional use cases of the category path.|URL-encoded string.</br>Forward and trailing slash is ignored; "/Cameras/" is the same as "Cameras"|

### Consume Event

!!! note "Publisher vs. Shop solution"

    The "consume" event is important for publisher/media web pages (like a newspaper, news agency or online movie provider). For E-commerce stores this event is not necessarily needed but can of course be used in own implementations.

The event should be sent if the user stays on the page for some predefined period of time. In this case it is assumed that the user consumed the item (read an article or finished watching a video).

The URL has the following format:

`GET https://event.yoochoose.net/api/[customerid]/consume/[userid]/[itemtypeid]/[itemid]`

All embedded parameters are the same as for a click event. The request parameters are:

| Name       | Description                                                                                                                                                   | Values |
|------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------|--------|
| percentage | It defines how much of an item was consumed, e.g. an article was read only in 20%, a movie was watched in 90% or someone finished 3/4 of all levels of a game | 0-100  |

The logic for calculating the percentage is to be defined by the implementation. For articles this could be by scrolling down, for a movie/video based on the consumption part. Keep in mind that you should put some though into what 100% consumption means. For example a movie contains end titles which are probably almost never consumed and therefore should not be part of the percentage calculation.

The simplest implementation for articles is a JavaScript timer, which sends this event after some predefined time has elapsed (and the user did not leave the page). The timespan after that the event is triggered should be dependent on the content, e.g. it could be 30 seconds for a small newspaper article or a timespan calculated by the amount of words.

!!! note "Incremental tracking of consume events"

    Consume events for a user can be sent incrementally as the recommender uses only the highest percentage rate. For example if a user watches a movie, the site could sent consume events in 10% steps in order not to lose tracking information when the browser window is forcibly closed.

### Buy Event

As the name suggests this event must be used if a user buys an item. It must be sent to the event tracker at the end of a successful check-out process to ensure that no further action of the user can result in an abort.

The URL has the following format: 

`GET https://event.yoochoose.net/api/[customerid]/buy/[userid]/[itemtypeid]/[itemid]?fullprice=2.50EUR&quantity=4`

In addition to the fact that an item is bought, this event should provide information about the product price and quantity.

|Name|Description|Values|
|---|---|---|
|quantity (optional)|The number of products a user has bought. Default value is "1". It is possible to send n events instead of setting this parameter to n.|Integer (default is "1")|
|fullprice (required)|A price for a **single** product. It contains the price in decimal format plus the currency ISO 4217 code. If the price has a decimal part, the point must be used. There can be no space between price and currency.|For example "12.45EUR" or "456JPY"|
|price (deprecated)|**This parameter is deprecated, use the "fullprice" instead!** The price for a single item in Euro cents, e.g. 2.25EUR is price=225, default currency "EUR" is assumed.|Integer|
|currency (deprecated)|**This parameter is deprecated, use the "fullprice" instead!** The currency of a price. If left out the default currency "EUR" is assumed.|ISO 4217|

For example, if a user bought 4 pens for 10 Euros, the parameter "fullprice" must be set to "2.50EUR" and parameter "quantity" to 4.

The "buy" event is only relevant if the user is charged per product like it happens in a classic shop. If products are sold on a subscription base or the web presence is ad-sponsored, this event type is not needed.

#### Prices in a Buy Event

As mentioned above, every buy event can contain a price. If the price is set, it is stored with the event and used for calculating revenue for statistics. The price should be a price the user paid for the item including all taxes and discounts. 

If product price filtering is activated, the information provided over the product import is used. See chapter [Content API](content_api.md) for more information.

The currency is stored with the price and normalized only when statistic information is requested. It is often a good choice to select a base currency and convert prices before sending the buy event. The price attached to a buy event never overwrites the price which was defined in an item import.

### Login Event (a.k.a. Transfer event)

Recommendations rely on the fact that user actions can be correlated over a longer period of time. Moreover, recommendations like "users who viewed this product ultimately bought it" require correlating click events with subsequent buy events. In general, users tend to browse a site anonymously and add products to their shopping cart. Up to this point, a user is identified by a visit-scoped variable (e.g. a session ID or a first party cookie). During the check-out of the shopping cart, a user probably logs in to an existing account. As a consequence, the user identifier changes from an anonymous visit-scoped ID (sourceuserid) to a pseudonymous, persistent account ID (targetuserid). It is highly desirable to correlate both IDs in order to correlate the buy events (account ID) with the preceding click events (visit-scoped ID). The administrative event 'login' serves exactly this purpose.

The format of the URL is: 

`GET https://event.yoochoose.net/api/[customerid]/login/[sourceuserid]/[targetuserid]`

|Name|Description|Values|
|---|---|---|
|sourceuserid|User identifier valid up to now(usually some anonymous session ID)|URL-encoded alphanumeric|
|targetuserid|User identifier valid from now on (usually an account ID or login name)|URL-encoded alphanumeric|

!!! note "Deprecated 'transfer' event"

    Based on feedback of our customers and to make the purpose a bit clearer, we renamed the formerly named 'transfer' event to 'login'. As the name implies, it should be used when a user logs in. It covers exactly the same functionality as the transfer event. There is no need to change anything on the customer's side for existing implementations as the transfer event https://event.yoochoose.net/\[solutionid\]/\[customerid\]/transfer/\[sourceuserid\]/\[targetuserid\] will still be supported but should be considered as deprecated!

### Basket Event

The basket event can be used to add products to a user's shopping cart. This event is especially useful if anonymized checkout is allowed or no recurring user identification is possible. By using the shopping cart products as input for getting recommendations, the empty profile or cold-start problem (meaning the user has no buy history) can be solved. The more valuable basket events instead of recent user clicks can be used to provide personalized recommendations. It also happens quite often that users "store" products on their shopping wishlist and plan to buy them later. With the help of this information, personalized shopping cart-based recommendations can be provided in the whole shop.

`GET https://event.yoochoose.net/api/[customerid]/basket/[userid]/[itemtypeid]/[itemid]`

|Name|Description|Values|
|---|---|---|
|categorypath|The categorypath from where the item is placed into the shopping cart.|URL-encoded string|

The categorypath parameter should be added for statistical reasons. Often articles or products are multihomed in a shop or a media/publisher site. In order to analyze from which location products were sold most often, the categorypath should be provided.

### Rate Event

Publishers, media or shops often allow commenting/rating products, articles or movies. If a user comments on an item, it indicates a special interest an this topic that has to be treated separately.

The format of the URL is:

`GET https://event.yoochoose.net/api/[customerid]/rate/[userid]/[itemtypeid]/[itemid]?rating=50`

This can also be used for explicit ratings like a five star rating or any other liquor scale-based rating. The predefined rating can be submitted when the user comments on an item.

|Name|Description|Values|
|---|---|---|
|rating|The rating a user gives an item|Integer from 0 to 100 (The rating value is normalized during the calculation of rate based recommendations. So there's no need to use the full scale of 0-100 but it needs to be consistent)|

### Blacklist Event

If a website offers a link or button that allows feedback like "do not recommend this product to me anymore" a user could express that they have bought it already on behalf of somebody else or in another shop.

The format of the URL is:

`GET https://event.yoochoose.net/api/[customerid]/blacklist/[userid]/[itemtypeid]/[itemid]`

There are no query string parameters for this event. 

## Tracking Events based on Recommendations

Tracking events based on integrated recommendations is the only way to measure success of recommendations. It is crucial to tell the recommendation engine which recommendations were shown and what recommendations were clicked. Otherwise reliable statistics cannot be calculated and used to check against a customer's KPIs.

In a recommendation response, the requests to generate a Clickrecommended or Rendered Event are already included. They should be used and executed when a recommendation was clicked/accepted or a recommendation was shown. Sending Rendered Events causes as much requests as recommendations to be displayed, a Clickrecommended Event is usually sent only once (if a user clicks on a specific recommendation item).

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
         "clickRecommended" : "//event.yoochoose.net/clickrecommended/johndoe/1/100175717?scenario=also_clicked&modelId=37",
         "rendered" : "//event.yoochoose.net/rendered/johndoe/1/100175717"
      },
```

In the field "links" you can see the delivered request string to be executed when displaying or clicking on recommendations. See [Recommendation API](recommendation_api.md) for more details.

You can still implement the traditional way as mentioned below but we **strongly advise against this**. If you do so, keep in mind to check it thoroughly with the YOOCHOOSE team as it is crucial for statistical analysis.

### Clickrecommended Event (a.k.a. Follow Event)

If users click on a recommendation, the following event should be sent to gather statistics over the acceptance of recommendations. Click-recommended events are also known as follow-events. The URL has the following format:

`GET https://event.yoochoose.net/api/[customerid]/clickrecommended/[userid]/[itemtypeid]/[itemid]?scenario=<scenarioid>`

All embedded parameters are the same as for a click event. The request parameters are:

|Name|Description|Values|
|---|---|---|
|scenario (required)|Name of the scenario, where recommendations originated from.|URL-encoded alphanumeric|

The scenario parameter identifies the originating scenario to gain detailed statistics about which scenario motivated the user to click on a recommendation. This information comes with the recommendation from the recommendation controller. 

This event is used for providing statistics about how often recommendations of the configured recommendation scenario were accepted or considered as useful by users. Besides that this information is used for providing and evaluating A/B Tests.

### Rendered Event

Render events must be sent if the website uses the recommendation provided by the recommendation engine and renders it on the webpage. In a combination with a predefined threshold it allows the recommender engine to exclude this item from a future result and not recommend the same item to the same user multiple times during a session.

The URL for a render event has the following format:

`GET https://event.yoochoose.net/api/[customerid]/rendered/[userid]/[itemtypeid]/[itemid[,itemid]]`

The render event has the same embedded parameters as a click event except for the item ID. It is common that recommendations are rendered as a block with multiple items. To save traffic and reduce latency, it is possible to bundle multiple recommendations in one request. Several item IDs must be comma-separated.

## Examples of translating user actions into tracking events

Below are examples for the translation of user actions on a website into tracking requests:

User "Js79009234YU7" navigates to an item with the id 123 and type "1" which is located under Shoes -&gt; Children:

`GET https://event.yoochoose.net/api/00000/click/Js79009234YU7/1/123?categorypath=%2FShoes%2FChildren`

Products 128, 129 and 155 of type 1 are rendered as recommendations for user "Js79009234YU7". Recommendations were delivered by the scenario "also\_bought":

`GET https://event.yoochoose.net/api/00000/rendered/Js79009234YU7/1/128,129,155`

They click on recommended product 155 that was delivered by the call of scenario "also\_bought":

`GET https://event.yoochoose.net/api/00000/clickrecommended/Js79009234YU7/1/155?scenario=also_bought`

User "Js79009234YU7" has watched a video with the id 452 (videos have item type "3"):

`GET https://event.yoochoose.net/api/00000/consume/Js79009234YU7/3/452`

User "Js79009234YU7" has watched 60 percent of a video with the id 466 (videos have item type "3"):

`GET https://event.yoochoose.net/api/00000/consume/Js79009234YU7/3/452?percentage=60`

User "Js79009234YU7" puts the product 128 and later 129 into the shopping basket.

`GET https://event.yoochoose.net/api/00000/basket/Js79009234YU7/1/128`

`GET https://event.yoochoose.net/api/00000/basket/Js79009234YU7/1/129`

To buy selected products, user "Js79009234YU7" logs in and gets an internal identifier "johndoe" (e.g. registration ID) from the site. Do not forget that it must be URL-encoded.

`GET https://event.yoochoose.net/api/00000/login/Js79009234YU7/johndoe`

They buy both products from the shopping basket: product 128 (one piece and the price of EUR 19.99) and product 129 (2 pieces with the price of EUR 4.44 each)

`GET https://event.yoochoose.net/api/00000/buy/johndoe/1/128?quantity=1&fullprice=19.99EUR`
`GET https://event.yoochoose.net/api/00000/buy/johndoe/1/129?quantity=2&fullprice=4.44EUR`

User "johndoe" likes the product 133 and wants to rate it, e.g. with 5 stars

`GET https://event.yoochoose.net/api/00000/rate/Js79009234YU7/1/133?rating=5`

### Response Handling

The following HTTP response codes are used by the event tracker.  

|HTTP Status Code|Description|
|---|---|
|200 OK</br>204 No Content|Request was successfully processed.|
|400 Bad Request</br>414 Request-URI Too Long|The request is wrongly formatted. See response body for more information.|
|401 Unauthorized|Illegal authentication credentials.|
|403 Forbidden|Access denied (not implemented yet).|
|404 Not Found|The customer ID (a.k.a. mandator ID) was not found. The event code was not found.|
|500 Internal Server Error|	Some unspecified error. Please inform support@yoochoose.com if it you get this error repeatedly.|

In case of errors the body of the response contains human-readable error messages. Human-readable error messages can be changed and should not be used for automated processing.
