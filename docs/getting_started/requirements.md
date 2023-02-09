---
description: System, component and package requirements for running Ibexa DXP.
---

# Requirements

The following server requirements cover both running the software on-premise and on third-party PaaS providers.

!!! note "Ibexa Cloud"

    For running on [Ibexa Cloud](https://www.ibexa.co/products/ibexa-cloud), where recommended configuration and support is provided out of the box, see separate [Ibexa Cloud section](#ibexa-cloud-requirements-and-setup) for further reading on its requirements.

The minimal setup requires PHP, MySQL/MariaDB, Apache/Nginx, Node.js and `yarn`.
Recommendation for production setups is to use Varnish/Fastly, Redis/Memcached, NFS/EFS/S3 and Solr/Elasticsearch in a [clustered setup](clustering.md).

!!! note "Recommended versions"

    Using the latest listed version of each product or component is always recommended. Review all the recommended versions carefully. If you see a "+" next to the product version, it means that we recommend this version or higher within the same major release. For example, "Nginx 1.18+" means any 1.x version higher or equal to 1.18, but not 2.x.

## Operating system

- Debian 10.x "buster" or Debian 11.x "bullseye"
- Ubuntu 20.04 "Focal Fossa"
- RHEL / CentOS 8.1+

## Web server

- Nginx 1.18+
- Apache 2.4 (with required modules `mod_rewrite`, `mod_env` and recommended: `mod_setenvif`, `mod_expires`;
event MPM is recommended, if you need to use prefork you also need the `mod_php` module)

## DBMS

- MariaDB 10.3+
- MySQL 8.0
- PostgreSQL 10+

## PHP

- 8.1
- 8.0
- 7.4 (PHP 7.4 has reached its End of Life. Unless you have extended support from vendors like Debian or Zend, you should use PHP 8.1)

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

- For content search, Solr 7.7 LTS or Solr 8, recommended 8.11.1 or higher. Alternatively, Elasticsearch 7.16.2 or higher 7.x version.
- For BinaryFile Field indexing, Apache Tika 1.20 or higher 1.x version, recommended 1.28.1 or higher.
- The above solutions require Oracle Java/Open JDK. The minimum requirement is 8 LTS, recommended 11 LTS. Newer versions are not supported.

## Graphic Handler

- GraphicsMagick
- ImageMagick
- GD

Optionally if you intend to edit [PNG, SVG, GIF or WEBP files in the Image Editor](images.md#image-optimization), or use it with image variations:

- JpegOptim
- Optipng
- Pngquant 2
- SVGO 1
- Gifsicle
- cwebp

## [Clustering](clustering.md)

- Linux NFS or S3/EFS (for IO, aka binary files stored in content repository, not supported with legacy)
- Redis 4.0+, 5.0 or higher (separate instances for session and cache, both using a `volatile-*` [eviction policy](https://redis.io/topics/lru-cache), session instance configured for persistence) or [Memcached](https://memcached.org/) 1.5 or higher
- [Varnish](http://varnish-cache.org/) 6.0LTS or 7.1 with [varnish-modules](https://github.com/varnish/varnish-modules/blob/master/README.md) or [Fastly](https://www.fastly.com/) using [the provided bundle](http_cache.md#serving-varnish-through-fastly) (for HttpCache)

## Filesystem

- Linux ext4 / XFS

## Package manager

- Composer: recent 2.1 version

## Asset manager

- `Node.js` 14+, 16+
- `yarn` 1.15.2+

## Browser

[[= product_name =]] is developed to work with *any* web browser that supports modern standards, on *any* screen resolution suitable for web, running on *any* device. However for the Editorial and Administration User Interfaces you'll need; a minimum of 1366-by-768 screen resolution, a desktop or tablet device, and a recommended/supported browser among the ones found below.

- Mozilla® Firefox® most recent stable version (recommended)
- Google Chrome™ most recent stable version (recommended)
- Chromium™ based browsers such as Microsoft® Edge® and Opera®, most recent stable version, desktop *and* tablet
- Apple® Safari® most recent stable version, desktop *and* tablet

## Ibexa Cloud requirements and setup

!!! note "Ibexa Cloud"

    ### Cloud hosting with Ibexa Cloud and Platform.sh

    In general, Ibexa Cloud supports all features and services of [Platform.sh](https://platform.sh/hosting/php/ez) that are compatible and supported by the [[= product_name =]] version you use.  

    For example:

    - Platform.sh provides Redis support for versions 3.2, 4.0 and 5.0. [[= product_name =]] supports Redis version 4.0 or higher, and recommends 5.0. As a result, Redis is supported on Ibexa Cloud in versions 4.0 and 5.0, but 5.0 is recommended.

    Features or services supported by [[= product_name =]] but not covered by Platform.sh may be possible by means of a [custom integration](#custom-integrations).

    ### Ibexa Cloud Setup support matrix

    All [[= product_name =]] features are supported in accordance with the example above. For example: As Legacy Bridge is not supported with v3, it is not supported on Ibexa Cloud either.

    !!! note

        As Platform.sh does not support a configuration with multiple PostgreSQL databases,
        for Ibexa Cloud / Platform.sh it is impossible to have a DFS table in a separate database.

    ### Recommended Ibexa Cloud setup

    For more details on recommended setup configuration see bundled `.platform.app.yaml` and `.platform/` configuration files.

    These files are kept up-to-date with latest recommendations and can be improved through contributions.

    ### Supported Ibexa Cloud setup

    Because of the large range of possible configurations of [[= product_name =]], there are many possibilities beyond what is provided in the default recommended configuration.

    Make sure to set aside time and budget for:

    - Verifying your requirements and ensuring they are supported by Platform.sh
    - Additional time for adaptation and configuration work, and testing by your development team
    - Additional consulting/onboarding time with Platform.sh, Ibexa technical services, and/or one of the many partners with prior experience using Platform.sh with [[= product_name =]]

    The cost and effort of this is not included in Ibexa Cloud subscription and will vary depending on the project.

    ### Custom integrations

    Features supported by [[= product_name =]], but not natively by Platform.sh, can in many cases be used by means of custom integrations with external services.

    For example, you can create an integration with S3 by means of setting up your own S3 bucket and configuring the relevant parts of [[= product_name =]].
    We recommend giving the development team working on the project access to the bucket
    to ensure work is done in a DevOps way without depending on external teams when changes are needed.
