---
description: Configure a Digital Asset Management connector.
---

# Add Image Asset from Digital Asset Management

With the Digital Asset Management (DAM) system connector you can use assets such as images directly from the DAM in your content.

## DAM configuration

You can configure a connection with a Digital Asset Management (DAM) system.

``` yaml
ibexa:
    system:
        default:
            content:
                dam: [ dam_name ]
```

The configuration for each connector depends on the requirements of the specific DAM system.

You can create your own connectors, or use the provided example DAM connector for [Unsplash](https://unsplash.com/).

To add the Unsplash connector to your system add the `ibexa/connector-unsplash` bundle to your installation.

## Add Image Asset in Page Builder [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

To add Image Assets directly in the Page Builder, you can do it by using the Embed block. 
The example below shows how to add images from [Unsplash](https://unsplash.com/).

First, in `templates/embed/`, create a custom template `dam.html.twig`:

``` html+twig
{% set dam_image = ibexa_field_value(content, 'image') %}
{% if dam_image.source is not null %}
    {% set transformation = ibexa_dam_image_transformation(dam_image.source, '770px') %}
    {% set asset = ibexa_dam_asset(dam_image.destinationContentId, dam_image.source, transformation) %}
    {% set image_uri = asset.assetUri.path %}
    <img src="{{ image_uri }}">
{% endif %}
```

The `770px` parameter in the template above is used to render the DAM image. It is the `unsplash` specific image variation and must be defined separately.

Next, in `config/packages/ibexa.yaml`, set the `dam.html.twig` template for the `embed` view type that is matched for the Content Type, which you created for DAM images. 
For more information about displaying content, see [Content rendering](render_content.md).

``` yaml
 ibexa:
   system:
     site:
       content_view:
         embed:
           image_dam:
             template: embed/dam.html.twig
             match:
               Identifier\ContentType: <dam_image_content_type_identifier>
```

In the `config/packages/ibexa.yaml` add the following configuration:

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

In the Back Office, go to **Admin** > **Content Types**.
In the **Content** group, create a Content Type for DAM images, which includes the ImageAsset Field. 

Now, when you use the Embed block in the Page Builder, you should see a DAM Image.

For more information about block customization (defined templates, variations), see [Create custom block](4_create_a_custom_block.md).
