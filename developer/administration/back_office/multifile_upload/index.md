# Multi-file upload

Configure multi-file upload functionality which allows uploading files in bulk.

You can use the multi-file upload module in the editorial interface of Ibexa DXP. It provides an interface to publish content based on dropped files while uploading them in the interface.

> **Caution: Caution**
>
> If you want to load the multi-file upload module, you need to load the JS code for it in your view, as it's not available by default.

## Use multi-file upload

With JS only:

```js
React.createElement(ibexa.modules.MultiFileUpload, {
    onAfterUpload: {Function},
    adminUiConfig: {
        multiFileUpload: {
            defaultMappings: [{
                contentTypeIdentifier: {String},
                contentFieldIdentifier: {String},
                contentNameIdentifier: {String},
                mimeTypes: [{String}, {String}, ...]
            }],
            fallbackContentType: {
                contentTypeIdentifier: {String},
                contentFieldIdentifier: {String},
                contentNameIdentifier: {String}
            },
            locationMappings: [{Object}],
            maxFileSize: {Number}
        },
        token: {String},
        siteaccess: {String}
    },
    parentInfo: {
        contentTypeIdentifier: {String},
        contentTypeId: {Number},
        locationPath: {String},
        language: {String}
    }
});
```

With JSX:

```jsx
const attrs = {
    onAfterUpload: {Function},
    adminUiConfig: {
        multiFileUpload: {
            defaultMappings: [{
                contentTypeIdentifier: {String},
                contentFieldIdentifier: {String},
                contentNameIdentifier: {String},
                mimeTypes: [{String}, {String}, ...]
            }],
            fallbackContentType: {
                contentTypeIdentifier: {String},
                contentFieldIdentifier: {String},
                contentNameIdentifier: {String}
            },
            locationMappings: [{Object}],
            maxFileSize: {Number}
        },
        token: {String},
        siteaccess: {String}
    },
    parentInfo: {
        contentTypeIdentifier: {String},
        contentTypeId: {Number},
        locationPath: {String},
        language: {String}
    }
};

<MultiFileUploadModule {...attrs}/>
```

## Properties list

The `<MultiFileUpload />` module can handle additional properties. There are two types of properties: **required** and **optional**.

### Required properties

All of the following properties must be used, otherwise the multi-file upload doesn't work.

- **onAfterUpload** *{Function}* - a callback to be invoked immediately after a file has been uploaded
- **adminUiConfig** *{Object}* - UI config object. It should keep the following structure:
  - **multiFileUpload** *{Object}* - multi file upload module config:
    - **defaultMappings** *{Array}* - a list of file type to content type mappings Sample mapping be an object and should follow the convention:
      - **contentTypeIdentifier** *{String}* - content type identifier
      - **contentFieldIdentifier** *{String}* - field identifier
      - **nameFieldIdentifier** *{String}* - name field identifier
      - **mimeTypes** *{Array}* - a list of file types assigned to a specific content type
    - **fallbackContentType** *{Object}* - a fallback content type definition. Should contain the following info:
      - **contentTypeIdentifier** *{String}* - content type identifier
      - **contentFieldIdentifier** *{String}* - field identifier
      - **nameFieldIdentifier** *{String}* - name field identifier
    - **locationMappings** *{Array}* - list of file type to content type mappings based on a location identifier
    - **maxFileSize** {Number} - maximum file size allowed for uploading. It's a number of bytes
  - **token** *{String}* - CSRF token
  - **siteaccess** *{String}* - SiteAccess identifier
- **parentInfo** *{Object}* - parent location meta information:
  - **contentTypeIdentifier** *{String}* - content type identifier
  - **contentTypeId** *{Number}* - content type ID
  - **locationPath** *{String}* - location path string
  - **language** *{String}* - language code identifier

### Optional properties

Optionally, the multi-file upload module can take a following list of properties:

- **checkCanUpload** *{Function}* - checks whether am uploaded file can be uploaded. The callback takes four params:
  - **file** *{File}* - file object
  - **parentInfo** *{Object}* - parent location meta information
  - **config** *{Object}* - Multi-file Upload module config
  - **callbacks** *{Object}* - error callbacks list: **fileTypeNotAllowedCallback** and **fileSizeNotAllowedCallback**
- **createFileStruct** *{Function}* - a function that creates a *ContentCreate* struct. The function takes two params:
  - **file** *{File}* - file object
  - **params** *{Object}* - params hash containing: **parentInfo** and **adminUiConfig** stored under the **config** key
- **deleteFile** *{Function}* - a function deleting content created from a given file. It takes three params:
  - **systemInfo** *{Object}* - hash containing information about CSRF token and SiteAccess: **token** and **siteaccess**
  - **struct** *{Object}* - content struct
  - **callback** *{Function}* - content deleted callback
- **onPopupClose** *{Function}* - function invoked when closing a Multi-file Upload popup. It takes one param: **itemsUploaded** - the list of uploaded items
- **publishFile** *{Function}* - publishes an uploaded file-based content item. Takes three params:
  - **data** *{Object}* - an object containing information about:
    - **struct** *{Object}* - the ContentCreate struct ()
    - **token** *{String}* - CSRF token
    - **siteaccess** *{String}* - SiteAccess identifier
  - **requestEventHandlers** *{Object}* - a list of upload event handlers:
    - **onloadstart** *{Function}* - on load start callback
    - **upload** *{Object}* - file upload events:
      - **onabort** *{Function}* - on abort callback
      - **onload** *{Function}* - on load callback
      - **onprogress** *{Function}* - on progress callback
      - **ontimeout** *{Function}* - on timeout callback
  - **callback** *{Function}* - a callback invoked when an uploaded file-based content has been published
