---
description: Configurations and management of binary files.
---

# File management

## Access binary files

To access binary files from the PHP API, use the `Ibexa\Core\IO\IOServiceInterface::loadBinaryFile()` method:

```php
$file = $this->ioService->loadBinaryFile($field->value->id);
$fileContent = $this->ioService->getFileContents($file);
```

## Handling binary files

[[= product_name =]] supports multiple binary file handling mechanisms by means of an `IOHandler` interface. This feature is used by the [BinaryFile](imagefield.md) field types.

### Native IO handler

The IO API is organized around two types of handlers, both used by the IOService:

- `Ibexa\Core\IO\IOMetadataHandler`: stores and reads metadata (such as validity or size)
- `Ibexa\Core\IO\IOBinarydataHandler`: stores and reads the actual binary data

You can configure IO handlers using semantic configuration. IO handlers are configurable per SiteAccess.
See the default configuration:

``` yaml
ibexa:
    system:
        default:
            io:
                metadata_handler: dfs
                binarydata_handler: nfs
```

The adapter is the *driver* used by Flysystem v2 to read/write files. Adapters are declared using `oneup_flysystem`.
Metadata and binary data handlers are configured under `ibexa_io`. See below the configuration for the default handlers. It declares a metadata handler and a binary data handler, both labeled `default`. Both handlers are of type `flysystem`, and use the same Flysystem v2 adapter, labeled `default` as well.

``` yaml
ibexa_io:
    binarydata_handlers:
        nfs:
            flysystem:
                adapter: nfs_adapter
    metadata_handlers:
        dfs:
            legacy_dfs_cluster:
                connection: doctrine.dbal.dfs_connection
```

The `nfs_adapter`'s directory is based on your site settings, and is automatically set to `$var_dir$/$storage_dir$` (for example, `/path/to/ibexa/public/var/site/storage`).

#### Permissions of generated files

You can configure permissions of generated files under the `ibexa.system.<scope>.io.permissions` [configuration key](configuration.md#configuration-files).

``` yaml
ibexa:
    system:
        default:
            io:
                permissions:
                    files: 0750 #default is 0644
                    directories: 0640 #default is 0755
```

Both `files` and `directories` are optional.

Default values:

- 0644 for files
- 0755 for directories

!!! note

    Make sure to configure permissions using a number and **not** a string.
    "0644" is **not** interpreted by PHP as an octal number, and unexpected permissions can be applied.

!!! note

    As SiteAccess configuration Flysystem's v2 native Local NFS adapter isn't supported, the following configuration should be used:

    ``` yaml
    oneup_flysystem:
        adapters:
            nfs_adapter:
                custom:
                    service: ibexa.io.nfs.adapter.site_access_aware
    ```


### Native Flysystem v2 handler

[[= product_name =]] uses it as the default way to read and write content in form of binary files.
Flysystem v2 can use the `local` filesystem, but is also able to read/write to `sftp`, `zip` or cloud filesystems (`azure`, `rackspace`, `S3`).
[league/flysystem](https://flysystem.thephpleague.com/docs/) (along with [FlysystemBundle](https://github.com/1up-lab/OneupFlysystemBundle/)) is an abstract file handling library.

#### Handler options

##### Adapter

To be able to rely on dynamic SiteAccess-aware paths, you need to use [[= product_name_base =]] custom `nfs_adapter`.
A basic configuration might look like the following:

``` yaml
oneup_flysystem:
    adapters:
        nfs_adapter:
            custom:
                service: ibexa.io.nfs.adapter.site_access_aware
```

To learn how to configure other adapters, see the [bundle's online documentation](https://github.com/1up-lab/OneupFlysystemBundle/blob/4.x/doc/index.md#step3-configure-your-filesystems).

!!! note

    Only the adapters are used here, not the filesystem configuration described in this documentation.

### DFS Cluster handler

For clustering, the platform provides a custom metadata handler that stores metadata about your assets in the database.
This is faster than accessing the remote NFS or S3 instance to read metadata.

For more information, see [Clustering](clustering.md).
