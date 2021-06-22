# Images

## Introduction

Image variations (image aliases) enable you to define and use different versions of the same image. You generate variations based on filters which modify aspects such as size and proportions, quality or effects.

Image variations are generated with [LiipImagineBundle](https://github.com/liip/LiipImagineBundle), using the underlying [Imagine library from avalanche123](http://imagine.readthedocs.org/en/latest/). This bundle supports GD (default), Imagick or Gmagick PHP extensions, and enables you to define flexible filters in PHP. Image files are stored using the `IOService,` and are completely independent from the Image Field Type. They are generated only once and cleared on demand (e.g. on content removal).

LiipImagineBundle only works on image blobs (no command line tool is needed). See the [bundle's documentation to learn more on that topic](http://symfony.com/doc/master/bundles/LiipImagineBundle/configuration.html).

## Images from a DAM system

If your installation is connected to a DAM system, you can use images directly from a DAM system in your content.

The [specific configuration](config_connector.md#dam-configuration) will depend on the DAM system in question.

## Images in Rich Text

The Rich Text Field allows you to embed other Content items within the Field.

Content items that are identified as images will be rendered in the Rich Text Field using a dedicated template.

You can determine which Content Types will be treated as images and rendered using this template in the `ezplatform.content_view.image_embed_content_types_identifiers` parameter. By default it is set to cover the Image Content Type, but you can add other types that you want to be treated as images, for example:

``` yaml
parameters:
    ezplatform.content_view.image_embed_content_types_identifiers: [image, photo, banner]
```

The template that is used when rendering embedded images can be set in the `ezplatform.default_view_templates.content.embed_image` container parameter:

``` yaml
parameters:
    ezplatform.default_view_templates.content.embed_image: content/view/embed/image.html.twig
```

## Managing variations

!!! caution "Code injection in image EXIF"

    EXIF metadata of an image may contain for example, HTML, JavaScript, or PHP code. [[= product_name =]] is itself does not parse EXIF metadata, but third-party bundles need to be secured against this eventuality. Images should be treated like any other user-submitted data - make sure the metadata is properly escaped before use.

### Resolving image URLs

You can use LiipImagine's `liip:image:cache:resolve` script to resolve the path to image variations generated from the original image, with one or more paths as arguments. See [LiipImagineBundle documentation](http://symfony.com/doc/current/bundles/LiipImagineBundle/commands.html#resolve-cache) for more information.

Note that paths to repository images must be relative to the `var/<site>/storage/images` directory, for example: `7/4/2/0/247-1-eng-GB/test.jpg`.

## Setting placeholder generator

Placeholder generator enables you to download or use generated image placeholder for any missing image. It might be used when you are working on an existing database and you are not able to download uploaded images to your local development environment because of their large size

`PlaceholderAliasGenerator::getVariation` method generates placeholder (by delegating it to the implementation of `PlaceholderProvider` interface) if original image cannot be resolved and saves it under the original path.

In [[= product_name =]] there are two implementations of `PlaceholderProvider` interface:

- [GenericProvider](#genericprovider)
- [RemoteProvider](#remoteprovider)

```php
<?php

namespace eZ\Bundle\EzPublishCoreBundle\Imagine;

use eZ\Publish\Core\FieldType\Image\Value as ImageValue;

interface PlaceholderProvider
{
    /**
     * Provides a placeholder image path for a given Image FieldType value.
     *
     * @param \eZ\Publish\Core\FieldType\Image\Value $value
     * @param array $options
     * @return string Path to placeholder
     */
    public function getPlaceholder(ImageValue $value, array $options = []): string;
}
```

### GenericProvider

`\eZ\Bundle\EzPublishCoreBundle\Imagine\PlaceholderProvider\GenericProvider` generates placeholder with basic information about original image - [example 1](#configuration-examples).

**Generic image example:**

![Placeholder image GenericProvider](img/placeholder_info.jpg)

**Full page example:**

![Placeholder GenericProvider](img/placeholder_generic_provider.png)

|Option|Default value|Description|
|------|-------------|-----------|
|fontpath|n/a|Path to the font file (*.ttf). **This option is required.**|
|text|"IMAGE PLACEHOLDER %width%x%height%\n(%id%)"|Text which will be displayed in the image placeholder. %width%, %height%, %id% in it will be replaced with width, height and ID of the original image.|
|fontsize|20|Size of the font in the image placeholder.|
|foreground|#000000|Foreground color of the placeholder.|
|secondary|#CCCCCC|Secondary color of the placeholder.|
|background|#EEEEEE|Background color of the placeholder.|

### RemoteProvider

`\eZ\Bundle\EzPublishCoreBundle\Imagine\PlaceholderProvider\RemoteProvider` allows you to download placeholders from:

 - remote source e.g. <http://placekitten.com> - [example 2](#configuration-examples)
 - live version of a site - [example 3](#configuration-examples)

**Full page example:**

![Placeholder RemoteProvider - placekitten.com](img/placeholder_remote_provider.jpg)

|Option|Default value|Description|
|------|-------------|-----------|
|url_pattern|''|URL pattern. %width%, %height%, %id% in it will be replaced with width, height and ID of the original image.|
|timeout|5|Period of time before timeout, measured in seconds.|

### Semantic configuration

Placeholder generation can be configured for each [`binary_handler`](file_management.md#handling-binary-files) under the `ezplatform.image_placeholder` key:

```yaml
ezplatform:
    # ...
    image_placeholder:
        <BINARY_HANDLER_NAME>:
            provider: <PROVIDER TYPE>
            options:  <CONFIGURATION>
```

If there is no configuration assigned to `binary_handler` name, the placeholder generation will be disabled.

##### Configuration examples:

**Example 1 - placeholders with basic information about original image**

```yaml
ezplatform:
    # ...
    image_placeholder:
        default:
            provider: generic
            options:
                fontpath: '%kernel.project_dir%/src/Resources/font/font.ttf'
                background: '#EEEEEE'
                foreground: '#FF0000'
                text: 'MISSING IMAGE %%width%%x%%height%%'
```

**Example 2 - placeholders from remote source**

```yaml
ezplatform:
    # ...
    image_placeholder:
        default:
            provider: remote
            options:
                url_pattern: 'https://placekitten.com/%%width%%/%%height%%'
```

**Example 3 - placeholders from live version of a site**

```yaml
ezplatform:
    # ...
    image_placeholder:
        default:
            provider: remote
            options:
                url_pattern: 'http://example.com/var/site/storage/%%id%%'
```

## Resizing images

You can resize all original images of a chosen Content Type using the `ibexa:images:resize-original` command.
You need to provide the command with:

- identifier of the image Content Type
- identifier of the Field you want to affect
- name of the image variation to apply to the images

`ibexa:images:resize-original <Content Type identifier> <Field identifier> -f <variation name>`

For example:

`ibexa:images:resize-original photo image -f small_image`

Additionally you can provide two parameters:

- `iteration-count` is the number of images to be recreated in a single iteration, to reduce memory use. Default is `25`.
- `user` is the identifier of a User with proper permission who will perform the operation (`read`, `versionread`, `edit` and `publish`). Default is `admin`.

!!! caution

    This command publishes a new version of each Content item it modifies.

## Reusing images

You can store images in the media library as independent Content items of a generic Image Content Type to reuse them across the system.
It is achieved by uploading images to an ImageAsset Field Type.

For an ImageAsset Field to be reused you have to publish it. Only then is notification triggered stating image has been published under the Location and can now be reused.
After establishing media library you can create object Relations between the main Content item and the image Content item being used by it.

To learn more about ImageAsset Field Type and its customization see [Field Type Reference](../api/field_types_reference/imageassetfield.md).

## Handling SVG images

Currently, [[= product_name =]] does not allow you to store SVG images by using the Image or ImageAsset Field Type.
Until the full support for this MIME type is in place, you can work things around by relying on the File Field Type and implementing a custom extension that lets you display and download files in your templates.

!!! caution

    SVG images may contain JavaScript, so they may introduce XSS or other security vulnerabilities.
    Make sure end users are not allowed to upload SVG images, and be restrictive about which editors are allowed to do so.

First, enable adding SVG files to content by removing them from the blacklist of allowed MIME types.

To do it, comment out the relevant line under `ezsettings.default.io.file_storage.file_type_blacklist`
in `EzPublishCoreBundle/Resources/config/default_settings.yml`.

Then, add a download route to the `config/routes.yaml` file:

```yaml
app.svg_download:
    path: /asset/download/{contentId}/{fieldIdentifier}/{filename}
    defaults: { _controller: app.controller.content.svg:downloadSvgAction }
```

It points to a custom controller that handles the downloading of the SVG file.
The controller's definition (that you place in the `config/services.yaml` file under `services` key) and implementation are as follows:

```yaml
services:
    # ...
    App\Controller\SvgController:
        public: true
        arguments:
            - '@ezpublish.api.service.content'
            - '@ezpublish.fieldType.ezbinaryfile.io_service'
            - '@ezpublish.translation_helper'
```

```php
<?php

declare(strict_types=1);

namespace App\Controller;

use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\Values\Content\Field;
use eZ\Publish\Core\Helper\TranslationHelper;
use eZ\Publish\Core\IO\IOServiceInterface;
use eZ\Publish\Core\MVC\Symfony\Controller\Controller;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class SvgController extends Controller
{
    private const CONTENT_TYPE_HEADER = 'image/svg+xml';

    /** @var \eZ\Publish\API\Repository\ContentService */
    private $contentService;

    /** @var \eZ\Publish\Core\IO\IOServiceInterface */
    private $ioService;

    /** @var \eZ\Publish\Core\Helper\TranslationHelper */
    private $translationHelper;

    public function __construct(
        ContentService $contentService,
        IOServiceInterface $ioService,
        TranslationHelper $translationHelper
    ) {
        $this->contentService = $contentService;
        $this->ioService = $ioService;
        $this->translationHelper = $translationHelper;
    }

    /**
     * @throws \eZ\Publish\API\Repository\Exceptions\NotFoundException
     * @throws \eZ\Publish\API\Repository\Exceptions\UnauthorizedException
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException
     */
    public function downloadSvgAction(
        int $contentId,
        string $fieldIdentifier,
        string $filename,
        Request $request
    ): Response {
        $version = null;

        if ($request->query->has('version')) {
            $version = $request->query->get('version');
        }

        $content = $this->contentService->loadContent($contentId, null, $version);
        $language = $request->query->has('inLanguage') ? $request->query->get('inLanguage') : null;
        $field = $this->translationHelper->getTranslatedField($content, $fieldIdentifier, $language);

        if (!$field instanceof Field) {
            throw new InvalidArgumentException(
                sprintf("%s field not present in content %d '%s'",
                    $fieldIdentifier,
                    $content->contentInfo->id,
                    $content->contentInfo->name
                )
            );
        }

        $binaryFile = $this->ioService->loadBinaryFile($field->value->id);
        $response = new Response($this->ioService->getFileContents($binaryFile));
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE, $filename
        );

        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', self::CONTENT_TYPE_HEADER);

        return $response;
    }
}
```

To be able to use a proper link in your templates, you also need a dedicated Twig extension:

```php
<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SvgExtension extends AbstractExtension
{
    /** @var \Symfony\Component\Routing\RouterInterface */
    protected $router;

    /**
     * SvgExtension constructor.
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('ibexa_svg_link', [
                $this,
                'generateLink',
            ]),
        ];
    }

    public function generateLink(int $contentId, string $fieldIdentifier, string $filename): string
    {
        return $this->router->generate('app.svg_download', [
            'contentId' => $contentId,
            'fieldIdentifier' => $fieldIdentifier,
            'filename' => $filename,
        ]);
    }
}
```

Now you can load SVG files in your templates by using generated links and a newly created Twig helper:

```twig
{% set svgField = ez_field(content, 'file') %}

<img src="{{ ibexa_svg_link(content.versionInfo.contentInfo.id, 'file', svgField.value.fileName) }}" alt="">
```
