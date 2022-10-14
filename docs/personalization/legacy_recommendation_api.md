---
description: An old method of fetching recommendations from the system using recommendation requests.
---

# Legacy Recommendation API

!!! caution

    This is a page describing the old version of the recommendation API. 
    It is available for reference purposes only.

    Use the new [Recommendation API](recommendation_api.md) instead.

This page describes how to fetch recommendations from the Recommender System through
recommendation requests.
Before recommendation can be fetched from the recommendation controller, a sufficient 
number of events must be collected and the model build must finish successfully.

!!! note

    **BASIC Authentication** for fetching recommendations is enabled for some 
    configurations (for example for Gambio Plugin) by default.
    Use the `customerid` as username and the license key as password.
    The license key is displayed in the upper right in the [Admin GUI](https://admin.yoochoose.net/)) 
    after you log in with your registration credentials.

    If you plan to use [JSONP](https://www.w3schools.com/js/js_json_jsonp.asp), authentication 
    must be disabled.
    If it is enabled in your solution (can be easily tested with a recommendation request in a browser), please contact the eZ Recommender support (<support@yoochoose.com>) for further information and disabling.

## Getting recommendations

Recommendations are retrieved from the Personalization server with RESTful requests 
by using the GET method.
The result is a list of item IDs that can be used to call the underlying CMS 
or shop system, to retrieve the necessary information for the rendering process.

To allow the customer to retrieve different types of recommendations based on different methods (for example, Collaborative Filtering, Content Based, Stereotype, etc.) the Recommendation System uses scenario IDs relating to a predefined set of configurations inside the system.
These configurations are a combination of methods and filters that should be applied including possible fallbacks if the requested methods do not deliver a result.

A recommendation request looks like this:

**`https://reco.perso.ibexa.co/\[solutionid\]/\[customerid\]/\[userid\]/\[scenarioid\].\[extension\]?parameter=value&\[attributename=attributevalue\]`**

The embedded parameters `solutionid`, `clientid` and `userid` are the same as used for event tracking. Additional embedded parameters are described in the following table.

| Parameter Name | Description | Values |
|-----|-----|------|
| `scenarioid` | The ID of the scenario used for providing recommendations. It is configured or predefined in the Administration GUI. | alphanumeric |
| `extension` | The format the server generates the response in. There are three formats supported: JSON, XML and JSONP. See the chapter [Response Handling](#response-handling) below for more information | json, xml or jsonp |

## Basic Request Parameters

Using additional query string parameters one can customize the recommendation request.

|Parameter name|Description|Values|
|---|---|---|
|`numrecs`|Defines the number of recommendations that should be delivered. Keep this amount as low as possible as this increases the response time of the recommendation call.|1 to 50 (default "10")|
|`contextitems` (required for context based recommendations)|Comma-separated list of items that the user is currently viewing on the webpage. All items must be from the same type. The type is defined in the scenario configuration.|comma separated list of item IDs (1 to 2147483647)|
|`itemid` (deprecated)|A single item to be used as a source for creating recommendations. This parameter is deprecated. Use `contextitems` instead.|1 to 2147483647|
|`outputtypeid` (required, if the scenario defined multiple output item types, otherwise it is optional)|Item type of the requested recommendations. This can differ from the input item type, for example, if you want to get recommendations for pictures based on an article the item type for pictures has to be used here. For a web shop this is probably not needed as only one type of items is tracked. Multiple item types are available only for advanced license.|numeric|
|`categorypath`|Base category path for providing recommendations. The format is the same as the category path for the event tracking. It is possible to add this parameter multiple times. The order of recommendations from the different categories is defined by the calculated relevance.|alphanumeric[/alphanumeric]*|
|`jsonpcallback` (used only for JSONP request)|Function or method name for a JSONP request. It can be a function ("callme"), or a method ("obj.callme").|valid JavaScript function call (by default "jsonpCallback")|

An example of the recommendation request: 

**`https://reco.perso.ibexa.co/ebl/0000/smith/productpage.json?contextitems=123&categorypath=%2FCamera%2FCompact&numrecs=8`**

It fetches 8 recommendations for user Smith, who is watching the item 123 and the category *"/Camera/Compact"* from the scenario with the identifier productpage.

!!! tip

    See the section [Advanced Request Parameter](#advanced-request-parameter) below in this document for advanced features.

    See the section [Integration best Practices](#integration-best-practices) below in this document for the implementation examples.

## Response handling

The recommendation request returns a list of item IDs that are JSON, JSONP or XML-formatted.
The result can be easily integrated into any webpage by using some lines of script code. 

!!! tips

    See the [Quickstart Guide](integrate_recommendation_service.md) for a simple example written in PHP.

The recommendation result list looks like the following:

Example JSON response:

``` json
{ recommendationResponseList: [ 
  { reason: "CF_I2I (context: ITEMS(s))", 
    itemType: 2, 
    itemId: 1399, 
    relevance: 100 },
  { reason: "POPULARITY_SHORT_BUY (context: ITEMS(s))", 
    itemType: 2, 
    itemId: 4711, 
    relevance: 91 
  } ] }
```

Example JSONP response:

``` json
jsonpCallback(
{ recommendationResponseList: [
  { reason: "CF_I2I (context: ITEMS(s))",
    itemType: 2,
    itemId: 1399,
    relevance: 100 },
  { reason: "POPULARITY_SHORT_BUY (context: ITEMS(s))",
    itemType: 2,
    itemId: 4711,
    relevance: 91
  } ] })
```

Example XML response:

``` xml
<list>
<recommendation>
  <itemId>1241769000</itemId>
  <reason>POPULARITY_SHORT_BUY (context: ITEMS(s))</reason>
  <relevance>148</relevance>
  <itemType>1</itemType>
</recommendation>
</list>
```

The "reason" field string tells the user out of which model the recommendations were provided. The models are preconfigured by the Personalization server.
For example "*CF\_I2I (context: ITEMS(s))*" means that the model which provides the recommendation is "Collaborative Filtering based on an Item to Item similarity" with the context item as input.
The human readable explanation is (in this case) "Users who bought this item also bought these items".

The "relevance" defines the similarity to the context item according to internal algorithm and scenario configuration.
A higher value means a "better" recommendation. The list of recommendations is sorted by the relevance in descending order.

### Response Codes

The Following HTTP response codes are used by the recommendation controller.

|HTTP Status Code|Description|
|---|---|
|200 OK|Request was successfully processed.|
|304 Not Modified|Recommendation result was not modified since the time specified in the provided If-Modified-Since header.|
|400 Bad Request</br>414 Request-URI Too Long|The request is wrongly formatted. See response body for more information.|
|401 Unauthorized|Not valid authentication credentials.|
|403 Forbidden|Access denied.|
|404 Not Found|The requested element was not found. It can be customer ID (a.k.a. mandator ID), model ID, scenario ID etc.|
|409 Conflict|The combination of used models and the recommendation request parameters doesn't allow to provide recommendations. This could be, for example, if personalized recommendations are requested for a user who has no history at all.|
|500 Internal Server Error|Unspecified error. Please inform support if you get this error repeatedly.|

The body of the response in case of errors contains human-readable error message.
The format of error messages can be changed and should not be used for automated processing.

## Advanced Request Parameter

There are some additional very special request parameters.

###### any attribute name (used only if submodels are configured)

Item's attribute, for example, color, price, etc.
These are customer specific and can only be understood by the recommender system if the item attributes are imported by using the YOOCHOOSE content import APIs.
There can be multiple attributename and attributevalue pairs.

Legacy Recommendation API and [Submodel configuration]([[= user_doc =]]/personalization/recommendation_models.md#submodels) is required for taking an advantage from this parameter.

**Values**: alphanumeric=alphanumeric [&alphanumeric=alphanumeric]

###### `usecontextcategorypath`

If set to true, the category path of the contextitem(s) will be resolved by the recommender engine from the internal store and used as base category path.
If more than one category is returned, all categories are used for providing recommendations.
Avoid setting this parameter to true to minimize the response time.
Use the parameter categorypath to provide the category to the recommender engine during the request.

**Values**: true or false (default "false")

###### `recommendCategory` (to be used only in the eZ Recommendation extension)

If passed in combination with a "categorypath" value, the "closest" category the recommended items linked with will be delivered in the response as additional field "category".

```
recommendationResponseList: [ {
        itemId: 1007640000,
        category: "09/0901/090113", ... } ... ]
```

This feature helps to find "better" template for articles, which are located in several categories.

For example there is an article about football in the USA.
The article is located in both categories "/Sport/Football" and "/America/USA".
Depending on the category it is shown with a football field or the USA flag in the background.

If this article is recommended and is clicked in the category "/Sport/Cricket" it must open with the "football" template.
If the article is clicked in the category "/America/Canada" it must open with the "USA" template.

The category information is returned only if the article is located in several categories and the "better" category found.

**Values**: true or false (default "false")

## Recommendation Caching

In most cases the response of the recommendation service can be cached for some time.
Depending on the used recommendation model and context it can dramatically reduce the number of recommendation requests and therefore the price for using the recommendation service.
Recommendation service support following HTTP headers to allow cache control on the client side:

|Scope|||Example|Format|
|---|---|---|---|---|
|Request|`If-Modified-Since`|Allows a *304 Not Modified* to be returned if content is unchanged.|`If-Modified-Since: Sat, 29 Oct 2013 19:43:31 GMT`|"HTTP-date" format as defined by [RFC 2616](https://tools.ietf.org/html/rfc2616)|
|Response|`Last-Modified`|The last modification date of the recommendations.|`Last-Modified: Tue, 15 Nov 2013 12:45:26 GMT`|-|
||`Expires`|Gives the date/time after which the response is considered to be outdated|`Expires: Thu, 01 Dec 2013 16:00:00 GMT`|-|

The last modification timestamp indicates a change that could influence the recommendation response. It depends on an updated recommendation calculation, an update of an item or some scenario configuration changes. The expiration timestamp is a best-effort prediction based on the model building configuration and provided context. The shortest expiration period is 5 minutes from the request time. The longest is 24 hours. In the table below several examples are illustrated:

| Model | Context | Expiration time | Description |
|------|------|-----|-----|
| Bestselling products last 7 days | no context | 24 hours | The model with the 7 days scope is usually built once a day. It can be easily cached for 24 hours. It has no context and can therefore be cached globally for all the users of a customer. |
| Also bought products in the last month | current product | 24 hours | The model with the 30 days scope is usually built once a day. The context is always the same. It can be cached for every product. The same result can be used for all users of a customer. |
| Also consumed read articles in the last hour | current article | 30 minutes | Models with a short scope are usually built several times a day or even per hour. In this case the expiration time is set to the half of the model build frequency/period. |
| Personalized recommendation based on the user's statistic | customers click history | now | Although the statistic model is not updated within minutes, it is very likely that the context will be changed shortly (customer clicks another product and therefore the click is added to his history). The expiration time should not be much longer than the user activity on the web page. |

In most cases you do not need to calculate the expiration time manually. The table above is provided for the orientation, how the Expires header of the HTTP response is calculated by the recommendation engine and already provided to your caching system. You just need to make sure that the Expires header is used in the configuration of your caching system instead of a static value out of your configuration.

## Integration best Practices

There are several ways to integrate the REST calls to the Recommendation engine and avoid the blocking of the web page rendering, if the communication with the Recommender is distrusted or interrupted.

#### **Simple Way**

The simplest way to load recommendations is to synchronously request the Recommendation Engine for recommendations as they are needed.
This way is sufficient in most cases. The most important drawback is that the request time increases by the time of the recommendation request.
If the network is overloaded or the Recommendation Engine is not available it can lock the request.

#### Loading in the bottom

You can place the code that loads the data from the eZ Recommender at the bottom of the generated document and flush the output buffer to the client just before requesting recommendations.
The browser will get a whole page to render and can display it even if the very end of the page is still loading.
Then the JavaScript code with the recommendation information loaded at the bottom of the page must fill the gaps on the page with recommendation as soon as it is completely loaded.

#### Non-blocking loading in the background

If the website is implemented in a language which supports multithreading or non-blocking I/O, it is possible to start the recommendation request just after the browser request is received.
The page generation and the recommendation requests will be accomplished in parallel.
By combining this idea with the previous solution and placing the recommendation results at the bottom of the page you can avoid any interruption in the processing.

#### Loading from JavaScript using JSONP

It is not possible to request the recommendation controller server directly from the JavaScript (over AJAX library or directly over XMLHttpRequest) because of the cross-domain restriction in most browsers.
One of the possible technique to work around this limitation is [JSONP](https://en.wikipedia.org/wiki/JSONP).

#### Loading over proxy

A better solution in comparison with JSONP is to provide the proxy on the server side, which will forward script requests to the Recommender system.
It can be implemented as a very simple proxy using the [mod\_proxy module](https://httpd.apache.org/docs/2.2/mod/mod_proxy.html) of Apache Webserver.
It just transfers the data and the JavaScript renders the response into HTML itself.

An alternative approach is creating the HTML code on the server side for every target page in a sense to simplify the script on the client side.

As a possible implementation of such a proxy following tools can be used: the apache proxy module, some independent daemon like “netcat” or a PHP script.

#### Comparison

An overview of pros and cons for each of the above techniques:

|Problem|Simple Way|Bottom loading|Background loading|JSONP|XMLHttpRequest + Proxy|
|---|---|---|---|---|---|
|Is not blocked by ad blockers or no-track plug-ins|Yes|Yes|Yes|-|Yes|
|Works if JavaScript is disabled|Yes|depends|-|-|-|	 	 
|Works for server without multithreading functionality|Yes|Yes|-|Yes|Yes|
|Compatible with frontend caching on the server|-|-|-|Yes|Yes|
|Does not delay page rendering|-|depends|depends|Yes|Yes|
|Supports authentication for recommendation fetching|Yes|Yes|Yes|-|depends|
