# Requirements and System Configuration

## Platform as a Service (PaaS)

If you're using a PaaS provider such as our partner [Platform.sh](https://platform.sh/hosting/php/ez/), where we have an single-server setup, and in the future also clustered setup, you can [skip](starting_ez_platform.md#hello-world) this step.

## Server

eZ software is built to rely on existing technologies and standards. The minimal setup is `PHP`,  `MySQL/MariaDB`, and `Apache/Nginx`. Recommendation for production setups is to use `Varnish`, `Redis`, `NFS` and `Solr` in a [clustered setup](../guide/clustering.md).

For supported versions of these technologies see Recommended and Supported setups below.

### Recommended setups

These setups are tested by QA and are generally recommended setups. For security and performance we furthermore recommend use of the newer versions of components below.

||Debian|Ubuntu|RHEL / CentOS|
|------|------|------|------|
|Operating system|9.x "Stretch"|17.10|7.x|
|Web Server|Nginx 1.10</br>Apache 2.4|Nginx 1.12</br>Apache 2.4|Nginx 1.10 *(latest via [RHSCL](https://access.redhat.com/documentation/en/red-hat-software-collections/))*</br>Apache 2.4|
|DBMS|MariaDB 10.1</br>MySQL 5.5|MariaDB 10.1</br>MySQL 5.7\*|MariaDB 10.1 *(latest via RHSCL)*</br>MariaDB 10.0 *(latest via RHSCL)*</br>MySQL 5.6 *(latest via RHSCL)*</br>MariaDB 5.5|
|PHP|PHP 7.1 _(Either using packages in [testing](https://packages.debian.org/buster/php7.1), or [deb.sury.org](https://deb.sury.org/))_|PHP 7.1|PHP 7.1 *(latest via RHSCL)*|
|PHP packages|php-cli</br>php-fpm</br>php-readline</br>php-mysql or php-pgsql</br>php-json</br>php-xsl</br>php-intl</br>php-mcrypt</br>php-curl</br>php-gd</br>*or* php-imagick|php-cli</br>php-fpm *(for use with nginx)*</br>php-readline</br>php-mysql or php-pgsql</br>php-json</br>php-xml</br>php-mbstring</br>php-intl</br>php-mcrypt</br>php-curl</br>php-gd or php-imagick|php-cli</br>php-fpm *(for use with nginx)*</br>php-mysqlnd or php-pgsql</br>php-xml</br>php-mbstring</br>php-process</br>php-intl</br>php-pear *(optional, provides pecl)*</br>php-gd or php-imagick *(via [pecl](https://pecl.php.net/package/imagick))*</br>php-memcached *(recommended, via [pecl](https://pecl.php.net/package/memcached))*|
|Cluster PHP packages</br>|php-redis *(via [pecl](https://pecl.php.net/package/redis))*|php-redis *(via [pecl](https://pecl.php.net/package/redis))*|php-redis *(via [pecl](https://pecl.php.net/package/redis))*|

|||
|------|------|
|Search|Solr (recommended; for performance, features and search quality):</br></br>Solr 6 or higher *Currently tested with Solr 6.6.2*</br></br>Oracle Java/Open JDK: 8 |
|Graphic Handler|GraphicsMagick or ImageMagick or GD|
|[Clustering](../guide/clustering.md)|Linux NFS *or* S3 *(for IO, aka binary files stored in content repository)*</br>Redis *(for Persistence cache & Sessions)*</br>Varnish *(for HttpCache)*|
|Filesystem|Linux ext3 / ext4|
|Package manager|Composer|

### Supported setups

Supported setups are those we perform automated testing on. For security and performance we generally recommend (unless otherwise noted and marked with \*) using the newer versions of components below.

-   OS: Linux
-   Web Servers:
    -   Apache 2.4, with required modules `mod_php`, `mod_rewrite`, `mod_env` and recommended: `mod_setenvif`, `mod_expires`
    -   Nginx 1.10, 1.12
-   DBMS
    -   MySQL 5.5, 5.6\*, 5.7\*
    -   MariaDB 5.5, 10.0, 10.1, 10.2\*
-   PHP
    -   7.1

- Cluster
    - Redis or Memcached
    - Solr or SQL *(but does not provide same featureset or performance as Solr)*
    - NFS or S3

-   PHP extensions/modules
    -   curl
    -   ctype
    -   fileinfo
    -   iconv
    -   intl
    -   json
    -   mbstring
    -   opcache *(recommended over APC)*
    -   pdo
        -   pdo mysql *(with mysqlnd)*
    -   posix
    -   readline
    -   reflection
    -   xml
    -   xsl
    -   zip
    -   [php-redis](https://pecl.php.net/package/redis) *or* php-memcached *(3.x)*

_\* Note: Mysql 5.7 and MariaDB 10.2 changes how certain queries are parsed and is known to have issues with content attribute sorting  queries in  legacy because of that at the moment, MySQL 5.6 technically works but executes several hundred times slower on said queries. Because of this we overall recommend MariaDB 10.1 and 10.0, and don't offically support MySQL 5.6/5.7 and MariaDB 10.2 in use with legacy at the moment._

### Development & Experimental setups

eZ Platform, the foundation of all eZ software, can theoretically run and execute on many more setups than the ones listed as recommended and supported, including any [operating system supported by PHP](https://wiki.php.net/platforms), on a PHP 5.6 version or higher that pass the [Symfony requirements](http://symfony.com/doc/current/reference/requirements.html), using cache solutions technically supported by [Stash](http://www.stashphp.com/Drivers.html), using databases supported by [Doctrine DBAL](http://doctrine-dbal.readthedocs.org/en/latest/reference/configuration.html#driver), and using a binary file storage solution supported by [FlySystem](https://github.com/thephpleague/flysystem#adapters).

Examples of Development setups:

-   OS: Windows, Mac OS X, Linux
-   Filesystem: NTFS, HFS+/APFS, ...

Examples of Experimental setups:

-   OS: Any system supported by PHP
-   Filesystem: BTRFS, AUFS, ...
-   IO: Azure, (S)FTP, GridFS, [...](https://flysystem.thephpleague.com/core-concepts/#adapters)
-   Databases: Postgres, MSSQL, Oracle *(As in technically supported by Doctrine DBAL which we use, but none supported by our installer at the moment, and Oracle and MSSQL is not covered by automated testing)*

**While all these options are not actively supported by eZ Systems**, they are community supported. Meaning you can use them with both open source edition and enterprise edition, however if you encounter issues best way to handle them is via contribution,  and any such efforts made to improve support for these technologies can contribute to the technology being supported by eZ Systems in the near future.

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
