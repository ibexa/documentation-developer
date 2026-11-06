# Add Image Asset from Digital Asset Management

Configure a Digital Asset Management connector.

With the Digital Asset Management (DAM) system connector you can use assets such as images directly from the DAM in your content.

## DAM configuration

You can configure a connection with a Digital Asset Management (DAM) system under the `ibexa.system.<scope>.content.dam` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files).

```yaml
ibexa:
    system:
        default:
            content:
                dam: [ dam_name ]
```

The configuration for each connector depends on the requirements of the specific DAM system.

You can use the provided example DAM connector for [Unsplash](https://unsplash.com/), or [extend DAM support by creating a connector of your choice](#extend-dam-support-by-adding-custom-connector).

To add the Unsplash connector to your system, add the `ibexa/connector-unsplash` bundle to your installation.

## Add Image Asset in Page Builder (Experience, Commerce)

To add Image Assets directly in the Page Builder, you can do it by using the Embed block. The example below shows how to add images from [Unsplash](https://unsplash.com/).

First, in `templates/themes/standard/embed/`, create a custom template `dam.html.twig`:

```html+twig
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

For more information about displaying content, see [Content rendering](../../../templating/render_content/render_content/index.md).

```yaml
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

In your [configuration file](../../../administration/configuration/configuration/index.md#configuration-files) add the following configuration:

```yaml
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

In the back office, go to **Admin** > **Content types**. In the **Content** group, create a content type for DAM images, which includes the ImageAsset field.

Now, when you use the Embed block in the Page Builder, you should see a DAM Image.

For more information about block customization (defined templates, variations), see [Create custom block](../../../tutorials/page_and_form_tutorial/4_create_a_custom_block/index.md).

## Extend DAM support by adding custom connector

To extend the DAM support built into Ibexa DXP, you must create a custom handler and transformation factory.

> **Note: Wikimedia Commons licensing**
>
> Before you use Wikimedia Commons assets in a production environment, ensure that you comply with their [license requirements](https://commons.wikimedia.org/wiki/Commons:Reusing_content_outside_Wikimedia#How_to_comply_with_a_file's_license_requirements).

### Create DAM handler

This class handles searching through Wikimedia Commons for images and fetching image assets.

In `src/Connector/Dam/Handler` folder, create the `WikimediaCommonsHandler.php` file that resembles the following example, which implements [`search()`](../../../../../../ibexa/connector-dam/src/contracts/Handler/Handler.php) to query the server and [`fetchAsset()`](../../../../../../ibexa/connector-dam/src/contracts/Handler/Handler.php) to return asset objects:

```php
<?php declare(strict_types=1);

namespace App\Connector\Dam\Handler;

use Ibexa\Contracts\Connector\Dam\Asset;
use Ibexa\Contracts\Connector\Dam\AssetCollection;
use Ibexa\Contracts\Connector\Dam\AssetIdentifier;
use Ibexa\Contracts\Connector\Dam\AssetMetadata;
use Ibexa\Contracts\Connector\Dam\AssetSource;
use Ibexa\Contracts\Connector\Dam\AssetUri;
use Ibexa\Contracts\Connector\Dam\Handler\Handler as HandlerInterface;
use Ibexa\Contracts\Connector\Dam\Search\AssetSearchResult;
use Ibexa\Contracts\Connector\Dam\Search\Query;

class WikimediaCommonsHandler implements HandlerInterface
{
    private const string USER_AGENT = 'Ibexa DXP Commons Dam Connector';

    public function search(Query $query, int $offset = 0, int $limit = 20): AssetSearchResult
    {
        $searchUrl = 'https://commons.wikimedia.org/w/api.php?action=query&list=search&format=json&srnamespace=6'
            . '&srsearch=' . urlencode($query->getPhrase())
            . '&sroffset=' . $offset
            . '&srlimit=' . $limit
        ;

        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => [
                    'User-Agent: ' . self::USER_AGENT,
                ],
            ],
        ];

        $jsonResponse = file_get_contents($searchUrl, false, stream_context_create($opts));
        if ($jsonResponse === false) {
            return new AssetSearchResult(0, new AssetCollection([]));
        }

        $response = json_decode($jsonResponse, true);
        if (!isset($response['query']['search'])) {
            return new AssetSearchResult(0, new AssetCollection([]));
        }

        $assets = [];
        foreach ($response['query']['search'] as $result) {
            $identifier = str_replace('File:', '', $result['title']);
            $assets[] = $this->fetchAsset($identifier);
        }

        return new AssetSearchResult(
            (int) ($response['query']['searchinfo']['totalhits'] ?? 0),
            new AssetCollection($assets)
        );
    }

    public function fetchAsset(string $id): Asset
    {
        $metadataUrl = 'https://commons.wikimedia.org/w/api.php?action=query&prop=imageinfo&iiprop=extmetadata&format=json'
            . '&titles=File%3a' . urlencode($id)
        ;

        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => [
                    'User-Agent: ' . self::USER_AGENT,
                ],
            ],
        ];

        $jsonResponse = file_get_contents($metadataUrl, false, stream_context_create($opts));
        if ($jsonResponse === false) {
            throw new \RuntimeException('Couldn\'t retrieve asset metadata');
        }

        $response = json_decode($jsonResponse, true);
        if (!isset($response['query']['pages'])) {
            throw new \RuntimeException('Couldn\'t parse asset metadata');
        }

        $pageData = array_values($response['query']['pages'])[0] ?? null;
        if (!isset($pageData['imageinfo'][0]['extmetadata'])) {
            throw new \RuntimeException('Couldn\'t parse image asset metadata');
        }

        $imageInfo = $pageData['imageinfo'][0]['extmetadata'];

        return new Asset(
            new AssetIdentifier($id),
            new AssetSource('commons'),
            new AssetUri('https://commons.wikimedia.org/w/index.php?title=Special:Redirect/file/' . urlencode($id)),
            new AssetMetadata([
                'page_url' => "https://commons.wikimedia.org/wiki/File:$id",
                'author' => $imageInfo['Artist']['value'] ?? null,
                'license' => $imageInfo['LicenseShortName']['value'] ?? null,
                'license_url' => $imageInfo['LicenseUrl']['value'] ?? null,
            ])
        );
    }
}
```

Then, in `config/services.yaml`, register the handler as a service:

```yaml
    App\Connector\Dam\Handler\WikimediaCommonsHandler:
        tags:
            - { name: 'ibexa.platform.connector.dam.handler', source: 'commons' }
```

The `source` parameter passed in the tag is an identifier of this new DAM connector and is used in other places to glue elements together.

### Create transformation factory

The transformation factory maps Ibexa DXP's image variations to corresponding variations from Wikimedia Commons.

In `src/Connector/Dam/Transformation` folder, create the `WikimediaCommonsTransformationFactory.php` file that resembles the following example, which implements the [`TransformationFactory` interface](../../../../../../ibexa/connector-dam/src/contracts/Variation/TransformationFactory.php):

```php
<?php declare(strict_types=1);

namespace App\Connector\Dam\Transformation;

use Ibexa\Contracts\Connector\Dam\Variation\Transformation;
use Ibexa\Contracts\Connector\Dam\Variation\TransformationFactory as TransformationFactoryInterface;

class WikimediaCommonsTransformationFactory implements TransformationFactoryInterface
{
    /** @param array<string, scalar> $transformationParameters */
    public function build(?string $transformationName = null, array $transformationParameters = []): Transformation
    {
        if (null === $transformationName) {
            return new Transformation(null, array_map(strval(...), $transformationParameters));
        }

        $transformations = $this->buildAll();

        if (array_key_exists($transformationName, $transformations)) {
            return $transformations[$transformationName];
        }

        throw new \InvalidArgumentException(sprintf('Unknown transformation "%s".', $transformationName));
    }

    public function buildAll(): array
    {
        return [
            'reference' => new Transformation('reference', []),
            'tiny' => new Transformation('tiny', ['width' => '30']),
            'small' => new Transformation('small', ['width' => '100']),
            'medium' => new Transformation('medium', ['width' => '200']),
            'large' => new Transformation('large', ['width' => '300']),
        ];
    }
}
```

Then register the transformation factory as a service:

```yaml
    App\Connector\Dam\Transformation\WikimediaCommonsTransformationFactory:
        tags:
            - { name: 'ibexa.platform.connector.dam.transformation_factory', source: 'commons' }
```

### Register variations generator

The variation generator applies map parameters coming from the transformation factory to build a fetch request to the DAM. The solution uses the built-in `URLBasedVariationGenerator` class, which adds all the map elements as query parameters to the request.

For example, for an asset with the ID `Ibexa_Logo.svg`, the handler generates the Asset with [`AssetUri's URL`](../../../../../../ibexa/connector-dam/src/contracts/AssetUri.php) equal to:

`https://commons.wikimedia.org/w/index.php?title=Special:Redirect/file/Ibexa_Logo.svg`

When the user requests a specific variation of the image, for example, "large", the variation generator modifies the URL and returns it in the following form:

`https://commons.wikimedia.org/w/index.php?title=Special:Redirect/file/Ibexa_Logo.svg&width=300`

For this to happen, register the variations generator as a service available for the custom `commons` connector:

```yaml
    commons_asset_variation_generator:
        class: Ibexa\Connector\Dam\Variation\URLBasedVariationGenerator
        tags:
            - { name: 'ibexa.platform.connector.dam.variation_generator', source: 'commons' }
```

### Configure tab for "Select from DAM" modal

To enable selecting an image from the DAM system, a modal window pops up with tabs and panels that contain different search interfaces.

In this example, the search only uses the main text input. The tab and its corresponding panel are a service created by combining existing components, like in the case of other [back office tabs](../../../administration/back_office/back_office_tabs/back_office_tabs/index.md).

The `commons_search_tab` service uses the `GenericSearchTab` class as a base, and the `GenericSearchType` form for search input. It is linked to the `commons` DAM source and uses the identifier `commons`. The DAM search tab is registered in the `connector-dam-search` [tab group](../../../administration/back_office/back_office_tabs/back_office_tabs/index.md#tab-groups) using the `ibexa.admin_ui.tab` tag.

```yaml
    commons_search_tab:
        class: Ibexa\Connector\Dam\View\Search\Tab\GenericSearchTab
        public: false
        arguments:
            $identifier: 'commons'
            $source: 'commons'
            $name: 'Wikimedia Commons'
            $searchFormType: 'Ibexa\Connector\Dam\Form\Search\GenericSearchType'
            $formFactory: '@form.factory'
        tags:
            - { name: 'ibexa.admin_ui.tab', group: 'connector-dam-search' }
```

### Create Twig template

The template defines how images that come from Wikimedia Commons are displayed.

In `templates/themes/standard/`, add the `commons_asset_view.html.twig` file that resembles the following example:

```html+twig
{% extends '@ibexadesign/ui/field_type/image_asset_view.html.twig' %}

{% block asset_preview %}
    {{ parent() }}
    <div>
        <a href="{{ asset.assetMetadata.page_url }}">Image</a>
        {% if asset.assetMetadata.author %} by {{ asset.assetMetadata.author|striptags }}{% endif %}
        {% if asset.assetMetadata.license and asset.assetMetadata.license_url %}
            under <a href="{{ asset.assetMetadata.license_url }}">{{ asset.assetMetadata.license }}</a>
        {% endif %}.
    </div>
{% endblock %}
```

Then, register the template and a fallback template in configuration files. Replace `<scope>` with an [appropriate value](../../../multisite/siteaccess/siteaccess_aware_configuration/index.md) that designates the SiteAccess or SiteAccess group, for example, `default` to use the template everywhere, including the back office:

```yaml
parameters:
    ibexa.site_access.config.<scope>.image_asset_view_defaults:
        full:
            commons:
                template: '@@ibexadesign/commons_asset_view.html.twig'
                match:
                    SourceBasedViewMatcher: commons
            default:
                template: '@@ibexadesign/ui/field_type/image_asset_view.html.twig'
                match: []
```

### Provide back office translation

When the image asset field is displayed in the back office, a table of metadata follows. This example uses new fields, so you need to provide translations for their labels, for example, in `translations/ibexa_fieldtypes_preview.en.yaml`:

```yaml
ibexa_image_asset.dam_asset.page_url: Image page
ibexa_image_asset.dam_asset.author: Image author
ibexa_image_asset.dam_asset.license: License
ibexa_image_asset.dam_asset.license_url: License page
```

### Add Wikimedia Commons connection to DAM configuration

You can now configure a connection with Wikimedia Commons under the `ibexa.system.<scope>.content.dam` key using the source identifier `commons`:

```yaml
ibexa:
    system:
        default:
            content:
                dam: [ commons ]
```

Once you clear the cache, you can search for images to see whether images from the newly configured DAM are displayed correctly, including their variations.
