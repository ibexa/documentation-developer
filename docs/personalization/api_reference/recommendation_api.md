---
description: Use HTTP GET request method to render recommendations.
month_change: false
---

# Recommendation API

Recommendations are retrieved from the Personalization server with RESTful requests that rely on the HTTP GET method.
The result can a list of item IDs that can then be used to call the underlying CMS or shop system and postload the necessary information for the rendering process.

For more information about Personalization, see [Introduction](personalization.md) and [Basic integration](recommendation_integration.md).

!!! note "Authentication"

    For fetching recommendations, authentication is disabled by default, and it must be disabled when you use [JSONP](https://en.wikipedia.org/wiki/JSONP) for response handling.
    If authentication is enabled for recommendation requests and you want to change this, contact support@ibexa.co.

## GET requests

The request for recommendations uses the following pattern:

`GET https://reco.perso.ibexa.co/api/v2/[customerid]/[userid]/[scenarioid].[extension]?parameter=value&[attribute=attributekey]`

## Request parameters

For the request to return recommendations, you must provide the following parameters:

|Parameter|Description|Value|
|---|---|---|
|`customerid`|A customer ID (for example "00000"), as defined when [enabling Personalization](enable_personalization.md#set-up-customer-credentials). Can be used to identify a website in installations that [hosts multiple SiteAccesses]([[= user_doc =]]/personalization/use_cases/#multiple-website-hosting).|alphanumeric|
|`userid`|An ID of the tracked user in the website (for example, an internal customer code, a session code, or a cookie for anonymous users.|alphanumeric|
|`scenarioid`|An ID of the scenario used for providing recommendations, as defined in the back office.|alphanumeric|
|`extension`|A format of the response (either JSON or JSONP).|`json` or `jsonp`|

!!! caution "Parameter encoding limitations"

    All parameters must be URL-encoded (see RFC 3986) and cannot contain a backslash (`%5C`) character.

### Customizing the recommendation request

You can customize the recommendation request by using additional query string parameters.
For example, you can send the following request to the Personalization server: 

`GET https://reco.perso.ibexa.co/api/v2/00000/john.doe/landing_page.json ?contextitems=123&categorypath=%2FCamera%2FCompact&attribute=title&attribute=deeplink,description&numrecs=8`

The request fetches 8 recommendations for user ID `john.doe`, who is viewing item 123 and the category `/Camera/Compact`, based on the scenario with the identifier `landing_page`.
The recommendation response uses the JSON format and should include values of `title`, `deeplink` and `description` attributes.

You can use the following parameters to customize a request:

|Parameter|Example|Description|Value|
|---|---|---|---|
|`numrecs`|20|Defines a number of recommendations to be delivered. The lower this value, the shorter the response time. The default value is 10. |1 to 50|
|`contextitems`|10,13,14, or "CLICKED"|A comma-separated list of items that the user is viewing on the web page. The list is required by [context-based recommendations]([[= user_doc =]]/personalization/recommendation_models/). All items must be of the same type. The type is defined in the scenario configuration. If history code is used ("CLICKED","CONSUMED", "OWNS", "RATED" or "BASKET"), context items are pulled from the user profile (for example, the most recent clicks or purchases). This parameter is optional. |1 to 2147483647 (or alphanumeric if enabled)|
|`outputtypeid`|1|Required for scenarios that are defined with multiple output item types, otherwise optional. By default it's the first/lowest output type enabled in the scenario config.|numeric|
|`crosscontenttype`| |Used instead of `outputtypeid`, if set to true, displays recommendations for all output types defined in the scenario. | boolean|
|`jsonpCallback`|"myCallback"|Function or method name (used for JSONP request only). It can be a function ("callme"), or a method ("obj.callme"). The default value is "jsonpCallback".|legal JavaScript function call|
|`attribute`|"title" or "description"|If you apply this parameter, the engine tries to fetch the value of the attribute. For example, `&attribute=title` means fetching the title for the item that's delivered in the response, if available. The fetch works if content import has been successful. You can pass multiple attributes: `&attribute=title&attribute=description` or `&attribute=title,description`. Use this to pull "pure" client-based recommendations without requesting local customer data.|string|
|`categorypath`|`/Women/Shirts`|Category path for fetching recommendations. The format is the same as the category path used in event tracking. Add this parameter multiple times to get recommendations from multiple categories. The order of recommendations from different categories is defined by the calculated relevance. The default value is `%2F`, which stands for an entire website.|string[/string]* |
|`usecontextcategorypath`| |Used in conjunction with `categorypath`. If set to true, the category path of given context item(s) is resolved by the Personalization server from the internal store and used as base category path. If more than one category is returned, all categories are used for providing recommendations. Setting this parameter to true increases the response time. If possible, use the `categorypath` parameter to provide the category to the recommender engine during the request. The default value is false.|boolean|
|`recommendCategory`| |Used in conjunction with `categorypath`. If set to true, the neighboring category linked with the recommended items is delivered in the response as an additional field `category`. Helps find a suitable template for articles from several categories.<br/>For example, take an article about American football. The article is categorized as `Sport/Football` and `America/USA`. Depending on the category, the webpage displays a football field or an American flag in the background. If the article is recommended and clicked in the `Sport/Cricket` category, it must open with the "field" template. If clicked in the `America/Canada` category, it must open with the "flag" template. The category is returned only if the article is located in several categories and the "closer" category is found. The default value is false.|boolean|
|`usetimeslot`| |If set to true, configured time-slots are active. As a result, recommendations are calculated for specific time frames and they have priority over the recommendations from the main model in the hours for which time slots are configured. Time slots must be enabled by and configured [[= product_name_base =]] Team.|true|

##### Submodel parameters

If your recommendation model uses submodels to group content items/products based on an attribute, you can pass the following parameters to request recommendations for a specific group.

For more information, see [Submodels]([[= user_doc =]]/personalization/recommendation_models/#submodels).

|Parameter|Example|Description|Value|
|---|---|---|---|
|attribute key|`&color=red`|Applicable if a submodel with the same name and value is configured.|string|
|`userattribute`|gender|If defined, the Personalization server tries to find the attribute value for the current user and, if found, "prefers" recommendations that are typically followed by users with the same value of the attribute. The default value is null.|string, csv list|

!!! note "Multiple submodels in recommendations"

    If you send a request with two attribute keys, the response contains an intersection of two recommendation sets that originate from submodels calculated for these attributes.

    For example, to get recommendations for items of certain type that are limited by submodels based on both a nominal and numeric attribute, you can send the following request:

    `GET https://reco.perso.ibexa.co/api/v2/00000/john.doe/landing_page.json?numrecs=50&outputtypeid=1&width-range=10:30&color=green`

!!! note "Dynamic attribute submodels"

    If dynamic attribute submodels are enabled, you only need to add submodel parameters to the request to trigger dynamic submodels in the upcoming model build.

    Dynamic attribute submodels must be enabled by [[= product_name_base =]] Team.
    To start using this functionality, contact support@ibexa.co.

    When enabled, to build dynamic attribute submodels, you need to send the request (which includes `"ATTRIBUTE_NAME=VALUE"` query parameters) to the scenario with model you want to use submodels for:

    `GET https://reco.perso.ibexa.co/api/v2/00000/john.doe/{SCENARIO_NAME}?numrecs=50&outputtypeid=1&color=red`

##### Segment parameters

If you have configured segments, you can use them in the recommendation model. Pass the following parameter to request recommendations for a specific segment or segment group.

Parameter|Example|Description|Value|
|---|---|---|---|
|`segments`|`&segments=7,8,10,11`|ID from segment group management|string|

For more information, see [Segments]([[= user_doc =]]/personalization/segment_management/).

## Responses

The recommendation request returns information about the currently used context items and an array of recommendation objects in JSON or JSONP format.
The result can be integrated into any webpage on the client side by using script code.
To track user actions like "clickrecommended" and "rendered", use the links delivered in the response.

For more information, see inline comments below.

!!! note "Previewing recommendations"

    You can preview the actual responses that come from the Personalization server and how they're rendered in the user interface.
    For more information, see [Previewing scenario results]([[= user_doc =]]/personalization/preview_scenario_results/).

For more information about integrating recommendations in the web page, see [Best practices](recommendation_integration.md).

### Response object format

A JSON response can look like this:

``` json
{
  "contextItems": [ // Information about the request's contextitems
    {
      "viewers": 134, // A number of users that were looking at this item
                      // (You could put the information on the currently viewed content item/product page as "Currently viewed by ### visitors".)
      "itemType" : 1,
      "itemId" : 10,
      "sources" : "REQUEST"
    },
    {
      "viewers": 79,
      "itemType" : 1,
      "itemId" : 11,
      "sources" : "REQUEST"
    }
  ],
  "recommendationItems": [
    { // First recommendation
      "relevance": 23, // A level of similarity to the current item, the higher the better
      "itemType": 1,
      "itemId": 100175717,
      "origin": {
        "itemIds" : [10, 11], // Items that the recommendations are based on (context or user history items), multiple values are possible
        "itemType" : 1,
        "source" : "REQUEST" // Possible options: REQUEST (parameter "contextitems") or CLICK, CONSUME, BUY, BASKET, RATE (user history)
      },
      "category" : "Women/Shirts", // Provided only if category suggestion is requested
      "links" : {
         "clickRecommended" : "//event.perso.ibexa.co/api/[customerID]/clickrecommended/[someuser]/[itemtype]/[itemid]?scenario=<scenario>&...", // A link that is provided if User ID is available. Link is fired when this recommendation is clicked.
         "rendered" : "//event.perso.ibexa.co/..." // A link used to inform the engine that this recommendation was shown to the user
      },
      "attributes" : [  // Only values that were requested in the query string are provided
         {  "key": "title",
            "value": [
                "French Cuff Cotton Twill Oxford"
            ]
        }, ...
      ]
    },
    { // Second recommendation
      "relevance": 22,
      "itemType": 1,
      "itemId": 100172819,
      "origin": {
        "itemIds" : [10, 11],
        "itemType" : 1,
        "source" : "REQUEST"
      },
      ...
    },
    ...
  ]
}
```

A JSONP response can look like this (same comments apply):

``` json
jsonpCallback({
  "contextItems": [
    {
      "viewers": 134,
      "itemType" : 1,
      "itemId" : 10,
      "sources" : "REQUEST"
    },
    {
      "viewers": 79,
      "itemType" : 1,
      "itemId" : 11,
      "sources" : "REQUEST"
    }
  ],
  "recommendationItems": [
    {
      "relevance": 23,
      "itemType": 1,
      "itemId": 100175717,
      "origin": {
        "itemIds" : [10, 11],
        "itemType" : 1,
        "source" : "REQUEST"
      },
      "category" : "Women/Shirts",
      "links" : {
         "clickRecommended" : "//event.perso.ibexa.co/api/[customerID]/clickrecommended/[someuser]/[itemtype]/[itemid]?scenario=<scenario>&...",
         "rendered" : "//event.perso.ibexa.co/..."
      },
      "attributes" : [
         {  "key": "title",
            "value": [
                "French Cuff Cotton Twill Oxford"
            ]
        }, ...
      ]
    },
    {
      "relevance": 22,
      "itemType": 1,
      "itemId": 100172819,
      "origin": {
        "itemIds" : [10, 11],
        "itemType" : 1,
        "source" : "REQUEST"
      },
      ...
    },
    ...
  ]
})
```

### HTTP response codes

The following HTTP response codes are used by the recommendation controller:

|HTTP Status Code|Description|
|---|---|
|200 OK|Request was processed successfully.|
|304 Not Modified|Recommendation result wasn't modified since the time specified in the provided `If-Modified-Since` header.|
|400 Bad Request</br>414 Request-URI Too Long|Wrong request formatting. See response body for more information.|
|401 Unauthorized|Invalid authentication credentials.|
|403 Forbidden|Access denied.|
|404 Not Found|The requested element was't found. It could be customer ID (or "mandator ID"), model ID, or scenario ID.|
|409 Conflict|The requested combination of models and recommendation parameters can't return recommendations. This could happen, for example, if you request personalized recommendations for a user who has no history.|
|500 Internal Server Error|Unspecified error. Contact [[= product_name_base =]] support if this error is recurring.|

In case of errors, the response body contains human-readable error messages.
Error messages can change, don't use them for automated processing.

!!! note "Rendering data"

    If data import with the [Content API](content_api.md) was successful, you can also fetch data used for rendering (for example "title", "description" or "deeplink") from the recommendation response.

## Cache recommendations

The Personalization server's response can be cached.
Depending on the recommendation model and context, it can drastically reduce the number of recommendation requests.
The recommendation service supports the following HTTP headers to enable cache control on the client side (all date values must follow the "HTTP-date" format as defined by [RFC 2616](https://datatracker.ietf.org/doc/html/rfc2616)):

|Scope|Header|Description|Example|
|---|---|---|---|
|Request|`If-Modified-Since`|Enables returning the *304 Not Modified* code if content is unchanged.|`If-Modified-Since: Sat, 29 Oct 2013 19:43:31 GMT`|
|Response|`Last-Modified`|The last modification date of the recommendations.|`Last-Modified: Tue, 15 Nov 2013 12:45:26 GMT`|
|Response|`Expires`|Gives the date/time after which the response is outdated|`Expires: Thu, 01 Dec 2013 16:00:00 GMT`|

The last modification timestamp indicates a change that could influence the recommendation response.
It depends on an updated recommendation calculation, an update of an item or certain scenario configuration changes. 

The expiration timestamp is a best-effort prediction based on the model configuration and provided context.
The shortest expiration period is 5 minutes from the request time, the longest is 24 hours.

You don't usually have to calculate the expiration time manually.
Instead, make sure that the `Expires` header is used in the configuration of your caching system and not a static value out of your configuration.

To learn how Personalization server calculates the `Expires` header that's provided to your caching system, see the following table with caching strategy examples:

| Model | Context | Expiration time | Description |
|------|------|-----|-----|
| Bestselling products (last 7 days) | No context | 24 hours | The model with the 7 days scope is usually built once a day. You can cache its results for 24 hours. It has no context, therefore it can be cached globally for all the users of the site. |
| Also bought products (last month) | Current product | 24 hours | The model with the 30 days scope is usually built once a day. The context is always the same, therefore it can be cached for every product, and the same result can be used for all users of the site. |
| Also consumed articles (last hour) | Current article | 30 minutes | Models with a short scope are usually built several times a day or even per hour. The expiration time is set to half of the model build frequency. |
| Personalized recommendation based on the user's statistic | User's click history | Now | Statistical models aren't updated within minutes, and it's likely that the context changes shortly (a user clicks another product, the click is added to their history). The expiration time shouldn't be much longer than the user's activity on the web page. |
