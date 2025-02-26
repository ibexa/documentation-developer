---
description: Configure a Digital Asset Management connector.
---

# Add Image Asset from Digital Asset Management

With the Digital Asset Management (DAM) system connector you can use assets such as images directly from the DAM in your content.

## DAM configuration

You can configure a connection with a Digital Asset Management (DAM) system under the `ibexa.system.<scope>.content.dam` [configuration key](configuration.md#configuration-files).

``` yaml
ibexa:
    system:
        default:
            content:
                dam: [ dam_name ]
```

The configuration for each connector depends on the requirements of the specific DAM system.

You can use the provided example DAM connector for [Unsplash](https://unsplash.com/), or [extend DAM support by creating a connector of your choice](#extend-dam-support-by-adding-custom-connector).

To add the Unsplash connector to your system, add the `ibexa/connector-unsplash` bundle to your installation.

## Add Image Asset in Page Builder [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

To add Image Assets directly in the Page Builder, you can do it by using the Embed block.
The example below shows how to add images from [Unsplash](https://unsplash.com/).

First, in `templates/themes/standard/embed/`, create a custom template `dam.html.twig`:

``` html+twig
{% set dam_image = ibexa_field_value(content, 'image') %}
{% if dam_image.source is not null %}
    {% set transformation = ibexa_dam_image_transformation(dam_image.source, '770px') %}
    {% set asset = ibexa_dam_asset(dam_image.destinationContentId, dam_image.source, transformation) %}
    {% set image_uri = asset.assetUri.path %}
    <img src="{{ image_uri }}">
{% endif %}
```

The `770px` parameter in the template above is used to render the DAM image. It's the `unsplash` specific image variation and must be defined separately.

Next, in `config/packages/ibexa.yaml`, set the `dam.html.twig` template for the `embed` view type that is matched for the content type, which you created for DAM images.

For more information about displaying content, see [Content rendering](render_content.md).

``` yaml
 ibexa:
   system:
     site:
       content_view:
         embed:
           image_dam:
             template: '@ibexadesign/embed/dam.html.twig'
             match:
               Identifier\ContentType: <dam_image_content_type_identifier>
```

In your [configuration file](configuration.md#configuration-files) add the following configuration:

``` yaml
dam_unsplash:
    application_id: <your_application_access_key>
    utm_source: <your_utm_source_name> 
    variations:
       770px:
            fm: jpg
            q: 80
            w: 770
            fit: max
```

You can customize the parameters according to your needs.

For more information about supported parameters, see the [Unsplash documentation](https://unsplash.com/documentation#dynamically-resizable-images).

In the back office, go to **Admin** > **Content types**.
In the **Content** group, create a content type for DAM images, which includes the ImageAsset field.

Now, when you use the Embed block in the Page Builder, you should see a DAM Image.

For more information about block customization (defined templates, variations), see [Create custom block](4_create_a_custom_block.md).

## Extend DAM support by adding custom connector

To extend the DAM support built into [= product_name =], you must create a custom Symfony bundle.

!!! note "Wikimedia Commons licensing"

    Before you use Wikimedia Commons assets in a production environment, ensure that you comply with their [license requirements](https://commons.wikimedia.org/wiki/Commons:Reusing_content_outside_Wikimedia#How_to_comply_with_a_file's_license_requirements).

### Create bundle structure

In your project's `src` directory, create a folder for the new bundle, for example, `WikimediaCommonsConnector`.

In that folder, create the main class file `WikimediaCommonsConnector.php` for the bundle:

```php
<?php

namespace WikimediaCommonsConnector;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class WikimediaCommonsConnector extends Bundle
{
}
```

Then, in `config/bundles.php`, at the end of an array with a list of bundles, add the following line:

```php
<?php

return [
    // Other bundles...
    WikimediaCommonsConnector\WikimediaCommonsConnector::class => ['all' => true],
];
```

###  Create DAM handler

This class handles searching through Wikimedia Commons for images and fetching assets.

In `src\WikimediaCommonsConnector\Handler` folder, create the `WikimediaHandler.php` file that resembles the following example, which uses `search()` and `fetchAsset()` functions to query the server for images and return asset objects, respectively:

```php
<?php

namespace WikimediaCommonsConnector\Handler;

use Ibexa\Platform\Contracts\Connector\Dam\Asset;
use Ibexa\Platform\Contracts\Connector\Dam\AssetCollection;
use Ibexa\Platform\Contracts\Connector\Dam\AssetIdentifier;
use Ibexa\Platform\Contracts\Connector\Dam\AssetMetadata;
use Ibexa\Platform\Contracts\Connector\Dam\AssetSource;
use Ibexa\Platform\Contracts\Connector\Dam\AssetUri;
use Ibexa\Platform\Contracts\Connector\Dam\Handler\Handler as HandlerInterface;
use Ibexa\Platform\Contracts\Connector\Dam\Search\AssetSearchResult;
use Ibexa\Platform\Contracts\Connector\Dam\Search\Query;

class WikimediaCommonsHandler implements HandlerInterface
{
    public function search(Query $query, int $offset = 0, int $limit = 20): AssetSearchResult
    {
        $searchUrl = 'https://commons.wikimedia.org/w/api.php?action=query&list=search&format=json&srnamespace=6'
            .'&srsearch='.urlencode($query->getPhrase())
            .'&sroffset='.$offset
            .'&srlimit='.$limit
        ;
        $response = json_decode(file_get_contents($searchUrl), true);

        $assets = [];
        foreach ($response['query']['search'] as $result) {
            $identifier = str_replace('File:', '', $result['title']);
            $assets[] = $this->fetchAsset($identifier);
        }

        return new AssetSearchResult((int) $response['query']['searchinfo']['totalhits'], new AssetCollection($assets));
    }

    public function fetchAsset(string $id): Asset
    {
        $metadataUrl = 'https://commons.wikipedia.org/w/api.php?action=query&prop=imageinfo&iiprop=extmetadata&format=json'
            .'&titles=File%3a'.urlencode($id)
        ;
        $response = json_decode(file_get_contents($metadataUrl), true);
        $imageInfo = array_values($response['query']['pages'])[0]['imageinfo'][0]['extmetadata'];

        return new Asset(
            new AssetIdentifier($id),
            new AssetSource('commons'),
            new AssetUri('https://commons.wikimedia.org/w/index.php?title=Special:Redirect/file/'.urlencode($id)),
            new AssetMetadata([
                'page_url' => "https://commons.wikimedia.org/wiki/File:$id",
                'author' => array_key_exists('Artist', $imageInfo) ? $imageInfo['Artist']['value'] : null,
                'license' => array_key_exists('LicenseShortName', $imageInfo) ? $imageInfo['LicenseShortName']['value'] : null,
                'license_url' => array_key_exists('LicenseUrl', $imageInfo) ? $imageInfo['LicenseUrl']['value'] : null,
            ])
        );
    }
}
```

Then, in `config\services.yaml`, register the handler as a service:

```yaml
services:
    WikimediaCommonsConnector\Handler\WikimediaCommonsHandler:
        arguments:
            $httpClient: '@http_client'
        tags:
            - { name: 'ibexa.platform.connector.dam.handler', source: 'commons'  }
```

### Create transformation factory

The transformation factory transforms image variations coming from Wikimedia Commons to the ones used by [= product_name =].

In `src\WikimediaCommonsConnector\Transformation` folder, create the `TransformationFactory.php` file that resembles the following example:


```php
<?php

namespace WikimediaCommonsConnector\Transformation;

use Ibexa\Platform\Contracts\Connector\Dam\Variation\Transformation;
use Ibexa\Platform\Contracts\Connector\Dam\Variation\TransformationFactory as TransformationFactoryInterface;

class TransformationFactory implements TransformationFactoryInterface
{
    public function build(?string $transformationName = null, array $transformationParameters = []): Transformation
    {
        return $this->buildAll()[$transformationName];
    }

    public function buildAll(): iterable
    {
        return [
            'reference' => new Transformation('reference'),
            'tiny' => new Transformation('tiny', ['width' => 30]),
            'small' => new Transformation('small', ['width' => 100]),
            'medium' => new Transformation('medium', ['width' => 200]),
            'large' => new Transformation('large', ['width' => 300]),
        ];
    }
}
```

Then register the transformation factory as a service:

```yaml
services:
    WikimediaCommonsConnector\Transformation\TransformationFactory:
        arguments:
            $httpClient: '@http_client'
        tags:
            - { name: 'ibexa.platform.connector.dam.transformation_factory', source: 'commons' }
```

### Register variations generator

The variation generator applies map parameters coming from the transformation factory to build a fetch request to the DAM.
The `WikimediaCommonsConnector` uses the built-in `URLBasedVariationGenerator` class, which adds all the map elements as query parameters of the request.

For example, the handler generates the following URL with `new AssetUri()`:

`https://commons.wikimedia.org/w/index.php?title=Special:Redirect/file/Ibexa_Logo.svg`

When the user requests a specific variation of the image, the variation generator modifies the URL and returns it in the following form:

`https://commons.wikimedia.org/w/index.php?title=Special:Redirect/file/Ibexa_Logo.svg&width=300`

For this to happen, register the variations generator as a service:

```yaml
services:
    commons_asset_variation_generator:
        class: Ibexa\Connector\Dam\Variation\URLBasedVariationGenerator
        tags:
            - { name: ibexa.platform.connector.dam.variation_generator, source: commons }
```

### Create Twig template for Admin UI

The template deffines how images that come from Wikimedia Commons appear in the back office.

In `src/WikimediaCommonsConnector/Resources/views/themes/standard/`, add the `commons_asset_view.html.twig` file that resembles the following example:

```html+twig
{% extends '@ezdesign/ui/field_type/image_asset_view.html.twig' %}

{% block asset_preview %}
    {{ parent() }}
    <div>
        {{ 'ezimageasset.commons.author_attribute'|trans({
            '%page_url%': asset.assetMetadata.page_url,
            '%author%': asset.assetMetadata.author,
            '%license_url%': asset.assetMetadata.license_url,
            '%license%': asset.assetMetadata.license,
        })|desc('<a href="%page_url%">Image</a> by %author% under <a href="%license_url%">%license%</a>')|raw }}
    </div>
{% endblock %}
```

Then, register the template in `config/packages/ibexa_admin.yaml`:

```yaml
ibexa_admin_ui:
    asset_view:
        wikimedia_commons:
            template: '@WikimediaCommonsConnector/admin/commons_asset_view.html.twig'
```

## Add Wikimedia Commons to DAM configuration

You can now configure a connection with Wikimedia Commons under the `ibexa.system.<scope>.content.dam` key:

```yaml
ibexa:
    system:
        default:
            content:
                dam: [ commons ]
```

Once you clear the cache, and search for images to see whether images from the newly configured DAM are displayed correctly, including their variations.