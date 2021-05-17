# Requirements

The following server requirements cover both running the software on-premise and on third-party PaaS providers.

!!! note "eZ Platform Cloud"

    For running on [eZ Platform Cloud](https://ez.no/Products/eZ-Platform-Cloud), where recommended configuration and support is provided out of the box, see separate [eZ Platform Cloud section](#ez-platform-cloud-requirements-and-setup) for further reading on its requirements.

The minimal setup requires PHP,  MySQL/MariaDB, Apache/Nginx, Node.js and `yarn`.
Recommendation for production setups is to use Varnish/Fastly, Redis/Memcached, NFS/EFS/S3 and Solr/Elasticsearch (excluding eZ Commerce) in a [clustered setup](../guide/clustering.md).

Using the latest listed version of each product or component is always recommended.

## Operating system

- Debian 10.x "Buster"
- Ubuntu 20.04 "Focal Fossa"
- RHEL / CentOS 8.1+

## Web server

- Nginx 1.12, 1.14, 1.16
- Apache 2.4 (with required modules `mod_rewrite`, `mod_env` and recommended: `mod_setenvif`, `mod_expires`;
event MPM is recommended, if you need to use prefork you also need the `mod_php` module)

## DBMS

- MariaDB 10.2, 10.3, 10.4
- MySQL 5.7 or 8.0
- PostgreSQL 10+

## PHP

- 7.3
- 7.4

### PHP packages

- `php-cli`
- `php-fpm`
- `php-mysql` (`php-mysqlnd`) or `php-pgsql`
- `php-xml`
- `php-mbstring`
- `php-json`
- `php-process` (on RHEL/CentOS)
- `php-intl`
- `php-curl`
- `php-pear` (optional, provides pecl)
- `php-gd` or `php-imagick` (via pecl on RHEL/CentOS)

### Cluster PHP packages

- `php-redis` or `php-memcached`

## Search

- Solr 7.7LTS or Solr 8
- Elasticsearch 7.7 (excluding eZ Commerce), using Oracle Java/Open JDK 8 or higher

## Graphic Handler

- GraphicsMagick
- ImageMagick
- GD

## [Clustering](../guide/clustering.md)

- Linux NFS or S3/EFS (for IO, aka binary files stored in content repository, not supported with legacy)
- Redis 4.0+, 5.0 or higher (separate instances for session and cache, both using a `volatile-*` [eviction policy](https://redis.io/topics/lru-cache), session instance configured for persistence) or [Memcached](https://memcached.org/) 1.5 or higher
- [Varnish](http://varnish-cache.org/) 6.0LTS with [varnish-modules](https://github.com/varnish/varnish-modules/blob/master/README.md) or [Fastly](https://www.fastly.com/) using [the bundle provided with [[= product_name_ee =]]](../guide/http_cache.md#serving-varnish-through-fastly) (for HttpCache)

## Filesystem

- Linux ext4 / XFS

## Package manager

- Composer (recent stable version)

## Asset manager

- `Node.js` 10 or higher
- `yarn` 1.15.2 or higher

## Browser

Ibexa software is developed to work with *any* web browser that supports modern standards, on *any* screen resolution suitable for web, running on *any* device. However for the Editorial and Administration User Interfaces you'll need; a minimum of 1366-by-768 screen resolution, a desktop or tablet device, and a recommended/supported browser among the ones found below.

- Mozilla® Firefox® most recent stable version (recommended)
- Google Chrome™ most recent stable version (recommended)
- Chromium™ based browsers such as Microsoft® Edge® and Opera®, most recent stable version, desktop *and* tablet
- Apple® Safari® most recent stable version, desktop *and* tablet

## eZ Platform Cloud requirements and setup

!!! note "eZ Platform Cloud"

    ### Cloud hosting with eZ Platform Cloud and Platform.sh

    In general, eZ Platform Cloud supports all features and services of [Platform.sh](https://platform.sh/hosting/php/ez) that are compatible and supported by the [[= product_name_oss =]] version you use.  

    For example:

    - Platform.sh provides Redis support for versions 3.2, 4.0 and 5.0. [[= product_name_oss =]] supports Redis version 4.0 or higher, and recommends 5.0. As a result, Redis is supported on eZ Platform Cloud in versions 4.0 and 5.0, but 5.0 is recommended.

    Features or services supported by [[= product_name_oss =]] but not covered by Platform.sh may be possible by means of a [custom integration](#custom-integrations).

    ### eZ Platform Cloud Setup support matrix

    All [[= product_name_oss =]] features are supported in accordance with the example above. For example: As Legacy Bridge is not supported with v3, it is not supported on eZ Platform Cloud either.

    !!! note

        As Platform.sh does not support a configuration with multiple PostgreSQL databases,
        for eZ Platform Cloud / Platform.sh it is impossible to have a DFS table in a separate database.

    ### Recommended eZ Platform Cloud setup

    For more details on recommended setup configuration see bundled `.platform.app.yaml` and `.platform/` configuration files.

    These files are kept up-to-date with latest recommendations and can be improved through contributions.

    ### Supported eZ Platform Cloud setup

    Because of the large range of possible configurations of [[= product_name_oss =]], there are many possibilities beyond what is provided in the default recommended configuration.

    Make sure to set aside time and budget for:

    - Verifying your requirements and ensuring they are supported by Platform.sh
    - Additional time for adaptation and configuration work, and testing by your development team
    - Additional consulting/onboarding time with Platform.sh, Ibexa technical services, and/or one of the many partners with prior experience using Platform.sh with [[= product_name_oss =]]

    The cost and effort of this is not included in eZ Platform Cloud subscription and will vary depending on the project.

    ### Custom integrations

    Features supported by [[= product_name_oss =]], but not natively by Platform.sh, can in many cases be used by means of custom integrations with external services.

    For example, you can create an integration with S3 by means of setting up your own S3 bucket and configuring the relevant parts of [[= product_name_oss =]].
    We recommend giving the development team working on the project access to the bucket
    to ensure work is done in a DevOps way without depending on external teams when changes are needed.
