# File management

## Accessing binary files

To access binary files from the PHP API, use the `Ibexa\Core\IO\IOServiceInterface::loadBinaryFile()` method:

```php
use Ibexa\Core\IO\IOServiceInterface;

class FileController
{
    //...

    $file = $this->ioService->loadBinaryFile($field->value->id);
    $fileContent = $this->ioService->getFileContents($file);
    
    // ...
}
```

## Handling binary files

[[= product_name =]] supports multiple binary file handling mechanisms by means of an `IOHandler` interface. This feature is used by the [BinaryFile](../api/field_types_reference/binaryfilefield.md), [Media](../api/field_types_reference/mediafield.md) and [Image](../api/field_types_reference/imagefield.md) Field Types.

### Native IO handler

The IO API is organized around two types of handlers, both used by the IOService:

- `Ibexa\Core\IO\IOMetadataHandler`: Stores and reads metadata (validity, size, etc.)
- `Ibexa\Core\IO\IOBinarydataHandler`: Stores and reads the actual binary data

IO handlers can be configured using semantic configuration and are configurable per SiteAccess.
This is the default configuration:

``` yaml
ibexa:
    system:
        default:
            io:
                metadata_handler: default
                binarydata_handler: default
```

Metadata and binary data handlers are configured under `ibexa_io`. Below is what the configuration looks like for the default handlers. It declares a metadata handler and a binary data handler, both labeled `default`. Both handlers are of type `flysystem`, and use the same Flysystem adapter, labeled `default` as well.

``` yaml
ibexa_io:
    metadata_handlers:
        default:
            flysystem:
                adapter: default
    binarydata_handlers:
        default:
            flysystem:
                adapter: default
```

The 'default' Flysystem adapter's directory is based on your site settings, and will automatically be set to `%webroot_dir%/$var_dir$/$storage_dir$` (for example: `/path/to/ibexa/public/var/site/storage`).

#### Configure the permissions of generated files

``` yaml
ibexa:
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

!!! note

    When using the NFS [adapter](file_management.md#adapter), configure file permissions under the `oneup_flysystem` key instead, as follows:

    ``` yaml
    oneup_flysystem:
        adapters:
            nfs_adapter:
                local:
                    permissions:
                        file:
                            public: 0750
                        dir:
                            public: 0640
    ```

### The native Flysystem handler

[league/flysystem](http://flysystem.thephpleague.com/) (along with [FlysystemBundle](https://github.com/1up-lab/OneupFlysystemBundle/)) is an abstract file handling library.

[[= product_name =]] uses it as the default way to read and write content in form of binary files. Flysystem can use the `local` filesystem (this is the default and officially supported configuration), but is also able to read/write to `sftp`, `zip` or cloud filesystems (`azure`, `rackspace`, `S3`).

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

## Enabling BinaryFile Field indexing

The indexing of all binary file Fields is disabled by default.
If you want to enable indexing, you must have installed Oracle Java/Open JDK 8 or higher and Apache Tika 1.20.
Next, in the `config/packages` folder create a `binary_files.yaml` file with the following configuration:

``` yaml
ibexa_commerce_field_types:
    binary_file_indexing:
        enabled: true
```

To check what types are indexed, see under the `ibexa_commerce_search.default.index_content` parameter in `src/Siso/Bundle/SearchBundle/Resources/config/search.yml`. This parameter can be overriden, so you use it to index only specific types per SiteAccess or to extend the indexing to other file types.
The following file types are indexed by default:

``` yaml
- application/pdf
- application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
```

The default path to the Tika jar is specified with the `apache_tika_path` parameter in `config/packages/commerce/commerce_parameters.yaml`.

## Binary and Media download

Unlike image files, files stored in BinaryFile or Media Fields may be restricted to certain User Roles. As such, they are not publicly downloadable from disk, and are instead served by Symfony, using a custom route that runs the necessary checks. This route is automatically generated as the `url` property for those Field values.

### The `content/download` route

The route follows this pattern: `/content/download/{contentId}/{fieldIdentifier}/{filename}`. For example: `/content/download/68/file/My-file.pdf.`

It also accepts optional query parameters:

- `version`: the version number that the file must be downloaded for. Requires the `versionread` permission. If not specified, the published version is used.
- `inLanguage`: The language the file should be downloaded in. If not specified, the most prioritized language for the SiteAccess will be used.

The [ez\_render\_field](content_rendering/twig_function_reference/field_twig_functions.md#ibexa_render_field) Twig helper will by default generate a working link.

### Download link generation

To generate a direct download link for the `File` Field Type you have to create
a Route Reference with the `ibexa_route` helper, passing `content` and `File` Field identifier as parameters.
Optional parameter `inLanguage` may be used to specify File content translation.

```twig
  {% set routeReference = ibexa_route( 'ibexa.content.download', {'content': content, 'fieldIdentifier': 'file', 'inLanguage': content.prioritizedFieldLanguageCode  } ) %}
  <a href="{{ ibexa_path( routeReference ) }}">Download</a>
```

### REST API: `uri` property

The `uri` property of Binary Fields in REST contains a valid download URL, of the same format as the Public API, prefixed with the same host as the REST Request.

For [more information about REST API see the documentation](../api/rest_api_guide).

## File URL handling

### IO URL decoration

By default, images and binary files that are referenced by the content will be served from the same server as the application, for example `/var/site/storage/images/3/6/4/6/6463-1-eng-GB/kidding.png`.
This is the default semantic configuration:

``` yaml
ibexa:
    system:
        default:
            io:
                url_prefix: '$var_dir$/$storage_dir$'
```

`$var_dir$` and `$storage_dir$` are dynamic, [SiteAccess-aware settings](config_dynamic.md#inject-configresolver-into-services), and will be replaced by their values in the execution context.

#### Using a static server for images

One common use case is to use an optimized nginx to serve images in an optimized way. The example image
above could be made available as `http://static.example.com/var/site/storage/images/3/6/4/6/6463-1-eng-GB/kidding.png`
by setting up a separate server that maps the `/path/to/ibexa/public/var` directory.
The configuration would be as follows:

``` yaml
ibexa:
    system:
        default:
            io:
                url_prefix: 'http://static.example.com/$var_dir$/$storage_dir$'
```

!!! caution

    For security reasons, do not map `/path/to/ibexa/public/` as
    Document Root of the static server.
    Map the `/var/` directory directly to `/path/to/ibexa/public/var` instead.

### `io.url_prefix`

Any `BinaryFile` returned by the public API is prefixed with the value of this setting, internally stored as `ibexa.site_access.config.scope.io.url_prefix`.

#### `io.url_prefix` dynamic service container setting

Default value: `$var_dir$/$storage_dir$`
Example: `/var/site/storage`

Used to configure the default URL decorator service (`ibexa.core.io.default_url_decorator`), used by all binary data handlers to generate the URI of loaded files. It is always interpreted as an absolute URI, meaning that unless it contains a scheme (http://, ftp://), it will be prepended with a '/'.

This setting is SiteAccess-aware.

### URL decorator service

A UrlDecorator decorates and undecorates a given string (URL). It has two mirror methods: `decorate` and `undecorate`.

Two implementations are provided: `Prefix`, and `AbsolutePrefix`. They both add a prefix to a URL, but `AbsolutePrefix` will ensure that unless the prefix is an external URL, the result will be prepended with /.

Three UrlDecorator services are introduced:

- `Ibexa\Core\IO\UrlDecorator\AbsolutePrefix` used by the binary data handlers to decorate all URIs sent out by the API. Uses `AbsolutePrefix`.
- `Ibexa\Core\IO\UrlDecorator\Prefix` used via the UrlRedecorator by various legacy elements (Converter, Storage Gateway, etc.) to generate its internal storage format for URIs. Uses a `Prefix`, not an `AbsolutePrefix`, meaning that no leading / is added.

In addition, a UrlRedecorator service, `Ibexa\Core\IO\UrlDecorator\Prefix`, uses both decorators above to convert URIs between what is used on the new stack, and what format legacy expects (relative urls from the ezpublish root).
