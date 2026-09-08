---
description: Configure a Digital Asset Management connector.
month_change: false
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

[[= product_name =]] provides a connector for [Unsplash](https://unsplash.com/).

## Add Image Asset in Page Builder

To add Image Assets directly in the Page Builder, you can do it by using the Embed block.
The example below shows how to add images from [Unsplash](https://unsplash.com/).

Every image variation that the connector may request must be declared for the connector.
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
The `770px` variation declared above is an `unsplash`-specific image variation.

For more information about supported parameters, see the [Unsplash documentation](https://unsplash.com/documentation#dynamically-resizable-images).

In the back office, go to **Admin** > **Content types**.
In the **Content** group, create a content type for DAM images, which includes the ImageAsset field.

Now, when you use the Embed block in the Page Builder, you should see a DAM Image.

For more information about block configuration, see [Page blocks](../pages/page_blocks.md).
