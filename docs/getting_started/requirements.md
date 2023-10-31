# Requirements

The following server requirements cover both running the software on-premise and on third-party PaaS providers.

!!! note "eZ Platform Cloud"

    For running on [eZ Platform Cloud](https://ez.no/Products/eZ-Platform-Cloud), where recommended configuration and support is provided out of the box, see separate [eZ Platform Cloud section](#ez-platform-cloud-requirements-and-setup) for further reading on its requirements.

The minimal setup requires PHP,  MySQL/MariaDB, Apache/Nginx, Node.js and `yarn`.
Recommendation for production setups is to use Varnish/Fastly, Redis/Memcached, NFS/EFS/S3 and Solr in a [clustered setup](../guide/clustering.md).

!!! caution "Recommended versions"

    Review all the recommended versions carefully. If you see a "+" next to the product version, it means that we recommend this version or higher within the same major release. For example, "Nginx 1.18+" means any 1.x version higher or equal to 1.18, but not 2.x.

    Using the latest listed version of each product or component is recommended. Always use a version that receives security updates, either by the vendor themselves or by a trusted third party, such as the distribution vendor.

## Operating system

- Debian 10.x "Buster"
- Ubuntu 18.04 LTS "Bionic"
- RHEL / CentOS 8.x

## Web server

- Nginx 1.12, 1.14, 1.16
- Apache 2.4 (with required modules `mod_rewrite`, `mod_env` and recommended: `mod_setenvif`, `mod_expires`;
event MPM is recommended, if you need to use prefork you also need the `mod_php` module)

## DBMS

- MariaDB 10.3, 10.4 (optionally 10.2 - deprecated)
- MySQL 8.0 (optionally 5.7 - deprecated)
- PostgreSQL 10+ (PostgreSQL 10 has reached its End of Life. We highly recommend using PostgreSQL 14 for optimal performance and security)

## PHP

- 7.1
- 7.2
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

- `php-redis` 3.1.3+ or `php-memcached` 3.x+

## Search

- For content search, Solr 7.7 LTS or Solr 8, recommended 8.11.1 or higher. Alternatively, Elasticsearch 7.16.2 or higher 7.x version.
- For BinaryFile Field indexing, Apache Tika 1.20 or higher 1.x version, recommended 1.28.1 or higher.
- The above solutions require Oracle Java/Open JDK. The minimum requirement is 8 LTS, recommended 11 LTS. Newer versions are not supported.

## Graphic Handler

- GraphicsMagick
- ImageMagick
- GD

## [Clustering](../guide/clustering.md)

- Linux NFS or S3/EFS (for IO, aka binary files stored in content repository, not supported with legacy)
- Redis 3.2+ (separate instances for session and cache, both using a `volatile-*` [eviction policy](https://redis.io/topics/lru-cache), session instance configured for persistence) or [Memcached](https://memcached.org/) 1.5 or higher
- [Varnish](http://varnish-cache.org/) 5.1 or 6.0LTS with [varnish-modules](https://github.com/varnish/varnish-modules/blob/master/README.md) or [Fastly](https://www.fastly.com/) using [the bundle provided with [[= product_name_ee =]]](../guide/cache/http_cache.md#serving-varnish-through-fastly) (for HttpCache)

## Filesystem

- Linux ext4 / XFS

## Package manager

- Composer (recent stable version)

## Asset manager

- `Node.js` 10, 12 or 14
- `yarn` 1.15.2 or higher

## Browser

[[= product_name_base =]] software is developed to work with *any* web browser that supports modern standards, on *any* screen resolution suitable for web, running on *any* device. However for the Editorial and Administration User Interfaces you'll need; a minimum of 1366-by-768 screen resolution, a desktop or tablet device, and a recommended/supported browser among the ones found below.

- Mozilla® Firefox® most recent stable version (recommended)
- Google Chrome™ most recent stable version (recommended)
- Chromium™ based browsers such as Microsoft® Edge® and Opera®, most recent stable version, desktop *and* tablet
- Apple® Safari® most recent stable version, desktop *and* tablet

## eZ Platform Cloud requirements and setup

!!! note "eZ Platform Cloud"

    ### Cloud hosting with eZ Platform Cloud and Platform.sh

    In general, eZ Platform Cloud supports all features and services of [Platform.sh](https://platform.sh/hosting/php/ez) that are compatible and supported by the eZ Platform version you use.  

    For example:

    - Platform.sh provides Redis support for versions 2.8, 3.0 and 3.2. eZ Platform supports Redis version 3.2 or higher. As a result, Redis is supported by eZ Platform Cloud versions 3.2.
    - Platform.sh provides Elastic Search service (different versions supported). Elastic Search is not supported for use as search engine for eZ Platform.

    Features or services supported by eZ Platform but not covered by Platform.sh may be possible by means of a [custom integration](#custom-integrations).

    ### Recommended eZ Platform Cloud setup

    For more details on recommended setup configuration see bundled `.platform.app.yaml` and `.platform/` configuration files.

    These files are kept up-to-date with latest recommendations and can be improved through contributions.

    ### Supported eZ Platform Cloud setup

    Because of the large range of possible configurations of eZ Publish legacy, there is no ready-made recommended setup.
    Make sure to set aside time and budget for:

    - Verifying your legacy configuration and ensuring it is supported by Platform.sh
    - Additional time for adaptation and configuration work, and testing by your own team
    - Additional consulting/onboarding time with Platform.sh, [[= product_name_base =]] technical services, and/or one of the many partners with prior experience using Platform.sh with eZ Publish legacy

    The cost and effort of this is not included in eZ Platform Cloud subscription and will vary depending on the project.

    ### Experimental/custom Platform.sh setups

    Any use of experimental versions or setups is not eligible for use with eZ Platform Cloud.
    However, it is possible to use an eZ Enterprise subscription in combination with a Platform.sh contract,
    where you or a partner take ownership of the configuration to set up the project.

    Such projects are possible by means of custom integrations/configuration,
    but they may generate issues that won't be covered by eZ Enterprise subscription bug fix guarantee.

    !!! tip "Use a partner with prior experience on legacy and Platform.sh"

        If you are in need of setting up your legacy project on Platform.sh for a transitional period,
        eZ can put you in contact with a partner experienced in setting up older projects on Platform.sh.
        This will save you a lot of time and effort.
        
    !!! note

        As Platform.sh does not support a configuration with multiple PostgreSQL databases,
        for eZ Platform Cloud / Platform.sh it is impossible to have a DFS table in a separate database.

    ### Custom integrations

    Features supported by eZ Platform, but not natively by Platform.sh, can in many cases be used by means of custom integrations with external services.

    For example, you can create an integration with S3 by means of setting up your own S3 bucket and configuring the relevant parts of eZ Platform.
    We recommend giving the development team working on the project access to the bucket
    to ensure work is done in a DevOps way without depending on external teams when changes are needed.
