# File Management

## Handling binary files

eZ Platform supports multiple binary file handling mechanisms by means of an `IOHandler` interface. This feature is used by the [BinaryFile](../api/field_type_reference.md#binaryfile-field-type), [Media](../api/field_type_reference.md#media-field-type) and [Image](../api/field_type_reference.md#image-field-type) Field Types.

### Native IO handler

The IO API is organized around two types of handlers, both used by the IOService:

- `eZ\Publish\IO\IOMetadataHandler`: Stores and reads metadata (validity, size, etc.)
- `eZ\Publish\IO\IOBinarydataHandler`: Stores and reads the actual binary data

IO handlers can be configured using semantic configuration and are configurable per SiteAccess.
This is the default configuration:

``` yaml
ezpublish:
    system:
        default:
            io:
                metadata_handler: default
                binarydata_handler: default
```

Metadata and binary data handlers are configured under `ez_io`. Below is what the configuration looks like for the default handlers. It declares a metadata handler and a binary data handler, both labeled `default`. Both handlers are of type `flysystem`, and use the same Flysystem adapter, labeled `default` as well.

``` yaml
ez_io:
    metadata_handlers:
        default:
            flysystem:
                adapter: default
    binarydata_handlers:
        default:
            flysystem:
                adapter: default
```

The 'default' Flysystem adapter's directory is based on your site settings, and will automatically be set to `%ezpublish_legacy.root_dir%/$var_dir$/$storage_dir$` (for example: `/path/to/ezpublish_legacy/var/ezdemo_site/storage`).

#### Configure the permissions of generated files

``` yaml
ezpublish:
    system:
        default:
            io:
                permissions:
                    files: 0750 #default is 0644
                    directories: 0640 #default is 0755
```

Both `files` and `directories` rules are optional.

Default values are 0644 for files and 0755 for directories.

!!! note

    Make sure to configure permissions using a number and *not* a string. If you write "0644" it will *not* be interpreted by PHP as an octal number, and unexpected permissions will be applied.

### The native Flysystem handler

[league/flysystem](http://flysystem.thephpleague.com/) (along with [FlysystemBundle](https://github.com/1up-lab/OneupFlysystemBundle/)) is an abstract file handling library.

eZ Platform uses it as the default way to read and write content in form of binary files. Flysystem can use the `local` filesystem (this is the default and officially supported configuration), but is also able to read/write to `sftp`, `zip` or cloud filesystems (`azure`, `rackspace`, `S3`).

#### Handler options

##### Adapter

The adapter is the "driver" used by Flysystem to read/write files. Adapters can be declared using `oneup_flysystem` as follows:

``` yaml
oneup_flysystem:
    adapters:
        default:
            local:
                directory: /path/to/directory
```

The way to configure other adapters can be found in the [bundle's online documentation](https://github.com/1up-lab/OneupFlysystemBundle/blob/master/Resources/doc/index.md#step3-configure-your-filesystems). Note that we do not use the filesystem configuration described in this documentation, only the adapters.

### The DFS Cluster handler

For clustering use we provide a custom metadata handler that stores metadata about your assets in the database. This is done as it is faster than accessing the remote NFS or S3 instance in order to read metadata. For further reading on setting this up, see [Clustering](clustering.md).

## Binary and Media download

Unlike image files, files stored in BinaryFile or Media Fields may be restricted to certain User Roles. As such, they are not publicly downloadable from disk, and are instead served by Symfony, using a custom route that runs the necessary checks. This route is automatically generated as the `url` property for those Field values.

### The `content/download` route

The route follows this pattern: `/content/download/{contentId}/{fieldIdentifier}/{filename}`. For example: `/content/download/68/file/My-file.pdf.`

It also accepts optional query parameters:

- `version`: the version number that the file must be downloaded for. Requires the `versionread` permission. If not specified, the published version is used.
- `inLanguage`: The language the file should be downloaded in. If not specified, the most prioritized language for the SiteAccess will be used.

The [ez\_render\_field](twig_functions_reference.md#ez_render_field) Twig helper will by default generate a working link.

### REST API: `uri` property

The `uri` property of Binary Fields in REST contains a valid download URL, of the same format as the Public API, prefixed with the same host as the REST Request.

For [more information about REST API see the documentation](../api/rest_api_guide).

## URL handling

### IO URL decoration

By default, images and binary files referenced by content will be served from the same server as the application, for example `/var/ezdemo_site/storage/images/3/6/4/6/6463-1-eng-GB/kidding.png`. This is the default semantic configuration:

``` yaml
ezpublish:
    system:
        default:
            io:
                url_prefix: '$var_dir$/$storage_dir$'
```

`$var_dir$` and `$storage_dir$` are dynamic, [SiteAccess-aware settings](configuration.md#dynamic-settings-injection), and will be replaced by their values in the execution context.

### Using a static server for images

One common use case is to use an optimized nginx to serve images in an optimized way. The example image above could be made available as `http://static.example.com/images/3/6/4/6/6463-1-eng-GB/kidding.png` by setting up a server that uses `ezpublish/ezpublish_legacy/var/ezdemo_site/storage`. The configuration would be as follows:

``` yaml
ezpublish:
    system:
        default:
            io:
                url_prefix: 'http://static.example.com/$var_dir$/$storage_dir$'
```

### Internals

Any `BinaryFile` returned by the public API is prefixed with the value of this setting, internally stored as `ezsettings.scope.io.url_prefix`.

#### `io.url_prefix` dynamic container setting

Default value: `$var_dir$/$storage_dir$`
Example: `/var/ezdemo_site/storage`

Used to configure the default URL decorator service (`ezpublish.core.io.default_url_decorator`), used by all binary data handlers to generate the URI of loaded files. It is always interpreted as an absolute URI, meaning that unless it contains a scheme (http://, ftp://), it will be prepended with a '/'.

This setting is SiteAccess-aware.

#### Services

##### URL decorators

A UrlDecorator decorates and undecorates a given string (URL). It has two mirror methods: `decorate` and `undecorate`.

Two implementations are provided: `Prefix`, and `AbsolutePrefix`. They both add a prefix to a URL, but `AbsolutePrefix` will ensure that unless the prefix is an external URL, the result will be prepended with /.

Three UrlDecorator services are introduced:

- `ezpublish.core.io.prefix_url_decorator` used by the binary data handlers to decorate all URIs sent out by the API. Uses `AbsolutePrefix`.
- `ezpublish.core.io.image_fieldtype.legacy_url_decorator` used via the UrlRedecorator by various legacy elements (Converter, Storage Gateway, etc.) to generate its internal storage format for URIs. Uses a `Prefix`, not an `AbsolutePrefix`, meaning that no leading / is added.

In addition, a UrlRedecorator service, `ezpublish.core.io.image_fieldtype.legacy_url_redecorator`, uses both decorators above to convert URIs between what is used on the new stack, and what format legacy expects (relative urls from the ezpublish root).

## Multi-file upload

Multi-file upload is a functionality that enables you to upload multiple binary files in bulk.

### Configuration

You can configure the storage options for uploading files using semantic configuration.

When a file is uploaded using multi-file upload, it is automatically stored in a Field of a new Content item. This configuration specifies which MIME types will be uploaded as content of which Content Types, using what Field Types. For example:

``` yaml
ez_systems_multi_file_upload:
    location_mappings:
        -   # gallery
            content_type_identifier: gallery
            mime_type_filter:
                - video/*
                - image/*
            mappings:
                -   # images
                    mime_types:
                        - image/jpeg
                        - image/jpg
                        - image/pjpeg
                        # ...
                    content_type_identifier: image
                    content_field_identifier: image
                    name_field_identifier: name
                -   # videos
                    mime_types:
                        - video/avi
                        - video/mpeg
                        - video/quicktime
                        # ...
                    content_type_identifier: video
                    content_field_identifier: file
                    name_field_identifier: name
                -   # .svg files are not supported by Image content type at the moment
                    mime_types:
                        - image/svg+xml
                    content_type_identifier: file
                    content_field_identifier: file
                    name_field_identifier: name
        -   # folder
            content_type_identifier: folder
            mappings:
                -   # files
                    mime_types:
                        - application/msword
                        - application/vnd.openxmlformats-officedocument.wordprocessingml.document
                        - application/vnd.ms-excel
                        - application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
                        - application/vnd.ms-powerpoint
                        - application/vnd.openxmlformats-officedocument.presentationml.presentation
                        - application/pdf
                    content_type_identifier: file
                    content_field_identifier: file
                    name_field_identifier: name

    default_mappings:
        -   # image
            mime_types:
                - image/jpeg
                - image/jpg
                - image/pjpeg
                # ...
            content_type_identifier: image
            content_field_identifier: image
            name_field_identifier: name
        -   # file
            mime_types:
                - image/svg+xml
                - application/msword
                - application/vnd.openxmlformats-officedocument.wordprocessingml.document
                # ...
            content_type_identifier: file
            content_field_identifier: file
            name_field_identifier: name

    fallback_content_type:
        content_type_identifier: file
        content_field_identifier: file
        name_field_identifier: name

    max_file_size: 24000000
```

Using `location_mappings` you can define which Content Types will have their own settings for categorizing MIME types. You can have a different set of rules for any Content Type.

If no rule is specified for a Content Type, the `default_mappings` will be used. Unspecified MIME types are covered by the `fallback_content_type` setting.

You can also define the maximum permitted uploaded file size under `max_file_size`.

Default setting for multi-file upload are defined in [default\_settings.yml](https://github.com/ezsystems/ezplatform-ee-multi-file-upload/blob/master/bundle/Resources/config/default_settings.yml).
