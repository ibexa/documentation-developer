---
description: See various tools that can help you debug your Ibexa DXP installation.
---

# Devops

## Cache clearing

### Clearing file cache using the Symfony cache:clear command

Symfony provides a command for clearing cache. It will delete all file-based caches, which mainly consist of a Twig template, a [service container](php_api.md#service-container), and the Symfony route cache, but also everything else stored in the cache folder. Out of the box on a single-server setup this includes Content cache. For further information on the command's use, see its help text:

``` bash
php bin/console --env=prod cache:clear -h
```

!!! note

    If you do not specify an environment, by default `cache:clear` will clear the cache for the `dev` environment. If you want to clear it for `prod` you need to use the `--env=prod` option.

!!! caution "Clustering"

    In [clustering](clustering.md) setup (with several web servers), the command to clear file cache needs to be executed on every web server.

### Clearing content cache on a cluster setup

For a [cluster](clustering.md) setup, the content cache ([HTTP cache](http_cache.md) and [Persistence cache](persistence_cache.md)) must be set up to be shared among the servers. And while all relevant cache is cleared for you on Repository changes when using the APIs, there might be times where you'll need to clear cache manually: 

- Varnish: [Cache purge](reverse_proxy.md#using-varnish-or-fastly)
- Persistence Cache: [Using Cache service](persistence_cache.md#using-cache-service)

## Web Debug Toolbar

As of [[= product_name =]] v4.5, the [Symfony Web Debug Toolbar](https://symfony.com/doc/current/profiler.html) is no longer installed by default.
To install it, run the following command:

```
composer require symfony/debug-pack
```

After you have installed Symfony Web Debug Toolbar, it will be available when running [[= product_name =]] in the `dev` environment. It is extended with some [[= product_name =]]-specific information:

![Ibexa DXP info in Web Debug Toolbar](web_debug_toolbar.png "Ibexa DXP info in Web Debug Toolbar")

#### SPI (persistence)

This section provides the number of non-cached SPI calls and handlers. You can see details of these calls in the [Symfony Profiler]([[= symfony_doc =]]/profiler.html) page.

#### SiteAccess

Here you can see the name of the current SiteAccess and how it was matched. For reference see the [list of possible SiteAccess matchers](siteaccess_matching.md#available-siteaccess-matchers).

## Logging and debug configuration

Logging in [[= product_name =]] consists of two parts.
One are several debug systems that integrate with Symfony developer toolbar to give you detailed information about what is going on.
The other is the standard [PSR-3](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md) logger, as provided by Symfony using [Monolog](https://github.com/Seldaek/monolog).

### Debugging in dev environment

When using the Symfony `dev` [environment](environments.md), the system tracks additional metrics for you to be able to debug issues. They
include Symfony cache use, and a [persistence cache](persistence_cache.md#persistence-cache-configuration) use.

#### Reducing memory use

!!! tip

    For long-running scripts, see [Long-running console commands](performance.md#long-running-console-commands).

If you are running out of memory and don't need to keep track of cache hits and misses, you can disable persistence cache logging, represented by the setting `parameters.ibexa.spi.persistence.cache.persistenceLogger.enableCallLogging`. In `config_dev.yaml`:

``` yaml
parameters:
    ibexa.spi.persistence.cache.persistenceLogger.enableCallLogging: false
```

### Error logging and rotation

[[= product_name =]] uses the [Monolog](https://github.com/Seldaek/monolog) component to log errors, and it has a `RotatingFileHandler` that allows for file rotation.

According to [their documentation](https://seldaek.github.io/monolog/doc/02-handlers-formatters-processors.html#log-to-files-and-syslog), it "logs records to a file and creates one logfile per day. It will also delete files older than `$maxFiles`".

Monolog's handler can be configured in `config/packages/<environment>/monolog.yaml`:

``` yaml
monolog:
    handlers:
        main:
            type: rotating_file
            max_files: 10
            path: '%kernel.logs_dir%/%kernel.environment%.log'
            level: debug
```

### Using `logrotate`

Monolog themselves recommend using [`logrotate`](https://manpages.debian.org/jessie/logrotate/logrotate.8.en.html) instead of doing the rotation in the handler, because it gives better performance.
