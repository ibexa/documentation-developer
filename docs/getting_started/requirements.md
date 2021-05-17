# Requirements

The following server requirements cover both running the software on-premise and on third-party PaaS providers.

!!! note "eZ Platform Cloud"

    For running on [eZ Platform Cloud](https://ez.no/Products/eZ-Platform-Cloud), where recommended configuration and support is provided out of the box, see separate [eZ Platform Cloud section](#ez-platform-cloud-requirements-and-setup) for further reading on its requirements.

The minimal setup requires PHP,  MySQL/MariaDB, Apache/Nginx.
Recommendation for production setups is to use Varnish/Fastly, Redis/Memcached, NFS/EFS/S3 and Solr in a [clustered setup](../guide/clustering.md).

Using the latest listed version of each product or component is always recommended.

## Operating system

- Debian 9.x "Stretch"
- Ubuntu 16.04LTS "Xenial" / 18.04LTS "Bionic"
- RHEL / CentOS 7.x

## Web server

- Nginx 1.10, 1.12, 1.14
- Apache 2.4 (with required modules `mod_rewrite`, `mod_env` and recommended: `mod_setenvif`, `mod_expires`;
event MPM is recommended, if you need to use prefork you also need the `mod_php` module)

## DBMS

- MariaDB 5.5 (new enough to support `utf8mb4` character set), 10.0, 10.1, 10.2, 10.3 (the latter two not recommended with Legacy Bridge)
- MySQL 5.5.3, 5.6, 5.7
- PostgreSQL 10+

## PHP

- 5.6
- 7.0
- 7.1
- 7.2
- 7.3

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

- `php-redis` 3.1.3+ or `php-memcached` 3.x on PHP 7, 2.2 on PHP 5

## Search

- Solr 4.10, 6.6LTS

## Graphic Handler

- GraphicsMagick
- ImageMagick
- GD

## [Clustering](../guide/clustering.md)

- Linux NFS or S3/EFS (for IO, aka binary files stored in content repository, not supported with legacy)
- Redis 3.0+ (separate instances for session and cache, both using a `volatile-*` [eviction policy](https://redis.io/topics/lru-cache), session instance configured for persistence) or [Memcached](https://memcached.org/) 1.5 or higher
- [Varnish](http://varnish-cache.org/) 4.1 with [varnish-modules](https://github.com/varnish/varnish-modules/blob/master/README.md) or [Fastly](https://www.fastly.com/) using [the bundle provided with [[= product_name_ee =]]](../guide/http_cache.md#serving-varnish-through-fastly) (for HttpCache)

## Filesystem

- Linux ext4 / XFS

## Package manager

- Composer (recent stable version)

## Browser

Ibexa software is developed to work with *any* web browser that supports modern standards, on *any* screen resolution suitable for web, running on *any* device. However for the Editorial and Administration User Interfaces you'll need; a minimum of 1024-by-768 screen resolution, a desktop or tablet device, and a recommended/supported browser among the ones found below.

- Mozilla® Firefox® most recent stable version (recommended)
- Google Chrome™ most recent stable version (recommended)
- Chromium™ based browsers such as Microsoft® Edge® and Opera®, most recent stable version, desktop *and* tablet
- Apple® Safari® most recent stable version, desktop *and* tablet

## eZ Platform Cloud requirements and setup

!!! note "eZ Platform Cloud"

    ### Cloud hosting with eZ Platform Cloud and Platform.sh

    In general, eZ Platform Cloud supports all features and services of [Platform.sh](https://platform.sh/hosting/php/ez) that are compatible and supported by the eZ Platform version you use.  

    For example:

    - Platform.sh provides Redis support for versions 2.8, 3.0 and 3.2. eZ Platform supports Redis version 3.0 or higher. As a result, Redis is supported by eZ Platform Cloud versions 3.0 and 3.2.
    - Platform.sh provides Elastic Search service (different versions supported). eZ Platform 1.13 *does not* officially support Elastic Search. As a result, Elastic Search is not supported for use as search engine for eZ Platform (1.13).

    Features or services supported by eZ Platform but not covered by Platform.sh may be possible by means of a [custom integration](#custom-integrations).

    ### eZ Platform Cloud Setup support matrix

    |Setup|Description|eZ Platform Cloud support|
    |-----|-----|-----|
    |Recommended setup|**eZ Platform**</br>eZ Platform setup, with no use of legacy.|eZ Platform software plus cloud hosting infrastructure is supported by eZ for version 1.13 and higher</br></br>Recommended configuration provided out of the box and fully supported, on-boarding help available.|
    |Supported setup|**Legacy Bridge setup**</br>eZ Publish 5.x-like setup where web traffic goes to eZ Platform/Symfony and Legacy Bundle provides legacy fallback features.</br>Notably it allows among other things enabling a "Legacy mode" where legacy bundle lets legacy take over handling of URL aliases.|Installation and cloud is supported by eZ for version 1.13 and 2.x</br></br>Review and potential adaptation of the application configuration to be performed by eZ Systems technical services prior to deployments. The cost and effort of this review and potential adaptation is not included in eZ Platform Cloud subscription and will vary depending on each project's specificities.</br></br>*NOTE: Advanced legacy features like ezfind, Async publishing, ezodf, S3, and similar go under 'Experimental setup', to avoid this migrate to similar eZ Platform features.*|
    |Experimental setup|**eZ Publish, eZ Publish Platform and other pure legacy setups**</br>eZ Publish (version 4.x) or eZ Publish Platform (version 5.x) standalone setup or an experimental setup with eZ Platform and Legacy Bridge.|Not covered by eZ Platform Cloud subscription.</br></br>The use of Platform.sh service is possible as a standalone service and can be used to bridge migration needs. We recommend involving an eZ business partner that has experience with setting up legacy projects on Platform.sh|

    ### Recommended eZ Platform Cloud setup

    For more details on recommended setup configuration see bundled `.platform.app.yaml` and `.platform/` configuration files.

    These files are kept up-to-date with latest recommendations and can be improved through contributions.

    ### Supported eZ Platform Cloud setup

    Because of the large range of possible configurations of eZ Publish legacy, there is no ready-made recommended setup.
    Make sure to set aside time and budget for:

    - Verifying your legacy configuration and ensuring it is supported by Platform.sh
    - Additional time for adaptation and configuration work, and testing by your own team
    - Additional consulting/onboarding time with Platform.sh, Ibexa technical services, and/or one of the many partners with prior experience using Platform.sh with eZ Publish legacy

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

    !!! tip "How to move to a supported setup with relatively low effort"

        If you would like to use a supported setup but need to run legacy code,
        consider upgrading to eZ Platform with Legacy Bridge, using PHP 7 to avoid legacy admin getting slower.

        Until you are ready for full migration you can continue to use legacy admin
        and operate your front end(s) in legacy mode or partial legacy mode (Symfony pagelayout with fallbacks to legacy)
        This makes your project ready to perform a gradual migration to eZ Platform.

        eZ Systems offers enablement and technical services to help you perform such an upgrade, and helps you plan for the follow-up migration.

    ### Custom integrations

    Features supported by eZ Platform, but not natively by Platform.sh, can in many cases be used by means of custom integrations with external services.

    For example, you can create an integration with S3 by means of setting up your own S3 bucket and configuring the relevant parts of eZ Platform.
    We recommend giving the development team working on the project access to the bucket
    to ensure work is done in a DevOps way without depending on external teams when changes are needed.
