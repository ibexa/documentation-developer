# Performance

eZ Platform can be set up to run efficiently on almost any modern configuration.
What follows is a list of recommendation that will make your installation perform better.

!!! note

    All the following recommendations are valid for both development and production setups, unless otherwise noted.

If you are in a hurry, the most important recommendations on this page are:

- Use PHP 7.x, and dump optimized Composer autoload classmap
- Use a full web (Nginx/Apache) server with vhost
- Avoid shared filesystems for code (Docker for Mac/Win, VirtualBox/*, Vagrant, etc.), or find ways to optimize or work around the issues.
- For clustering (mainly relevant for production/staging), reduce latency to Redis/Memcached, use Varnish and [Solr](solr.md).

## Client

- Always use an up-to-date browser and an up-to-date operating system so you have access to latest browser versions
- If possible, use a fast, stable internet connection, because an unreliable connection will slow down UI

## Server

In production setups:

- Always use reverse proxy, and if possible use Varnish.
    - Compared to the built-in Symfony Proxy in PHP Varnish is much faster and is able to queue up requests for the same fresh/invalidated resource.
    - With [ezplatform-http-cache](https://github.com/ezsystems/ezplatform-http-cache) support for xkey and grace Varnish provides more stable performance in read/write scenarios.
- Set up eZ Platform in [cluster mode](clustering.md) if you need to handle bigger spikes of traffic than a single server can manage.
    - See [recommendation for Memcached/Redis](#memcachedredis) and [Search](#search) below.

!!! note

    The following recommendations are ordered from largest to smallest impact they have on performance in general.

### VM

- Avoid shared filesystems for code (Docker for Mac/Win, VirtualBox/*, Vagrant, etc.), because they typically slow down the application 10x or more, compared to native Linux filesystem.
- VM in itself also adds 10-30% of overhead. However when it comes to production, e.g. AWS vs barebones, it also comes down to cost and convenience factors.

!!! tip "For Development use, try eZ Launchpad"

    For a ready solution that allows you to share code between your host and the underlying running VM system without this performance hit, try [eZ Launchpad](https://ezsystems.github.io/launchpad/).

### Web server

- Use Nginx/Apache even for development, as PHP's built-in web server (as exposed via Symfony's `server:*` commands) is only able to handle one request at a time (including JS/CSS/* asset loading, etc.).
- Use a recent version of nginx, set up https, and enable http/2 to reduce connection latency on parallel requests.

### PHP

- Use PHP 7.0 (or, better yet, PHP 7.1 if available).
- Always enable opcache for php-fpm/`mod_php`.
- Prefer php-fpm and web server using it over fast-cgi for lower overall memory usage.

### Composer

- Keep Composer up to date.
- Always dump optimized class map using `composer dump-autoload --optimize` or relevant flags on `composer install/update`.

### Memcached/Redis

- Memcached/Redis is recommended over filesystem cache even with a single server, as it offers better general performance for operations invalidating cache.
    - However, pure read performance is slower, especially if the next point is not optimized.
- If you use Redis, make sure to tune it for in-memory cache usage. Its persistence feature is not needed with eZ Platform cache and will severely slow down execution time.

### Search

- Use [Solr Bundle and Solr](solr.md) to greatly offload your database and get more stable performance on your installation.
