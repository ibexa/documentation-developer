---
description: Manage image assets by using DAM systems, configuring image variations, optimizing and using placeholders.
month_change: false
---

# Images

Images are an integral part of any website.
They can serve as decoration and convey information.

In [[= product_name =]], you can reuse them, normalize their file names, generate different size variations, resize images programmatically, or even define placeholders for missing ones.

## Images from DAM systems

If your installation is connected to a DAM system, you can use images directly from a DAM system in your content.

Specific [DAM configuration](add_image_asset_from_dam.md#dam-configuration) depends on the system that the installation uses.

## Reuse images

You can store images in the media library as independent content items of a generic Image [content type](content_types.md) to reuse them across the system.
You do this by uploading images to an [ImageAsset](imageassetfield.md) field type.

For an ImageAsset field to be reused, you must publish it.
Only then is notification triggered, which states that an image has been published under the location and can now be reused.
After you establish a media library, you can create [Relations](content_relations.md) between the image content item and the main content item that uses it.

## Configuring image variations

With image variations (image aliases) you can define and use different versions of the same image.
You generate variations based on filters that modify aspects such as size and proportions, quality or effects.

Image variations are generated with [LiipImagineBundle](https://github.com/liip/LiipImagineBundle), by using the underlying [Imagine library](https://imagine.readthedocs.io/en/latest/).
The LiipImagineBundle bundle supports GD (default), Imagick or Gmagick PHP extensions, and enables you to define flexible filters in PHP.
Image files are stored by using the `IOService,` and are completely independent from the Image field type.
They're generated only once and cleared on demand, for example, on content removal).

LiipImagineBundle only works on image blobs, so no command line tool is needed.

For more information, see the [bundle's documentation](https://symfony.com/bundles/LiipImagineBundle/current/configuration.html).

!!! caution "Code injection in images"

    Images must be treated like any other user-submitted data - as potentially malicious.

    - EXIF metadata of an image may contain for example, HTML, JavaScript, or PHP code.
      [[= product_name =]] itself doesn't parse EXIF metadata, but third-party bundles must be secured against this eventuality.
      Make sure that metadata is properly escaped before use.
    - Images may contain specially crafted flaws that exploit vulnerabilities in common image libraries
      like GD or Imagick, leading to code execution. It's important to keep these libraries up to date with security updates.

## Generating placeholder images

With a placeholder generator you can download or generate placeholder images for any missing image.
It proves useful when you're working on an existing database and are unable to download uploaded images to your local development environment, due to, for example, a large size of files.

If the original image cannot be resolved, the `PlaceholderAliasGenerator::getVariation` method generates a placeholder by delegating it to the implementation of the [PlaceholderProvider](https://github.com/ibexa/core/blob/6.0/src/bundle/Core/Imagine/PlaceholderProvider.php) interface, and saves it under the original path.

In [[= product_name =]], there are two implementations of the `PlaceholderProvider` interface:

- [GenericProvider](#genericprovider)
- [RemoteProvider](#remoteprovider)

### GenericProvider

The [`GenericProvider`](https://github.com/ibexa/core/blob/6.0/src/bundle/Core/Imagine/PlaceholderProvider.php) package generates placeholders with basic information about the original image (see [example 1](#configuration-examples)).

![Placeholder image GenericProvider](placeholder_info.jpg "Example of a generic placeholder image")

![Placeholder GenericProvider](placeholder_generic_provider.png "Generic placeholder images on a page")

|Option|Default value|Description|Required?|
|------|-------------|-----------|-|
|fontpath|n/a|Path to the font file (*.ttf).|Yes|
|text|"IMAGE PLACEHOLDER %width%x%height%\n(%id%)"|Text which is displayed in the image placeholder. %width%, %height%, %id% in it's replaced with width, height and ID of the original image.| |
|fontsize|20|Size of the font in the image placeholder.| |
|foreground|#000000|Foreground color of the placeholder.| |
|secondary|#CCCCCC|Secondary color of the placeholder.| |
|background|#EEEEEE|Background color of the placeholder.| |

### RemoteProvider

With the [`RemoteProvider`](https://github.com/ibexa/core/blob/6.0/src/bundle/Core/Imagine/PlaceholderProvider/RemoteProvider.php) you can download placeholders from:

- remote sources, for example, <http://placecats.com> (see [example 2](#configuration-examples))
- live version of a site (see [example 3](#configuration-examples))

![Placeholder RemoteProvider - placecats.com](placeholder_remote_provider.jpg "Remote placeholder images on a page")

|Option|Default value|Description|
|------|-------------|-----------|
|url_pattern|''|URL pattern. %width%, %height%, %id% in it's replaced with width, height and ID of the original image.|
|timeout|5|Period of time before timeout, measured in seconds.|

### Semantic configuration

Placeholder generation can be configured for each [`binary_handler`](file_management.md#handling-binary-files) under the `ibexa.image_placeholder` [configuration key](configuration.md#configuration-files):

```yaml
ibexa:
    # ...
    image_placeholder:
        <BINARY_HANDLER_NAME>:
            provider: <PROVIDER TYPE>
            options:  <CONFIGURATION>
```

If there is no configuration assigned to the `binary_handler`, the placeholder generation is disabled.

#### Configuration examples

##### Example 1 - placeholders with basic information about original image

```yaml
[[= include_file('code_samples/back_office/images/config/packages/images_basic.yaml') =]]
```

##### Example 2 - placeholders from remote source

```yaml
[[= include_file('code_samples/back_office/images/config/packages/images_remote.yaml') =]]
```

##### Example 3 - placeholders from live version of a site

```yaml
[[= include_file('code_samples/back_office/images/config/packages/images_live.yaml') =]]
```

## Image optimization

JPEG images are optimized using the ImageMagic library, which is available out of the box.

If you use other formats, such a PNG, SVG, GIF, or WEBP, and you use the Image Editor, to prevent images increasing in size when you modify them in the editor, you need to install additional image handling libraries.

|Image format|Library|
|---|---|
|JPEG|JpegOptim|
|PNG|Either OptiPNG or Pngquant 2|
|SVG|SVGO 1|
|GIF|Gifsicle|
|WEBP|cwebp|

Install these libraries using your package manager, for example:

``` bash
sudo apt-get install optipng
```

## Embedding images in Rich Text

The [RichText](richtextfield.md) field allows you to embed other content items within the field.

Content items that are identified as images are rendered in the Rich Text field by using a dedicated template.

You can determine content types that are treated as images and rendered.
You do this by overriding the `ibexa.content_view.image_embed_content_types_identifiers` parameter, for example:

``` yaml
[[= include_file('code_samples/back_office/images/config/default_settings.yaml', 0, 2) =]]
```

You can set the template that is used when rendering embedded images in the `ibexa.default_view_templates.content.embed_image` container parameter:

``` yaml
[[= include_file('code_samples/back_office/images/config/default_settings.yaml', 0, 1) =]] [[= include_file('code_samples/back_office/images/config/default_settings.yaml', 2, 3) =]]
```
