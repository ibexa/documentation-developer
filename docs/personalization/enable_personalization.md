---
description: Configure your project files to enable Personalization and set up items you want to track.
month_change: false
---

# Enable Personalization

The Personalization service is based on a client-server architecture.
To enable it, you must set up authentication parameters that you receive from [[= product_name_base =]].

## Get authentication parameters

First, either you or another [[= product_name_base =]] user responsible for managing the [[= product_name =]] instance must [request access to the service]([[= user_doc =]]/personalization/enable_personalization/#request-access-to-the-server).

## Set up customer credentials

When you receive the credentials, add them to your configuration.

In the root folder of your project, edit the `.env.local` file by adding the following lines with your customer ID and license key: 

```
PERSONALIZATION_CUSTOMER_ID=12345
PERSONALIZATION_LICENSE_KEY=67890-1234-5678-90123-4567
PERSONALIZATION_HOST_URI=https://server_uri
```

!!! note "Configuring user credentials for multisite setup and different personalization customers"

    If your installation [hosts multiple sites]([[= user_doc =]]/personalization/use_cases/#multiple-website-hosting) with different customer IDs, for example, to provide separate recommendations for different language versions of the store, you can store all credentials in the same file:

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

The [Personalization package](https://github.com/ibexa/personalization-client) adds a personalization solution to [[= product_name =]] and communicates with the Personalization server.

Its job is to track the way visitors use the website and recommend content based on their behavior.

For more information about integrating the Personalization service, see [Developer guide](tracking_api.md) and [Best practices](tracking_integration.md).

### Set up item type tracking

For the recommendations to be calculated, apart from visitor events (for example, CLICK or BUY), the Personalization server must receive a list of item types that are tracked.

You define item types to be tracked in [configuration files](configuration.md#configuration-files).
The content is then initially exported by a script.
After this, it's synchronized with the Personalization service every time a change occurs (using any method that triggers the event).

The Personalization configuration is SiteAccess-aware.
If your installation hosts multiple sites with different customer IDs, for example, to provide separate recommendations for different language versions of the site, provide the credentials that correspond to each of the sites.

The configuration can resemble the following example:

``` yaml
ibexa:
    system:
        <site_access_name_1>:
            personalization:
                site_name: '<site_name_1>' # For example 'ENU store'
                host_uri: '%env(PERSONALIZATION_HOST_URI)%'
                authentication:
                    customer_id: '%env(int:PERSONALIZATION_CUSTOMER_ID)%'
                    license_key: '%env(PERSONALIZATION_LICENSE_KEY)%'
                included_item_types: [product, article]
                output_type_attributes:
                    123: # content type ID
                        title: 'title'
                        image: 'image_legend'
                        description: 'sub_title'
                    456:
                        title: 'short_title'
                        image: 'primary_image'
                        description: 'sub_title'

        <site_access_name_2>:
            personalization:
                site_name: '<site_name_2>' # For example 'FRA store'
                host_uri: '%env(FRA_HOST_URI)%'
                authentication:
                    customer_id: '%env(int:FRA_CUSTOMER_ID)%'
                    license_key: '%env(FRA_LICENSE_KEY)%'
                included_item_types: [product, article]
                output_type_attributes:
                    123: # content type ID
                        title: 'title'
                        image: 'image_legend'
                        description: 'sub_title'
                    456:
                        title: 'short_title'
                        image: 'primary_image'
                        description: 'sub_title'
```

!!! note "Authentication"

    For data exchange purposes, basic authentication is enabled by default.
    To change this, contact support@ibexa.co.
    For security reasons, [store the authentication credentials in the ENV file](#set-up-customer-credentials), and don't commit them to the Version Control System.
    Then, use environment variables to pull them into the YAML file.

| Parameter                            | Description                                               |
|--------------------------------------|-----------------------------------------------------------|
| `host_uri`                           | A location where the site's REST API can be accessed. This is where the Personalization server imports items from.       |
| `authentication.customer_id`         | A customer ID related to the supported SiteAccess.                                         |
| `authentication.license_key`         | The Personalization service's license key.                                         |
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

!!! note "Support for alphanumeric content identifier"

     Contact support@ibexa.co with your organization's requirements to have the alphanumeric content identifier enabled.

#### Enable tracking

The Personalization client bundle delivers a Twig extension which helps integrate the user tracking functionality into your site.
Place the following code snippet in the `<head>` section of your header template:

``` html+twig
{% if content is defined %}
    {{ ibexa_recommendation_track_user(content) }}
{% endif %}
```

!!! tip "How tracking works"

    For more information about tracking in general, see [Tracking API](tracking_api.md) and [Tracking with ibexa-tracker.js](tracking_with_ibexa-tracker.md).

### Check whether the bundle provides REST data

You can verify the import controller of the bundle by calling the local API.
As the API uses token based authorization you first need a valid bearer token.

When you publish a content item a bearer token is created and saved to the `ibexa_token` db table.

Additionally a POST request is send to the Personalization Engine,  containing the token and the Rest URL where the Personalization Engine can fetch the changed Content.

The `BEARER_TOKEN` is the newest one in `ibexa_token` table having `type=1` and `identifier=update`. The token has a default lifetime of one day.

You can use this token to check what is provided to the Personalization Engine:


```bash
curl --location '{PERSONALIZATION_HOST_URI}/api/ibexa/v2/personalization/v1/content/id/{contentId}?lang={comma_separated_languages}' \
--header 'Accept: application/vnd.ibexa.api.Content+json' \
--header 'Authorization: Bearer {BEARER_TOKEN}'
```

Additionally, check whether the `contentlist` endpoint is working with the following request:

```bash
curl --location '{PERSONALIZATION_HOST_URI}/api/ibexa/v2/personalization/v1/contentlist/{comma_separated_content_ids}?lang={comma_separated_languages}' \
--header 'Accept: application/vnd.ibexa.api.ContentList+json' \
--header 'Authorization: Bearer {BEARER_TOKEN}'
```

The `content` endpoint returns one item and the `contentlist` endpoint returns many.

``` json
{
    "contentList": {
        "_media-type": "application/vnd.ibexa.api.ContentList+json",
        "content": [
            {
                "_media-type": "application/vnd.ibexa.api.Content+json",
                "contentId": 72,
                "contentTypeId": 38,
                "identifier": "place",
                "language": "eng-GB",
                "publishedDate": "2015-09-17T13:23:10+00:00",
                "author": "Sandip Patel",
                "uri": "/Places-Tastes/Places/Kochin-India",
                "categoryPath": "/1/2/95/71/73/",
                "mainLocation": {
                    "_media-type": "application/vnd.ibexa.api.mainLocation+json",
                    "_href": "/api/ezp/v2/content/locations/1/2/95/71/73/"
                },
                "locations": {
                    "_media-type": "application/vnd.ibexa.api.locations+json",
                    "_href": "/api/ezp/v2/content/objects/72/locations"
                },
                "name": "Kochin, India",
                "intro": "<![CDATA[<section xmlns=\"http://ibexa.co/namespaces/ezpublish5/xhtml5\"><p>We got the major port city on the south west coast of India.</p></section>\n]]>",
                "description": "<![CDATA[<section xmlns=\"http://ibexa.co/namespaces/ezpublish5/xhtml5\"><p><strong>Kochi </strong>(formerly Cochin) ... </p></section>\n]]>",
                "image": "/var/site/storage/images/places-tastes/places/kochin-india/282-5-eng-GB/Kochin-India.jpg",
                "caption": "<![CDATA[<section xmlns=\"http://ibexa.co/namespaces/ezpublish5/xhtml5\"><p>Chinese fishing nets ... </p></section>\n]]>",
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

After you [define item types to be tracked and recommended](#set-up-item-type-tracking), start the full export.

You need to run the `ibexa:personalization:run-export command per SiteAccesses that you want to use together with Personalization. You need different customer IDs for different SiteAccesses.

``` bash
php bin/console ibexa:personalization:run-export
    --item-type-identifier-list=<item_type>,<item_type>
    --siteaccess=<site_access_name>
    --customer-id=<customer_id>
    --license-key=<license_key>
    --languages=<language>,<language>
```

The bundle exporter collects all content related to the `<site_access_name>`/`<customer_id>` pair and stores it in files to the folder `public/var/export/yyyy/mm/dd/hh/mm` of your project.
After finishing, the system sends a POST request to the endpoint and informs the Personalization server to fetch new content.
An internal workflow is then triggered, so that the generated files are downloaded and imported in the Personalization server's content store.

The export process can take several minutes.

![Personalization Full Content Export](full_content_export.png)

!!! caution "Re-exporting modified item types"

    If the item types to be recommended change, you must perform a new full export by running the `php bin/console ibexa:personalization:run-export` command again.

#### Check export results

There are three ways to check whether content was transferred and stored successfully in the Personalization server:

- [REST request to client's content store](#rest-request-to-clients-content-store)

- [Personalization backend](#personalization-backend)

- [Subsequent content exports](#subsequent-content-exports)

##### REST request to client's content store

To get the data of an imported item you can request the following REST resource:

`GET https://admin.perso.ibexa.co/api/<your_customer_id>/item/<your_item_type_id>/<your_item_id>`

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
                <attribute value="&lt;![CDATA[&lt;section xmlns=&quot;http://ibexa.co/namespaces/ezpublish5/xhtml5&quot;&gt;&lt;p&gt;Outstanding beaches of Dominican Republic, Samana is one of them.&lt;/p&gt;&lt;p&gt;&lt;em&gt;Photograph by Brian Henry - Anchorage north shore Samana, Dominican Republic&lt;/em&gt;&lt;/p&gt;&lt;/section&gt;&#xA;]]&gt;" key="caption" type="TEXT"/>
                <attribute value="/Places-Tastes/Places/Santo-Domingo-Dominican-Republic" key="uri" type="TEXT"/>
                <attribute value="38" key="contentTypeId" type="TEXT"/>
                <attribute value="Dominican Republic, Santo Domingo" key="tags" type="TEXT"/>
                <attribute value="&lt;![CDATA[&lt;section xmlns=&quot;http://ibexa.co/namespaces/ezpublish5/xhtml5&quot;&gt;&lt;p&gt;Santo Domingo meaning &quot;Saint Dominic&quot;, officially Santo Domingo de Guzm&amp;aacute;n, is the capital and largest city in the ... &lt;/p&gt;&lt;/section&gt;&#xA;]]&gt;" key="description" type="TEXT"/>
                <attribute value="73" key="contentId" type="TEXT"/>
                <attribute value="&lt;![CDATA[&lt;section xmlns=&quot;http://ibexa.co/namespaces/ezpublish5/xhtml5&quot;&gt;&lt;p&gt;The oldest European inhabited settlement in the Americas.&lt;/p&gt;&lt;/section&gt;&#xA;]]&gt;" key="intro" type="TEXT"/>
                <attribute value="1442500260" key="publication_date" type="TEXT"/>
                <attribute value="Santo Domingo, Dominican Republic" key="name" type="TEXT"/>
                <attribute value="Santo Domingo, Dominican Republic" key="location" type="TEXT"/>
                <attribute value="2015-09-17T13:24:25+00:00" key="publishedDate" type="TEXT"/>
            </attributes>
        </item>
    </items>
    ```

##### Personalization backend

In the back office, go to **Personalization** > **Import** and review the list of historical import operations to see whether a full import was successful.

![Item Import tab with full import results](reco_full_import.png)

#### Subsequent content exports

The Personalization server is automatically kept in sync with the content in [[= product_name =]].

Every time an editor creates, updates or deletes content in the back office, a notification is sent to https://admin.perso.ibexa.co/.
The personalization service also notifies other components of the Personalization server and it eventually fetches the affected content and updates it internally.

![Subsequent content exports](incremental_content_export.png)

### Display recommendations

!!! note "Client-based recommendations"

    Recommendations are fetched and rendered asynchronously, so there is no additional load on the server.
    Therefore, it's crucial that you check whether the content export was successful, because certain references, for example, deeplinks and image references, are included.
    If the export fails, the Personalization server doesn't have full content information.
    As a result, even if the recommendations are displayed, they might miss images, titles or deeplinks.

To display recommendations on your site, you must include the asset in the template.
To do it, use the following code:

``` html+twig
{{ encore_entry_script_tags('ibexa-personalization-client-js', null, 'ibexa') }}
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

    To check whether tracking is enabled on the front end, use the `ibexa_recommendation_enabled()` Twig function.
    You can wrap the call to the `RecommendationController` with:

    ``` html+twig
    {% if ibexa_recommendation_enabled() %}
        <div class="container">
            {# ... #}
        </div>
    {% endif %}
    ```

#### Parameters

| Parameter        | Type   | Description   |
|------------------|--------|---------------|
| `contextItems`   | int    | ID of the content you want to get recommendations for. |
| `scenario`       | string | Scenario used to display recommendations. You can create custom scenarios in the back office. |
| `outputTypeId`   | string | Item type that you expect in response, for example, `blog_post`. |
| `crossContentType`| bool | If set to `true`, returns recommendations for all content types specified in the scenario. |
| `limit`          | int    | Number of recommendations to fetch. |
| `template`       | string | Template name. |
| `attributes`     | array  | Fields that are required and are requested from the Personalization server. These field names are also used inside Handlebars templates. |

You can also bypass named arguments with standard value passing as arguments.

!!! note "Custom templates"

    To use a custom template for displaying recommendations, ensure that it includes `event_tracking.html.twig`:

    `{% include '@IbexaPersonalization/event_tracking.html.twig' %}`.

Recommendation responses contain all content data that is requested as attribute in the recommendation call.
This response data can be used in templates to render and style recommendations.

For example, the following GET request should deliver the response below if the content fields were previously exported by the export script.

`GET https://reco.perso.ibexa.co/api/v2/<your_customer_id>/someuser/popular.json?contextitems=71&numrecs=5&categorypath=/&outputtypeid=<your_item_type>&attribute=name,author,uri,image`

!!! note "Example response"

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
                    "clickRecommended": "//event.perso.ibexa.co/api/723/clickrecommended/someuser/38/71?scenario=popular&modelid=4199&categorypath=&requestuuid=d75e7cf0-e4ca-11e7-a94d-0a64dbbea736",
                    "rendered": "//event.perso.ibexa.co/api/723/rendered/someuser/38/71?scenario=popular&modelid=4199&categorypath=&requestuuid=d75e7cf0-e4ca-11e7-a94d-0a64dbbea736"
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
                    "clickRecommended": "//event.perso.ibexa.co/api/723/clickrecommended/someuser/38/75?scenario=popular&modelid=4199&categorypath=&requestuuid=d75e7cf0-e4ca-11e7-a94d-0a64dbbea736",
                    "rendered": "//event.perso.ibexa.co/api/723/rendered/someuser/38/75?scenario=popular&modelid=4199&categorypath=&requestuuid=d75e7cf0-e4ca-11e7-a94d-0a64dbbea736"
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

You can retrieve data returned from the Personalization server and modify it before it's shown to the user.

To modify recommendation data, subscribe to `RecommendationResponseEvent`.
See [`Event/Subscriber/RecommendationEventSubscriber.php`](https://github.com/ibexa/personalization-client/blob/4.6/src/lib/Event/Subscriber/RecommendationEventSubscriber.php) for an example:

``` php
public static function getSubscribedEvents(): array
{
    return [
        RecommendationResponseEvent::class => ['onRecommendationResponse', -10],
    ];
}
```

The `-10` refers to priority, which must be negative so this action is performed before the main subscriber is run.

### Image variations

Displaying image variations isn't supported out of the box.

You can work around this limitation by creating a template (based on [recommendations.html.twig](https://github.com/ibexa/personalization-client/blob/4.6/src/bundle/Resources/views/recommendations.html.twig)).

To access a specific image variation through API, add the `image` parameter to the request URL with the name of the variation as its value.
For example, to retrieve the `rss` variation of the image, use:

`/api/ezp/v2/ibexa_recommendation/v1/contenttypes/16?lang=eng-GB&fields=title,description,image,intro,name&page=1&page_size=20&image=rss`

### Troubleshooting

#### Logging

Most operations are logged by using the `ibexa-personalization` [Monolog channel]([[= symfony_doc =]]/logging/channels_handlers.html).
To log everything about Personalization to `dev.recommendation.log`, add the following configuration:

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

Depending on your requirements, you may need to set up `edit` and `view` [permissions](permissions.md) to grant users access to recommendation settings that relate to different SiteAccesses and results that come from these websites.

## Configure recommendation logic

When you enable the Personalization, you can go back to the back office, refresh the Personalization dashboard and proceed with [configuring the logic]([[= user_doc =]]/personalization/configure_personalization/) used to calculate the recommendation results.
