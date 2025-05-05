---
description: Configure a Digital Asset Management connector.
month_change: true
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

To extend the DAM support built into [[= product_name =]], you must create a custom handler and transformation factory.

!!! note "Wikimedia Commons licensing"

    Before you use Wikimedia Commons assets in a production environment, ensure that you comply with their [license requirements](https://commons.wikimedia.org/wiki/Commons:Reusing_content_outside_Wikimedia#How_to_comply_with_a_file's_license_requirements).

###  Create DAM handler

This class handles searching through Wikimedia Commons for images and fetching image assets.

In `src/Connector/Dam/Handler` folder, create the `WikimediaCommonsHandler.php` file that resembles the following example,
which implements [`search()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connector-Dam-Handler-Handler.html#method_search) to query the server
and [`fetchAsset()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connector-Dam-Handler-Handler.html#method_fetchAsset) to return asset objects:

```php
[[= include_file('code_samples/back_office/images/src/Connector/Dam/Handler/WikimediaCommonsHandler.php') =]]
```

Then, in `config/services.yaml`, register the handler as a service:

```yaml
[[= include_file('code_samples/back_office/images/config/services.yaml', 9, 12) =]]
```

The `source` parameter passed in the tag is an identifier of this new DAM connector and is used in other places to glue elements together.

### Create transformation factory

The transformation factory maps [[= product_name =]]'s image variations to corresponding variations from Wikimedia Commons.

In `src/Connector/Dam/Transformation` folder, create the `WikimediaCommonsTransformationFactory.php` file that resembles the following example,
which implements the [`TransformationFactory` interface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connector-Dam-Variation-TransformationFactory.html):

```php
[[= include_file('code_samples/back_office/images/src/Connector/Dam/Transformation/WikimediaCommonsTransformationFactory.php') =]]
```

Then register the transformation factory as a service:

```yaml
[[= include_file('code_samples/back_office/images/config/services.yaml', 13, 16) =]]
```

### Register variations generator

The variation generator applies map parameters coming from the transformation factory to build a fetch request to the DAM.
The solution uses the built-in `URLBasedVariationGenerator` class, which adds all the map elements as query parameters to the request.

For example, for an asset with the ID `Ibexa_Logo.svg`, the handler generates the Asset with [`AssetUri's URL`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connector-Dam-AssetUri.html#method_getPath) equal to:

`https://commons.wikimedia.org/w/index.php?title=Special:Redirect/file/Ibexa_Logo.svg`

When the user requests a specific variation of the image, for example, "large", the variation generator modifies the URL and returns it in the following form:

`https://commons.wikimedia.org/w/index.php?title=Special:Redirect/file/Ibexa_Logo.svg&width=300`

For this to happen, register the variations generator as a service available for the custom `commons` connector:

```yaml
[[= include_file('code_samples/back_office/images/config/services.yaml', 17, 21) =]]
```

### Configure tab for "Select from DAM" modal

To enable selecting an image from the DAM system, a modal window pops up with tabs and panels that contain different search interfaces.

In this example, the search only uses the main text input.
The tab and its corresponding panel are a service created by combining existing components, like in the case of other [back office tabs](back_office_tabs.md).

The `commons_search_tab` service uses the `GenericSearchTab` class as a base, and the `GenericSearchType` form for search input.
It is linked to the `commons` DAM source and uses the identifier `commons`. 
The DAM search tab is registered in the `connector-dam-search` [tab group](back_office_tabs.md#tab-groups) using the `ibexa.admin_ui.tab` tag.


```yaml
[[= include_file('code_samples/back_office/images/config/services.yaml', 22, 33) =]]
```

### Create Twig template

The template defines how images that come from Wikimedia Commons are displayed.

In `templates/themes/standard/`, add the `commons_asset_view.html.twig` file that resembles the following example:

```html+twig
[[= include_file('code_samples/back_office/images/templates/themes/standard/commons_asset_view.html.twig') =]]
```

Then, register the template and a fallback template in configuration files.
Replace `<scope>` with an [appropriate value](siteaccess_aware_configuration.md) that designates the SiteAccess or SiteAccess group, for example, `default` to use the template everywhere, including the back office:

```yaml
[[= include_file('code_samples/back_office/images/config/packages/views.yaml') =]]
```

### Provide back office translation

When the image asset field is displayed in the back office, a table of metadata follows.
This example uses new fields, so you need to provide translations for their labels, for example, in `translations/ibexa_fieldtypes_preview.en.yaml`:

```yaml
[[= include_file('code_samples/back_office/images/translations/ibexa_fieldtypes_preview.en.yaml') =]]
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
