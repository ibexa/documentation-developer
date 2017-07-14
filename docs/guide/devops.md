1.  [Developer](index.html)
2.  [Documentation](Documentation_31429504.html)
3.  [The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)

# Devops 

Created by Sarah Haïm-Lubczanski, last modified by André Rømcke on Jun 19, 2017

# Introduction

## Cache Clearing

This page describes commands involved in clearing cache from the command line.

### Clearing file cache using the Symfony cache:clear command

Out of the box Symfony provides a command to perform cache clearing. It will delete all file-based caches, which mainly consist of Twig template, Symfony container, and Symfony route cache, but also everything else stored in cache folder. Out of the box on a single-server setup this includes "Content cache". For further information on use, see the help text of the command:

``` brush:
php app/console --env=prod cache:clear -h
```

If you do not specify an environment, by default `cache:clear` will clear the cache for the `dev` environment. If you want to clear it for `prod` you need to to use the --env=prod option.

On each web server

In [Clustering](Clustering_31430387.html) setup *(several web servers),* the command to clear file cache needs to be executed on each and every web server!

### Clearing "Content Cache" on a Cluster setup

For [Cluster](Clustering_31430387.html) setup, the content cache ([HTTP Cache](HTTP-Cache_31430152.html)   and [Persistent Cache](Repository_31432023.html#Repository-PersistenceCache)) must be set up to be shared among the servers. And while all relevant cache is cleared for you on repository changes when using the APIs, there might be times where you'll need to clear cache manually: 

-   Varnish: [Cache purge](https://doc.ez.no/display/DEVELOPER/HTTP+Cache#HTTPCache-CachePurge)
-   Persistence Cache: [Using Cache service](Repository_31432023.html#Repository-UsingCacheService)

## Web Debug Toolbar

When running eZ Platform in the `dev` environment you have access to the standard Symfony Web Debug Toolbar. It is extended with some eZ Platform-specific information:

![eZ Platform info in Web Debug Toolbar](attachments/31432029/32868731.png "eZ Platform info in Web Debug Toolbar")

#### SPI (persistence)

This section provides the number of non-cached [SPI](Repository_31432023.html#Repository-SPI)calls and handlers. You can see details of these calls in the [Symfony Profiler](http://symfony.com/doc/current/profiler.html) page.

#### Site Access

Here you can see the name of the current Siteaccess and how it was matched. For reference see the [list of possible siteaccess matchers](SiteAccess_31429665.html#SiteAccess-Availablematchers).

# Configuration

## Logging and Debug Configuration

### Introduction

Logging in eZ Platform consists of two parts, several debug systems that integrates with symfony developer toolbar to give you detailed information about what is going on. And standard [PSR-3](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md) logger, as provided by Symfony using [Monolog](https://github.com/Seldaek/monolog).

### Debugging in dev environment

When using the Symfony dev [environment](Environments_31429669.html), the system out of the box tracks additional metrics for you to be able to debug issues, this includes [Stash](http://stash.tedivm.com/) cache use *(done by [StashBundle](https://github.com/tedivm/TedivmStashBundle))*, and a [persistence cache](Repository_31432023.html#Repository-Persistencecacheconfiguration) use.

#### Reducing memory use

For long running scripts, instead head over to [Executing long-running console commands](Executing-long-running-console-commands_31429811.html) for some much more relevant info.

If you are running out of memory and don't need to keep track of cache hits and misses. Then StashBundle tracking, represented by the `stash.tracking` setting, and persistence cache logging, represented by the setting `parameters.ezpublish.spi.persistence.cache.persistenceLogger.enableCallLogging`, can optionally be disabled.

 

**config\_dev.yml**

``` brush:
stash:
    tracking: false                  # Default is true in dev
    tracking_values: false           # Default is false in dev, to only track cache keys not values
    caches:
        default:
            inMemory: false          # Default is true, but this uses a lot of php memory
            registerDoctrineAdapter: false

parameters:
    ezpublish.spi.persistence.cache.persistenceLogger.enableCallLogging: false
```

### Error logging and rotation

eZ Platform uses the Monolog component to log errors, and it has a `RotatingFileHandler` that allows for file rotation.

According to their documentation, it "logs records to a file and creates one logfile per day. It will also delete files older than `$maxFiles`".

But then, their own recommendation is to use "`logrotate`" instead of doing the rotation in the handler as you would have better performance.

 

More details here:

-   <https://github.com/Seldaek/monolog>
-   <http://linuxcommand.org/man_pages/logrotate8.html>

 

If you decided to use Monolog's handler, it can be configured in `app/config/config.yml`

``` brush:
monolog:
    handlers:
        main:
            type: rotating_file
            max_files: 10
            path: "%kernel.logs_dir%/%kernel.environment%.log"
            level: debug
```

#### In this topic:

-   [Introduction](#Devops-Introduction)
    -   [Cache Clearing](#Devops-CacheClearing)
        -   [Clearing file cache using the Symfony cache:clear command](#Devops-ClearingfilecacheusingtheSymfonycache:clearcommand)
        -   [Clearing "Content Cache" on a Cluster setup](#Devops-Clearing%22ContentCache%22onaClustersetup)
    -   [Web Debug Toolbar](#Devops-WebDebugToolbar)
-   [Configuration](#Devops-Configuration)
    -   [Logging and Debug Configuration](#Devops-LoggingandDebugConfiguration)
        -   [Introduction](#Devops-Introduction.1)
        -   [Debugging in dev environment](#Devops-Debuggingindevenvironment)
        -   [Error logging and rotation](#Devops-Errorloggingandrotation)

## Attachments:

![](images/icons/bullet_blue.gif) [webdebugtoolbar.png](attachments/31432029/32868731.png) (image/png)






