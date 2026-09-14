# Image field type

The Image field type allows you to store an image file.

| Name    | Internal name |
|---------|---------------|
| `Image` | `ibexa_image` |

A **variation service** handles the conversion of the original image into different formats and sizes through a set of preconfigured named variations, for example, large, small, medium, or black and white thumbnail.

## Field value

The field value is an object with the following keys, or `null` when the field is empty:

| Key               | Type      | Description                                                                                     | Example                                       |
|-------------------|-----------|-------------------------------------------------------------------------------------------------|-----------------------------------------------|
| `id`              | `string`  | The image's unique identifier. Usually the path, or a part of the path.                          | `0/8/4/1/1480-1-eng-GB/image.png`             |
| `alternativeText` | `string`  | The alternative text, as entered in the field's properties. Optional unless the `AlternativeTextValidator` requires it. | `Picture of an apple.`                        |
| `fileName`        | `string`  | The original image's filename, without the path.                                                 | `image.png`                                   |
| `fileSize`        | `integer` | The original image's size, in bytes.                                                             | `37931`                                       |
| `mime`            | `string`  | The image's MIME type.                                                                        | `image/png`                                   |
| `uri`             | `string`  | The original image's URI.                                                                        | `/var/site/storage/images/0/8/4/1/1480-1-eng-GB/image.png` |
| `imageId`         | `string`  | Image ID used to address image variations.                                                       | `240-1480`                                    |
| `inputUri`        | `string`  | Input image file URI.                                                                            | `var/site/storage/images/0/8/4/1/1480-1-eng-GB/image.png` |
| `path`            | `string`  | Same value as `inputUri`, with a leading slash.                                                  | `/var/site/storage/images/0/8/4/1/1480-1-eng-GB/image.png` |
| `width`           | `integer` | Original image width in pixels.                                                                  | `960`                                         |
| `height`          | `integer` | Original image height in pixels.                                                                 | `540`                                         |
| `additionalData`  | `object`  | Extra information about the image, if available.                                                 | `{}`                                          |
| `variations`      | `object`  | Available image variations, keyed by variation identifier. Read-only, added by the API on output only. | See below.                                    |

``` json
{
    "id": 1480,
    "fieldDefinitionIdentifier": "image",
    "languageCode": "eng-GB",
    "fieldValue": {
        "id": "0/8/4/1/1480-1-eng-GB/image.png",
        "alternativeText": "Picture of an apple.",
        "fileName": "image.png",
        "fileSize": 37931,
        "imageId": "240-1480",
        "uri": "/var/site/storage/images/0/8/4/1/1480-1-eng-GB/image.png",
        "inputUri": "var/site/storage/images/0/8/4/1/1480-1-eng-GB/image.png",
        "width": 960,
        "height": 540,
        "variations": {
            "articleimage": {
                "href": "/api/ibexa/v2/content/binary/images/240-1480/variations/articleimage"
            },
            "articlethumbnail": {
                "href": "/api/ibexa/v2/content/binary/images/240-1480/variations/articlethumbnail"
            }
        }
    }
}
```

## Image variations

For each variation, the field value provides a URI.
Requesting that resource generates the variation if it doesn't exist yet, and returns the variation details as a `ContentImageVariation`:

``` json
{
    "ContentImageVariation": {
        "_media-type": "application/vnd.ibexa.api.ContentImageVariation+json",
        "_href": "/api/ibexa/v2/content/binary/images/240-1480/variations/tiny",
        "uri": "/var/site/storage/images/0/8/4/1/1480-1-eng-GB/image_tiny.png",
        "contentType": "image/png",
        "width": 30,
        "height": 30,
        "fileSize": 1361
    }
}
```

## Creating and updating an Image field

To send image contents, provide them as a base64-encoded string under the `data` key, together with `fileName`:

``` json
{
    "fieldDefinitionIdentifier": "image",
    "languageCode": "eng-GB",
    "fieldValue": {
        "fileName": "rest-rocks.jpg",
        "alternativeText": "HTTP",
        "data": "/9j/4AAQSkZJRgABAQEAZABkAAD/2wBDAAIBAQIBAQICAgICAgICAwUDAwMDAwYEBAMFBwYHBwcG..."
    }
}
```

Updating an Image field requires that you re-send the existing data.
You can do this by reusing the field value you read from the API, **removing the `variations` key**, and updating `alternativeText`, `fileName`, or `data`.
If you don't want to change the image itself, don't provide the `data` key.

``` json
{
    "fieldDefinitionIdentifier": "image",
    "languageCode": "eng-GB",
    "fieldValue": {
        "id": "media/images/507-1-eng-GB/Existing-image.png",
        "alternativeText": "Updated alternative text",
        "fileName": "Updated-filename.png"
    }
}
```

## Validation

The field type supports the following validators:

| Name                                    | Type      | Default value | Description                                        |
|-----------------------------------------|-----------|---------------|------------------------------------------------------|
| `FileSizeValidator[maxFileSize]`        | `numeric` | `null`        | Maximum size of the image file in bytes.           |
| `AlternativeTextValidator[required]`    | `boolean` | `false`       | When `true`, the `alternativeText` key is required. |

``` json
{
    "validatorConfiguration": {
        "FileSizeValidator": {
            "maxFileSize": 10485760
        },
        "AlternativeTextValidator": {
            "required": true
        }
    }
}
```

## Settings

| Name        | Type    | Default value | Description                                                                       |
|-------------|---------|---------------|-------------------------------------------------------------------------------------|
| `mimeTypes` | `array` | `[]`          | MIME types accepted by the field. When empty, all image MIME types are accepted. |

``` json
{
    "fieldSettings": {
        "mimeTypes": ["image/jpeg", "image/png"]
    }
}
```

## Using an Image field

To read more about handling images, see the [Images documentation](images.md).
