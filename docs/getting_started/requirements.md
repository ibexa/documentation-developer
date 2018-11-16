# Requirements

## eZ Platform Cloud / Platform.sh

If you're using a PaaS provider such as the native [eZ Platform Cloud](https://ez.no/Products/eZ-Platform-Cloud), or its underlying [Platform.sh](https://platform.sh/hosting/php/ez/) offering, you can get started using the bundled config which contains recommended initial setup, and thus [skip this step](starting_ez_platform.md#hello-world).

_NOTE: Usage on eZ Platform Cloud/Platform.sh is limited to the featureset of [platform.sh](https://docs.platform.sh/), however you can also use additional services like for instance S3, GridFS, etc., as long as you host that service yourself and set up the necessary credentials to use it, as you would normally do when hosting the application on-premise._

## Server

eZ software is built to rely on existing technologies and standards. The minimal setup is `PHP`,  `MySQL/MariaDB`, and `Apache/Nginx`. Recommendation for production setups is to use `Varnish`/`Fastly`, `Redis`, `NFS`/`EFS`/`S3` and `Solr` in a [clustered setup](../guide/clustering.md).

For supported versions of these technologies see Recommended and Supported setups below.

### Recommended setups

These setups are tested by QA and are generally recommended setups. For security and performance we furthermore recommend use of the newer versions of components below.

||Debian|Ubuntu|RHEL / CentOS|
|------|------|------|------|
|Operating system|9.x "Stretch"|18.04 LTS "Bionic"|7.x|
|Web Server|Nginx 1.10</br>Apache 2.4|Nginx 1.14</br>Apache 2.4|Nginx 1.10 *(latest via [RHSCL](https://access.redhat.com/documentation/en/red-hat-software-collections/))*</br>Apache 2.4|
|DBMS|MariaDB 10.1</br>MySQL 5.5.3|MariaDB 10.1</br>MySQL 5.7\*|MariaDB 10.1 *(latest via RHSCL)*</br>MariaDB 10.0 *(latest via RHSCL)*</br>MySQL 5.6 *(latest via RHSCL)*</br>MariaDB 5.5|
|PHP|PHP 7.2 _(Either using packages in [testing](https://packages.debian.org/buster/php7.2), or [deb.sury.org](https://deb.sury.org/))_|PHP 7.2|PHP 7.1 *(latest via RHSCL)*|
|PHP packages|php-cli</br>php-fpm</br>php-mysql or php-pgsql</br>php-xml</br>php-intl</br>php-curl</br>php-gd *or* php-imagick|php-cli</br>php-fpm</br>php-mysql or php-pgsql</br>php-xml</br>php-mbstring</br>php-intl</br>php-curl</br>php-gd *or* php-imagick|php-cli</br>php-fpm</br>php-mysqlnd or php-pgsql</br>php-xml</br>php-mbstring</br>php-process</br>php-intl</br>php-pear *(optional, provides pecl)*</br>php-gd *or* php-imagick *(via [pecl](https://pecl.php.net/package/imagick))*|
|Cluster PHP packages</br>|php-redis *(via [pecl](https://pecl.php.net/package/redis))*|php-redis *(via [pecl](https://pecl.php.net/package/redis))*|php-redis *(via [pecl](https://pecl.php.net/package/redis))*|

|||
|------|------|
|Search|Solr (recommended; for performance, features and search quality):</br></br>Solr 6 or higher *Currently tested with Solr 6.6.2*</br></br>Oracle Java/Open JDK: 8 |
|Graphic Handler|GraphicsMagick or ImageMagick or GD|
|[Clustering](../guide/clustering.md)|Linux NFS *or* S3/EFS *(for IO, aka binary files stored in content repository)*</br>Redis 3.0 or higher *(preferably a separate volatile-ttl instance for sessions, and an allkeys-lru/allkeys-lfu instance for cache)*</br>[Varnish](http://varnish-cache.org/) 4.1 or higher with [varnish-modules](https://github.com/varnish/varnish-modules/blob/master/README.rst) *or* [Fastly](https://www.fastly.com/) using [our bundle provided with eZ Platform Enterprise](../guide/http_cache.md#serving-varnish-through-fastly) *(for HttpCache)*|
|Filesystem|Linux ext3 / ext4|
|Package manager|Composer|

### Supported setups

Supported setups are those we perform automated testing on. For security and performance we generally recommend (unless otherwise noted and marked with \*) using the newer versions of components below.

-   OS: Linux
-   Web Servers:
    -   Apache 2.4, with required modules `mod_rewrite`, `mod_env` and recommended: `mod_setenvif`, `mod_expires`
        - event MPM is recommended, if you need to use _prefork_ you'll also need the `mod_php` module
    -   Nginx 1.10, 1.12, 1.14
-   DBMS
    -   MySQL 5.5.3 and higher, 5.6\*, 5.7\*
    -   MariaDB 5.5 (new enough to support `utf8mb4` character set), 10.0, 10.1, 10.2\*
-   PHP
    -   7.1
    -   7.2

- Cluster
    - Redis _(preferably a separate volatile-ttl instance for sessions, and an allkeys-lru/allkeys-lfu instance for cache)_
    - Solr or SQL based Search engine *(but does not provide same featureset or performance as Solr)*
    - NFS or S3
    - [Varnish](http://varnish-cache.org/) 4.1 or higher with [varnish-modules](https://github.com/varnish/varnish-modules/blob/master/README.rst) *or* [Fastly](https://www.fastly.com/) using [our bundle provided with eZ Platform Enterprise](../guide/http_cache.md#serving-varnish-through-fastly) *(for HttpCache)*

-   PHP extensions/modules
    -   curl
    -   ctype
    -   fileinfo
    -   iconv
    -   intl
    -   mbstring
    -   opcache
    -   pdo
        -   pdo mysql *(with mysqlnd)*
    -   posix
    -   reflection
    -   xml
    -   xsl
    -   zip
    -   [php-redis](https://pecl.php.net/package/redis) *or* php-memcached *(3.x)*

<a id="mysql-versions-note"></a>
_\* Note: Mysql 5.7 and MariaDB 10.2 changes how certain queries are parsed and is known to have issues with content attribute sorting  queries in  legacy because of that at the moment, MySQL 5.6 technically works but executes several hundred times slower on said queries. Because of this we overall recommend MariaDB 10.1 and 10.0, and don't offically support MySQL 5.6/5.7 and MariaDB 10.2 in use with legacy at the moment._

### Development and Experimental setups

eZ Platform, the foundation of all eZ software, can theoretically run and execute on many more setups than the ones listed as recommended and supported, including any [operating system supported by PHP](https://wiki.php.net/platforms), on a PHP 7.3 version or higher that pass the [Symfony requirements](http://symfony.com/doc/3.4/reference/requirements.html), using cache solutions technically supported by [Symfony Cache component](https://symfony.com/doc/3.4/components/cache/cache_pools.html), using databases supported by [Doctrine DBAL](http://doctrine-dbal.readthedocs.org/en/latest/reference/configuration.html#driver), and using a binary file storage solution supported by [FlySystem](https://github.com/thephpleague/flysystem#adapters).

Examples of Development setups:

-   OS: Windows, Mac OS X, Linux
-   Filesystem: NTFS, HFS+/APFS, ...

Examples of Experimental setups:

-   OS: Any system supported by PHP
-   Filesystem: BTRFS, AUFS, ...
-   IO: Azure, (S)FTP, GridFS, [...](https://flysystem.thephpleague.com/core-concepts/#adapters)
-   Databases: Postgres, MSSQL, Oracle *(As in technically supported by Doctrine DBAL which we use, but none supported by our installer at the moment, and Oracle and MSSQL is not covered by automated testing)*

**While all these options are not actively supported by eZ Systems**, they are community supported. Meaning you can use them with both open source edition and enterprise edition, however if you encounter issues best way to handle them is via contribution, and any such efforts made to improve support for these technologies can contribute to the technology being supported by eZ Systems in the near future.

## Client

eZ software is developed to work with *any* web browser that support modern standards, on *any* screen resolution suitable for web, running on *any* device. However for the Editorial and Administration User Interfaces you'll need; a minimum of 1024-by-768 screen resolution, a desktop or tablet device, and a recommended/supported browsers found below.

### Recommended browsers

These setups have been undergone some additional manual testing and is known to work.

-   Mozilla® Firefox® most recent stable version
-   Google Chrome™ most recent stable version
-   Microsoft® Edge® most recent stable version

### Supported browsers

-   Apple® Safari® most recent stable version, desktop *and* tablet
-   Opera® most recent stable version, or higher, desktop *and* mobile 

Please note that the user interface might not look or behave exactly the same across all browsers as it will gracefully degrade if browser does not support certain features.

## eZ Platform Cloud requirements and setup

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
|Supported setup|**Legacy Bridge setup**</br>eZ Publish 5.x-like setup where web traffic goes to eZ Platform/Symfony and Legacy Bundle provides legacy fallback features.</br>Notably it allows among other things enabling a "Legacy mode" where legacy bundle lets legacy take over handling of URL aliases.|Installation and cloud is supported by eZ for version 1.13 and 2.x</br></br>Review and potential adaptation of the application configuration to be performed by eZ Systems technical services prior to deployments. The cost and effort of this review and potential adaptation is not included in eZ Platform Cloud subscription and will vary depending on each project's specificities.</br></br>*NOTE: Advanced legacy features like ezfind, Async publishing, ezodf, and similar go under 'Experimental setup', to avoid this migrate to similar eZ Platform features.*|
|Experimental setup|**eZ Publish, eZ Publish Platform and other pure legacy setups**</br>eZ Publish (version 4.x) or eZ Publish Platform (version 5.x) standalone setup or an experimental setup with eZ Platform and Legacy Bridge.|Not covered by eZ Platform Cloud subscription.</br></br>The use of Platform.sh service is possible as a standalone service and can be used to bridge migration needs. We recommend involving an eZ business partner that has experience with setting up legacy projects on Platform.sh|

### Recommended eZ Platform Cloud setup

For more details on recommended setup configuration see bundled `.platform.app.yaml` and `.platform/` configuration files.

These files are kept up-to-date with latest recommendations and can be improved through contributions.

### Supported eZ Platform Cloud setup

Because of the large range of possible configurations of eZ Publish legacy, there is no ready-made recommended setup.
Make sure to set aside time and budget for:

- Verifying your legacy configuration and ensuring it is supported by Platform.sh
- Additional time for adaptation and configuration work, and testing by your own team
- Additional consulting/onboarding time with Platform.sh, eZ Systems technical services, and/or one of the many partners with prior experience using Platform.sh with eZ Publish legacy

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
