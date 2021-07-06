# Recommendation client

The [`ezrecommentation-client`](https://github.com/ezsystems/ezrecommendation-client) package 
adds a personalization solution to [[= product_name =]] and communicates with 
the Personalization server.

The client's job is to track the way visitors use the website and recommend content 
based on their behavior.

Once you become familiar with this article, for more information about integrating 
the Personalization service, see [Developer guide](developer_guide/tracking_api.md) and [Best practices](best_practices/tracking_integration.md).

## Configuration

Before you can use the Personalization service, you must configure the client.

### Set up item type tracking

For the recommendations to be calculated, apart from visitor events (CLICK, BUY, etc.), 
the Personalization server must be fed with the list of item types that are tracked.

You define item types to be tracked in the `config/packages/ezplatform.yaml` file.
The content is then initially exported by a script.
After this, it is synchronized with the Personalization service every time a change 
occurs in the Back Office.

The client's configuration is SiteAccess-aware.
If your installation [supports multiple sites](https://doc.ibexa.co/projects/userguide/en/latest/personalization/use_cases/#multiple-stores) with different customer IDs, 
for example, to provide separate recommendations for different language versions 
of the site, provide the credentials that correspond to each of the sites.

The client's configuration can resemble the following example:

``` yaml
ezrecommendation:
    system:
        <site_access_name_1>:
            site_name: '<site_name_1>' # For example 'ENU store'
            authentication:
                customer_id: `'%env(RECOMMENDATION_CUSTOMER_ID)%'`
                license_key: `'%env(RECOMMENDATION_LICENSE_KEY)%'`
            included_item_types: [product, article]
            random_item_types: [blog]
            host_uri: http://example.com

        <site_access_name_1>:
            site_name: '<site_name_2>' # For example 'ENU store'
            authentication:
                customer_id: `'%env(FRA_CUSTOMER_ID)%'`
                license_key: `'%env(FRA_LICENSE_KEY)%'`
            included_item_types: [product, article]
            random_item_types: [blog]
            host_uri: http://example.com
```

!!! note "User credential variables"

    For security reasons, [store the authentication credentials in the ENV file](enabling_personalization.md#setting-up-customer-credentials), 
    and do not commit them to the Version Control System.
    Then, use environment variables to pull them into the YAML file.

| Parameter                            | Description                                               |
|--------------------------------------|-----------------------------------------------------------|
| `authentication.customer_id`         | A customer ID related to the supported SiteAccess.                                         |
| `authentication.license_key`         | The Personalization service's license key.                                         |
| `host_uri`                           | The URI your site's REST API can be accessed from.        |
| `included_item_types`             | A list of alphanumerical identifiers of item types on which the tracking script is shown. |
| `random_item_types`               | A list of alphanumerical identifiers of item types that are returned when the response from the server contains no content. |

#### Advanced configuration

If the item's intro, author or image are stored in a different Field,
you can specify its name in the `ezplatform.yaml` file:

``` yaml
ezrecommendation:
    system:
        <siteaccess>
            field:
                identifiers:
                    intro:
                        blog_post: intro
                        article: lead
                    author:
                        blog_post: author
                        article: authors
                    image:
                        <item_type_name>: <field_name>
```

In case a item owner ID is missing, you can set up the default item author in the `default_settings.yaml` file:

``` yaml
ezrecommendation:
    system:
        <siteaccess>:
            author_id: 14   # ID: 14 is default ID of admin user
```

You can edit advanced options for the Personalization server by using the following settings:

``` yaml
ezrecommendation:
    system:
        <siteaccess>:
            api:
                admin:
                    endpoint: 'https://admin.yoochoose.net'
                recommendation:
                    endpoint: 'https://reco.yoochoose.net'
                    consume_timeout: 20
                event_tracking:
                    endpoint: 'https://event.yoochoose.net'
                    script_url: 'cdn.yoochoose.net/yct.js'
                notifier:
                    endpoint: 'https://admin.yoochoose.net'
```

!!! caution

    Changing any of these parameters without a valid reason breaks all calls to the Personalization server.

#### Enable tracking

The `EzRecommendationClientBundle` delivers a Twig extension
which helps integrate the user tracking functionality into your site.
Place the following code snippet in the `<head>` section of your header template:

``` html+twig
{% if content is defined %}
    {{ ez_recommendation_track_user(content.id) }}
{% endif %}
```

!!! tip "How tracking works"

    For more information about tracking in general, see [Tracking API](developer_guide/tracking_api.md) and [Tracking with yct.js](developer_guide/tracking_with_yct.md).

### Check whether the bundle provides REST data

You can verify the import controller of the bundle by calling the local API.
Use the `Accept` header; you may need to add an `Authorization` header if authentication is required.

To check whether the `content` endpoint is working as expected, perform the following request:

```
GET http://<yourdomain>/api/ezp/v2/ez_recommendation/v1/content/{contentId}
Accept application/vnd.ez.api.Content+json
Authorization Basic xxxxxxxx
```

Additionally, check whether the `contenttypes` endpoint is working with the following request:

```
GET http://<yourdomain>/api/ezp/v2/ez_recommendation/v1/contenttypes/38?page=1&page_size=10
Accept application/vnd.ez.api.Content+json
Authorization Basic xxxxxxxx
```

The `content` endpoint returns one item and the `contenttypes` endpoint returns many.

``` json
{
    "contentList": {
        "_media-type": "application/vnd.ez.api.contentList+json",
        "content": [
            {
                "_media-type": "application/vnd.ez.api.content+json",
                "contentId": 72,
                "contentTypeId": 38,
                "identifier": "place",
                "language": "eng-GB",
                "publishedDate": "2015-09-17T13:23:10+00:00",
                "author": "Sandip Patel",
                "uri": "/Places-Tastes/Places/Kochin-India",
                "categoryPath": "/1/2/95/71/73/",
                "mainLocation": {
                    "_media-type": "application/vnd.ez.api.mainLocation+json",
                    "_href": "/api/ezp/v2/content/locations/1/2/95/71/73/"
                },
                "locations": {
                    "_media-type": "application/vnd.ez.api.locations+json",
                    "_href": "/api/ezp/v2/content/objects/72/locations"
                },
                "name": "Kochin, India",
                "intro": "<![CDATA[<section xmlns=\"http://ez.no/namespaces/ezpublish5/xhtml5\"><p>We got the major port city on the south west coast of India.</p></section>\n]]>",
                "description": "<![CDATA[<section xmlns=\"http://ez.no/namespaces/ezpublish5/xhtml5\"><p><strong>Kochi </strong>(formerly Cochin) ... </p></section>\n]]>",
                "image": "/var/site/storage/images/places-tastes/places/kochin-india/282-5-eng-GB/Kochin-India.jpg",
                "caption": "<![CDATA[<section xmlns=\"http://ez.no/namespaces/ezpublish5/xhtml5\"><p>Chinese fishing nets ... </p></section>\n]]>",
                "location": "kochin, india",
                "authors_position": "Senior Editor",
                "tags": "India, Kochin",
                "rating": "0",
                "publication_date": "1442500260",
                "metas": ""
            }
        ],
        ....
    }
}
```

## Export item information

To get recommendations you must first export the item information to the Personalization server.

After you [define item types to be tracked and recommended](#set-up-content-type-tracking),
start the full export.
You do it with the `ibexa:recommendation:run-export` command:

``` bash
php bin/console ibexa:recommendation:run-export
    --contentTypeIdList=<item_type>,<item_type>
    --siteaccess=<site_access_name>
    --customerId=<customer_id>
    --licenseKey=<license_key>
```

If your installation supports multiple SiteAccesses with different customer IDs, 
you must run the export separately for each of the `<site_access_name>`/`<customer_id>` pairs.

The bundle exporter collects all content related to the `<site_access_name>`/`<customer_id>` 
pair and stores it in files.
After finishing, the systems sends a POST request to the endpoint and informs the 
Personalization server to fetch new content.
An internal workflow is then triggered, so that the generated files are downloaded 
and imported in the Personalization server's content store.

The export process can take several minutes.

![Recommendation Full Content Export](img/full_content_export.png)

!!! caution "Re-exporting modified item types"

    If the item types to be recommended change, you must perform a new full export
    by running the `php bin/console ibexa:recommendation:run-export` command again.

### Check export results

There are three ways to check whether content was transferred and stored successfully in the Personalization server:

#### REST request to the client's content store

To get the data of an imported item you can request the following REST resource:

`GET https://admin.yoochoose.net/api/<your_customer_id>/item/<your_item_type_id>/<your_item_id>`

This way requires BASIC Auth. BASIC Auth username is the `customerID` and the password is the license key.

??? note "Example response"

    ``` xml
    <?xml version="1.0" encoding="UTF-8" standalone="yes"?>
    <items version="1">
        <item id="73" type="38">
            <imageurls>
                <imageurl type="preview">/var/site/storage/images/places-tastes/places/santo-domingo-dominican-republic/288-4-eng-GB/Santo-Domingo-Dominican-Republic.jpg</imageurl>
            </imageurls>
            <deeplinkurl>/Places-Tastes/Places/Santo-Domingo-Dominican-Republic</deeplinkurl>
            <validfrom>2015-09-17T13:24:25.000</validfrom>
            <categoryids/>
            <categorypaths>
                <categorypath>1/2/95/71/74</categorypath>
            </categorypaths>
            <content/>
            <attributes>
                <attribute value="/var/site/storage/images/places-tastes/places/santo-domingo-dominican-republic/288-4-eng-GB/Santo-Domingo-Dominican-Republic.jpg" key="image" type="TEXT"/>
                <attribute value="place" key="identifier" type="TEXT"/>
                <attribute value="fre-FR" key="language" type="TEXT"/>
                <attribute value="Senior Editor" key="authors_position" type="TEXT"/>
                <attribute value="Michael Wang" key="author" type="TEXT"/>
                <attribute value="/1/2/95/71/74/" key="categoryPath" type="TEXT"/>
                <attribute value="Michael Wang" key="author" type="NOMINAL"/>
                <attribute value="0" key="rating" type="TEXT"/>
                <attribute value="&lt;![CDATA[&lt;section xmlns=&quot;http://ez.no/namespaces/ezpublish5/xhtml5&quot;&gt;&lt;p&gt;Outstanding beaches of Dominican Republic, Samana is one of them.&lt;/p&gt;&lt;p&gt;&lt;em&gt;Photograph by Brian Henry - Anchorage north shore Samana, Dominican Republic&lt;/em&gt;&lt;/p&gt;&lt;/section&gt;&#xA;]]&gt;" key="caption" type="TEXT"/>
                <attribute value="/Places-Tastes/Places/Santo-Domingo-Dominican-Republic" key="uri" type="TEXT"/>
                <attribute value="38" key="contentTypeId" type="TEXT"/>
                <attribute value="Dominican Republic, Santo Domingo" key="tags" type="TEXT"/>
                <attribute value="&lt;![CDATA[&lt;section xmlns=&quot;http://ez.no/namespaces/ezpublish5/xhtml5&quot;&gt;&lt;p&gt;Santo Domingo meaning &quot;Saint Dominic&quot;, officially Santo Domingo de Guzm&amp;aacute;n, is the capital and largest city in the ... &lt;/p&gt;&lt;/section&gt;&#xA;]]&gt;" key="description" type="TEXT"/>
                <attribute value="73" key="contentId" type="TEXT"/>
                <attribute value="&lt;![CDATA[&lt;section xmlns=&quot;http://ez.no/namespaces/ezpublish5/xhtml5&quot;&gt;&lt;p&gt;The oldest European inhabited settlement in the Americas.&lt;/p&gt;&lt;/section&gt;&#xA;]]&gt;" key="intro" type="TEXT"/>
                <attribute value="1442500260" key="publication_date" type="TEXT"/>
                <attribute value="Santo Domingo, Dominican Republic" key="name" type="TEXT"/>
                <attribute value="Santo Domingo, Dominican Republic" key="location" type="TEXT"/>
                <attribute value="2015-09-17T13:24:25+00:00" key="publishedDate" type="TEXT"/>
            </attributes>
        </item>
    </items>
    ```

#### Recommendation client backend

In the Back Office, navigate to **Personalization** > **Import** and review a list of historical import operations to see whether a full import was successful.

![Item Import tab with full import results](img/reco_full_import.png)

### Subsequent content exports

The Personalization server is automatically kept in sync with the content in [[= product_name =]].

Every time an editor creates, updates or deletes content in the Back Office,
a notification is sent to https://admin.yoochoose.net.
The personalization service also notifies other components of the Personalization server
and it eventually fetches the affected content and updates it internally.

![Subsequent content exports](img/incremental_content_export.png)

## Display recommendations

!!! note "Client-based recommendations"

    Recommendations are fetched and rendered asynchronously in the client, so there 
    is no additional load on the server.
    Therefore, it is crucial that you check whether the content export was successful, 
    because certain references, for example, deeplinks and image references, are 
    included.
    If the export fails, the Personalization server does not have full content information.
    As a result, even if the recommendations are displayed, they might miss images, 
    titles or deeplinks.

To display recommendations on your site, you must add the following JavaScript assets 
to your header template:

``` html+twig
{% javascripts
    '@EzRecommendationClientBundle/Resources/public/js/EzRecommendationClient.js'
%}
```

This file is responsible for sending notifications to the [Recommendation API](developer_guide/recommendation_api.md) after the user clicks on a tracking element.

To render recommended content, use a dedicated `showRecommendationsAction` from the `RecommendationController.php`:

``` html+twig
render_esi(controller('ez_recommendation::showRecommendationsAction', {
        'contextItems': content.id,
        'scenario': 'front',
        'outputTypeId': 'blog_post',
        'limit': 3,
        'template': 'EzRecommendationClientBundle::recommendations.html.twig',
        'attributes': ['title', 'intro', 'image', 'uri']
      }))
```

!!! tip

    To check whether tracking is enabled on the front end, use the 
    `ez_recommendation_enabled()` Twig function.
    You can wrap the call to the `RecommendationController` with:

    ``` html+twig
    {% if ez_recommendation_enabled() %}
        <div class="container">
            {# ... #}
        </div>
    {% endif %}
    ```

### Parameters

| Parameter        | Type   | Description   |
|------------------|--------|---------------|
| `contextItems`   | int    | ID of the content you want to get recommendations for. |
| `scenario`       | string | Scenario used to display recommendations. You can create custom scenarios in the Back Office. |
| `outputTypeId`   | string | Item type that you expect in response, for example, `blog_post`. |
| `limit`          | int    | Number of recommendations to fetch. |
| `template`       | string | Template name. |
| `attributes`     | array  | Fields that are required and are requested from the Personalization server. These Field names are also used inside Handlebars templates. |

You can also bypass named arguments with standard value passing as arguments.

!!! note "Custom templates"

    To use a custom template for displaying recommendations,
    ensure that it includes `event_tracking.html.twig`:

    `{% include 'EzRecommendationClientBundle::event_tracking.html.twig' %}`.

Recommendation responses contain all content data that is requested as attribute 
in the recommendation call.
This response data can be used in templates to render and style recommendations.

For example, the following GET request should deliver the response below
if the content Fields were previously exported by the export script.

`GET https://reco.yoochoose.net/api/v2/<your_customer_id>/someuser/popular.json?contextitems=71&numrecs=5&categorypath=/&outputtypeid=<your_item_type>&attribute=name,author,uri,image`

??? note "Example response"

    ``` json
    {
        "contextItems": [
            {
                "itemId": 71,
                "itemType": 38,
                "sources": [
                    "REQUEST"
                ],
                "viewers": 0
            }
        ],
        "recommendationItems": [
            {
                "itemId": 71,
                "itemType": 38,
                "relevance": 3,
                "links": {
                    "clickRecommended": "//event.test.yoochoose.net/api/723/clickrecommended/someuser/38/71?scenario=popular&modelid=4199&categorypath=&requestuuid=d75e7cf0-e4ca-11e7-a94d-0a64dbbea736",
                    "rendered": "//event.test.yoochoose.net/api/723/rendered/someuser/38/71?scenario=popular&modelid=4199&categorypath=&requestuuid=d75e7cf0-e4ca-11e7-a94d-0a64dbbea736"
                },
                "attributes": [
                    {
                        "key": "image",
                        "values": [
                            "/var/site/storage/images/places-tastes/places/valencia-spain/276-4-eng-GB/Valencia-Spain.jpg"
                        ]
                    },
                    {
                        "key": "author",
                        "values": [
                            "Tara Fitzgerald"
                        ]
                    },
                    {
                        "key": "name",
                        "values": [
                            "Valencia, Spain"
                        ]
                    },
                    {
                        "key": "uri",
                        "values": [
                            "/Places-Tastes/Places/Valencia-Spain"
                        ]
                    }
                ]
            },
            {
                "itemId": 75,
                "itemType": 38,
                "relevance": 1,
                "links": {
                    "clickRecommended": "//event.test.yoochoose.net/api/723/clickrecommended/someuser/38/75?scenario=popular&modelid=4199&categorypath=&requestuuid=d75e7cf0-e4ca-11e7-a94d-0a64dbbea736",
                    "rendered": "//event.test.yoochoose.net/api/723/rendered/someuser/38/75?scenario=popular&modelid=4199&categorypath=&requestuuid=d75e7cf0-e4ca-11e7-a94d-0a64dbbea736"
                },
                "attributes": [
                    {
                        "key": "image",
                        "values": [
                            "/var/site/storage/images/places-tastes/places/brooklyn-new-york/300-4-eng-GB/Brooklyn-New-York.jpg"
                        ]
                    },
                    {
                        "key": "author",
                        "values": [
                            "Elizabeth Liu"
                        ]
                    },
                    {
                        "key": "name",
                        "values": [
                            "Brooklyn, New York"
                        ]
                    },
                    {
                        "key": "uri",
                        "values": [
                            "/Places-Tastes/Places/Brooklyn-New-York"
                        ]
                    }
                ]
            }
        ]
    }
    ```

### Modify recommendation data

You can retrieve data returned from the Personalization server and modify it 
before it is shown to the user.

To modify recommendation data, subscribe to `RecommendationResponseEvent`.
See [`Event/Subscriber/RecommendationEventSubscriber.php`](https://github.com/ezsystems/ezrecommendation-client/blob/master/src/lib/Event/Subscriber/RecommendationEventSubscriber.php) for example:

``` php
public static function getSubscribedEvents(): array
{
    return [
        RecommendationResponseEvent::class => ['onRecommendationResponse', -10],
    ];
}
```

The `-10` refers to priority, which must be negative so this action is performed 
before the main subscriber is run.

### Image variations

Displaying image variations is not readily supported yet.

You can work around this limitation by creating a template
(based on [recommendations.html.twig](https://github.com/ezsystems/ezrecommendation-client/blob/master/src/bundle/Resources/views/recommendations.html.twig)).

To access a specific image variation through API, add the `image` parameter to the 
request URL with the name of the variation as its value.
For example, to retrieve the `rss` variation of the image, use:

`/api/ezp/v2/ez_recommendation/v1/contenttypes/16?lang=eng-GB&fields=title,description,image,intro,name&page=1&page_size=20&image=rss`

## Troubleshooting

### Logging

Most operations are logged via the `ez_recommendation` [Monolog channel](http://symfony.com/doc/5.0/cookbook/logging/channels_handlers.html).
To log everything about Recommendation to `dev.recommendation.log`, add the following to the `ezplatform.yaml`:

``` yaml
monolog:
    handlers:
        ez_recommendation:
            type: stream
            path: '%kernel.logs_dir%/%kernel.environment%.recommendation.log'
            channels: [ez_recommendation]
            level: info
```

You can replace `info` with `debug` to increase verbosity.
