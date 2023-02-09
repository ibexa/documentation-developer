---
description: Integrate recommendation service into your website.
---

# Integrate recommendation service

To return recommendations, you must first [enable the Personalization service](enable_personalization.md).
Next, integrate the service with [[= product_name =]] by activating 
event tracking and embedding recommendation results into the website.

!!! note

    Examples below use '00000' as a customer ID for creating requests.
    In a real-life scenario, use the customer ID that you receive from Ibexa.

## Track events

The service primarily relies on event tracking. 
For the events to be registered, every Content item or product page must call 
a special tracking URL.
The easiest way of embedding the tracking URL is placing a one pixel image on every page, 
like in the case of analytical tools or visitor counters.
A code that includes an image looks like this:

`<img href="https://event.perso.ibexa.co/ebl/00000/click/<user_ID>/<content_type_ID>/<content_ID>" width="1" height="1">`

where:

- `<user_ID>` stands either for the user ID or session ID of the user who is currently 
logged into your website (any URL-encoded string is allowed).

- `<content_type_ID>` stands for the [contentTypeId](content_model.md#content-information) of the Content item or product that you want to track and recommend.

- `<content_ID>` stands for the [id](content_model.md#content-information) of the Content item or product that you want to track and recommend.

The following examples show how you can integrate a CLICK event:

PHP:

``` php
$mandator_id = '00000';
$product_id = '123';
$server = '//event.perso.ibexa.co';
$tracking = $server.'/ebl/'.$mandator_id.'/click/'.urlencode(session_id()).'/1/'.$product_id;
echo "<img href='$tracking' width='1' height='1'>";
```

JavaScript:

``` js
var mandator_id = '00000';
var product_id = '123';
var server = '//event.perso.ibexa.co';
var url = server + '/api/' + mandator_id + '/click/' + getSessionId() + '/1/' + product_id;
var ycimg=new Image(1,1);
ycimg.src=url;
```

A similar tracking image can be placed on a confirmation page that ends the payment process.

``` php
$server = '//event.perso.ibexa.co';
foreach ($just_bought_products as $product_id) {
   $tracking = $server.'/ebl/'.$mandator_id.'/buy/'.urlencode(session_id()).'/1/'.$product_id;
   echo "<img href='$tracking' width='1' height='1'>\n";
}
```

## Embed recommendations

As soon as the Personalization server collects enough events, it can generate recommendations.
The more tracking data is available, the more accurate the recommendations.
Recommendations can be fetched with the following calls, and the response is returned in JSON format.

To return the most popular products, use:

`https://reco.perso.ibexa.co/api/v2/00000/<user_ID>/landing_page.json`

To return products that the current user is most probably interested in, use:

`https://reco.perso.ibexa.co/api/v2/00000/<user_ID>/cross_sell.json?contextitems=OWNS,CLICKED`

To return products that are most probably interesting for users interested in product 123, use:

`https://reco.perso.ibexa.co/api/v2/00000/<user_ID>/cross_sell.json?contextitems=123`

A response with two recommendations resembles the following object:

``` json
{
   "contextItems":[
      {
         "itemId":123,
         "itemType":1,
         "sources":[
            "REQUEST"
         ],
         "viewers":0
      }
   ],
   "recommendationItems":[
      {
         "itemId":555,
         "itemType":1,
         "relevance":127,
         "links":{
            "clickRecommended":"//event.perso.ibexa.co/api/00000/clickrecommended/user/1/555?scenario=landing_page&modelid=5768",
            "rendered":"//event.perso.ibexa.co/api/00000/rendered/user/1/555?scenario=landing_page&modelid=5768"
         }
      },
      {
         "itemId":444,
         "itemType":1,
         "relevance":126,
         "links":{
            "clickRecommended":"//event.perso.ibexa.co/api/00000/clickrecommended/user/1/444?scenario=landing_page&modelid=5768",
            "rendered":"//event.perso.ibexa.co/api/00000/rendered/user/1/444?scenario=landing_page&modelid=5768"
         }
      }
   ]
}
```

You can use the following code to make requests and parse results:

``` php
$mandator_id = '00000';
$license_key = '67890-1234-5678-90123-4567';
$server = "https://reco.perso.ibexa.co";
$scenario = "category_page";
$url = $server.'/ebl/00000/'.urlencode(session_id()).'/'.urlencode($scenario).'.json';

$curl = curl_init();
$request = array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_USERPWD => "$mandator_id:$license_key");
curl_setopt_array($curl, $request);
$body = curl_exec($curl);
$recommendations = json_decode($body);
if ($recommendations && isset($recommendations->recommendationResponseList)) {
  foreach ($recommendations->recommendationResponseList as $product) {
    $product_id = $product->itemId;
    # load the product and create the recommendation HTML here
    echo($product->itemId);
    echo(" \n");
  };
} else {
    echo("Error: ".$body);
}
curl_close($curl);
```

## Advanced integration

You can configure integration at a more advanced level to track more events, 
use additional parameters, apply custom scenario configurations, filters, 
and enable additional features.

For more information about available functionalities, see the [User Documentation]([[= user_doc =]]/personalization/personalization).

For more information about integrating the Personalization service, see [tracking API](tracking_api.md) and [tracking integration](tracking_integration.md) documentation.
