# Performance

[[= product_name =]] can be set up to run efficiently on almost any modern configuration.
What follows is a list of recommendation that will make your installation perform better.

!!! note

    All the following recommendations are valid for both development and production setups, unless otherwise noted.

If you are in a hurry, the most important recommendations on this page are:

- Dump optimized Composer autoload classmap
- Use a full web (Nginx/Apache) server with vhost
- Avoid shared filesystems for code (Docker for Mac/Win, VirtualBox/*, Vagrant, etc.), or find ways to optimize or work around the issues.
- For clustering (mainly relevant for production/staging), reduce latency to Redis/Memcached, use Varnish and [Solr](search/solr.md).

## Client

- Always use an up-to-date browser and an up-to-date operating system so you have access to latest browser versions
- If possible, use a fast, stable internet connection, because an unreliable connection will slow down UI

## Server

In production setups:

- Always use reverse proxy, and if possible use Varnish.
    - Compared to the built-in Symfony Proxy in PHP Varnish is much faster and is able to queue up requests for the same fresh/invalidated resource.
    - With [ezplatform-http-cache](https://github.com/ezsystems/ezplatform-http-cache) support for xkey and grace Varnish provides more stable performance in read/write scenarios.
- Set up [[= product_name =]] in [cluster mode](clustering.md) if you need to handle bigger spikes of traffic than a single server can manage.
    - See [recommendation for Memcached/Redis](#memcachedredis) and [Search](#search) below.

!!! note

    The following recommendations are ordered from largest to smallest impact they have on performance in general.

### VM

- Avoid shared filesystems for code (Docker for Mac/Win, VirtualBox/*, Vagrant, etc.), because they typically slow down the application 10x or more, compared to native Linux filesystem.
- VM in itself also adds 10-30% of overhead. However when it comes to production, e.g. AWS vs barebones, it also comes down to cost and convenience factors.

!!! tip "For Development use, try eZ Launchpad"

    For a ready solution that allows you to share code between your host and the underlying running VM system without this performance hit, try [eZ Launchpad](https://ezsystems.github.io/launchpad/), made by and supported by the eZ Community.

### Web server

- Use Nginx/Apache even for development, as PHP's built-in web server (as exposed via Symfony's `server:*` commands) is only able to handle one request at a time (including JS/CSS/* asset loading, etc.).
- Use a recent version of nginx, set up https, and enable http/2 to reduce connection latency on parallel requests.

### PHP

- Always enable opcache for php-fpm/`mod_php`.
- Prefer php-fpm and web server using it over fast-cgi for lower overall memory usage.

### Composer

- Keep Composer up to date.
- Always dump optimized class map using `composer dump-autoload --optimize` or relevant flags on `composer install/update`.

### Memcached/Redis

!!! note

    Redis is currently recommended over Memcached, as the latter has had big performance issues.
    [Symfony v3.4.15](https://github.com/symfony/symfony/pull/28249) may have resolved this.

- Memcached/Redis can in some cases perform better than filesystem cache even with a single server, as it offers better general performance for operations invalidating cache.
    - However, pure read performance is slower, especially if the next points are not optimized.
    - With cache being on different node(s) than web server, make sure to try to tune latency between the two.

!!! tip

    Check if your cloud provider has native service for Memcached/Redis, as those might be better tuned.

- If you use Redis, make sure to tune it for in-memory cache usage. Its persistence feature is not needed with cache and will severely slow down execution time.
    - [For use with sessions](sessions.md#cluster-setup) however, persistence can be a good fit if you want sessions to survive service interruptions.
    - Further tips for Redis with cache can be found in doc regarding [Redis Clustering](persistence_cache.md#redis-clustering).

### Search

- Use [Solr Bundle and Solr](search/solr.md) to greatly offload your database and get more stable performance on your installation.

## Executing long-running console commands

Executing long-running console commands can result in running out of memory.
Two examples of such commands are a custom import command and the indexing command provided by the [Solr Bundle](search/solr.md).

### Reducing memory usage

To avoid quickly running out of memory while executing such commands you should make sure to:

1. Always run in prod environment using: `--env=prod`

    1. See [Environments](../guide/environments.md) for further information on Symfony environments.
    1. See [Logging and debug configuration](../guide/devops.md#logging-and-debug-configuration)
    for some of the different features enabled in development environments, which by design use memory.

1. For logging using monolog, if you use either the default `fingers_crossed`, or `buffer` handler, make sure to specify `buffer_size` to limit how large the buffer grows before it gets flushed:

    ``` yaml
    # config_prod.yaml (partial example)
    monolog:
        handlers:
            main:
                type: fingers_crossed
                buffer_size: 200
    ```

1.  Run PHP without memory limits using: `php -d memory_limit=-1 bin/console <command>`
1.  Disable `xdebug` *(PHP extension to debug/profile php use)* when running the command, this will cause php to use much more memory.

!!! note "Memory will still grow"

    Even when everything is configured like described above, memory will grow for each iteration
    of indexing/inserting a Content item with at least *1kb* per iteration after the initial first 100 rounds.
    This is expected behavior; to be able to handle more iterations you will have to do one or several of the following:

    - Change the import/index script in question to [use process forking](#process-forking-with-symfony) to avoid the issue.
    - Upgrade PHP: *newer versions of PHP are typically more memory-efficient.*
    - Run the console command on a machine with more memory (RAM).

### Process forking with Symfony

The recommended way to completely avoid "memory leaks" in PHP in the first place is to use processes.
For console scripts this is typically done using process forking which is quite easily achievable with Symfony.

The things you will need to do:

1. Change your command so it supports taking slice parameters, like for instance a batch size and a child-offset parameter.
    1. *If defined, child-offset parameter denotes if a process is a child,
    this can be accomplished using two commands as well.*
    2. *If not defined, it is the master process which will execute the processes until nothing is left to process.*

2. Change the command so that the master process takes care of forking child processes in slices.
    1. For execution in-order, [you may look to our platform installer code](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Bundle/PlatformInstallerBundle/src/Command/InstallPlatformCommand.php#L220)
    used to fork out Solr indexing after installation to avoid cache issues.
    2. For parallel execution of the slices, [see Symfony doc for further instruction](http://symfony.com/doc/5.0/components/process.html#process-signals).
