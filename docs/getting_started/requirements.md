# Requirements

The following server requirements cover both running the software on-premise and on third-party PaaS providers.

!!! note "Ibexa Cloud"

    For running on [Ibexa Cloud](https://www.ibexa.co/products/ibexa-cloud), where recommended configuration and support is provided out of the box, see separate [Ibexa Cloud section](#ibexa-cloud-requirements-and-setup) for further reading on its requirements.

## Server

Ibexa software is built to rely on existing technologies and standards. The minimal setup is `PHP`,  `MySQL/MariaDB`, `Apache/Nginx`, `Node.js` and `yarn`. Recommendation for production setups is to use `Varnish`/`Fastly`, `Redis`/`Memcached`, `NFS`/`EFS`/`S3` and `Solr`/`Elasticsearch` in a [clustered setup](../guide/clustering.md).

For supported versions of these technologies see Recommended and Supported setups below.

### Recommended setups

These setups are tested by QA and are generally recommended setups. For security and performance we furthermore recommend use of the newer versions of components below unless otherwise noted.

||Debian|Ubuntu|RHEL / CentOS|
|------|------|------|------|
|Operating system|10.x "Buster"|20.04 "Focal Fossa"|8.1+|
|Web Server|Nginx 1.14</br>Apache 2.4|Nginx 1.18</br>Apache 2.4|Nginx 1.14</br>Apache 2.4|
|DBMS|MariaDB 10.3|MariaDB 10.3</br>MySQL 8.0|MariaDB 10.3</br>MySQL 8.0|
|PHP|PHP 7.3|PHP 7.4|PHP 7.3|
|PHP packages|php-cli</br>php-fpm</br>php-mysql or php-pgsql</br>php-xml</br>php-json</br>php-intl</br>php-curl</br>php-gd *or* php-imagick|php-cli</br>php-fpm</br>php-mysql or php-pgsql</br>php-xml</br>php-mbstring</br>php-json</br>php-intl</br>php-curl</br>php-gd *or* php-imagick|php-cli</br>php-fpm</br>php-mysqlnd or php-pgsql</br>php-xml</br>php-mbstring</br>php-json</br>php-process</br>php-intl</br>php-pear *(optional, provides pecl)*</br>php-gd *or* php-imagick *(via [pecl](https://pecl.php.net/package/imagick))*|
|Cluster PHP packages|[php-redis](https://pecl.php.net/package/redis) *or* [php-memcached](https://pecl.php.net/package/memcached)|[php-redis](https://pecl.php.net/package/redis) *or* [php-memcached](https://pecl.php.net/package/memcached)|[php-redis](https://pecl.php.net/package/redis) *or* [php-memcached](https://pecl.php.net/package/memcached)|

|||
|------|------|
|Search|Solr 7.7LTS *or* Elasticsearch 7.7, using Oracle Java/Open JDK 8 or higher |
|Graphic Handler|GraphicsMagick or ImageMagick or GD|
|[Clustering](../guide/clustering.md)|Linux NFS *or* S3/EFS *(for IO, aka binary files stored in content repository, not supported with legacy)*</br>Redis 5.0 or higher *(separate instances for session & cache, both using a `volatile-*` [eviction policy](https://redis.io/topics/lru-cache), session instance configured for persistance)* *or* [Memcached](https://memcached.org/) 1.5 or higher</br>[Varnish](http://varnish-cache.org/) 6.0LTS with [varnish-modules](https://github.com/varnish/varnish-modules/blob/master/README.rst) *or* [Fastly](https://www.fastly.com/) using [the bundle provided with [[= product_name_exp =]]](../guide/http_cache.md#serving-varnish-through-fastly) *(for HttpCache)*|
|Filesystem|Linux ext4 / XFS|
|Package manager|Composer (recent stable version)|
|Asset manager|`Node.js` 10.15.3 LTS</br>`yarn` 1.15.2 or higher|

### Other supported setups

For security and performance we generally recommend (unless otherwise noted) using the newer versions of components below.

-   OS: Linux
-   Web Servers:
    -   Apache 2.4, with required modules `mod_rewrite`, `mod_env` and recommended: `mod_setenvif`, `mod_expires`
        - event MPM is recommended, if you need to use _prefork_ you'll also need the `mod_php` module
    -   Nginx 1.12, 1.14, 1.16
-   DBMS
    -   MySQL 5.7 or 8.0
    -   MariaDB 10.2, 10.3, 10.4
    -   PostgreSQL 10+
-   PHP
    -   7.3
    -   7.4

- Cluster
    - Cache:
        - Redis 4.0+ (5.0 recommended, using `volatile-*` [eviction policy](https://redis.io/topics/lru-cache) is required with default [Redis adapter](../guide/persistence_cache.md#redis))
        - Memcached 1.5 or higher (See [Memcached adapter](../guide/persistence_cache.md##memcached) for comparison with Redis)
    - Session: either own Redis instance with persistence turned on, or Database.
    - Search: Solr 7, Solr 8, or Elasticsearch 7.7 (recommended over SQL-based Search engine, especially on cluster, as SQL does not provide the same feature set or performance as the other two).
    - IO: NFS or S3
    - HttpCache, using one of:
        - [Varnish](http://varnish-cache.org/) 6.0LTS with [varnish-modules](https://github.com/varnish/varnish-modules/blob/master/README.rst)
        - [Fastly](https://www.fastly.com/) using [the bundle provided with [[= product_name_exp =]]](../guide/http_cache.md#serving-varnish-through-fastly)

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
    -   [php-redis](https://pecl.php.net/package/redis) *or* [php-memcached](https://pecl.php.net/package/memcached)


### Development and Experimental setups

[[= product_name =]] can theoretically run and execute on many more setups than the ones listed as recommended and supported, including any [operating system supported by PHP](https://wiki.php.net/platforms), on a PHP 7.3 version or higher that pass the [Symfony requirements](http://symfony.com/doc/5.0/reference/requirements.html), using cache solutions technically supported by [Symfony Cache component](https://symfony.com/doc/5.0/components/cache/cache_pools.html), using databases supported by [Doctrine DBAL](https://www.doctrine-project.org/projects/doctrine-dbal/en/2.9/reference/configuration.html#driver), and using a binary file storage solution supported by [FlySystem](https://github.com/thephpleague/flysystem#adapters).

Examples of Development setups:

-   OS: Windows, macOS X, Linux
-   Filesystem: NTFS, HFS+/APFS, ...

Examples of Experimental setups:

-   OS: Any system supported by PHP
-   Filesystem: BTRFS, AUFS, ...
-   IO: Azure, (S)FTP, GridFS, [etc.](https://flysystem.thephpleague.com/docs/adapter/local/)
-   Databases: MSSQL, Oracle (databases technically supported by Doctrine DBAL which we use, but not supported by our installer at the moment, and not covered by automated testing)


**While all these options are not actively supported by Ibexa**, they are community supported. Meaning you can use them with both open source edition and enterprise edition, however if you encounter issues best way to handle them is via contribution, and any such efforts made to improve support for these technologies can contribute to the technology being supported by Ibexa in the near future.

## Client

[[= product_name =]] is developed to work with *any* web browser that support modern standards, on *any* screen resolution suitable for web, running on *any* device. However for the Editorial and Administration User Interfaces you'll need; a minimum of 1366-by-768 screen resolution, a desktop or tablet device, and a recommended/supported browsers found below.

### Recommended browsers

These setups have been undergone some additional manual testing and is known to work.

-   Mozilla® Firefox® most recent stable version
-   Google Chrome™ most recent stable version

### Supported browsers

-   Chromium™ based browsers such as Microsoft® Edge® and Opera®, most recent stable version, desktop *and* tablet
-   Apple® Safari® most recent stable version, desktop *and* tablet

Please note that the user interface might not look or behave exactly the same across all browsers as it will gracefully degrade if browser does not support certain features.

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
