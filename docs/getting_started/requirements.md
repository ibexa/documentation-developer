# Requirements

The following server requirements cover both running the software on-premise and on third-party PaaS providers.

!!! cloud "eZ Platform Cloud"

    For running on [eZ Platform Cloud](https://ez.no/Products/eZ-Platform-Cloud), where recommended configuration and support is provided out of the box, see separate [eZ Platform Cloud section](#ez-platform-cloud-requirements-and-setup) for further reading on its requirements.

## Server

Ibexa software is built to rely on existing technologies and standards. The minimal setup is `PHP`,  `MySQL/MariaDB`, `Apache/Nginx`, `Node.js` and `yarn`. Recommendation for production setups is to use `Varnish`/`Fastly`, `Redis`, `NFS`/`EFS`/`S3` and `Solr` in a [clustered setup](../guide/clustering.md).

For supported versions of these technologies see Recommended and Supported setups below.

### Recommended setups

These setups are tested by QA and are generally recommended setups. For security and performance we furthermore recommend use of the newer versions of components below unless otherwise noted.

||Debian|Ubuntu|RHEL / CentOS|
|------|------|------|------|
|Operating system|10.x "Buster"|18.04 LTS "Bionic"|8.x|
|Web Server|Nginx 1.14</br>Apache 2.4|Nginx 1.14</br>Apache 2.4|Nginx 1.14</br>Apache 2.4|
|DBMS|MariaDB 10.3\*|MariaDB 10.1</br>MySQL 5.7\*|MariaDB 10.3\*</br>MySQL 8.0\*|
|PHP|PHP 7.3|PHP 7.2|PHP 7.2|
|PHP packages|php-cli</br>php-fpm</br>php-mysql or php-pgsql</br>php-xml</br>php-json</br>php-intl</br>php-curl</br>php-gd *or* php-imagick|php-cli</br>php-fpm</br>php-mysql or php-pgsql</br>php-xml</br>php-mbstring</br>php-json</br>php-intl</br>php-curl</br>php-gd *or* php-imagick|php-cli</br>php-fpm</br>php-mysqlnd or php-pgsql</br>php-xml</br>php-mbstring</br>php-json</br>php-process</br>php-intl</br>php-pear *(optional, provides pecl)*</br>php-gd *or* php-imagick *(via [pecl](https://pecl.php.net/package/imagick))*|
|Cluster PHP packages|[php-redis](https://pecl.php.net/package/redis) *(3.1.3+)*|[php-redis](https://pecl.php.net/package/redis) *(3.1.3+)*|[php-redis](https://pecl.php.net/package/redis) *(3.1.3+)*|

|||
|------|------|
|Search|Solr (recommended; for performance, features and search quality):</br></br>Solr 7.x</br></br>Oracle Java/Open JDK: 8</br></br>*Currently tested with Solr 7.7LTS and Java Runtime Environment (JRE) version 1.8*|
|Graphic Handler|GraphicsMagick or ImageMagick or GD|
|[Clustering](../guide/clustering.md)|Linux NFS *or* S3/EFS *(for IO, aka binary files stored in content repository; S3 is not supported with legacy)*</br>Redis 3.2 or higher *(preferably separate instances for session & cache, both using one of the `volatile-*` [eviction policies](https://redis.io/topics/lru-cache))*</br>[Varnish](http://varnish-cache.org/) 5.1 or 6.0LTS *(recommended)* with [varnish-modules](https://github.com/varnish/varnish-modules/blob/master/README.rst) *or* [Fastly](https://www.fastly.com/) using [our bundle provided with eZ Platform Enterprise](../guide/http_cache.md#serving-varnish-through-fastly) *(for HttpCache)*|
|Filesystem|Linux ext4 / XFS|
|Package manager|Composer (recent stable version)|
|Asset manager|`Node.js` 10.15.3 LTS</br>`yarn` 1.15.2 or higher|

### Other supported setups

For security and performance we generally recommend (unless otherwise noted and marked with \*) using the newer versions of components below.

-   OS: Linux
-   Web Servers:
    -   Apache 2.4, with required modules `mod_rewrite`, `mod_env` and recommended: `mod_setenvif`, `mod_expires`
        - event MPM is recommended, if you need to use _prefork_ you'll also need the `mod_php` module
    -   Nginx 1.12, 1.14
-   DBMS
    -   MySQL 5.7\* or 8.0\* \**
    -   MariaDB 10.0, 10.1, 10.2\*, 10.3\*
    -   PostgreSQL 10+
-   PHP
    -   7.1
    -   7.2
    -   7.3
    -   7.4

- Cluster
    - Redis 3.2+ (preferably separate instances for session and cache, both using one of the `volatile-*` [eviction policies](https://redis.io/topics/lru-cache))
    - Solr
        - Recommended over SQL based Search engine, especially on cluster, as SQL does not provide the same feature set or performance as Solr
        - Recommended with Solr 7.7 (Solr Bundle v2.0)
        - Supported, but deprecated with Solr 6.6 (Solr Bundle 1.7)
    - NFS or S3
    - HttpCache, using one of:
        - [Varnish](http://varnish-cache.org/) 5.1 or 6.0LTS *(recommended)* with [varnish-modules](https://github.com/varnish/varnish-modules/blob/master/README.rst)
        - [Fastly](https://www.fastly.com/) using [the bundle provided with eZ Platform Enterprise](../guide/http_cache.md#serving-varnish-through-fastly)

-   PHP extensions/modules
    -   curl
    -   ctype
    -   dom (usually bundled with `xml` extension package)
    -   fileinfo
    -   iconv
    -   intl
    -   mbstring
    -   json
    -   opcache
    -   pdo
        - pdo mysql *(with mysqlnd)*
        - pdo pgsql
    -   posix
    -   reflection
    -   xml
    -   xsl
    -   zip
    -   [php-redis](https://pecl.php.net/package/redis) *(3.1.3+)* *or* [php-memcached](https://pecl.php.net/package/memcached) *(3.x+)*

<a id="mysql-versions-note"></a>
_\* Note: MySQL 5.7+ and MariaDB 10.2+ change how certain queries are parsed and are known to have issues with content attribute sorting queries in legacy because of that. Because of this we generally recommend MariaDB 10.1 and 10.0 in use with Legacy Bridge setups._
_\** For MySQL 8.0; either pick legacy authentication, or familiarize yourself with [requirements](https://secure.php.net/manual/en/mysqli.requirements.php) to use the new caching ssh2 authentication._

### Development and Experimental setups

eZ Platform, the foundation of all Ibexa software, can theoretically run and execute on many more setups than the ones listed as recommended and supported, including any [operating system supported by PHP](https://wiki.php.net/platforms), on a PHP 7.3 version or higher that pass the [Symfony requirements](http://symfony.com/doc/3.4/reference/requirements.html), using cache solutions technically supported by [Symfony Cache component](https://symfony.com/doc/3.4/components/cache/cache_pools.html), using databases supported by [Doctrine DBAL](https://www.doctrine-project.org/projects/doctrine-dbal/en/2.9/reference/configuration.html#driver), and using a binary file storage solution supported by [FlySystem](https://github.com/thephpleague/flysystem#adapters).

Examples of Development setups:

-   OS: Windows, macOS X, Linux
-   Filesystem: NTFS, HFS+/APFS, ...

Examples of Experimental setups:

-   OS: Any system supported by PHP
-   Filesystem: BTRFS, AUFS, ...
-   IO: Azure, (S)FTP, GridFS, [etc.](https://flysystem.thephpleague.com/docs/adapter/local/)
-   Databases: MSSQL, Oracle (databases technically supported by Doctrine DBAL which we use, but not supported by our installer at the moment, and not covered by automated testing)

Examples of experimental / deprecated bundles:
- Assetic 2.8 *(As of eZ Platform 2.5LTS, [Webpack Encore](https://symfony.com/doc/3.4/frontend.html) is used for assets. Assetic is no longer actively supported by eZ besides help with migrating code base)*

**While all these options are not actively supported by Ibexa**, they are community supported. Meaning you can use them with both open source edition and enterprise edition, however if you encounter issues best way to handle them is via contribution, and any such efforts made to improve support for these technologies can contribute to the technology being supported by Ibexa in the near future.

## Client

Ibexa software is developed to work with *any* web browser that support modern standards, on *any* screen resolution suitable for web, running on *any* device. However for the Editorial and Administration User Interfaces you'll need; a minimum of 1366-by-768 screen resolution, a desktop or tablet device, and a recommended/supported browsers found below.

### Recommended browsers

These setups have been undergone some additional manual testing and is known to work.

-   Mozilla® Firefox® most recent stable version
-   Google Chrome™ most recent stable version

### Supported browsers

-   Chromium™ based browsers such as Microsoft® Edge® and Opera®, most recent stable version, desktop *and* tablet
-   Apple® Safari® most recent stable version, desktop *and* tablet

Please note that the user interface might not look or behave exactly the same across all browsers as it will gracefully degrade if browser does not support certain features.

## eZ Platform Cloud requirements and setup

!!! cloud "eZ Platform Cloud"

    ### Cloud hosting with eZ Platform Cloud and Platform.sh

    In general, eZ Platform Cloud supports all features and services of [Platform.sh](https://platform.sh/hosting/php/ez) that are compatible and supported by the eZ Platform version you use.  

    For example:

    - Platform.sh provides Redis support for versions 2.8, 3.0 and 3.2. eZ Platform supports Redis version 3.2 or higher. As a result, Redis is supported by eZ Platform Cloud versions 3.2.
    - Platform.sh provides Elastic Search service (different versions supported). Elastic Search is not supported for use as search engine for eZ Platform.

    Features or services supported by eZ Platform but not covered by Platform.sh may be possible by means of a [custom integration](#custom-integrations).

    ### eZ Platform Cloud Setup support matrix

    |Setup|Description|eZ Platform Cloud support|
    |-----|-----|-----|
    |Recommended setup|**eZ Platform**</br>eZ Platform setup, with no use of legacy.|eZ Platform software plus cloud hosting infrastructure is supported by eZ for version 1.13 and higher</br></br>Recommended configuration provided out of the box and fully supported, on-boarding help available.|
    |Supported setup|**Legacy Bridge setup**</br>eZ Publish 5.x-like setup where web traffic goes to eZ Platform/Symfony and Legacy Bundle provides legacy fallback features.</br>Notably it allows among other things enabling a "Legacy mode" where legacy bundle lets legacy take over handling of URL aliases.|Installation and cloud is supported by eZ for version 1.13 and 2.x</br></br>Review and potential adaptation of the application configuration to be performed by eZ Systems technical services prior to deployments. The cost and effort of this review and potential adaptation is not included in eZ Platform Cloud subscription and will vary depending on each project's specificities.</br></br>*NOTE: Advanced legacy features like ezfind, Async publishing, ezodf, S3, and similar go under 'Experimental setup', to avoid this migrate to similar eZ Platform features.*|
    |Experimental setup|**eZ Publish, eZ Publish Platform and other pure legacy setups**</br>eZ Publish (version 4.x) or eZ Publish Platform (version 5.x) standalone setup or an experimental setup with eZ Platform and Legacy Bridge.|Not covered by eZ Platform Cloud subscription.</br></br>The use of Platform.sh service is possible as a standalone service and can be used to bridge migration needs. We recommend involving an eZ business partner that has experience with setting up legacy projects on Platform.sh|

    !!! note

        As Platform.sh does not support a configuration with multiple PostgreSQL databases,
        for eZ Platform Cloud / Platform.sh it is impossible to have a DFS table in a separate database.

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
