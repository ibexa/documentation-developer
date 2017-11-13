# Recommendation

The Recommendation Bundle extends the functionality of eZ Platform with a recommendation engine, powered by [YOOCHOOSE](https://yoochoose.com/). It allows you to track the way visitors use your website and suggests recommended content to them based on their behavior.

See [eZ Services documentation](https://doc.ezplatform.com/projects/ezservices) to learn how the recommendation engine works from the YOOCHOOSE side.

## Installing the Recommendation Bundle

The Recommendation Bundle is installed in a similar way as any other Symfony bundle.

### Requirements

- eZ Platform/Enterprise with the REST API configured to use sessions and publicly open to the YOOCHOOSE servers
- A YOOCHOOSE license

### Step 1: Installation

**1.** Run the following from your eZ Platform installation root *(here with most recent 1.x release)*:

``` bash
composer require --no-update ezsystems/recommendation-bundle:^1.0.0
composer update --prefer-dist
```

**2.** Enable the bundle in `app/AppKernel.php`:

``` php
$bundles = array(
    // existing bundles
    new EzSystems\RecommendationBundle\EzSystemsRecommendationBundle()
);
```

**3.** Import additional routing by adding the following lines to your `routing.yml` file:

``` yaml
recommendationBundleRestRoutes:
    resource: "@EzSystemsRecommendationBundle/Resources/config/routing_rest.yml"
    prefix:   %ezpublish_rest.path_prefix%
```

Keep in mind that legacy support is disabled by default. To enable legacy search engine (requires `ezpublish-kernel` bundle) uncomment these lines in the bundle's `services.yml`:

``` yaml
# ez_recommendation.legacy.search_engine:
#     class: ezpSearchEngine
#     factory_class: EzSystems\RecommendationBundle\eZ\Publish\LegacySearch\LegacySearchFactory
#     factory_method: build
#     arguments: [@ezpublish_legacy.kernel]

# ez_recommendation.legacy.recommendation_search_engine:
#     class: EzSystems\RecommendationBundle\eZ\Publish\LegacySearch\RecommendationLegacySearchEngine
#     arguments:
#         - @ez_recommendation.client.yoochoose_notifier
#         - @ez_recommendation.legacy.search_engine

# ez_recommendation.legacy.search_configuration_mapper:
#     class: EzSystems\RecommendationBundle\eZ\Publish\LegacySearch\ConfigurationMapper
#     arguments:
#         - @ez_recommendation.legacy.recommendation_search_engine
#         - @ezpublish.siteaccess
#     tags:
#         - { name: kernel.event_subscriber }
```

### Step 2: Configuration

The bundle's configuration is SiteAccess-aware. This is an example of settings *(config.yml)*:

``` yaml
ez_recommendation:
    system:
        default:
            yoochoose:
                customer_id: "12345"
                license_key: "1234-5678-9012-3456-7890"
            server_uri: "http://example.com"
            recommender:
                included_content_types: ["blog", "article"]
```

The following parameters need to be included in the settings file:

| Parameter                            | Description                                                                                                    |
|--------------------------------------|----------------------------------------------------------------------------------------------------------------|
| `yoochoose.customer_id`              | Your YOOCHOOSE customer ID.                                                                                    |
| `yoochoose.license_key`              | Your YOOCHOOSE license key.                                                                                    |
| `server_uri`                         | The URI your site's REST API can be accessed from.                                                             |
| `recommender.included_content_types` | Content Types on which the tracking script will be shown. See [Tracking](#tracking) below for more information. |

If content's author or image are stored in different field, you can specify it in **parameters.yml:**

``` yaml
    ez_recommendation.field_identifiers:
        {field fetched by controller (image or author)}
             {content type}: {field with value}
```

For example:

``` yaml
    ez_recommendation.field_identifiers:
         author:
             article: authors
         image:
             article: thumbnail
             blog_post: main_image
```

#### Advanced configuration

You can select advanced options for YOOCHOOSE back end using the following settings:

``` yaml
ez_recommendation:
    api_endpoint: 'https://admin.yoochoose.net'
    recommender:
        api_endpoint: '//reco.yoochoose.net'
        consume_timeout: 20
    tracking:
        api_endpoint: 'http://event.yoochoose.net'
        script_url: 'cdn.yoochoose.net/yct.js'
```

Changing any of these parameters without a valid reason will break all calls to YOOCHOOSE. It can be useful to test the API by mocking the service, or if you have a hosted version of YOOCHOOSE Recommendation service.

### Step 3: Clear `prod` cache

While Symfony `dev` environment keeps track of changes to yml files, `prod` does not, so to make sure Symfony reads the new config, clear cache:

``` bash
php app/console --env=prod clear:cache
```

## Using the Recommendation Bundle

### Initial Setup

Your content structure must be mapped to the YOOCHOOSE domain model. This must be done in collaboration with YOOCHOOSE.

### Indexing

**Public** content is automatically indexed. When necessary, eZ Platform will notify YOOCHOOSE of changes to content. Initial import is to be managed with your YOOCHOOSE sales representative. Note that your server's REST API will need to be open to the YOOCHOOSE servers for indexing to be possible.

### Tracking

Events from the site need to be sent to YOOCHOOSE so that recommendations can be adapted to visitors. Tracking can be set up in multiple ways, depending on existing constraints.

`EzSystemsRecommendationBundle` delivers a Twig extension which helps integrate the tracking functionality into your site.

##### To enable tracking

**1.** Place the following snippet of code somewhere in the HEAD section of your header template:

``` html
{% if content is defined %}
    {{ yc_track_user(content.id) }}
{% endif %}
```

**2.** Configure settings under the `recommender.included_content_types` parameter (see the `default_settings.yml` file delivered with this bundle). Here you can define for which Content Types tracking script will be shown.

In the YOOCHOOSE documentation you can find more information about [tracking in general](https://doc.ezplatform.com/projects/ezservices/en/latest/personalization/developer_guide/tracking_api/) and about the [generic asynchronous javascript tracker](https://doc.ezplatform.com/projects/ezservices/en/latest/personalization/developer_guide/tracking_with_yct/).

Additionally, in case of missing content owner ID, there's an option in `default_settings.yml` to set up the default content author:

``` yaml
    ez_recommendation.default.author_id: 14   # ID: 14 is default ID of admin user
```

### Displaying

In order to allow displaying recommendations on your site you must add portions of scripts which will integrate the recommender engine with your site.

Implementation is very easy and can be performed in just a few steps (assuming that the `EzSystemsRecommendationBundle` is properly configured and enabled in `AppKernel.php`):

#### To enable displaying recommendations

**1.** Add the following JavaScript assets to your header template:

``` html
{% javascripts
    ...

    '%kernel.root_dir%/../vendor/components/handlebars.js/handlebars.min.js'
    '@EzSystemsRecommendationBundle/Resources/public/js/recommendationtemplaterenderer.js'
    '@EzSystemsRecommendationBundle/Resources/public/js/recommendationtemplatehelper.js'
    '@EzSystemsRecommendationBundle/Resources/public/js/recommendationrestclient.js'
%}
```

**2.** Place a dedicated Twig helper in the place where you want to display recommendations:

``` html
{{ yc_show_recommendations(
    contentId = content.id,
    scenario = '',
    limit = '',
    contentType = '',
    template = '',
    fields = []
) }}
```

#### Parameters

| Parameter   | Type   | Description   |
|-------------|--------|---------------|
| `contentId`   | int    | In content-based views the Twig variable holding the content ID (the content you want to get recommendations for). |
| `scenario`    | string | Scenario used to display recommendations. You can create custom scenarios in the YOOCHOOSE dashboard. |
| `limit`       | int    | Number of recommendations to show. |
| `contentType` | string | Content Types you are expecting in response. |
| `template`    | string | HandleBars template name (your templates are stored in the `ezsystems/recommendation-bundle/Resources/public/views` directory. Take a look at `default.html.twig` which includes a default template that can be used to prepare customized versions). |
| `fields`      | array  | Fields which are required and will be requested from the recommender engine. These field names are also used inside HandleBars templates. |

Sample integration can take the following form:

``` html
{{ yc_show_recommendations(
    contentId = content.id,
    scenario = 'popular',
    limit = 5,
    contentType = 'article',
    template = 'default',
    fields = ['ez_publishedDate', 'ez_url', 'title', 'image', 'author', 'intro']
) }}
```

You can also bypass named arguments using standard value passing as arguments.

#### Item ID

The item ID is usually set to the viewed ContentId. Depending on requirements, it can be set to a different value, in collaboration with YOOCHOOSE.

#### Displaying image variations

Displaying image variations defined with image aliases is not currently supported out of the box.

You can work around this limitation by creating your own template (based on <https://github.com/ezsystems/ezstudio-demo/blob/master/app/Resources/EzSystemsRecommendationBundle/views/recommendations.html.twig>) or your own Twig extension (based on <https://github.com/ezsystems/EzSystemsRecommendationBundle/blob/master/Twig/RecommendationTwigExtension.php#L214>).

If you want to access a specific image variation through API, you need to add the `image` parameter to the request URL with name of the variation as its value. For example, to retrieve the `rss` variation of the image, use:

`/api/ezp/v2/ez_recommendation/v1/contenttypes/16?lang=eng-GB&fields=title,description,image,intro,name&page=1&page_size=20&image=rss`

The additional `sa` parameter takes the SiteAccess name and defines the SiteAccess whose content will be displayed.

### Troubleshooting

Most operations are logged via the `ez_recommendation` [Monolog channel](http://symfony.com/doc/current/cookbook/logging/channels_handlers.html). To log everything about Recommendation to `dev.recommendation.log`, add the following to your `config.yml`:

``` yaml
monolog:
    handlers:
        ez_recommendation:
            type:   stream
            path:   "%kernel.logs_dir%/%kernel.environment%.recommendation.log"
            channels: [ez_recommendation]
            level: info
```

You can replace `info` with `debug` for more verbosity.

##### Further information:

[API doc for YOOCHOOSE Service](http://docs.ezreco.apiary.io/)

[Developer Guides for YOOCHOOSE Service](https://doc.ezplatform.com/projects/ezservices/en/latest/personalization/developer_guide/tracking_api/)
