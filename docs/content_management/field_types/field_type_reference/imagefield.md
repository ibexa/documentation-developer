# Image field type

The Image field type allows you to store an image file.

| Name    | Internal name |
|---------|---------------|
| `Image` | `ibexa_image` |

A **variation service** handles the conversion of the original image into different formats and sizes through a set of preconfigured named variations, for example, large, small, medium, or black and white thumbnail.

## PHP API field type

### Value object

The `value` property of an Image field returns an `Ibexa\Core\FieldType\Image\Value` object with the following properties:

#### Properties

| Property          | Type   | Example                                                          | Description                                                                                                                                                                                                                                                          |
|-------------------|--------|------------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `id`              | string | `0/8/4/1/1480-1-eng-GB/image.png`                                | The image's unique identifier. Usually the path, or a part of the path. To get the full path, use the `uri` property.                                                                                                                                                |
| `alternativeText` | string | `Picture of an apple.`                                           | The alternative text, as entered in the field's properties. This property is optional. It's recommended that you require the alternative text for an image when you add the Image field to a content type, by selecting the "Alternative text is required" checkbox. |
| `fileName`        | string | `image.png`                                                      | The original image's filename, without the path.                                                                                                                                                                                                                     |
| `fileSize`        | int    | `37931`                                                          | The original image's size, in bytes.                                                                                                                                                                                                                                 |
| `uri`             | string | `var/ezdemo_site/storage/images/0/8/4/1/1480-1-eng-GB/image.png` | The original image's URI.                                                                                                                                                                                                                                            |
| `imageId`         | string | `240-1480`                                                       | A special image ID, used by REST.                                                                                                                                                                                                                                    |
| `inputUri`        | string | `var/storage/images/test/199-2-eng-GB/image.png`                 | Input image file URI.                                                                                                                                                                                                                                                |
| `width`           | int    | `960`                                                            | Original image width in pixels.                                                                                                                                                                                             |
| `height`          | int    | `540`                                                            | Original image height in pixels.                                                                                                                                                                                            |

### Settings

This field type doesn't support settings.

### Image variations

Using the variation Service, variations of the original image can be obtained.
They're `Ibexa\Contracts\Core\Variation\Values\ImageVariation` objects with the following properties:

| Property       | Type     | Example                                          | Description                                                                                                                                |
|----------------|----------|--------------------------------------------------|--------------------------------------------------------------------------------------------------------------------------------------------|
| `width`        | int      | `200`                                            | The variation's width in pixels.                                                                                                           |
| `height`       | int      | `112`                                            | The variation's height in pixels.                                                                                                          |
| `name`         | string   | `medium`                                         | The variation's identifier, name of the image variation.                                                                                   |
| `info`         | mixed    | n/a                                              | Extra information about the image, depending on the image type, such as EXIF data. If there is no information, the `info` value is `null`. |
| `fileSize`     | int      | `31010`                                          | Size (in byte) of current variation.                                                                                                       |
| `mimeType`     | string   | `image/png`                                      | The MIME type.                                                                                                                             |
| `fileName`     | string   | `my_image.png`                                   | The name of the file.                                                                                                                      |
| `dirPath`      | string   | `var/storage/images/test/199-2-eng-GB`           | The path to the file.                                                                                                                      |
| `uri`          | string   | `var/storage/images/test/199-2-eng-GB/apple.png` | The variation's URI. Complete path with a name of image file.                                                                              |
| `lastModified` | DateTime | ``"2017-08-282 12:20 Europe/Berlin"``            | When the variation was last modified.                                                                                                      |

### Field Definition options

The Image field type supports one `FieldDefinition` option: the maximum size for the file.

!!! note

    Maximum size is 10MB.
    We recommend setting the `upload_max_filesize` key in the `php.ini` configuration file to a value equal to or higher than that.
    It prevents validation errors while editing content types.

## Using an Image field

To read more about handling images and image variations, see the [Images documentation](images.md).

### With the REST API

Image Fields within REST are exposed by the `application/vnd.ibexa.api.Content` media-type.
An Image field looks like this:

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

Children of the `fieldValue` node list the general properties of the field's original image (for example, `fileSize`, `fileName`, or `inputUri`), and its variations.
For each variation, a URI is provided.
Requested through REST, this resource generates the variation if it doesn't exist yet, and list the variation details:

``` xml
<ContentImageVariation media-type="application/vnd.ibexa.api.ContentImageVariation+xml" href="/api/ibexa/v2/content/binary/images/240-1480/variations/tiny">
  <uri>/var/ezdemo_site/storage/images/0/8/4/1/1480-1-eng-GB/kidding_tiny.png</uri>
  <contentType>image/png</contentType>
  <width>30</width>
  <height>30</height>
  <fileSize>1361</fileSize>
</ContentImageVariation>
```

### From REST

The REST API expects field values to be provided in a hash-like structure.
Those keys are identical to those expected by the `Image\Value` constructor: `fileName`, `alternativeText`.
In addition, image data can be provided using the `data` property, with the image's content encoded as base64.

#### Creating an Image field

```xml
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

### Updating an Image field

Updating an Image field requires that you re-send existing data.
This can be done by re-using the field obtained via REST, **removing the variations key**, and updating `alternativeText`, `fileName` or `data`.
If you don't want to change the image itself, don't provide the `data` key.

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

