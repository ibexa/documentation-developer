# Performance

## Introduction

eZ Platform can be tuned and set up in different ways so that it is able to run on just about any somewhat modern configuration. What follows is an incomplete list of performance recommendations that we intend to gradually expand upon.

*All tips are valid for both development and production setup unless otherwise noted.*

If you are in a hurry then the single most important recommendations on this page is:

- General: Dump optimized composer autoload classmap
- Dev: Use a full web server with vhost
- Cluster: Reduce latency to Redis/Memcached, use Varnish, and use [Solr](search.md#solr-bundle)

## Client

- Always use an up-to-date browser *(and an up-to-date operating system so you have access to latest browser versions)*
- If possible, use a fast, stable internet connection, a flaky or overcrowded connection will slow down UI

## Server

Overall, for production setup:

- Always use reverse proxy, and strongly prefer to use Varnish.
    - Compared to the built-in Symfony Proxy in php it is much faster, is able to queue up requests coming in for same fresh/invalidated resource
    - With [ezplatform-http-cache](https://github.com/ezsystems/ezplatform-http-cache) support for xkey & grace provides more stable performance in read/write scenarios
- Set up eZ Platform in [cluster mode](clustering.md) if you need to handle more traffic than what a single server can handle on spikes of traffic.
    - See recommendation for Memcached/Redis and Search below

### Web server

- Even for development use Nginx/Apache, as php built-in webserver\* is only able to handle one request at a time.
    - *\* as exposed via Symfony's "`server:*`" commands*
- Use a recent version of Nginx, set up https, and enable http/2 to reduce connection latency on parallel requests.

### PHP

- Always enable opcache for php-fpm/mod\_php.
- Prefer php-fpm and web server using it over fast-cgi for lower overall memory usage.

### Composer

- Keep Composer up to date.
- Always dump optimized class map using `composer dump-autoload --optimize` or relevant flags on `composer install/update`.

### Memcached/Redis

- Memcached/Redis is recommended over filesystem cache even with single server, as it offers overall better performance for operations invalidating cache.
    - But pure read performance is slower, especially if not optimizing next point.
- If you use Redis, make sure to tune it for in-memory cache usage. Its persistence feature is not needed for use with eZ Platform cache and will severely slow down execution time.

### Search

- Use [Solr Bundle and Solr](search.md#solr-bundle) to greatly offload your database and get more stable performance on your install
