# File Management

## Handling binary files

eZ Platform supports multiple binary file handling mechanisms by means of an `IOHandler` interface. This feature is used by the [BinaryFile](field_type_reference.md#binaryfield-field-type), [Media](field_type_reference.md#media-field-type) and [Image](field_type_reference.md#image-field-type) Field Types.

### Native IO handler

The IO API is organized around two types of handlers:

- `eZ\Publish\IO\IOMetadataHandler`: Stores and reads metadata (validity, size, etc.)
- `eZ\Publish\IO\IOBinarydataHandler`: Stores and reads binarydata (actual contents)

The IOService uses both of them.

IO handling can now be configured using semantic configuration. Assigning the IO handlers to ezplatform itself is configurable per siteaccess. This is the default configuration:

``` yaml
ezpublish:
    system:
        default:
            io:
                metadata_handler: default
                binarydata_handler: default
```

Metadata and binarydata handlers are configured in the `ez_io` extension. Below is what the configuration looks like for the default handlers. It declares a metadata handler and a binarydata handler, both labeled `default`. Both handlers are of type `flysystem`, and use the same flysystem adapter, labeled `default` as well.

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

The 'default' flysystem adapter's directory is based on your site settings, and will automatically be set to `%ezpublish_legacy.root_dir%/$var_dir$/$storage_dir$` (example: `/path/to/ezpublish_legacy/var/ezdemo_site/storage`).

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

Make sure to configure permissions using a number and *not* a string. If you write "0644" it will *not* be interpreted by PHP as an octal number, and unexpected permissions will be applied.

### The native Flysystem handler

[league/flysystem](https://github.com/ezsystems/ezpublish-kernel/blob/native_io_spec/doc/specifications/io/flysystem.thephpleague.com) (along with [FlysystemBundle](https://github.com/1up-lab/OneupFlysystemBundle/)) is an abstract file handling library.

eZ Platform uses it as the default way to read and write content in form of binary files. Flysystem can use the `local` filesystem *(this is the default configuration and the one that is officially supported)*, but is also able to read/write to `sftp`, `zip` or cloud filesystems *(`azure`, `rackspace`, `S3`)*.

#### Handler options

##### Adapter

The adapter is the "driver" used by flysystem to read/write files. Adapters can be declared using `oneup_flysystem` as follows:

``` yaml
oneup_flysystem:
    adapters:
        default:
            local:
                directory: "/path/to/directory"
```

The way to configure other adapters can be found in the [bundle's online documentation](https://github.com/1up-lab/OneupFlysystemBundle/blob/master/Resources/doc/index.md#step3-configure-your-filesystems). Note that we do not use the filesystem configuration described in this documentation, only the adapters.

### The DFS Cluster handler

For clustering use we provide a custom metadata handler that stores metadata about your assets in the database. This is done as it is faster than accessing the remote NFS or S3 instance in order to read metadata. For further reading on setting this up, see [Clustering](clustering.md).

## Binary and Media download

Unlike image files, files stored in BinaryFile or Media Fields may be limited to certain User Roles. As such, they are not publicly downloadable from disk, and are instead served by Symfony, using a custom route that runs the necessary checks. This route is automatically generated as the `url` property for those Fields values.

### The content/download route

The route follows this pattern: `/content/download/{contentId}/{fieldIdentifier}/{filename}`. Example: `/content/download/68/file/My-file.pdf.`

It also accepts optional query parameters:

- `version`: the version number that the file must be downloaded for. Requires the `versionread` permission. If not specified, the published version is used.
- `inLanguage`: The language the file should be downloaded in. If not specified, the most prioritized language for the siteaccess will be used.

The [ez\_render\_field](content_rendering#ez95render95_field) twig helper will by default generate a working link.

### REST API: `uri` property

The `uri` property of Binary Fields in REST contains a valid download URL, of the same format as the Public API, prefixed with the same host as the REST Request.

For [more information about REST API see the documentation](../api/rest_api_guide).

## URL handling

### IO URL decoration

By default, images and binary files referenced by content will be served from the same server as the application, like `           /var/ezdemo_site/storage/images/3/6/4/6/6463-1-eng-GB/kidding.png`. This is the default semantic configuration:

``` yaml
ezpublish:
    system:
        default:
            io:
                url_prefix: "$var_dir$/$storage_dir$"
```

`$var_dir$` and `$storage_dir$` are dynamic, [siteaccess-aware settings](siteaccess.md#dynamic-settings-injection), and will be replaced by their values in the execution context.

URL decorators are an eZ Platform feature. If an image field is displayed via a legacy callback or legacy template, no decoration will be applied.

### Using a static server for images

One common use case is to use an optimized nginx to serve images in an optimized way. The example image above could be made available as `                http://static.example.com/images/3/6/4/6/6463-1-eng-GB/kidding.png`, by setting up a server that uses `ezpublish/ezpublish_legacy/var/ezdemo_site/storage`. The eZ Platform configuration would be as follows:

``` yaml
ezpublish:
    system:
        default:
            io:
                url_prefix: "http://static.example.com/$var_dir$/$storage_dir$"
```

##### Legacy compatibility

Legacy still requires a non-absolute path to store images (var/site/storage/images/etc.). In order to work around this, a `UrlRedecorator`, that converts back and forth between the legacy uri prefix and the one in use in the application has been added. It is used in all places where a legacy URL is returned/expected, and takes care of making sure the value is as expected.

### Internals

Any `BinaryFile` returned by the public API is prefixed with the value of this setting, internally stored as `ezsettings.scope.io.url_prefix`.

#### Dynamic container settings

###### `io.url_prefix`

Default value: `$var_dir$/$storage_dir$`
Example: `/var/ezdemo_site/storage`

Used to configure the default URL decorator service (`ezpublish.core.io.default_url_decorator`), used by all binarydata handlers to generate the URI of loaded files. It is always interpreted as an absolute URI, meaning that unless it contains a scheme (http://, ftp://), it will be prepended with a '/'.

This setting is siteaccess aware.

#### Services

###### URL decorators

A UrlDecorator decorates and undecorates a given string (url) in some way. It has two mirror methods: `decorate` and `undecorate`.

Two implementations are provided: `Prefix`, and `AbsolutePrefix`. They both add a prefix to a URL, but `AbsolutePrefix` will ensure that unless the prefix is an external URL, the result will be prepended with /.

Three UrlDecorator services are introduced:

- `ezpublish.core.io.prefix_url_decorator` used by the binarydata handlers to decorate all uris sent out by the API. Uses `AbsolutePrefix`.
- `ezpublish.core.io.image_fieldtype.legacy_url_decorator` used via the UrlRedecorator by various legacy elements (Converter, Storage Gateway, etc.) to generate its internal storage format for uris. Uses a `Prefix`, not an `AbsolutePrefix`, meaning that no leading / is added.

In addition, a UrlRedecorator service, `ezpublish.core.io.image_fieldtype.legacy_url_redecorator`, uses both decorators above to convert URIs between what is used on the new stack, and what format legacy expects (relative urls from the ezpublish root).
