# Basic service integration

To return recommendations, you must first [enable the Personalization service](enabling_personalization.md).
Then, you must integrate the service with [[= product_name =]] by activating 
event tracking and embedding recommendation results into the website.

!!! note

    Examples below use '00000' as a customer ID for creating requests.
    In a real-life scenario, use the customer ID that you receive from Ibexa.

## Tracking events

The service primarily relies on event tracking. 
For the events to be registered, every Content item or product page must call 
a special tracking URL.
The simplest way of embedding the tracking URL is placing a one pixel image on every page, 
just like in the case of analytical tools or visitor counters.
A code that includes an image may look like this:

`<img href="https://event.yoochoose.net/ebl/00000/click/<user_ID>/<content_type_ID>/<content_ID>" width="1" height="1">`

`<user_ID>` stands either for the user ID or session ID of the user who is currently 
logged into your website (any URL-encoded string is allowed).

`<content_type_ID>` stands for the [contentTypeId](../content_model.md#content-information) of the Content item or product that you want to track and recommend.

`<content_ID>` stands for the [id](../content_model.md#content-information) of the Content item or product that you want to track and recommend.

The following examples show how you can integrate a CLICK event:

PHP:

``` php
$mandator_id = '00000';
$product_id = '123';
$server = '//event.yoochoose.net';
$tracking = $server.'/ebl/'.$mandator_id.'/click/'.urlencode(session_id()).'/1/'.$product_id;
echo "<img href='$tracking' width='1' height='1'>";
```

JavaScript:

``` js
var mandator_id = '00000';
var product_id = '123';
var server = '//event.yoochoose.net';
var url = server + '/api/' + mandator_id + '/click/' + getSessionId() + '/1/' + product_id;
var ycimg=new Image(1,1);
ycimg.src=url;
```

A similar tracking image can be placed on a confirmation page that ends the payment process.

``` php
$server = '//event.yoochoose.net';
foreach ($just_bought_products as $product_id) {
   $tracking = $server.'/ebl/'.$mandator_id.'/buy/'.urlencode(session_id()).'/1/'.$product_id;
   echo "<img href='$tracking' width='1' height='1'>\n";
}
```

## Embedding recommendations

As soon as the recommendation engine collects enough events, it can generate recommendations.
The more tracking data is available, the more accurate the recommendations.
Recommendations can be fetched with the following calls, and the response is returned in JSON format.

To return the most popular products, use:

`https://reco.yoochoose.net/api/v2/00000/<user_ID>/landing_page.json`

To return products that the current user is most probably interested in, use:

`https://reco.yoochoose.net/api/v2/00000/<user_ID>/cross_sell.json?contextitems=OWNS,CLICKED`

To return products that are most probably interesting for users interested in product 123, use:

`https://reco.yoochoose.net/api/v2/00000/<user_ID>/cross_sell.json?contextitems=123`

A response with two recommendations will resemble the following object:

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
            "clickRecommended":"//event.yoochoose.net/api/00000/clickrecommended/user/1/555?scenario=landing_page&modelid=5768",
            "rendered":"//event.yoochoose.net/api/00000/rendered/user/1/555?scenario=landing_page&modelid=5768"
         }
      },
      {
         "itemId":444,
         "itemType":1,
         "relevance":126,
         "links":{
            "clickRecommended":"//event.yoochoose.net/api/00000/clickrecommended/user/1/444?scenario=landing_page&modelid=5768",
            "rendered":"//event.yoochoose.net/api/00000/rendered/user/1/444?scenario=landing_page&modelid=5768"
         }
      }
   ]
}
```

You can use the following code to make requests and parse results:

``` php
$mandator_id = '00000';
$license_key = '67890-1234-5678-90123-4567';
$server = "https://reco.yoochoose.net";
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
use additional parameters, apply custom scenario configurations, apply filters, 
and enable additional features.

For more information about available functionalities, see the [User Documentation](https://doc.ibexa.co/projects/userguide/en/latest/personalization/personalization).

For more information about integrating the Personalization service, see [Developer guide](developer_guide/tracking_api.md) and [Best practices](best_practices/tracking_integration.md).
