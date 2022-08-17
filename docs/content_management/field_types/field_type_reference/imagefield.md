# Image Field Type

The Image Field Type allows you to store an image file.

| Name    | Internal name |
|---------|---------------|
| `Image` | `ezimage`     |

A **variation service** handles the conversion of the original image into different formats and sizes through a set of preconfigured named variations: large, small, medium, black and white thumbnail, etc.

## PHP API Field Type

### Value object

The `value` property of an Image Field returns an `Ibexa\Core\FieldType\Image\Value` object with the following properties:

##### Properties

|Property|Type|Example|Description|
|------|------|------|------|
|`id`|string|`0/8/4/1/1480-1-eng-GB/image.png`|The image's unique identifier. Usually the path, or a part of the path. To get the full path, use the `uri` property.|
|`alternativeText`|string|`Picture of an apple.`|The alternative text, as entered in the Field's properties. This property is optional. It is recommended that you require the alternative text for an image when you add the Image Field to a Content Type, by selecting the "Alternative text is required" checkbox.|
|`fileName`|string|`image.png`|The original image's filename, without the path.|
|`fileSize`|int|`37931`|The original image's size, in bytes.|
|`uri`|string|`var/ezdemo_site/storage/images/0/8/4/1/1480-1-eng-GB/image.png`|The original image's URI.|
|`imageId`|string|`240-1480`|A special image ID, used by REST.|
|`inputUri`|string|`var/storage/images/test/199-2-eng-GB/image.png`|Input image file URI.|
|`width`*|int|`null`|Original image width in pixels. For more details see Caution note below.|
|`height`*|int|`null`|Original image height in pixels. For more details see Caution note below.|

!!! caution

    Properties marked with an asterisk are currently unsupported. They are available but their value is always `null`.

    Follow [EZP-27987](https://jira.ez.no/browse/EZP-27987) for future progress on this issue.

### Settings

This Field Type does not support settings.

### Image Variations

Using the variation Service, variations of the original image can be obtained. They are `Ibexa\Contracts\Core\Variation\Values\ImageVariation` objects with the following properties:

| Property       | Type     | Example  | Description|
|----------------|----------|----------|------------|
| `width`*       | int      | `null`    | The variation's width in pixels. For more details see Caution note below.|
| `height`*      | int      | `null`    | The variation's height in pixels. For more details see Caution note below.|
| `name`         | string   | `medium` | The variation's identifier, name of the image alias.|
| `info`         | mixed    |n/a| Extra information about the image, depending on the image type, such as EXIF data. If there is no information, the `info` value will be `null`.|
| `fileSize`     | int      |`31010` |Size (in byte) of current variation.|
| `mimeType`     | string   |`image/png`|The MIME type.|
| `fileName`     | string   |`my_image.png`|The name of the file.|
| `dirPath`      | string   |`var/storage/images/test/199-2-eng-GB`|The path to the file.|
| `uri`          | string   |`var/storage/images/test/199-2-eng-GB/apple.png`| The variation's URI. Complete path with a name of image file.|
| `lastModified` | DateTime |``"2017-08-282 12:20 Europe/Berlin"``| When the variation was last modified.|

!!! caution

    Properties marked with an asterisk are currently unsupported. They are available but their value is always `null`.

    Follow [EZP-27987](https://jira.ez.no/browse/EZP-27987) for future progress on this issue.

### Field Definition options

The Image Field Type supports one `FieldDefinition` option: the maximum size for the file.

!!!note

    Maximum size is rounded to 1 MB (legacy storage limitation).

!!! note

    As the default value for maximum size is set to 10MB, we recommend setting the `upload_max_filesize` key in the `php.ini` configuration file to a value equal to or higher than that. It will prevent validation errors while editing Content Types.

## Using an Image Field

To read more about handling images and image variations, see the [Images documentation](images.md).

### Template Rendering

When displayed using `ibexa_render_field`, an Image Field will output this type of HTML:

``` html+twig
<img src="var/ezdemo_site/storage/images/0/8/4/1/1480-1-eng-GB/image_medium.png" width="844" height="430" alt="Alternative text" />
```

The template called by the [`ibexa_render_field()` Twig function](field_twig_functions.md#ibexa_render_field) while rendering a Image Field accepts the following parameters:

| Parameter | Type     | Default        | Description |
|-----------|----------|----------------|-------------|
| `alias`   | `string` | `"original"` | The image variation name, must be defined in your SiteAccess's `image_variations` settings. Defaults to "original", the originally uploaded image.|
| `width`   | `int`    |   n/a        | Optionally to specify a different width set on the image HTML tag then then one from image alias. |
| `height`  | `int`    |   n/a        | Optionally to specify a different height set on the image HTML tag then then one from image alias. |
| `class`   | `string` |   n/a        | Optionally to specify a specific html class for use in custom JavaScript and/or CSS. |

Example: 

``` html+twig
{{ ibexa_render_field( content, 'image', { 'parameters':{ 'alias': 'imagelarge', 'width': 400, 'height': 400 } } ) }}
```

The raw Field can also be used if needed. Image variations for the Field's content can be obtained using the `ibexa_image_alias` Twig helper:

``` html+twig
{% set imageAlias = ibexa_image_alias( field, versionInfo, 'medium' ) %}
```

The variation's properties can be used to generate the required output:

``` html+twig
<img src="{{ asset( imageAlias.uri ) }}" width="{{ imageAlias.width }}" height="{{ imageAlias.height }}" alt="{{ field.value.alternativeText }}" />
```

### With the REST API

Image Fields within REST are exposed by the `application/vnd.ibexa.api.Content` media-type. An Image Field will look like this:

``` xml
<field>
    <id>1480</id>
    <fieldDefinitionIdentifier>image</fieldDefinitionIdentifier>
    <languageCode>eng-GB</languageCode>
    <fieldValue>
        <value key="inputUri">/var/ezdemo_site/storage/images/0/8/4/1/1480-1-eng-GB/kidding.png</value>
        <value key="alternativeText"></value>
        <value key="fileName">kidding.png</value>
        <value key="fileSize">37931</value>
        <value key="imageId">240-1480</value>
        <value key="uri">/var/ezdemo_site/storage/images/0/8/4/1/1480-1-eng-GB/kidding.png</value>
        <value key="variations">
            <value key="articleimage">
                <value key="href">/api/ibexa/v2/content/binary/images/240-1480/variations/articleimage</value>
            </value>
            <value key="articlethumbnail">
                <value key="href">/api/ibexa/v2/content/binary/images/240-1480/variations/articlethumbnail</value>
            </value>
        </value>
    </fieldValue>
</field>
```

Children of the `fieldValue` node will list the general properties of the Field's original image (`fileSize`, `fileName`, `inputUri`, etc.), as well as variations. For each variation, a URI is provided. Requested through REST, this resource will generate the variation if it doesn't exist yet, and list the variation details:

``` xml
<ContentImageVariation media-type="application/vnd.ibexa.api.ContentImageVariation+xml" href="/api/ibexa/v2/content/binary/images/240-1480/variations/tiny">
  <uri>/var/ezdemo_site/storage/images/0/8/4/1/1480-1-eng-GB/kidding_tiny.png</uri>
  <contentType>image/png</contentType>
  <width>30</width>
  <height>30</height>
  <fileSize>1361</fileSize>
</ContentImageVariation>
```

### From PHP code

#### Getting an image variation

The variation service, `ibexa.field_type.ezimage.variation_service`, can be used to generate/get variations for a Field. It expects a VersionInfo, the Image Field, and the variation name as a string (`large`, `medium`, etc.):

``` php
$variation = $imageVariationHandler->getVariation(
    $imageField, $versionInfo, 'large'
);

echo $variation->uri;
```

## Manipulating image content

### From PHP

As for any Field Type, there are several ways to input content to a Field. For an Image, the quickest is to call `setField()` on the ContentStruct:

``` php
$createStruct = $contentService->newContentCreateStruct(
    $contentTypeService->loadContentType( 'image' ),
    'eng-GB'
);

$createStruct->setField( 'image', '/tmp/image.png' );
```

In order to customize the Image's alternative texts, you must first get an `Image\Value` object, and set this property. For that, you can use the `Image\Value::fromString()` method that accepts the path to a local file:

``` php
$createStruct = $contentService->newContentCreateStruct(
    $contentTypeService->loadContentType( 'image' ),
    'eng-GB'
);

$imageField = \Ibexa\Core\FieldType\Image\Value::fromString( '/tmp/image.png' );
$imageField->alternativeText = 'My alternative text';
$createStruct->setField( 'image', $imageField );
```

You can also provide a hash of `Image\Value` properties, either to `setField()`, or to the constructor:

``` php
$imageValue = new \Ibexa\Core\FieldType\Image\Value(
    [
        'id' => '/tmp/image.png',
        'fileSize' => 37931,
        'fileName' => 'image.png',
        'alternativeText' => 'My alternative text'
    ]
);

$createStruct->setField( 'image', $imageValue );
```

### From REST

The REST API expects Field values to be provided in a hash-like structure. Those keys are identical to those expected by the `Image\Value` constructor: `fileName`, `alternativeText`. In addition, image data can be provided using the `data` property, with the image's content encoded as base64.

#### Creating an Image Field

```
<?xml version="1.0" encoding="UTF-8"?>
<ContentCreate>
    <!-- [...metadata...] -->

    <fields>
        <field>
            <id>247</id>
            <fieldDefinitionIdentifier>image</fieldDefinitionIdentifier>
            <languageCode>eng-GB</languageCode>
            <fieldValue>
                <value key="fileName">rest-rocks.jpg</value>
                <value key="alternativeText">HTTP</value>
                <value key="data"><![CDATA[/9j/4AAQSkZJRgABAQEAZABkAAD/2wBDAAIBAQIBAQICAgICAgICAwUDAwMDAwYEBAMFBwYHBwcG
                    BwcICQsJCAgKCAcHCg0KCgsMDAwMBwkODw0MDgsMDAz/2[...]</value>
            </fieldValue>
        </field>
    </fields>
</ContentCreate>
```

### Updating an Image Field

Updating an Image Field requires that you re-send existing data. This can be done by re-using the Field obtained via REST, **removing the variations key**, and updating `alternativeText`, `fileName` or `data`. If you do not want to change the image itself, do not provide the `data` key.

``` xml
<?xml version="1.0" encoding="UTF-8"?>
<VersionUpdate>
    <fields>
        <field>
            <id>247</id>
            <fieldDefinitionIdentifier>image</fieldDefinitionIdentifier>
            <languageCode>eng-GB</languageCode>
            <fieldValue>
                <value key="id">media/images/507-1-eng-GB/Existing-image.png</value>
                <value key="alternativeText">Updated alternative text</value>
                <value key="fileName">Updated-filename.png</value>
            </fieldValue>
        </field>
    </fields>
</VersionUpdate>
```

## Naming

Each storage engine determines how image files are named.

### Legacy Storage Engine naming

Images are stored within the following directory structure:

`<varDir>/<StorageDir>/<ImagesStorageDir>/<FieldId[-1]>/<FieldId[-2]>/<FieldId[-3]>/<FieldId[-4]>/<FieldId>-<VersionNumber>-<LanguageCode>/`

With the following values:

- `VarDir` = `var` (default)
- `StorageDir` = `storage` (default)
- `ImagesStorageDir` = `images` (default)
- `FieldId` = `1480`
- `VersionNumber` = `1`
- `LanguageCode` = `eng-GB`

Images will be stored in `web/var/ezdemo_site/storage/images/0/8/4/1/1480-1-eng-GB`.

Using the Field ID digits in reverse order as the folder structure maximizes sharding of files through multiple folders on the filesystem.

Within this folder, images will be named like the uploaded file, suffixed with an underscore and the variation name:

- `MyImage.png`
- `MyImage_large.png`
- `MyImage_rss.png`
