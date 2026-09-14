# BinaryFile field type

This field type represents and handles a single binary file. It also counts the number of times the file has been downloaded.

It's capable of handling virtually any file type and is typically used for storing document types, for example, PDF files, Word documents, or spreadsheets.
The maximum allowed file size is determined by the `FileSizeValidator` configuration of the field definition.

| Name         | Internal name      |
|--------------|--------------------|
| `BinaryFile` | `ibexa_binaryfile` |

## Field value

The field value is an object with the following keys, or `null` when the field is empty:

| Key             | Type      | Description                                                                             | Example                           |
|-----------------|-----------|-----------------------------------------------------------------------------------------|-----------------------------------|
| `id`            | `string`  | Binary file identifier.                                                                  | `application/63cd472dd7.pdf`      |
| `fileName`      | `string`  | The human-readable file name, as exposed to the outside. Used when sending the file for download to name the file. | `20130116_whitepaper.pdf`         |
| `fileSize`      | `integer` | File size, in bytes.                                                                     | `1077923`                         |
| `mimeType`      | `string`  | The file's MIME type.                                                                    | `application/pdf`                 |
| `uri`           | `string`  | Download URL of the file, prefixed with the same host as the REST request. See [Binary and Media download](binary_and_media_download.md). | `https://example.com/content/download/210/file/20130116_whitepaper.pdf` |
| `url`           | `string`  | Same value as `uri`. Kept for backward compatibility, use `uri` instead.                 | See `uri`.                        |
| `downloadCount` | `integer` | Number of times the file was downloaded.                                                 | `0`                               |
| `inputUri`      | `string`  | Internal storage path of the file. Read-only on output.                                  | `var/site/storage/original/application/63cd472dd7.pdf` |
| `path`          | `string`  | Same value as `inputUri`. Kept for backward compatibility.                               | See `inputUri`.                   |

``` json
{
    "fieldDefinitionIdentifier": "file",
    "languageCode": "eng-GB",
    "fieldValue": {
        "id": "application/63cd472dd7.pdf",
        "fileName": "20130116_whitepaper.pdf",
        "fileSize": 1077923,
        "mimeType": "application/pdf",
        "uri": "https://example.com/content/download/210/file/20130116_whitepaper.pdf",
        "downloadCount": 0
    }
}
```

### Uploading a file

To send file contents, provide them as a base64-encoded string under the `data` key, together with `fileName`:

``` json
{
    "fieldDefinitionIdentifier": "file",
    "languageCode": "eng-GB",
    "fieldValue": {
        "fileName": "My file.pdf",
        "fileSize": 17589,
        "data": "JVBERi0xLjQKJcOkw7zDtsOfCjIgMCBvYmoKPDwvTGVuZ3RoIDMgMCBS..."
    }
}
```

To keep the existing file while updating other keys, send the field value without the `data` key.

## Validation

The field type supports `FileSizeValidator`, defining the maximum size of the file in bytes:

| Name          | Type      | Default value | Description                          |
|---------------|-----------|---------------|----------------------------------------|
| `maxFileSize` | `integer` | `null`        | Maximum size of the file in bytes.   |

``` json
{
    "validatorConfiguration": {
        "FileSizeValidator": {
            "maxFileSize": 10485760
        }
    }
}
```
