# Clustering

Clustering in eZ Platform refers to setting up your installation with several web servers for handling more load and/or for failover.

## Server setup overview

This diagram illustrates how clustering in eZ Platform is typically set up.
The parts illustrate the different roles needed for a successful cluster setup.

![Server setup for clustering](img/server_setup.png)

The number of web servers, Memcached/Redis, Solr, Varnish, Database and NFS servers,
as well as whether some servers play several of these roles (typically running Memcached/Redis across the web server)
is up to you and your performance needs.

The minimal requirements are:

- [Shared HTTP cache (using Varnish)](http_cache.md#using-varnish)
- [Shared persistence cache](#shared-persistence-cache) and [sessions](#shared-sessions) (using Redis or Memcached)
- Shared database (using MySQL/MariaDB)
- [Shared binary files](#shared-binary-files) (using NFS, or S3)

For further details on requirements, see [Requirements page](../getting_started/requirements.md).

It is also recommended to use:

- [Solr](solr.md) for better search and performance
- a CDN for improved performance and faster ping time worldwide
- active/passive database for failover
- more recent versions of PHP and MySQL/MariaDB within [what is supported](../getting_started/requirements.md) for your eZ Platform version to get more performance out of each server. Numbers might vary so make sure to test this when upgrading.

### Shared persistence cache

[Redis](http://redis.io/), an in-memory data structure store, is the recommended cache solution for clustering.

Redis is used via [Redis pecl extension](https://pecl.php.net/package/redis).

See [Redis Cache Adapter in Symfony documentation](https://symfony.com/doc/3.4/components/cache/adapters/redis_adapter.html#configure-the-connection)
for information on how to configure Redis.

To use Redis, you need to set `cache_service_name` to `cache.redis`.

Example:

``` yaml
services:
    cache.redis:
        parent: cache.adapter.redis
        tags:
            - name: cache.pool
              clearer: cache.app_clearer
              provider: 'redis://secret@example.com:1234/13'
```

!!! caution "Clearing Redis cache"

    The regular `php bin/console cache:clear` command does not clear Redis persistence cache.
    To clear it, use a dedicated Symfony command: `php bin/console cache:pool:clear cache.redis`.

##### Redis Cluster

It is possible to set up and use Redis as a cluster. This configuration is more efficient and reliable for large installations.

Redis Cluster can be configured in two ways, using [create-cluster script](https://redis.io/topics/cluster-tutorial) or using [Redis Sentinel](https://redis.io/topics/sentinel).
If you use Platform.sh Enterprise you can benefit from the Redis Sentinel across three nodes for greater fault tolerance.
Platform.sh Professional and lower versions offer Redis in single instance mode only.
Configuration for eZ Platform is the same regardless of the Redis version, single instance mode or cluster mode.

### Shared sessions

For a [cluster](clustering.md) setup you need to configure sessions to use a back end that is shared between web servers and supports locking.
Alternatively, use a load balancer that supports session affinity ("sticky sessions") so a user is served by a single server once they get a session.

The only out-of-the-box options supporting this in Symfony are the native PHP Memcached session save handler
provided by the `php-memcached` extension, and Symfony session handler for PDO (database).

### Shared binary files

eZ Platform supports multi-server setups by means of [custom IO handlers](file_management#the-dfs-cluster-handler).
They make sure that files are correctly synchronized among the multiple clients using the data.

## DFS IO handler

The DFS IO handler (`legacy_dfs_cluster`) can be used to store binary files on an NFS server.
It will use a database to manipulate metadata, making up for the potential inconsistency of network-based filesystems.

### Configuring the DFS IO handler

You need to configure both metadata and binarydata handlers.

As the binarydata handler, create a new Flysystem local adapter configured to read/write to the NFS mount point on each local server.
As metadata handler, create a DFS one, configured with a Doctrine connection.

!!! tip

    The default database install will now include the dfs table *in the same database*

For production, we strongly recommend creating the DFS table in its own database, using the `vendor/ezsystems/ezpublish-kernel/data/mysql/dfs_schema.sql` file.
In our example, we will use one named `dfs`.

``` yaml
# new Doctrine connection for the DFS legacy_dfs_cluster metadata handler.
doctrine:
    dbal:
        connections:
            dfs:
                driver: pdo_mysql
                host: 127.0.0.1
                port: 3306
                dbname: ezdfs
                user: root
                password: "rootpassword"
                charset: UTF8MB4

# define the Flysystem handler
oneup_flysystem:
    adapters:
        nfs_adapter:
            local:
                directory: "/<path to nfs>/$var_dir$/$storage_dir$"

# define the eZ Platform handlers
ez_io:
    binarydata_handlers:
        nfs:
            flysystem:
                adapter: nfs_adapter
    metadata_handlers:
        dfs:
            legacy_dfs_cluster:
                connection: doctrine.dbal.dfs_connection

# set the application handlers
ezpublish:
    system:
        default:
            io:
                metadata_handler: dfs
                binarydata_handler: nfs
```


!!! tip

    If you are looking to [set up S3](../cookbook/setting_up_amazon_aws_s3_clustering.md) or other [Flysystem](https://flysystem.thephpleague.com/)/third-party adapters like Google Cloud Storage, this needs to be configured as binary handler. The rest here will still stay the same, the DFS metadata handler will take care of caching the lookups to avoid slow IO lookups.

#### Customizing the storage directory

Earlier versions required the NFS adapter directory to be set to `$var_dir$/$storage_dir$` part for the NFS path.
This is no longer required (unless you plan to use [Legacy Bridge](https://github.com/ezsystems/LegacyBridge)),
but the default prefix used to serve binary files still matches this expectation.

If you decide to change this setting, make sure you also set `io.url_prefix` to a matching value.
If you set the NFS adapter's directory to `/path/to/nfs/storage`, use this configuration so that the files can be served by Symfony:

``` yaml
ezpublish:
    system:
        default:
            io:
                url_prefix: "storage"
```

As an alternative, you may serve images from NFS using a dedicated web server.
If in the example above, this server listens on `http://static.example.com/`
and uses `/path/to/nfs/storage` as the document root, configure `io.url_prefix` as follows:

``` yaml
ezpublish:
    system:
        default:
            io:
                url_prefix: "http://static.example.com/"
```

You can read more about that on [Binary files URL handling](file_management.md#url-handling).

### Web server rewrite rules

The default eZ Platform rewrite rules will let image requests be served directly from disk.
In a cluster setup, files matching `^/var/([^/]+/)?storage/images(-versioned)?/.*` have to be passed through `/web/app.php` instead.

In any case, this specific rewrite rule must be placed before the ones that "ignore" image files and just let the web server serve the files directly.

#### Apache

```
RewriteRule ^/var/([^/]+/)?storage/images(-versioned)?/.* /app.php [L]
```

Place this before the standard image rewrite rule in your vhost config (or uncomment if already there).

#### nginx

```
rewrite "^/var/([^/]+/)?storage/images(-versioned)?/(.*)" "/app.php" break;
```

Place this before the include of `ez_params.d`/`ez_rewrite_params` in your vhost config (or uncomment if already there).

## Migrating to a cluster setup

If you are migrating an existing single-server site to a cluster setup, and not setting up clustering from scratch, you need to migrate your files.
Once you have configured your binarydata and metadata handlers, you can run the `ezplatform:io:migrate-files` command.
You can also use it when you are migrating from one data handler to another, e.g. from NFS to Amazon S3.

This command shows which handlers are configured:

```
> php bin/console ezplatform:io:migrate-files --list-io-handlers
Configured meta data handlers: default, dfs, aws_s3
Configured binary data handlers: default, nfs, aws_s3
```

You can do the actual migration like this:

```
> php bin/console ezplatform:io:migrate-files --from=default,default --to=dfs,nfs --env=prod
```

The `--from` and `--to` values must be specified as `<metadata_handler>,<binarydata_handler>`.
If `--from` is omitted, the default IO configuration will be used.
If `--to` is omitted, the first non-default IO configuration will be used.

!!! tip

    The command must be executed with the same permissions as the web server.

While the command is running, the files should not be modified.
To avoid surprises you should create a [backup](backup.md) and/or execute a dry run before doing the actual update, using the `--dry-run` switch.

Since this command can run for a very long time, to avoid memory exhaustion run it in the production environment using the `--env=prod` switch.

## Clustering using Amazon AWS S3

See [Setting up Amazon AWS S3 clustering](../cookbook/setting_up_amazon_aws_s3_clustering.md).
