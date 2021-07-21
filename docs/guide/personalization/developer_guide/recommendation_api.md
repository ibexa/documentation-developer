# Recommendation API

!!! note

    Before recommendations can be fetched from the recommendation controller, a sufficient number of events must be collected. On a website with more than 100 clicks per day, one day of collecting user data should be sufficient for the first recommendations. They will become better over time, that is with the amount of user data collected.

    **BASIC Authentication** for fetching recommendations is disabled by default. If enabled, use the customerid as username and the license key as password. The license key is displayed in the upper right corner in the Admin GUI ([https://admin.yoochoose.net](https://admin.yoochoose.net/)) after logging in with your registration credentials.

    If you plan to use [JSONP](https://en.wikipedia.org/wiki/JSONP), authentication must be disabled. If it is enabled in your solution and you want to remove authentication for recommendation requests, please contact <support@ibexa.co> for further information and disabling.

Recommendations are retrieved from the Recommendation Engine via RESTful requests using the HTTP GET method. The result is at least a list of item IDs that can be used to call the underlying CMS or shop system in order to postload the necessary information for the rendering process.

!!! note "Rendering Data"

    If a data import via the [Content API](content_api.md) has been successful, it is also possible to fetch rendering data like e.g. "title", "description" or "deeplink" from the recommendation response.

To allow a customer to get recommendations based on predefined configurations, so-called "scenarios" are used. Scenarios are a combination of models and filters that should be applied to recommendation results including possible fallbacks. See [Scenarios](https://doc.ibexa.co/projects/userguide/en/3.3/personalization/scenarios/), [Recommendation Models](https://doc.ibexa.co/projects/userguide/en/3.3/personalization/recommendation_models/) and [Filters](https://doc.ibexa.co/projects/userguide/en/3.3/personalization/filters/) for more information about scenario configuration.

A recommendation request looks like this:

    GET https://reco.yoochoose.net/api/v2/[customerid]/[userid]/[scenarioid].[extension]?parameter=value&[attribute=attributekey]

The embedded parameters `customerid` and `userid` are the same as used in the [Tracking API](tracking_api.md). Additional embedded parameters are described in the following table. 

|Parameter Name|Description|Values|
|---|---|---|
|`scenarioid`|The ID of the scenario used for providing recommendations. It is defined in the Admin GUI.|alphanumeric|
|`extension`|The format in which the server generates the response. There are two formats supported: JSON, JSONP. See [Response Handling](#response-handling) below for more information|json or jsonp (xml is deprecated)|

!!! caution "XML format"

    XML is deprecated and will not be developed further on. It can only be used in the old api (without using `/v2/` in the recommendation URL)

    `GET https://reco.yoochoose.net/api/[customerid]/[userid]/[scenarioid].xml?parameter=value&[attribute=attributekey]`

## Basic Request Parameters

Using additional query string parameters you can customize the recommendation request.

|Parameter Name|Example|Description|Values|
|---|---|---|---|
|`numrecs`|20|Defines the number of recommendations that should be delivered. Keep this number as low as possible as this increases the response time of the recommendation call.|1 to 50 (default "10")|
|`contextitems` (required for context-based recommendations)|10,13,14 or "CLICK"|Comma-separated list of items that the user is currently viewing on the web page. All items must be of the same type. The type is defined in the scenario configuration. If a history code like "CLICKED","CONSUMED", "OWNS", "RATED" or "BASKET" is used, the user's profile is used to simulate context items (e.g. the last clicks or the last purchases).|comma-separated list of item IDs (1 to 2147483647) or comma-separated list of alphanumeric item IDs if enabled for the customer|
|`itemid` (deprecated)|10|A single item to be used as a source for creating recommendations. This parameter is deprecated. Use `contextitems` instead.|numeric|
|`outputtypeid` (required if the scenario defined multiple output item types, otherwise it is optional)|1|Required if the scenario defined multiple output item types, otherwise it is optional.|numeric (default is the first/lowest outputtype enabled in the scenario config)|
|`categorypath`|"Women/Shirts"|Category path for fetching recommendations. The format is the same as the category path in the event tracking. It is possible to add this parameter multiple times to get recommendations from multiple categories. The order of recommendations from the different categories is defined by the calculated relevance.|string[/string]* (default is `%2F`, meaning the whole website)|
|`jsonpCallback` (used only for JSONP request)|"myCallback"|Function or method name for a JSONP request. It can be a function ("callme"), or a method ("obj.callme").|legal JavaScript function call (default is "jsonpCallback")|
|`attribute`|"title" or "description"|If this parameter is used, the recommender will try to fetch the value of the given attribute.</br>E.g. `&attribute=title` will try to fetch the value of the attribute title for the item which is delivered in the recommendation response if available. It works if the content import has been done successfully.</br>Multiple attributes are allowed, e.g. `&attribute=title&attribute=description` or csv-style: `&attribute=title,description`</br>It allows pure client-based recommendations without requesting local customer data.|string|

An example of the recommendation request: 

 `GET https://reco.yoochoose.net/ebl/0000/john.doe/detailpage.json` `?contextitems=123&categorypath=%2FCamera%2FCompact&attribute=title&attribute=deeplink,description&numrecs=8`

It fetches 8 recommendations for user john.doe, who is watching item 123 and the category *"/Camera/Compact"* from the scenario with the identifier detailpage. The recommendation response should also include the attribute values of the attributes `title`, `deeplink` and `description `for rendering the recommendations.

## Advanced Request Parameters

### Categorypath Parameters

|Parameter Name|Description|Values|
|---|---|---|
|`usecontextcategorypath`|If set to true, the category path of the given contextitem(s) will be resolved by the recommender engine from the internal store and used as base category path. If more than one category is returned, all categories are used for providing recommendations. Avoid setting this parameter to true to minimize the response time. If possible, use the parameter categorypath to provide the category to the recommender engine during the request.|default is false|
|`recommendCategory `|If passed in combination with a `categorypath` value, the "closest" category the recommended items linked with will be delivered in the response as additional field "category".</br>This feature helps to find "better" template for articles, which are located in several categories.</br>For example there is an article about football in the USA. The article is located in both categories "Sport/Football" and "America/USA". Depending on the category it is shown with a football field or the USA flag in the webpage background.</br>If this article is recommended and is clicked in the category "Sport/Cricket" it must open with the "football" template. If the article is clicked in the category "America/Canada" it must open with the "USA" template.</br>The category information is returned only if the article is located in several categories and the "closer" category is found.|default is false|

### Submodel Request Parameters

|Parameter Name|Description|Values|
|---|---|---|
|any attribute key (for example "color") |Used if a submodel with the same name and value is configured. See Submodel configuration for more information.</br>Example: `&color=red`|-|
|`userattribute`|If defined, the recommender tries to find the attribute value for the current user and - if available - prefers recommendations which are typically used by the current user's gender, e.g. attributename of a user like "userattribute=gender" or "userattribute=customerclass" or csv separated "userattribute=gender,customerclass"|default is null|

## Response handling

The recommendation request returns information about the currently used contextitems and an array of recommendation objects in JSON or JSONP format. The result can be integrated into any webpage on the client side by using some lines of script code. Please use the delivered links in the response to track user actions like "clickrecommended" and "rendered", see comments below.

Example JSON response:

``` json
{
  "contextItems": [ // information about the request's contextitem(s)
    {
      "viewers": 134, // number of users that were looking at this item
                      // You can for example put the information next to the currently viewed product/article as "currently viewed by 134 visitors".
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
    { // first recommendation
      "relevance": 23, //level of similarity to the current item, the higher the better
      "itemType": 1,
      "itemId": 100175717,
      "origin": {
        "itemIds" : [10, 11], // these are the items that the recommendations are based on (context or user history items), multiple values are possible
        "itemType" : 1,
        "source" : "REQUEST" // Possible options: REQUEST (parameter "contextitems") or CLICK, CONSUME, BUY, BASKET, RATE (user history)
      },
      "category" : "Women/Shirts", // Provided only if category suggestion is requested
      "links" : {
         "clickRecommended" : "//event.yoochoose.net/api/[customerID]/clickrecommended/[someuser]/[itemtype]/[itemid]?scenario=<scenario>&...", // a link which is provided if a user ID is available. It should be fired if this recommendation is clicked
         "rendered" : "//event.yoochoose.net/..." // a link which should be used to tell the recommender that this recommendation was shown to the user
      },
      "attributes" : [  // only values that were requested in the query string are provided
         {  "key": "title",
            "value": [
                "French Cuff Cotton Twill Oxford"
            ]
        }, ...
      ]
    },
    { // second recommendation
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

Example JSONP response:

``` json
jsonpCallback({
  "contextItems": [ // information about the request's contextitem(s)
    {
      "viewers": 134, // number of users that were looking at this item
                      // You can for example put the information next to the currently viewed product/article as "currently viewed by 134 visitors".
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
    { // first recommendation
      "relevance": 23, //level of similarity to the current item, the higher the better
      "itemType": 1,
      "itemId": 100175717,
      "origin": {
        "itemIds" : [10, 11], // these are the items that the recommendations are based on (context or user history items), multiple values are possible
        "itemType" : 1,
        "source" : "REQUEST" // Possible options: REQUEST (parameter "contextitems") or CLICK, CONSUME, BUY, BASKET, RATE (user history)
      },
      "category" : "Women/Shirts", // Provided only if category suggestion is requested
      "links" : {
         "clickRecommended" : "//event.yoochoose.net/api/[customerID]/clickrecommended/[someuser]/[itemtype]/[itemid]?scenario=<scenario>&...", // a link which is provided if a user ID is available. It should be fired if this recommendation is clicked
         "rendered" : "//event.yoochoose.net/..." // a link which should be used to tell the recommender that this recommendation was shown to the user
      },
      "attributes" : [  // only values that were requested in the query string are provided
         {  "key": "title",
            "value": [
                "French Cuff Cotton Twill Oxford"
            ]
        }, ...
      ]
    },
    { // second recommendation
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

##  Response Codes

The Following HTTP response codes are used by the recommendation controller.

|HTTP Status Code|Description|
|---|---|
|200 OK|Request was successfully processed.|
|304 Not Modified|Recommendation result was not modified since the time specified in the provided If-Modified-Since header.|
|400 Bad Request</br>414 Request-URI Too Long|The request is wrongly formatted. See response body for more information.|
|401 Unauthorized|Illegal authentication credentials.|
|403 Forbidden|Access denied.|
|404 Not Found|The requested element was not found. It can be customer ID (a.k.a. mandator ID), model ID, scenario ID in the request.|
|409 Conflict|The combination of used models and given recommendation request parameters doesn't allow to provide recommendations. This could be e.g. if personalized recommendations are requested for a user who has no history at all.|
|500 Internal Server Error|Unspecified error. Please inform support if you get this error repeatedly.|

The body of the response in case of errors contains human-readable error message. The format of error messages can be changed and should not be used for automated processing.

## Recommendation Caching

In most cases the response of the recommendation service can be cached for some time. Depending on the used recommendation model and context it can dramatically reduce the number of recommendation requests and therefore the price of using the recommendation service. Recommendation service support following HTTP headers to allow cache control on the client side:

|Scope|||Example|Format|
|---|---|---|---|---|
|Request|`If-Modified-Since`|Allows a *304 Not Modified* to be returned if content is unchanged.|`If-Modified-Since: Sat, 29 Oct 2013 19:43:31 GMT`|"HTTP-date" format as defined by [RFC 2616](https://tools.ietf.org/html/rfc2616)|
|Response|`Last-Modified`|The last modification date of the recommendations.|`Last-Modified: Tue, 15 Nov 2013 12:45:26 GMT`|-|
||`Expires`|Gives the date/time after which the response is considered to be outdated|`Expires: Thu, 01 Dec 2013 16:00:00 GMT`|-|

The last modification timestamp indicates a change, that could influence the recommendation response. It depends on an updated recommendation calculation, an update of an item or some scenario configuration changes. The expiration timestamp is a best-effort prediction based on the model building configuration and provided context. The shortest expiration period is 5 minutes from the request time. The longest is 24 hours. In the table below several examples are illustrated:

| Model | Context | Expiration time | Description |
|------|------|-----|-----|
| Bestselling products last 7 days | no context | 24 hours | The model with the 7 days scope is usually built once a day. It can be easily cached for 24 hours. It has no context and can therefore be cached globally for all the users of a customer. |
| Also bought products in the last month | current product | 24 hours | The model with the 30 days scope is usually built once a day. The context is always the same. It can be cached for every product. The same result can be used for all users of a customer. |
| Also consumed read articles in the last hour | current article | 30 minutes | Models with a short scope are usually built several times a day or even per hour. In this case the expiration time is set to the half of the model build frequency/period. |
| Personalized recommendation based on the user's statistic | customers click history | now | Although the statistic model is not updated within minutes, it is very likely that the context will be changed shortly (customer clicks another product and therefore the click is added to his history). The expiration time should not be much longer than the user activity on the web page. |

In most cases you do not need to calculate the expiration time manually. The table above is provided for the orientation, how the Expires header of the HTTP response is calculated by the recommendation engine and already provided to your caching system. You just need to make sure that the Expires header is used in the configuration of your caching system instead of a static value out of your configuration.

## Further Reading

- Best Practices: [Recommendation Integration](../best_practices/recommendation_integration.md)
- [Representational state transfer - Wikipedia](https://en.wikipedia.org/wiki/Representational_state_transfer)
- [Uniform Resource Identifier (URI): Generic Syntax](https://tools.ietf.org/html/rfc3986)
- [Apache Module mod\_proxy](https://httpd.apache.org/docs/2.2/mod/mod_proxy.html)
- [Hypertext Transfer Protocol - HTTP/1.1](https://tools.ietf.org/html/rfc2616)
- [Personalization quickstart](../personalization_quickstart.md)
