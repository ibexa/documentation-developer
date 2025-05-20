---
description: System, component and package requirements for running Ibexa DXP.
month_change: false
---

<!-- vale off -->

# Requirements

This document covers all supported versions of the product.
To review the requirements, select the specific version of [[= product_name =]] you're interested in.

The following server requirements cover both running the software on-premise and on third-party PaaS providers.

!!! note "[[= product_name_cloud =]]"

    For running on [[[= product_name_cloud =]]](https://www.ibexa.co/products/ibexa-cloud), where recommended configuration and support is provided out of the box, see separate [[[= product_name_cloud =]] section](#ibexa-cloud-requirements-and-setup) for further reading on its requirements.

The minimal setup requires PHP, MySQL/MariaDB, Apache/Nginx, Node.js and `yarn`.
Recommendation for production setups is to use Varnish/Fastly, Redis/Memcached, NFS/EFS/S3 and Solr/Elasticsearch in a [clustered setup](clustering.md).

!!! caution "Recommended versions"

    Review all the recommended versions carefully.
    If you see a "+" next to the product version, it means that we recommend this version or higher within the same major release.
    For example, "1.18+" means any 1.x version higher or equal to 1.18, but not 2.x.

    Using the latest listed version of each product or component is recommended.
    Always use a version that receives security updates, either by the vendor themselves or by a trusted third party, such as the distribution vendor.

## Operating system

=== "[[= product_name =]] v4.6"

    |Name|Version|
    |---|---|
    |Debian 10 "Buster" |10.0-10.13+|
    |Debian 11 "Bullseye"|11.0-11.7+|
    |Ubuntu  "Focal Fossa" | 20.04 |
    |Ubuntu "Jammy Jellyfish"| 22.04 |
    |Ubuntu "Noble Numbat"| 24.04 |
    |RHEL / CentOS / CentOS Stream | 8.1-9.5+ |

    If you see a "+" next to the product version, it indicates a recommended version or higher within the same major release.
    For example, "1.18+" means any 1.x version equal to or higher than 1.18, but not 2.x.

=== "[[= product_name =]] v3.3"

    |Name|Version|
    |---|---|
    |Debian 10 "Buster" |10.0-10.13+|
    |Debian 11 "Bullseye"|11.0-11.7+|
    |Ubuntu  "Focal Fossa" | 20.04 |
    |Ubuntu "Jammy Jellyfish"| 22.04 |
    |RHEL / CentOS | 8.1-8.5+ |

    If you see a "+" next to the product version, it indicates a recommended version or higher within the same major release.
    For example, "1.18+" means any 1.x version equal to or higher than 1.18, but not 2.x.

## Web server

=== "[[= product_name =]] v4.6"

    - Nginx 1.18-1.25+
    - Apache 2.4 (with required modules `mod_rewrite`, `mod_env` and recommended: `mod_setenvif`, `mod_expires`;
    event MPM is recommended, if you need to use prefork you also need the `mod_php` module)

    If you see a "+" next to the product version, it indicates a recommended version or higher within the same major release.
    For example, "1.18+" means any 1.x version equal to or higher than 1.18, but not 2.x.

=== "[[= product_name =]] v3.3"

    - Nginx 1.18
    - Apache 2.4 (with required modules `mod_rewrite`, `mod_env` and recommended: `mod_setenvif`, `mod_expires`;
    event MPM is recommended, if you need to use prefork you also need the `mod_php` module)

## DBMS

=== "[[= product_name =]] v4.6"

    - MariaDB 10.3-10.11+
    - MySQL 8.0+
    - PostgreSQL 14

    If you see a "+" next to the product version, it indicates a recommended version or higher within the same major release.
    For example, "1.18+" means any 1.x version equal to or higher than 1.18, but not 2.x.

=== "[[= product_name =]] v3.3"

    - MariaDB  10.3, 10.4 (optionally 10.2 - deprecated)
    - MySQL  8.0 (optionally 5.7 - deprecated)
    - PostgreSQL 10+ (PostgreSQL 10 has reached its End of Life. We highly recommend using PostgreSQL 14 for optimal performance and security)

    If you see a "+" next to the product version, it indicates a recommended version or higher within the same major release.
    For example, "1.18+" means any 1.x version equal to or higher than 1.18, but not 2.x.

## PHP

=== "[[= product_name =]] v4.6"

    - 8.3
    - 8.2
    - 8.1
    - 8.0 (PHP 8.0 has reached its End of Life. Unless you have extended support from vendors like Debian or Zend, you should use PHP 8.1)
    - 7.4 (PHP 7.4 has reached its End of Life. Unless you have extended support from vendors like Debian or Zend, you should use PHP 8.1)

=== "[[= product_name =]] v3.3"

    - 8.3
    - 8.2
    - 8.1
    - 8.0 (PHP 8.0 has reached its End of Life. Unless you have extended support from vendors like Debian or Zend, you should use PHP 8.1)
    - 7.4 (PHP 7.4 has reached its End of Life. Unless you have extended support from vendors like Debian or Zend, you should use PHP 8.1)
    - 7.3 (PHP 7.3 has reached its End of Life. Unless you have extended support from vendors like Debian or Zend, you should use PHP 8.1)

### PHP extensions

=== "[[= product_name =]] v4.6"

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
    - `php-sodium`
    - `php-bcmath`

=== "[[= product_name =]] v3.3"

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
    - `php-sodium`

### Cluster PHP extensions

=== "[[= product_name =]] v4.6"

    - `php-redis` or `php-memcached`

=== "[[= product_name =]] v3.3"

    - `php-redis` or `php-memcached`

## Search

=== "[[= product_name =]] v4.6"

    - For content search, Solr 7.7 LTS or Solr 8, recommended 8.11.1 or higher.
    Alternatively, Elasticsearch 7.16.2 or higher 7.x version.
    - The above solutions require Oracle Java/Open JDK. The minimum requirement is 8 LTS, recommended 11 LTS.
    Newer versions aren't supported.

=== "[[= product_name =]] v3.3"

    - For content search, Solr 7.7 LTS or Solr 8, recommended 8.11.1 or higher.
    Alternatively, Elasticsearch 7.16.2 or higher 7.x version.
    - For BinaryFile field indexing, Apache Tika 1.20 or higher 1.x version, recommended 1.28.1 or higher.
    - The above solutions require Oracle Java/Open JDK. The minimum requirement is 8 LTS, recommended 11 LTS. Newer versions aren't supported.

## Graphic Handler

=== "[[= product_name =]] v4.6"

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

=== "[[= product_name =]] v3.3"

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

=== "[[= product_name =]] v4.6"

    - Linux NFS or S3/EFS (for IO, aka binary files stored in content repository, not supported with legacy)
    - Redis 4.0+, 5.0 or higher (separate instances for session and cache, both using a `volatile-*` [eviction policy](https://redis.io/docs/latest/develop/reference/eviction/), session instance configured for persistence) or [Memcached](https://memcached.org/) 1.5 or higher
    - [Varnish](http://varnish-cache.org/) 6.0LTS or 7.1 with [varnish-modules](https://github.com/varnish/varnish-modules/blob/master/README.md) or [Fastly](https://www.fastly.com/) using [the provided bundle](http_cache.md) (for HTTP Cache)

    If you see a "+" next to the product version, it indicates a recommended version or higher within the same major release.
    For example, "1.18+" means any 1.x version equal to or higher than 1.18, but not 2.x.

=== "[[= product_name =]] v3.3"

    - Linux NFS or S3/EFS (for IO, aka binary files stored in content repository, not supported with legacy)
    - Redis 4.0+, 5.0 or higher (separate instances for session and cache, both using a `volatile-*` [eviction policy](https://redis.io/docs/latest/develop/reference/eviction/), session instance configured for persistence) or [Memcached](https://memcached.org/) 1.5 or higher
    - [Varnish](http://varnish-cache.org/) 6.0LTS with [varnish-modules](https://github.com/varnish/varnish-modules/blob/master/README.md) or [Fastly](https://www.fastly.com/) using [the provided bundle](https://doc.ibexa.co/en/3.3/guide/cache/http_cache/) (for HTTP Cache)

    If you see a "+" next to the product version, it indicates a recommended version or higher within the same major release.
    For example, "1.18+" means any 1.x version equal to or higher than 1.18, but not 2.x.

## Filesystem

=== "[[= product_name =]] v4.6"

    - Linux ext4 / XFS

=== "[[= product_name =]] v3.3"

    - Linux ext4 / XFS

## Package manager

=== "[[= product_name =]] v4.6"

    - Composer: recent 2.7 version

=== "[[= product_name =]] v3.3"

    - Composer: recent 2.1 version

## Asset manager

=== "[[= product_name =]] v4.6"

    - `Node.js` 18+, 20+, 22+
    - `yarn` 1.15.2+

    If you see a "+" next to the product version, it indicates a recommended version or higher within the same major release.
    For example, "1.18+" means any 1.x version equal to or higher than 1.18, but not 2.x.

=== "[[= product_name =]] v3.3"

    - `Node.js` 14+, 16+, 18+ (`Node.js` 14+ has reached its End of Life.
    We strongly recommend using a newer version to ensure you receive security updates.)
    - `yarn` 1.15.2+

    If you see a "+" next to the product version, it indicates a recommended version or higher within the same major release.
    For example, "1.18+" means any 1.x version equal to or higher than 1.18, but not 2.x.

## Browser

=== "[[= product_name =]] v4.6"

    [[= product_name =]] is developed to work with *any* web browser that supports modern standards, on *any* screen resolution suitable for web, running on *any* device.
    However for the Editorial and Administration User Interfaces you need: a minimum of 1366-by-768 screen resolution, a desktop or tablet device, and a recommended/supported browser among the ones found below.

    - Mozilla® Firefox® most recent stable version (recommended)
    - Google Chrome™ most recent stable version (recommended)
    - Chromium™ based browsers such as Microsoft® Edge® and Opera®, most recent stable version, desktop *and* tablet
    - Apple® Safari® most recent stable version, desktop *and* tablet

=== "[[= product_name =]] v3.3"

    [[= product_name =]] is developed to work with *any* web browser that supports modern standards, on *any* screen resolution suitable for web, running on *any* device.
    However for the Editorial and Administration User Interfaces you need: a minimum of 1366-by-768 screen resolution, a desktop or tablet device, and a recommended/supported browser among the ones found below.

    - Mozilla® Firefox® most recent stable version (recommended)
    - Google Chrome™ most recent stable version (recommended)
    - Chromium™ based browsers such as Microsoft® Edge® and Opera®, most recent stable version, desktop *and* tablet
    - Apple® Safari® most recent stable version, desktop *and* tablet

## [[= product_name_cloud =]] requirements and setup

=== "[[= product_name =]] v4.6"

    ### Cloud hosting with [[= product_name_cloud =]] and Platform.sh

    In general, [[= product_name_cloud =]] supports all features and services of [Platform.sh](https://platform.sh/marketplace/ibexa/) that are compatible and supported by the [[= product_name =]] version you use.

    For example:

    - Platform.sh provides Redis support for versions 3.2, 4.0 and 5.0. [[= product_name =]] supports Redis version 4.0 or higher, and recommends 5.0.
    As a result, Redis is supported on [[= product_name_cloud =]] in versions 4.0 and 5.0, but 5.0 is recommended.

    Features or services supported by [[= product_name =]] but not covered by Platform.sh may be possible by means of a [custom integration](#custom-integrations).

    ### [[= product_name_cloud =]] Setup support matrix

    All [[= product_name =]] features are supported in accordance with the example above.
    For example: As Legacy Bridge isn't supported with v3, it's not supported on [[= product_name_cloud =]] either.

    !!! note

        As Platform.sh doesn't support a configuration with multiple PostgreSQL databases, for [[= product_name_cloud =]] / Platform.sh it's impossible to have a DFS table in a separate database.

    ### Recommended [[= product_name_cloud =]] setup

    For more details on recommended setup configuration see bundled `.platform.app.yaml` and `.platform/` configuration files.

    These files are kept up-to-date with latest recommendations and can be improved through contributions.

    ### Supported [[= product_name_cloud =]] setup

    Because of the large range of possible configurations of [[= product_name =]], there are many possibilities beyond what is provided in the default recommended configuration.

    Make sure to set aside time and budget for:

    - Verifying your requirements and ensuring they're supported by Platform.sh
    - Additional time for adaptation and configuration work, and testing by your development team
    - Additional consulting/onboarding time with Platform.sh, Ibexa technical services, and/or one of the many partners with prior experience in using Platform.sh with [[= product_name =]]

    The cost and effort of this isn't included in [[= product_name_cloud =]] subscription and is vary depending on the project.

    ### Custom integrations

    Features supported by [[= product_name =]], but not natively by Platform.sh, can in many cases be used by means of custom integrations with external services.

    For example, you can create an integration with S3 by means of setting up your own S3 bucket and configuring the relevant parts of [[= product_name =]].
    We recommend giving the development team working on the project access to the bucket to ensure work is done in a DevOps way without depending on external teams when changes are needed.

=== "[[= product_name =]] v3.3"

    ### Cloud hosting with [[= product_name_cloud =]] and Platform.sh

    In general, [[= product_name_cloud =]] supports all features and services of [Platform.sh](https://platform.sh/marketplace/ibexa/) that are compatible and supported by the [[= product_name =]] version you use.

    For example:

    - Platform.sh provides Redis support for versions 3.2, 4.0 and 5.0. [[= product_name =]] supports Redis version 4.0 or higher, and recommends 5.0.
    As a result, Redis is supported on [[= product_name_cloud =]] in versions 4.0 and 5.0, but 5.0 is recommended.

    Features or services supported by [[= product_name =]] but not covered by Platform.sh may be possible by means of a [custom integration](#custom-integrations_1).

    ### [[= product_name_cloud =]] Setup support matrix

    All [[= product_name =]] features are supported in accordance with the example above.
    For example: As Legacy Bridge isn't supported with v3, it's not supported on [[= product_name_cloud =]] either.

    !!! note

        As Platform.sh doesn't support a configuration with multiple PostgreSQL databases, for [[= product_name_cloud =]] / Platform.sh it's impossible to have a DFS table in a separate database.

    ### Recommended [[= product_name_cloud =]] setup

    For more details on recommended setup configuration see bundled `.platform.app.yaml` and `.platform/` configuration files.

    These files are kept up-to-date with latest recommendations and can be improved through contributions.

    ### Supported [[= product_name_cloud =]] setup

    Because of the large range of possible configurations of [[= product_name =]], there are many possibilities beyond what is provided in the default recommended configuration.

    Make sure to set aside time and budget for:

    - Verifying your requirements and ensuring they're supported by Platform.sh
    - Additional time for adaptation and configuration work, and testing by your development team
    - Additional consulting/onboarding time with Platform.sh, Ibexa technical services, and/or one of the many partners with prior experience in using Platform.sh with [[= product_name =]]

    The cost and effort of this isn't included in [[= product_name_cloud =]] subscription and is vary depending on the project.

    ### Custom integrations

    Features supported by [[= product_name =]], but not natively by Platform.sh, can in many cases be used by means of custom integrations with external services.

    For example, you can create an integration with S3 by means of setting up your own S3 bucket and configuring the relevant parts of [[= product_name =]].
    We recommend giving the development team working on the project access to the bucket to ensure work is done in a DevOps way without depending on external teams when changes are needed.
