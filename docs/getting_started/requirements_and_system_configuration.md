# Requirements and System Configuration

## Platform as a Service (PaaS)

If you're using a PaaS provider such as our partner [Platform.sh](https://platform.sh/hosting/php/ez/), where we have an single-server setup, and in the future also clustered setup, you can [skip](starting_ez_platform.md#hello-world) this step.

## Server

eZ software is built to rely on existing technologies and standards. The minimal setup is `PHP`,  `MySQL/MariaDB`, and `Apache/Nginx`. Recommendation for production setups is to use `Varnish`, and  `Memcached`, `NFS` `and ``Solr` in a [clustered setup](../guide/clustering.md).

For supported versions of these technologies see Recommended and Supported setups below.

### Recommended setups

These setups are tested by QA and are generally recommended setups. For security and performance we furthermore recommend use of the newer versions of components below.

||Debian|Ubuntu|RHEL / CentOS|
|------|------|------|------|
|Operating system|8.x "Jessie"|16.04LTS|7.x|
|Web Server|Nginx 1.6</br>Apache 2.4 *(prefork mode)*|Nginx 1.10</br>Apache 2.4 *(prefork mode)*|Nginx 1.8 *(latest via [RHSCL](https://access.redhat.com/documentation/en/red-hat-software-collections/))*</br>Apache 2.4 *(prefork mode)*|
|DBMS|MariaDB 10.0</br>MySQL 5.5|MySQL 5.7</br>MariaDB 10.0|MariaDB 10.1 *(latest via RHSCL)*</br>MariaDB 10.0 *(latest via RHSCL)*</br>MySQL 5.6 *(latest via RHSCL)*</br>MariaDB 5.5|
|PHP|PHP 5.6 *(via libapache2-mod-php5 for Apache)*|PHP 7.0|PHP 7.0 *(latest via RHSCL)*</br>PHP 5.6 *(latest via RHSCL)*|
|PHP packages|php5-cli</br>php5-fpm *(for use with nginx)*</br>php5-readline</br>php5-mysqlnd or php5-pgsql</br>php5-json</br>php5-xsl</br>php5-intl</br>php5-mcrypt</br>php5-curl</br>php5-gd</br>php5-imagick *(optional)*</br>php5-twig *(optional, improves performance)*</br>php5-memcached</br> *(recommended, improves performance)*|php-cli</br>php-fpm *(for use with nginx)*</br>php-readline</br>php-mysql or php-pgsql</br>php-json</br>php-xml</br>php-mbstring</br>php-intl</br>php-mcrypt</br>php-curl</br>php-gd or php-imagick</br>php-memcached *(recommended, via [pecl](https://pecl.php.net/package/memcached))*|php-cli</br>php-fpm *(for use with nginx)*</br>php-mysqlnd or php-pgsql</br>php-xml</br>php-mbstring</br>php-process</br>php-intl</br>php-pear *(optional, provides pecl)*</br>php-gd or php-imagick *(via [pecl](https://pecl.php.net/package/imagick))*</br>php-memcached *(recommended, via [pecl](https://pecl.php.net/package/memcached))*|

|||
|------|------|
|Search|Solr (recommended, for better performance and scalability of all API Queries):</br></br>Solr 4.10</br>*Solr 6 SOLR BUNDLE >= 1.3, CURRENTLY TESTED WITH SOLR 6.4.2*</br></br>Oracle Java/Open JDK: 7 or 8 (needed for Solr, version 8 recommended)|
|Graphic Handler|GraphicsMagick or ImageMagick or GD|
|[Clustering](../guide/clustering.md)|Linux NFS *(for IO, aka binary files stored in content repository)*</br>Memcached *(for Persistence cache & Sessions)*</br>Varnish *(for HttpCache)*|
|Filesystem|Linux ext3 / ext4|
|Package manager|Composer|

### Supported setups

WORK IN PROGRESS FOR FUTURE RELEASE, SEE ABOVE FOR NOW

Supported setups are those we perform automated testing on. For security and performance we recommend use of the newer versions of components below.

-   OS: Linux
-   Web Servers:
    -   Apache 2.2, 2.4, with required modules `mod_php`, `mod_rewrite`, `mod_env` and recommended: `mod_setenvif`, `mod_expires`
    -   Nginx 1.6, 1.8. 1.10
-   DBMS
    -   MySQL 5.5, 5.6, 5.7
    -   MariaDB 5.5, 10.0, 10.1
-   PHP
    -   5.6
    -   7.0 - 7.1

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
    -   php-memcached *(3.x on PHP 7, 2.2 on PHP 5)*

### Development & Experimental setups

eZ Platform, the foundation of all eZ software, can theoretically run and execute on many more setups than the ones listed as recommended and supported, including any [operating system supported by PHP](https://wiki.php.net/platforms), on a PHP 5.6 version or higher that pass the [Symfony requirements](http://symfony.com/doc/current/reference/requirements.html), using cache solutions technically supported by [Stash](http://www.stashphp.com/Drivers.html), using databases supported by [Doctrine DBAL](http://doctrine-dbal.readthedocs.org/en/latest/reference/configuration.html#driver), and using a binary file storage solution supported by [FlySystem](https://github.com/thephpleague/flysystem#adapters).

Examples of Development setups:

-   OS: Windows, Mac OS X, Linux
-   Filesystem: NTFS, , HFS+, ...

Examples of Experimental setups:

-   OS: Any system supported by PHP
-   Persistence Cache: Redis *(php-redis is known to be unstable with Stash under load, if you experience this consider using custom Predis Stash driver)*
-   Filesystem: BTRFS, AUFS, APFS, ...
-   IO: S3, Azure, (S)FTP, GridFS, [...](https://flysystem.thephpleague.com/core-concepts/#adapters)
-   Databases: Postgres, MSSQL, Oracle *(As\\ in\\ technically\\ supported\\ by\\ Doctrine\\ DBAL\\ which\\ we\\ use,\\ but\\ none\\ supported\\ by\\ our\\ installer\\ at\\ the moment,\\ and\\ Oracle\\ and\\ MSSQL\\ is\\ not\\ covered\\ by\\ automated\\ testing)*

**While all these options are not supported by eZ Systems**, they are community supported, meaning contributions and efforts made to improve support for these technologies are welcome and can contribute to the technology being supported by the eZ Systems team in the future.

## Client

eZ software is developed to work with *any* web browser that support modern standards, on *any* screen resolution suitable for web, running on *any* device. However for the Editorial and Administration User Interfaces you'll need; a minimum of 1024-by-768 screen resolution, a desktop or tablet device, and a recommended/supported browsers found below.

### Recommended browsers

These setups have been undergone some additional manual testing and is known to work.

-   Mozilla® Firefox® most recent stable version (tested\\ on\\ Firefox\\ 50)
-   Google Chrome™ most recent stable version (tested\\ on\\ Chrome\\ 55) 
-   Microsoft® Edge® most recent stable version (tested\\ on Edge\\ 38) 

### Supported browsers

-   Apple® Safari® most recent stable version, desktop *and* tablet
-   Opera® most recent stable version, or higher, desktop *and* mobile 

Please note that the user interface might not look or behave exactly the same across all browsers as it will gracefully degrade if browser does not support certain features.

