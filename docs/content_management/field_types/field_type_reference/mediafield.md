# Media field type

This field type represents and handles a media (audio/video) binary file.

It's capable of handling the following types of files:

- Apple QuickTime
- Adobe Flash
- Microsoft Windows Media
- Real Media
- Silverlight
- HTML5 Video
- HTML5 Audio

| Name  | Field type identifier |
|-------|-----------------------|
| Media | `ibexa_media`         |

## Field value

The field value is an object with the following keys, or `null` when the field is empty:

| Key             | Type      | Description                                                                | Example                          |
|-----------------|-----------|----------------------------------------------------------------------------|----------------------------------|
| `id`            | `string`  | Media file identifier.                                                      | `application/63cd472dd7.mp4`     |
| `fileName`      | `string`  | The human-readable file name, as exposed to the outside. Used to name the file when sending it for download. | `butterflies.mp4`                |
| `fileSize`      | `integer` | File size, in bytes.                                                        | `1077923`                        |
| `mimeType`      | `string`  | The file's MIME type.                                                       | `video/mp4`                      |
| `uri`           | `string`  | Download URL of the media file. If it doesn't include a host or protocol, it applies to the request domain. See [Binary and Media download](binary_and_media_download.md). | `/content/download/210/media/butterflies.mp4` |
| `hasController` | `boolean` | Whether the media has a controller when being displayed.                    | `true`                           |
| `autoplay`      | `boolean` | Whether the media should be automatically played.                           | `true`                           |
| `loop`          | `boolean` | Whether the media should be played in a loop.                               | `false`                          |
| `height`        | `integer` | Height of the media.                                                        | `300`                            |
| `width`         | `integer` | Width of the media.                                                         | `400`                            |
| `inputUri`      | `string`  | Internal storage path of the file. Read-only on output.                     | `var/site/storage/original/application/63cd472dd7.mp4` |
| `path`          | `string`  | Same value as `inputUri`. Kept for backward compatibility.                  | See `inputUri`.                  |

``` json
{
    "fieldDefinitionIdentifier": "media",
    "languageCode": "eng-GB",
    "fieldValue": {
        "id": "application/63cd472dd7.mp4",
        "fileName": "butterflies.mp4",
        "fileSize": 1077923,
        "mimeType": "video/mp4",
        "uri": "/content/download/210/media/butterflies.mp4",
        "hasController": true,
        "autoplay": false,
        "loop": false,
        "width": 400,
        "height": 300
    }
}
```

### Uploading a file

To send file contents, provide them as a base64-encoded string under the `data` key, together with `fileName`:

``` json
{
    "fieldDefinitionIdentifier": "media",
    "languageCode": "eng-GB",
    "fieldValue": {
        "fileName": "butterflies.mp4",
        "data": "AAAAIGZ0eXBpc29tAAACAGlzb21pc28yYXZjMW1wNDEAAAAIZnJlZQ..."
    }
}
```

To keep the existing file while updating other keys, send the field value without the `data` key.

## Validation

The field type supports `FileSizeValidator`, defining the maximum size of the media file in bytes:

| Name          | Type      | Default value | Description                        |
|---------------|-----------|---------------|--------------------------------------|
| `maxFileSize` | `integer` | `null`        | Maximum size of the file in bytes. |

## Settings

The field type supports the `mediaType` setting, defining how the media file should be handled in output.

| Name        | Type     | Default value        | Description                              |
|-------------|----------|----------------------|--------------------------------------------|
| `mediaType` | `string` | `"TYPE_HTML5_VIDEO"` | Type of the media. See the values below. |

| Value                 | Description             |
|-----------------------|-------------------------|
| `"TYPE_FLASH"`        | Adobe Flash             |
| `"TYPE_QUICKTIME"`    | Apple QuickTime         |
| `"TYPE_REALPLAYER"`   | Real Media              |
| `"TYPE_SILVERLIGHT"`  | Silverlight             |
| `"TYPE_WINDOWSMEDIA"` | Microsoft Windows Media |
| `"TYPE_HTML5_VIDEO"`  | HTML5 Video             |
| `"TYPE_HTML5_AUDIO"`  | HTML5 Audio             |

``` json
{
    "fieldSettings": {
        "mediaType": "TYPE_HTML5_VIDEO"
    }
}
```
