# Clustering

Clustering in [[= product_name =]] refers to setting up your installation with several web servers for handling more load and/or for failover.

## Server setup overview

This diagram illustrates how clustering in [[= product_name =]] is typically set up.
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

- [Solr](search/solr.md) for better search and performance
- a CDN for improved performance and faster ping time worldwide
    - you can use Fastly, which has native support as HTTP cache and CDN.
- active/passive database for failover
- more recent versions of PHP and MySQL/MariaDB within [what is supported](../getting_started/requirements.md) for your [[= product_name =]] version to get more performance out of each server. Numbers might vary so make sure to test this when upgrading.

### Shared persistence cache

Redis is the recommended cache solution for clustering. An alternative solution is using Memcached.

See [persistence cache documentation](persistence_cache.md#persistence-cache-configuration) on information on how to configure them.

### Shared sessions

For a [cluster](clustering.md) setup you need to configure sessions to use a back end that is shared between web servers.
The main options out of the box in Symfony are the native PHP Memcached or PHP Redis session handlers, alternatively there is Symfony session handler for PDO (database).

To avoid concurrent access to session data from front-end nodes, if possible you should either:

- Enable [Session locking](http://php.net/manual/en/features.session.security.management.php#features.session.security.management.session-locking)
- Use "Sticky Session", aka [Load Balancer Persistence](https://en.wikipedia.org/wiki/Load_balancing_(computing)#Persistence)

Session locking is available with `php-memcached`, and with `php-redis` (v4.2.0 and higher).

On Ibexa Cloud (and Platform.sh) Redis is preferred and supported.

### Shared binary files

[[= product_name =]] supports multi-server setups by means of [custom IO handlers](file_management.md#the-dfs-cluster-handler).
They make sure that files are correctly synchronized among the multiple clients using the data.

## DFS IO handler

The DFS IO handler (`legacy_dfs_cluster`) can be used to store binary files on an NFS server.
It will use a database to manipulate metadata, making up for the potential inconsistency of network-based filesystems.

### Configuring the DFS IO handler

You need to configure both metadata and binarydata handlers.

[[= product_name =]] ships with a custom local adapter (`ibexa.platform.io.nfs.adapter.site_access_aware`), 
which decorates the Flysystem local adapter to enable support for SiteAccess-aware settings.
If an NFS path relies on SiteAccess-aware dynamic parameters, you must use the custom local adapter 
instead of the Flysystem local adapter.
Configure the custom local adapter to read/write to the NFS mount point on each local server.
As metadata handler, create a DFS one, configured with a Doctrine connection.

!!! tip

    The default database install will now include the dfs table *in the same database*

For production, it is recommended to create the DFS table in its own database,
manually importing its schema definition:

??? note "dfs_schema.sql (MySQL)"

    ``` sql
        CREATE TABLE ezdfsfile (
          name text NOT NULL,
          name_trunk text NOT NULL,
          name_hash varchar(34) NOT NULL DEFAULT '',
          datatype varchar(255) NOT NULL DEFAULT 'application/octet-stream',
          scope varchar(25) NOT NULL DEFAULT '',
          size bigint(20) unsigned NOT NULL DEFAULT '0',
          mtime int(11) NOT NULL DEFAULT '0',
          expired tinyint(1) NOT NULL DEFAULT '0',
          status tinyint(1) NOT NULL DEFAULT '0',
          PRIMARY KEY (name_hash),
          KEY ezdfsfile_name (name (191)),
          KEY ezdfsfile_name_trunk (name_trunk (191)),
          KEY ezdfsfile_mtime (mtime),
          KEY ezdfsfile_expired_name (expired,name (191))
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ```

??? note "dfs_schema.sql (PostgreSQL)"

    ``` sql
    CREATE TABLE ezdfsfile (
      name_hash varchar(34) DEFAULT '' NOT NULL,
      name text NOT NULL,
      name_trunk text NOT NULL,
      datatype varchar(255) DEFAULT 'application/octet-stream' NOT NULL,
      scope character varying(25) DEFAULT '' NOT NULL,
      size bigint DEFAULT 0 NOT NULL,
      mtime integer DEFAULT 0 NOT NULL,
      expired boolean DEFAULT false NOT NULL,
      status boolean DEFAULT false NOT NULL
    );

    ALTER TABLE ONLY ezdfsfile
      ADD CONSTRAINT ezdfsfile_pkey PRIMARY KEY (name_hash);

    CREATE INDEX ezdfsfile_expired_name ON ezdfsfile USING btree (expired, name);
    CREATE INDEX ezdfsfile_mtime ON ezdfsfile USING btree (mtime);
    CREATE INDEX ezdfsfile_name ON ezdfsfile USING btree (name);
    CREATE INDEX ezdfsfile_name_trunk ON ezdfsfile USING btree (name_trunk);
    ```

!!! note
    On Ibexa Cloud (and Platform.sh) a separate DFS database is supported for MySQL only.

This example uses Doctrine connection named `dfs`:

``` yaml
parameters:
    ibexa.platform.io.nfs.adapter.config:
        root: '%dfs_nfs_path%'
        path: '$var_dir$/$storage_dir$/'
        writeFlags: ~
        linkHandling: ~
        permissions: [ ]

# new Doctrine connection for the DFS legacy_dfs_cluster metadata handler.
doctrine:
    dbal:
        connections:
            dfs:
                # configure these settings to match your database server
                driver: pdo_mysql
                charset: utf8mb4
                default_table_options:
                    charset: utf8mb4
                    collate: utf8mb4_unicode_520_ci
                url: mysql://root:rootpassword@127.0.0.1:3306/ezdfs

# define the Flysystem handler
oneup_flysystem:
    adapters:
        nfs_adapter:
            custom:
                service: ibexa.platform.io.nfs.adapter.site_access_aware

# define the Ibexa handlers
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
ezplatform:
    system:
        default:
            io:
                metadata_handler: dfs
                binarydata_handler: nfs
```


!!! tip

    If you are looking to [set up S3](clustering_aws_s3.md) or other [Flysystem](https://flysystem.thephpleague.com/)/third-party adapters like Google Cloud Storage, this needs to be configured as binary handler. The rest here will still stay the same, the DFS metadata handler will take care of caching the lookups to avoid slow IO lookups.

#### Customizing the storage directory

Earlier versions required the NFS adapter directory to be set to `$var_dir$/$storage_dir$` part for the NFS path.
This is no longer required (unless you plan to use [Legacy Bridge](https://github.com/ezsystems/LegacyBridge)),
but the default prefix used to serve binary files still matches this expectation.

If you decide to change this setting, make sure you also set `io.url_prefix` to a matching value.
If you set the NFS adapter's directory to `/path/to/nfs/storage`, use this configuration so that the files can be served by Symfony:

``` yaml
ezplatform:
    system:
        default:
            io:
                url_prefix: storage
```

As an alternative, you may serve images from NFS using a dedicated web server.
If in the example above, this server listens on `http://static.example.com/`
and uses `/path/to/nfs/storage` as the document root, configure `io.url_prefix` as follows:

``` yaml
ezplatform:
    system:
        default:
            io:
                url_prefix: 'http://static.example.com/'
```

You can read more about that on [Binary files URL handling](file_management.md#url-handling).

### Web server rewrite rules

The default [[= product_name =]] rewrite rules will let image requests be served directly from disk.
In a cluster setup, files matching `^/var/([^/]+/)?storage/images(-versioned)?/.*` have to be passed through `/public/index.php` instead.

In any case, this specific rewrite rule must be placed before the ones that "ignore" image files and just let the web server serve the files directly.

#### Apache

```
RewriteRule ^/var/([^/]+/)?storage/images(-versioned)?/.* /index.php [L]
```

Place this before the standard image rewrite rule in your vhost config (or uncomment if already there).

#### nginx

```
rewrite "^/var/([^/]+/)?storage/images(-versioned)?/(.*)" "/index.php" break;
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

See [AWS S3 clustering](clustering_aws_s3.md).
