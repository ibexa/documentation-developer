---
description: Configure your project files to enable Personalization and set up items you want to track.
---

# Enable Personalization

The Personalization service is based on a client-server architecture.
To enable it, you must set up authentication parameters that you receive from Ibexa.

## Get authentication parameters

First, either you or another Ibexa user responsible for managing the [[= product_name =]]  
instance must [request access to the service]([[= user_doc =]]/personalization/enabling_personalization/#request-access-to-the-server).

## Set up customer credentials

When you receive the confirmation email, add the credentials to your configuration.
In the root folder of your project, edit either the `.env` or `.env.local` file 
by adding the following lines with your customer ID and license key: 

```
PERSONALIZATION_CUSTOMER_ID=12345
PERSONALIZATION_LICENSE_KEY=67890-1234-5678-90123-4567
PERSONALIZATION_HOST_URI=https://server_uri
```

!!! note "Configuring user credentials for different customers"

    If your installation [hosts multiple sites]([[= user_doc =]]/personalization/use_cases/#multiple-website-hosting) with different 
    customer IDs, for example, to provide separate recommendations for different 
    language versions of the store, you can store all credentials in the same file:
    
    ```
    # Main credentials - ENU store
    PERSONALIZATION_CUSTOMER_ID=12345
    PERSONALIZATION_LICENSE_KEY=67890-1234-5678-90123-4567
    PERSONALIZATION_HOST_URI=https://server_uri

    # Additional credentials - FRA store 
    FRA_CUSTOMER_ID=54321
    FRA_LICENSE_KEY=09876-5432-1098-7654-3210
    FRA_HOST_URI=https://FRA_server_uri
    FRA_CUSTOM_EXPORT_LOGIN=65432
    FRA_CUSTOM_EXPORT_PASSWORD=#prtpswd_1
    ```

## Configure Personalization

The [Personalization package](https://github.com/ibexa/personalization-client) 
adds a personalization solution to [[= product_name =]] and communicates with 
the Personalization server.

Its job is to track the way visitors use the website and recommend content 
based on their behavior.

For more information about integrating the Personalization service,
see [Developer guide](tracking_api.md) and [Best practices](tracking_integration.md).

### Set up item type tracking

For the recommendations to be calculated, apart from visitor events (CLICK, BUY, etc.), 
the Personalization server must receive a list of item types that are tracked.

You define item types to be tracked in the `config/packages/ibexa.yaml` file.
The content is then initially exported by a script.
After this, it is synchronized with the Personalization service every time a change 
occurs (using any method that triggers the event).

The Personalization configuration is SiteAccess-aware.
If your installation hosts multiple sites with different customer IDs, 
for example, to provide separate recommendations for different language versions 
of the site, provide the credentials that correspond to each of the sites.

The configuration can resemble the following example:

``` yaml
ibexa_personalization:
    system:
        <site_access_name_1>:
            site_name: '<site_name_1>' # For example 'ENU store'
            host_uri: '%env(RECOMMENDATION_HOST_URI)%'
            authentication:
                customer_id: '%env(RECOMMENDATION_CUSTOMER_ID)%'
                license_key: '%env(RECOMMENDATION_LICENSE_KEY)%'
            included_item_types: [product, article]

        <site_access_name_2>:
            site_name: '<site_name_2>' # For example 'FRA store'
            host_uri: '%env(FRA_HOST_URI)%'
            authentication:
                customer_id: '%env(FRA_CUSTOMER_ID)%'
                license_key: '%env(FRA_LICENSE_KEY)%'
            export:
                authentication:
                    method: 'user'
                    login: '%env(FRA_CUSTOM_EXPORT_LOGIN)%'
                    password: '%env(FRA_CUSTOM_EXPORT_PASSWORD)%'
                included_item_types: [product, article]
```

!!! note "Authentication"

    For data exchange purposes, basic authentication is enabled by default. 
    To change this, contact support@ibexa.co.
    For security reasons, [store the authentication credentials in the ENV file](#set-up-customer-credentials), 
    and do not commit them to the Version Control System.
    Then, use environment variables to pull them into the YAML file.

| Parameter                            | Description                                               |
|--------------------------------------|-----------------------------------------------------------|
| `host_uri`                           | A location where the site's REST API can be accessed. This is where the Personalization server imports items from.       |
| `authentication.customer_id`         | A customer ID related to the supported SiteAccess.                                         |
| `authentication.license_key`         | The Personalization service's license key.                                         |
| `export.authentication.method`         | Authentication method used to get access when importing items.                                         |
| `export.authentication.login`         | The credential used when importing items.                                         |
| `export.authentication.password`         | The password used when importing items.                                         |
| `included_item_types`             | A list of alphanumerical identifiers of item types on which the tracking script is shown. |
| `random_item_types`               | A list of alphanumerical identifiers of item types that are returned when the response from the server contains no content. |

You can use an alphanumeric content identifier `remoteId` instead of a numeric `id`.
To enable it, add the following configuration:

```yaml
ibexa:
    system:
        <scope>:
            personalization:
                repository:
                    content:
                        use_remote_id: true
```

#### Enable tracking

The Personalization client bundle delivers a Twig extension
which helps integrate the user tracking functionality into your site.
Place the following code snippet in the `<head>` section of your header template:

``` html+twig
{% if content is defined %}
    {{ ibexa_personalization_track_user(content.id) }}
{% endif %}
```

!!! tip "How tracking works"

    For more information about tracking in general, see [Tracking API](tracking_api.md) and [Tracking with yct.js](tracking_with_yct.md).

### Check whether the bundle provides REST data

You can verify the import controller of the bundle by calling the local API.
Use the `Accept` header; you may need to add an `Authorization` header if authentication is required.

To check whether the `content` endpoint is working as expected, perform the following request:

```
GET http://<yourdomain>/api/ezp/v2/ibexa_personalization/v1/content/{contentId}
Accept application/vnd.ez.api.Content+json
Authorization Basic xxxxxxxx
```

Additionally, check whether the `contenttypes` endpoint is working with the following request:

```
GET http://<yourdomain>/api/ezp/v2/ibexa_personalization/v1/contenttypes/38?page=1&page_size=10
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
### Export item information

To get recommendations you must first export the item information to the Personalization server.

After you [define item types to be tracked and recommended](#set-up-item-type-tracking),
start the full export.

You do it with the `ibexa:personalization:run-export` command.

If your installation hosts only one SiteAccess, run the following command to export your data:

``` bash
php bin/console ibexa:personalization:run-export
    --item-type-identifier-list=<item_type>,<item_type>
    -—languages=<language>,<language>
```

If your installation hosts multiple SiteAccesses with different customer IDs, 
you must run the export separately for each of the `<site_access_name>`/`<customer_id>` pairs.

``` bash
php bin/console ibexa:personalization:run-export
    --item-type-identifier-list=<item_type>,<item_type>
    --siteaccess=<site_access_name>
    --customer-id=<customer_id>
    --license-key=<license_key>
    -—languages=<language>,<language>
```

The bundle exporter collects all content related to the `<site_access_name>`/`<customer_id>` 
pair and stores it in files.
After finishing, the system sends a POST request to the endpoint and informs the 
Personalization server to fetch new content.
An internal workflow is then triggered, so that the generated files are downloaded 
and imported in the Personalization server's content store.

The export process can take several minutes.

![Personalization Full Content Export](full_content_export.png)

!!! caution "Re-exporting modified item types"

    If the item types to be recommended change, you must perform a new full export
    by running the `php bin/console ibexa:personalization:run-export` command again.

#### Check export results

There are three ways to check whether content was transferred and stored successfully in the Personalization server:

- [REST request to client's content store](#rest-request-to-clients-content-store)

- [Personalization backend](#personalization-backend)

- [Subsequent content exports](#subsequent-content-exports)

##### REST request to client's content store

To get the data of an imported item you can request the following REST resource:

`GET https://https://admin.perso.ibexa.co/api/<your_customer_id>/item/<your_item_type_id>/<your_item_id>`

This way uses basic authentication. 
The username is the customer ID and the password is the license key.

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

##### Personalization backend

In the Back Office, go to **Personalization** > **Import** and review the list of historical import operations to see whether a full import was successful.

![Item Import tab with full import results](reco_full_import.png)

#### Subsequent content exports

The Personalization server is automatically kept in sync with the content in [[= product_name =]].

Every time an editor creates, updates or deletes content in the Back Office,
a notification is sent to https://admin.perso.ibexa.co.
The personalization service also notifies other components of the Personalization server
and it eventually fetches the affected content and updates it internally.

![Subsequent content exports](incremental_content_export.png)

### Display recommendations

!!! note "Client-based recommendations"

    Recommendations are fetched and rendered asynchronously, so there 
    is no additional load on the server.
    Therefore, it is crucial that you check whether the content export was successful, 
    because certain references, for example, deeplinks and image references, are 
    included.
    If the export fails, the Personalization server does not have full content information.
    As a result, even if the recommendations are displayed, they might miss images, 
    titles or deeplinks.

To display recommendations on your site, you must include the asset in the template using the following code:

``` html+twig
{{ encore_entry_script_tags('ezrecommendation-client-js', null, 'ezplatform') }}
```

This file is responsible for sending notifications to the [Recommendation API](recommendation_api.md) after the user clicks a tracking element.

To render recommended content, use a dedicated `showRecommendationsAction()` from the `RecommendationController.php`:

``` html+twig
render(controller('ibexa_personalization::showRecommendationsAction', {
        'contextItems': content,
        'scenario': 'front',
        'outputTypeId': 57,
        'limit': 3,
        'template': '@IbexaPersonalization::recommendations.html.twig',
        'attributes': ['title', 'intro', 'image', 'uri']
      }))
```

!!! tip

    To check whether tracking is enabled on the front end, use the 
    `ibexa_personalization_enabled()` Twig function.
    You can wrap the call to the `RecommendationController` with:

    ``` html+twig
    {% if ibexa_personalization_enabled() %}
        <div class="container">
            {# ... #}
        </div>
    {% endif %}
    ```

#### Parameters

| Parameter        | Type   | Description   |
|------------------|--------|---------------|
| `contextItems`   | int    | ID of the content you want to get recommendations for. |
| `scenario`       | string | Scenario used to display recommendations. You can create custom scenarios in the Back Office. |
| `outputTypeId`   | string | Item type that you expect in response, for example, `blog_post`. |
| `crossContentType`| bool | If set to `true`, returns recommendations for all Content Types specified in the scenario. |
| `limit`          | int    | Number of recommendations to fetch. |
| `template`       | string | Template name. |
| `attributes`     | array  | Fields that are required and are requested from the Personalization server. These Field names are also used inside Handlebars templates. |

You can also bypass named arguments with standard value passing as arguments.

!!! note "Custom templates"

    To use a custom template for displaying recommendations,
    ensure that it includes `event_tracking.html.twig`:

    `{% include '@IbexaPersonalization/event_tracking.html.twig' %}`.

Recommendation responses contain all content data that is requested as attribute 
in the recommendation call.
This response data can be used in templates to render and style recommendations.

For example, the following GET request should deliver the response below
if the content Fields were previously exported by the export script.

`GET https://https://reco.perso.ibexa.co/api/v2/<your_customer_id>/someuser/popular.json?contextitems=71&numrecs=5&categorypath=/&outputtypeid=<your_item_type>&attribute=name,author,uri,image`

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
                    "clickRecommended": "//event.test.perso.ibexa.co/api/723/clickrecommended/someuser/38/71?scenario=popular&modelid=4199&categorypath=&requestuuid=d75e7cf0-e4ca-11e7-a94d-0a64dbbea736",
                    "rendered": "//event.test.perso.ibexa.co/api/723/rendered/someuser/38/71?scenario=popular&modelid=4199&categorypath=&requestuuid=d75e7cf0-e4ca-11e7-a94d-0a64dbbea736"
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
                    "clickRecommended": "//event.test.perso.ibexa.co/api/723/clickrecommended/someuser/38/75?scenario=popular&modelid=4199&categorypath=&requestuuid=d75e7cf0-e4ca-11e7-a94d-0a64dbbea736",
                    "rendered": "//event.test.perso.ibexa.co/api/723/rendered/someuser/38/75?scenario=popular&modelid=4199&categorypath=&requestuuid=d75e7cf0-e4ca-11e7-a94d-0a64dbbea736"
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

#### Modify recommendation data

You can retrieve data returned from the Personalization server and modify it 
before it is shown to the user.

To modify recommendation data, subscribe to `RecommendationResponseEvent`.
See [`Event/Subscriber/RecommendationEventSubscriber.php`](https://github.com/ibexa/personalization-client/blob/main/src/lib/Event/Subscriber/RecommendationEventSubscriber.php) for an example:

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

Displaying image variations is not supported out of the box.

You can work around this limitation by creating a template
(based on [recommendations.html.twig](https://github.com/ibexa/personalization-client/blob/main/src/bundle/Resources/views/recommendations.html.twig)).

To access a specific image variation through API, add the `image` parameter to the 
request URL with the name of the variation as its value.
For example, to retrieve the `rss` variation of the image, use:

`/api/ezp/v2/ibexa_recommendation/v1/contenttypes/16?lang=eng-GB&fields=title,description,image,intro,name&page=1&page_size=20&image=rss`

### Troubleshooting

#### Logging

Most operations are logged by using the `ibexa-personalization` [Monolog channel](http://symfony.com/doc/5.0/cookbook/logging/channels_handlers.html).
To log everything about Personalization to `dev.recommendation.log`, add the following to the `ibexa.yaml`:

``` yaml
monolog:
    handlers:
        ibexa_personalization:
            type: stream
            path: '%kernel.logs_dir%/%kernel.environment%.recommendation.log'
            channels: [ibexa-personalization]
            level: info
```

You can replace `info` with `debug` to increase verbosity.

## Set up user roles and permissions

Depending on your requirements, you may need to set up `edit` and `view` [permissions](permissions.md) 
to grant users access to recommendation settings that relate to different SiteAccesses 
and results that come from these websites.

## Configure recommendation logic

When you enable the Personalization, you can go back to the Back Office, 
refresh the Personalization dashboard and proceed with [configuring the logic]([[= user_doc =]]/personalization/perso_configuration) 
used to calculate the recommendation results.
