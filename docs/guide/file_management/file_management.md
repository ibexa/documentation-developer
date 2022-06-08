# File Management

## Access binary files

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

[[= product_name =]] supports multiple binary file handling mechanisms by means of an `IOHandler` interface. This feature is used by the [BinaryFile](../../api/field_types_reference/binaryfilefield.md), [Media](../../api/field_types_reference/mediafield.md) and [Image](../../api/field_types_reference/imagefield.md) Field Types.

### Native IO handler

The IO API is organized around two types of handlers, both used by the IOService:

- `Ibexa\Core\IO\IOMetadataHandler`: stores and reads metadata (such as, validity, size)
- `Ibexa\Core\IO\IOBinarydataHandler`: stores and reads the actual binary data

You can configure IO handlers using semantic configuration. IO handlers are configurable per SiteAccess.
See the default configuration:

``` yaml
ibexa:
    system:
        default:
            io:
                metadata_handler: default
                binarydata_handler: default
```

Metadata and binary data handlers are configured under `ibexa_io`. See below the configuration for the default handlers. It declares a metadata handler and a binary data handler, both labeled `default`. Both handlers are of type `flysystem`, and use the same Flysystem adapter, labeled `default` as well.

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

The default Flysystem adapter's directory is based on your site settings, and will automatically be set to `%webroot_dir%/$var_dir$/$storage_dir$` (for example, `/path/to/ibexa/public/var/site/storage`).

#### Permissions of generated files

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

Default values:

- 0644 for files
- 0755 for directories

!!! note

    Make sure to configure permissions using a number and **not** a string. If you write "0644" it will **not** be interpreted by PHP as an octal number, and unexpected permissions will be applied.

!!! note

    When using the NFS [adapter](../file_management/file_management.md#adapter), configure file permissions under the `oneup_flysystem` key instead, as follows:

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

### Native Flysystem handler

Flysystem is a file storage library for PHP. It provides one interface to interact with many types of filesystems. 

[league/flysystem](http://flysystem.thephpleague.com/) (along with [FlysystemBundle](https://github.com/1up-lab/OneupFlysystemBundle/)) is an abstract file handling library.

[[= product_name =]] uses it as the default way to read and write content in form of binary files. Flysystem can use the `local` filesystem (this is the default and officially supported configuration), but is also able to read/write to `sftp`, `zip` or cloud filesystems (`azure`, `rackspace`, `S3`).

#### Handler options

##### Adapter

The adapter is the *driver* used by Flysystem to read/write files. Adapters are declared using `oneup_flysystem`. A basic configuration might look like the following:

``` yaml
oneup_flysystem:
    adapters:
        default:
            local:
                directory: /path/to/directory
```

To learn how to configure other adapters, see the [bundle's online documentation](https://github.com/1up-lab/OneupFlysystemBundle/blob/main/doc/index.md#step3-configure-your-filesystems). 

!!! note

    Only the adapters are used here, not the filesystem configuration described in this documentation.
    

### DFS Cluster handler

For clustering use the platform provides a custom metadata handler that stores metadata about your assets in the database. This is done as it is faster than accessing the remote NFS or S3 instance to read metadata. For further reading on setting this up, see [Clustering](../clustering.md).

## Enabling BinaryFile Field indexing

The indexing of all binary file Fields is disabled by default.
To enable it, first, make sure you have installed Oracle Java/Open JDK 8 or higher and Apache Tika 1.20.
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