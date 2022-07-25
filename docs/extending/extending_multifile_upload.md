---
description: Configure multi-file upload functionality which allows uploading files in bulk.
---

# Multi-file upload

You can use the multi-file upload module in the editorial interface of [[= product_name =]].
It provides an interface to publish content based on dropped files while uploading them in the interface.

!!! caution

    If you want to load the multi-file upload module, you need to load the JS code for it in your view,
    as it is not available by default.

## Use multi-file upload

With JS only:

``` js
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

``` jsx
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

The `<MultiFileUpload />` module can handle additional properties.
There are two types of properties: **required** and **optional**.

### Required properties

All of the following properties must be used, otherwise the multi-file upload does not work.

- **onAfterUpload** _{Function}_ - a callback to be invoked immediately after a file has been uploaded
- **adminUiConfig** _{Object}_ - UI config object. It should keep the following structure:
    - **multiFileUpload** _{Object}_  - multi file upload module config:
        - **defaultMappings** _{Array}_ - a list of file type to Content Type mappings
        Sample mapping be an object and should follow the convention:
            - **contentTypeIdentifier** _{String}_ - Content Type identifier
            - **contentFieldIdentifier** _{String}_ - Field identifier
            - **nameFieldIdentifier** _{String}_ - name Field identifier
            - **mimeTypes** _{Array}_ - a list of file types assigned to a specific Content Type
        - **fallbackContentType** _{Object}_ - a fallback Content Type definition. Should contain the following info:
            - **contentTypeIdentifier** _{String}_ - Content Type identifier
            - **contentFieldIdentifier** _{String}_ - Field identifier
            - **nameFieldIdentifier** _{String}_ - name Field identifier
        - **locationMappings** _{Array}_ - list of file type to Content Type mappings based on a Location identifier
        - **maxFileSize** {Number} - maximum file size allowed for uploading. It's a number of bytes
    - **token** _{String}_ - CSRF token
    - **siteaccess** _{String}_ - SiteAccess identifier
- **parentInfo** _{Object}_ - parent Location meta information:
    - **contentTypeIdentifier** _{String}_ - Content Type identifier
    - **contentTypeId** _{Number}_ - Content Type ID
    - **locationPath** _{String}_ - Location path string
    - **language** _{String}_ - language code identifier

### Optional properties

Optionally, the multi-file upload module can take a following list of properties:

- **checkCanUpload** _{Function}_ - checks whether am uploaded file can be uploaded. The callback takes four params:
    - **file** _{File}_ - file object
    - **parentInfo** _{Object}_ - parent Location meta information
    - **config** _{Object}_ - Multi-file Upload module config
    - **callbacks** _{Object}_ - error callbacks list: **fileTypeNotAllowedCallback** and **fileSizeNotAllowedCallback**
- **createFileStruct** _{Function}_ - a function that creates a _ContentCreate_ struct. The function takes two params:
    - **file** _{File}_ - file object
    - **params** _{Object}_ - params hash containing: **parentInfo** and **adminUiConfig** stored under the **config** key
- **deleteFile** _{Function}_ - a function deleting content created from a given file. It takes three params:
    - **systemInfo** _{Object}_ - hash containing information about CSRF token and SiteAccess: **token** and **siteaccess**
    - **struct** _{Object}_ - Content struct
    - **callback** _{Function}_ - content deleted callback
- **onPopupClose** _{Function}_ - function invoked when closing a Multi-file Upload popup. It takes one param: **itemsUploaded** - the list of uploaded items
- **publishFile** _{Function}_ - publishes an uploaded file-based Content item. Takes three params:
    - **data** _{Object}_ - an object containing information about:
        - **struct** _{Object}_ - the ContentCreate struct ()
        - **token** _{String}_ - CSRF token
        - **siteaccess** _{String}_ - SiteAccess identifier
    - **requestEventHandlers** _{Object}_ - a list of upload event handlers:
        - **onloadstart** _{Function}_ - on load start callback
        - **upload** _{Object}_ - file upload events:
            - **onabort** _{Function}_ - on abort callback
            - **onload** _{Function}_ - on load callback
            - **onprogress** _{Function}_ - on progress callback
            - **ontimeout** _{Function}_ - on timeout callback
    - **callback** _{Function}_ - a callback invoked when an uploaded file-based content has been published
