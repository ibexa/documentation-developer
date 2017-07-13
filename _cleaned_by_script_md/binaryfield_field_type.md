1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>

 Developer : Migrating to eZ Platform - Follow the Ibex! 



Are you considering a move to eZ Platform? Worried about switching to a new technology? Unsure how to migrate your existing content?

Take a look at our guides for moving to eZ Platform from other solutions below. If you're looking for what's new from eZ Publish to eZ Platform, check this [Feature Comparison](https://doc.ez.no/x/jpTUAQ).

 

-   [Coming to eZ Platform from eZ Publish Platform](Coming-to-eZ-Platform-from-eZ-Publish-Platform_31429598.html)
    -   [Upgrading from 5.4.x and 2014.11 to 16.xx](Upgrading-from-5.4.x-and-2014.11-to-16.xx_31430322.html)
        -   [Migrating legacy Page field (ezflow) to Landing Page (Enterprise)](31431405.html)
-   [Migration from eZ Publish](Migration-from-eZ-Publish_31430320.html)

 

 

## Comments:

<table>
<colgroup>
<col width="100%" />
</colgroup>
<tbody>
<tr class="odd">
<td align="left"><a href=""></a>
<p><span class="jira-issue"> <a href="https://jira.ez.no/browse/EZP-26204?src=confmacro" class="jira-issue-key"><img src="https://jira.ez.no/images/icons/issuetypes/epic.png" class="icon" />EZP-26204</a> - <span class="summary">Provide information for developers coming to eZ from other platforms</span> <span class="aui-lozenge aui-lozenge-subtle aui-lozenge-complete jira-macro-single-issue-export-pdf">Open</span> </span></p>
<div class="smallfont" align="left" style="color: #666666; width: 98%; margin-bottom: 10px;">
<img src="images/icons/contenttypes/comment_16.png" width="16" height="16" /> Posted by david.liedle@ez.no at Aug 24, 2016 16:00
</div></td>
</tr>
</tbody>
</table>






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Get Started with eZ Platform](Get-Started-with-eZ-Platform_31429520.html)</span>

 Developer : Step 0: Requirements & System Configuration 



# Platform as a Service (PaaS)

If you're using a PaaS provider such as our partner <a href="https://platform.sh/hosting/php/ez/">Platform.sh</a>, where we have an single-server setup, and in the future also clustered setup, you can [skip](https://doc.ez.no/pages/viewpage.action?pageId=31429552) this step.

# Server

eZ software is built to rely on existing technologies and standards. The minimal setup is `PHP`,  `MySQL/MariaDB`, and `Apache/Nginx`. Recommendation for production setups is to use `Varnish`, and  `Memcached`, `NFS` `and ``Solr` in a [<span class="confluence-link">clustered</span> setup](Clustering_31430387.html).

<span>For supported versions of these technologies see Recommended and Supported setups below.</span>

## Recommended setups

These setups are tested by QA and are generally recommended setups. For security and performance we furthermore recommend use of the newer versions of components below.

 
Debian

<span>Ubuntu</span>
<span style="color: rgb(0,98,147);">RHEL / CentOS</span>
**Operating system**

8.x "Jessie"

<span style="color: rgb(128,128,128);"><span style="color: rgb(0,0,0);">16.04LTS</span></span>

7.x

**Web Server**

Nginx 1.6
Apache 2.4 <sup><span style="color: rgb(128,128,128);">(prefork\\ mode)</span></sup><span>
</span>

<span>Nginx 1.10
Apache 2.4 <sup><span style="color: rgb(128,128,128);">(prefork\\ mode)</span></sup></span><span style="color: rgb(255,102,0);">
</span>

<span>Nginx 1.8 </span><sup><span style="color: rgb(128,128,128);">(via\\ <a href="https://access.redhat.com/documentation/en-US/Red_Hat_Software_Collections/2/html/2.1_Release_Notes/index.html">RHSCL</a>)</span></sup>
Apache 2.4 <sup><span style="color: rgb(128,128,128);">(prefork\\ mode)</span></sup><span style="color: rgb(128,128,128);">
</span>

**DBMS**

MariaDB 10.0
MySQL 5.5

<span>MySQL 5.7
MariaDB 10.0</span><span>
</span>

<span>MariaDB 10.1 </span><sup><span style="color: rgb(128,128,128);">(via\\ <a href="https://access.redhat.com/documentation/en-US/Red_Hat_Software_Collections/2/html/2.2_Release_Notes/index.html">RHSCL</a>)
</span></sup>MariaDB 10.0 <sup><span style="color: rgb(128,128,128);">(via\\ <a href="https://access.redhat.com/documentation/en-US/Red_Hat_Software_Collections/2/html/2.1_Release_Notes/index.html">RHSCL</a>)
</span></sup>MySQL 5.6 <sup><span style="color: rgb(128,128,128);">(via\\ <a href="https://access.redhat.com/documentation/en-US/Red_Hat_Software_Collections/2/html/2.1_Release_Notes/index.html">RHSCL</a>)
</span></sup>MariaDB 5.5

**PHP**

PHP<span style="color: rgb(255,0,0);"> <span style="color: rgb(34,34,34);">5.6</span></span><span> </span><span style="color: rgb(128,128,128);"><sup>(via\\ libapache2-mod-php5\\ for\\ Apache)</sup></span>

PHP 7.0<span> </span>

<span>PHP 7.0 </span><sup><span style="color: rgb(128,128,128);">(via\\ <a href="https://access.redhat.com/documentation/en-US/Red_Hat_Software_Collections/2/html/2.3_Release_Notes/index.html">RHSCL</a>)</span></sup>

PHP 5.6 <sup><span style="color: rgb(128,128,128);">(via\\ <a href="https://access.redhat.com/documentation/en-US/Red_Hat_Software_Collections/2/html/2.1_Release_Notes/index.html">RHSCL</a>)</span></sup>

**PHP <span style="color: rgb(34,34,34);">packages</span>**

<span>php5-cli
php5-fpm <sup><span style="color: rgb(128,128,128);">(<span style="color: rgb(128,128,128);">for\\ use\\ </span>with\\ nginx</span><span style="color: rgb(128,128,128);">)</span></sup>
php5-readline</span>
<span>php5-mysqlnd *<span style="color: rgb(128,128,128);">or </span>*</span>php5-pgsql
<span>php5-json
php5-xsl
php5-intl
php5-mcrypt
<span>php5-curl</span></span>
<span><span>php5-gd
</span></span>php5-imagick <span style="color: rgb(128,128,128);">(optional)</span>
php5-twig <sup><span style="color: rgb(128,128,128);">(optional,\\ improves\\ performance</span><span style="color: rgb(128,128,128);">)
</span></sup>php5-memcached <sup><span style="color: rgb(128,128,128);"><span>(<span>recommended</span>,\\ improves\\ performance)</span></span></sup>

php-cli
php-fpm <sup><span style="color: rgb(128,128,128);">(for\\ use\\ with\\ nginx</span><span style="color: rgb(128,128,128);">)</span></sup>
php-readline
php-mysql *<span style="color: rgb(128,128,128);">or </span>*php-pgsql
php-json
php-xml
php-mbstring
php-intl
php-mcrypt
php-curl
php-gd *<span style="color: rgb(128,128,128);">or </span>*php-imagick

<span>php-memcached </span><sup><span style="color: rgb(128,128,128);">(recommended,\\ via\\ <a href="https://pecl.php.net/package/memcached">pecl</a></span><span style="color: rgb(128,128,128);">)</span></sup>

 

<span>php-cli
php-fpm<span> </span><sup><span style="color: rgb(128,128,128);">(for\\ use\\ with\\ <span style="color: rgb(128,128,128);">nginx</span></span><span style="color: rgb(128,128,128);">)</span></sup>
<span>php-<span>mysqlnd </span></span></span><span>*<span style="color: rgb(128,128,128);">or </span>*</span><span>php-pgsql
php-xml
php-mbstring
php-process
php-intl
php-pear <span style="color: rgb(128,128,128);"><sup>(optional,\\ provides\\ *pecl*)</sup></span>
php-gd *<span style="color: rgb(128,128,128);">or </span>*<span>php-imagick<span> </span><sup><span style="color: rgb(128,128,128);">(via\\ <a href="https://pecl.php.net/package/imagick">pecl</a></span><span style="color: rgb(128,128,128);">)</span></sup></span></span><span>
php-memcached </span><sup><span style="color: rgb(128,128,128);">(recommended,\\ via\\ <a href="https://pecl.php.net/package/memcached">pecl</a></span><span style="color: rgb(128,128,128);">)</span></sup>

<span style="color: rgb(128,128,128);"><span>
</span></span>

**Search**
Solr <sup><span style="color: rgb(128,128,128);">(recommended,\\ for\\ better\\ performance\\ and\\ scalability\\ of\\ all\\ API\\ Queries)</span></sup>

-   Solr 4.10

<span style="color: rgb(0,0,0);">Oracle Java/Open JDK: 7 *<span style="color: rgb(128,128,128);">or</span>* 8 <sup><span style="color: rgb(128,128,128);">(needed\\ for\\ Solr,\\ <a href="https://lucene.apache.org/solr/4_10_4/SYSTEM_REQUIREMENTS.html">version\ 8\ recommended</a></span></sup></span><sup><span style="color: rgb(128,128,128);">)</span></sup>

**Graphic Handler**

GraphicsMagick *<span style="color: rgb(128,128,128);">or</span>* ImageMagick *<span style="color: rgb(128,128,128);">or</span>* GD

**<span class="confluence-link">[Clustering](Clustering_31430387.html)</span>**

Linux NFS<sup><span style="color: rgb(128,128,128);">\\ (for\\ IO,\\ aka\\ binary\\ files\\ stored\\ in\\ content\\ repository)</span></sup>
Memcached <sup><span style="color: rgb(128,128,128);">(for\\ Persistence\\ cache\\ &\\ Sessions)</span></sup>
Varnish <sup><span style="color: rgb(128,128,128);">(for\\ HttpCache)</span></sup>

**Filesystem**

Linux ext3 / ext4

**Package manager**
Composer

## Supported setups

<span class="status-macro aui-lozenge aui-lozenge-current">WORK IN PROGRESS FOR FUTURE RELEASE, SEE ABOVE FOR NOW</span>

Supported setups are those we perform automated testing on. For security and performance we recommend use of the newer versions of components below.

-   OS: Linux
-   Web Servers:
    -   Apache 2.2, 2.4
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
    -   opcache <span style="color: rgb(128,128,128);">*(recommended over APC)*</span>
    -   pdo
        -   pdo mysql <span style="color: rgb(128,128,128);">*(with mysqlnd)*</span>
    -   posix
    -   readline
    -   reflection
    -   xml
    -   xsl
    -   zip
    -   php-memcached *(<span style="color: rgb(128,128,128);">3.x on PHP 7, 2.2 on PHP 5)</span>*

## Development & Experimental setups

eZ Platform, the foundation of all eZ software, can theoretically run and execute on many more setups than the ones listed as recommended and supported, including any <a href="https://wiki.php.net/platforms">operating system supported by PHP</a>, on a PHP 5.6 version or higher that pass the <a href="http://symfony.com/doc/current/reference/requirements.html">Symfony requirements</a>, using cache solutions technically supported by <a href="http://www.stashphp.com/Drivers.html">Stash</a>, using databases supported by <a href="http://doctrine-dbal.readthedocs.org/en/latest/reference/configuration.html#driver">Doctrine DBAL</a>, and using a binary file storage solution supported by <a href="https://github.com/thephpleague/flysystem#adapters">FlySystem</a>.

Examples of Development setups:

-   OS: Windows, Mac OS X, Linux
-   Filesystem: NTFS, <span style="color: rgb(34,34,34);">, </span>HFS+, ..

Examples of Experimental setups:

-   OS: Any system supported by PHP
-   Persistence Cache: Redis *(php-redis is known to be unstable with Stash under load, if you experience this consider using custom Predis Stash driver)*
-   Filesystem: BTRFS, AUFS, A<span style="color: rgb(34,34,34);">PFS,</span> ...
-   IO: S3, Azure, (S)FTP, GridFS, <a href="https://flysystem.thephpleague.com/core-concepts/#adapters">...</a>
-   Databases: Postgres, MSSQL, Oracle <span style="color: rgb(128,128,128);"><sup>*(As\\ in\\ technically\\ supported\\ by\\ Doctrine\\ DBAL\\ which\\ we\\ use,\\ but\\ none\\ supported\\ by\\ our\\ installer\\ at\\ the moment,\\ and\\ Oracle\\ and\\ MSSQL\\ is\\ not\\ covered\\ by\\ automated\\ testing)*</sup></span>

 

**While all these options are not supported by eZ Systems**, they are community supported, meaning contributions and efforts made to improve support for these technologies are welcome and can contribute to the technology being supported by the eZ Systems team in the future.

 

# <span id="Step0:Requirements&SystemConfiguration-client" class="confluence-anchor-link"></span>Client

<span style="color: rgb(79,79,79);">eZ software is developed to work with *any* web browser that support modern standards, on *any* screen resolution suitable for web, running on *any* device. </span><span style="color: rgb(79,79,79);">However for the Editorial and Administration User Interfaces you'll need; a minimum of 1024-by-768 screen resolution, a desktop or tablet device, and a recommended/supported browsers found below.</span>

## Recommended browsers

These setups have been undergone some additional manual testing and is known to work.

-   <span style="color: rgb(0,0,0);"><span>Mozilla® Firefox® most recent stable version <sup><span style="color: rgb(128,128,128);">(t</span></sup></span><sup><span style="color: rgb(128,128,128);">ested\\ on\\ Firefox\\ 50</span></sup></span><sup><span style="color: rgb(128,128,128);">)</span></sup>

-   <span style="color: rgb(0,0,0);"><span>Google Chrome™ most recent stable version <span style="color: rgb(128,128,128);"><sup>(t</sup></span></span><span style="color: rgb(128,128,128);"><sup>ested\\ on\\ Chrome\\ 55</sup></span></span><span><span style="color: rgb(0,0,0);"><span style="color: rgb(128,128,128);"><sup>)</sup></span> </span></span>

-   <span style="color: rgb(0,0,0);">Microsoft® </span><span>Edge<span style="color: rgb(0,0,0);">® <span style="color: rgb(0,0,0);">most recent stable version</span> <span style="color: rgb(128,128,128);"><sup>(tested\\ on Edge\\ 38)</sup></span></span><span style="color: rgb(0,0,0);"> </span></span>

## Supported browsers

-   <span style="color: rgb(0,0,0);">Apple® Safari® <span style="color: rgb(0,0,0);">most recent stable version</span></span><span style="color: rgb(0,0,0);"><span style="color: rgb(0,0,0);">, desktop<span> *and* tablet</span></span></span>

-   <span style="color: rgb(0,0,0);"><span><span style="color: rgb(0,0,0);">Opera® <span style="color: rgb(0,0,0);">most recent stable version</span>, or higher, <span style="color: rgb(0,0,0);">desktop *and* mobile</span></span><span style="color: rgb(0,0,0);"> </span></span></span>

Please note that the user interface might not look or behave exactly the same across all browsers as it will gracefully degrade if browser does not support certain features.

 

#### In this topic:

-   [Platform as a Service (PaaS)](#Step0:Requirements&SystemConfiguration-PlatformasaService(PaaS))
-   [Server](#Step0:Requirements&SystemConfiguration-Server)
    -   [Recommended setups](#Step0:Requirements&SystemConfiguration-Recommendedsetups)
    -   [Supported setups](#Step0:Requirements&SystemConfiguration-Supportedsetups)
    -   [Development & Experimental setups](#Step0:Requirements&SystemConfiguration-Development&Experimentalsetups)
-   [Client](#Step0:Requirements&SystemConfiguration-clientClient)
    -   [Recommended browsers](#Step0:Requirements&SystemConfiguration-Recommendedbrowsers)
    -   [Supported browsers](#Step0:Requirements&SystemConfiguration-Supportedbrowsers)

#### Related:

-   [Clustering](Clustering_31430387.html)
-   [Performance](Performance_33555232.html)

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Get Started with eZ Platform](Get-Started-with-eZ-Platform_31429520.html)</span>

 Developer : Step 1: Installation 



## Install All The Things!

Well, at least the things required to run your chosen distribution:

General installation guide for all eZ distributions

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
<span id="Step1:Installation-InstallationLinks" class="confluence-anchor-link"></span>This installation guide can be followed with any eZ distribution based on the Symfony framework. Here's a list of available <span>distributions from eZ</span>:

| Type                                                                                      | Archive                                                                                                                                     | License                                                                                                                                                                | GIT */ Composer*                                                                                                                          |
|-------------------------------------------------------------------------------------------|---------------------------------------------------------------------------------------------------------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------|
| **eZ Platform**<span style="color: rgb(128,128,128);">*                                   
 "clean" distribution*</span>                                                               | <a href="http://share.ez.no/downloads/downloads">share.ez.no/downloads/downloads</a>                                  | GPLv2                                                                                                                                                                  | <a href="https://github.com/ezsystems/ezplatform">ezsystems/ezplatform</a>                                          
                                                                                                                                                                                                                                                                                                                                                                                                                    (<a href="https://github.com/ezsystems/ezplatform/blob/master/INSTALL.md">INSTALL.md</a>)                            |
| <span>eZ Platform Demo                                                                    
 </span><span style="color: rgb(128,128,128);">*Not for production use*</span>              | <span style="color: rgb(128,128,128);"> *Available via Git / Composer* </span>                                                              | GPLv2                                                                                                                                                                  | <a href="https://github.com/ezsystems/ezplatform-demo">ezsystems/ezplatform-demo</a>                                |
| **eZ Platform Enterprise Edition**                                                        
 <span style="color: rgb(128,128,128);">*"clean" distribution* </span>                      | <span style="color: rgb(153,153,153);"> <a href="https://support.ez.no/Downloads">support.ez.no/Downloads</a> </span> | BUL <span style="color: rgb(128,128,128);">(***Requires <a href="http://ez.no/Products/eZ-Enterprise">eZ Enterprise</a> subscription)*** </span> | <a href="https://github.com/ezsystems/ezplatform-ee">ezsystems/ezplatform-ee</a>                                    
                                                                                                                                                                                                                                                                                                                                                                                                                    <span>(</span> <a href="https://github.com/ezsystems/ezstudio/blob/master/INSTALL.md">INSTALL.md</a> <span>)</span>  |
| eZ Platform <span>Enterprise Edition Demo</span><span style="color: rgb(128,128,128);"> * 
 Not for production use*</span>                                                             | <span style="color: rgb(153,153,153);"> <a href="https://support.ez.no/Downloads">support.ez.no/Downloads</a> </span> | BUL <span style="color: rgb(128,128,128);">(**R*equires <a href="http://ez.no/Products/eZ-Enterprise">eZ Enterprise</a> subscription)*** </span> | <a href="https://github.com/ezsystems/ezplatform-ee-demo">ezsystems/ezplatform-ee-demo</a>                          |

## Choose Your Adventure!

Instructions vary depending on your desired operating system and method of installation. We recommend using Composer:

-   [Installation Using Composer](Installation-Using-Composer_31429546.html)
-   [Manual Installation Guides](Manual-Installation-Guides_31431727.html)
    -   [Installation Guide for OS X](Installation-Guide-for-OS-X_31431738.html)
    -   [Installation Guide for Unix-Based Systems](Installation-Guide-for-Unix-Based-Systems_31431755.html)
        -   [Setup folder rights](Setup-folder-rights_32866325.html)
        -   [Set up Swap on Debian 8.x](Set-up-Swap-on-Debian-8.x_32114141.html)
    -   [Manual Installation on Windows](Manual-Installation-on-Windows_32113648.html)
-   [Starting eZ Platform](Starting-eZ-Platform_31429550.html)
    -   [Web Server](Web-Server_31429554.html)
    -   [PHP's built-in server](31429556.html)
-   [Hello World!](31429552.html)
-   [Installation Using Docker](Installation-Using-Docker_32113397.html)
-   [Avoiding Problems](Avoiding-Problems_32113599.html)

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Get Started with eZ Platform](Get-Started-with-eZ-Platform_31429520.html)</span>

 Developer : Step 2: Going Deeper 



Now that you have eZ Platform installed, what's next?

 

-   Follow one of the tutorials that will lead you step-by-step through some of the operations you can do.
    (See [Next Steps: Follow a Tutorial Path](31429565.html).)
-   Play with a ready-to-use demo that lets you see and investigate how an example website is built.
    (See [eZ Platform Demo](eZ-Platform-Demo_31429540.html).)
-   Learn what eZ Enterprise has to offer on top of eZ Platform.
    (See [Get Started with eZ Enterprise](Get-Started-with-eZ-Enterprise_31429569.html).)

 

-   [Using Composer](Using-Composer_31431588.html)
-   [Next Steps: Follow a Tutorial Path](31429565.html)
-   [eZ Platform Features](eZ-Platform-Features_32866981.html)
-   [eZ Platform Demo](eZ-Platform-Demo_31429540.html)
-   [Get Started with eZ Enterprise](Get-Started-with-eZ-Enterprise_31429569.html)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Get Started with eZ Platform](Get-Started-with-eZ-Platform_31429520.html)</span>
4.  <span>[Step 1: Installation](31429538.html)</span>

 Developer : Hello World! 



Now your installation is ready and you're on your way to starting work with eZ Platform.

To access the back office of your installation, append `/ez` to its path: &lt;`your_installation path>/ez`. You will be prompted for the username and password, which by default are:

username: admin
password: publish

 

A clean installation of eZ Platform is empty, so you only get a single page with a rudimentary content model. This is a blank canvas for you to create and customize your own structure.

If you'd like to take a look at an example of using the system to construct a fully functional page, you can also [install eZ Platform with the Demo Bundle](eZ-Platform-Demo_31429540.html).

 

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Get Started with eZ Platform](Get-Started-with-eZ-Platform_31429520.html)</span>
4.  <span>[Step 1: Installation](31429538.html)</span>
5.  <span>[Starting eZ Platform](Starting-eZ-Platform_31429550.html)</span>

 Developer : PHP's built-in server 



## <span style="color: rgb(0,98,147);">Description</span>

PHP, in 5.4 and later, comes with a <a href="http://php.net/manual/en/features.commandline.webserver.php">built-in webserver for development purposes</a>. This is very handy, as it allows you to **kickstart development quickly**, avoiding having to install and configure <a href="https://github.com/ezsystems/ezplatform/tree/master/doc/apache2">Apache</a> / <a href="https://github.com/ezsystems/ezplatform/tree/master/doc/nginx">Nginx</a>. All you need here is PHP 5.4+ with command line binary.

## Usage

Symfony comes with a wrapper script for booting the built-in webserver: `server:run`. It's a nice shortcut as it will correctly set the web root depending on your configuration, and with eZ Platform it can be used as is.

<span class="aui-icon aui-icon-small aui-iconfont-error confluence-information-macro-icon"></span>
Use this command for **local development purpose only**!
DO NOT use this on production servers, the use of `--env=prod` below is just showcasing that you can use the command both with Symfony's dev and prod environment depending on if you are debugging or just testing out your application locally.

##### Examples

The following example will start the webserver on <a href="http://127.0.0.1:8000" class="uri">http://127.0.0.1:8000</a> on your machine, in Symfony dev environment for debug use:

**Debug example**

``` brush:
php app/console server:run
```

The following example will start the webserver on <a href="http://localhost:8000/">http://localhost:8000</a> on your machine, in Symfony prod environment for demo/testing use:

**Testing/Demo example**

``` brush:
php app/console server:run --env=prod localhost:8000
```

 

##### **Help with the command**

As with any Symfony command, you may execute the command with a `-h` flag to get up-to-date help text for the command:

**Help info example**

``` brush:
php app/console server:run -h
```

 

 

#### Further reading:

<a href="http://symfony.com/doc/current/cookbook/web_server/built_in.html" class="uri">http://symfony.com/doc/current/cookbook/web_server/built_in.html</a>






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Get Started with eZ Platform](Get-Started-with-eZ-Platform_31429520.html)</span>
4.  <span>[Step 2: Going Deeper](31429542.html)</span>

 Developer : Next Steps: Follow a Tutorial Path 



With your system configured and eZ Platform up and running, you're ready to dive in and follow a tutorial.

 

You may want to start by [Building a Bicycle Route Tracker in eZ Platform](Building-a-Bicycle-Route-Tracker-in-eZ-Platform_31431606.html), in which you'll learn how to build an eZ Platform website from the ground up.

 

#### All available tutorials:

-   [Building a Bicycle Route Tracker in eZ Platform](Building-a-Bicycle-Route-Tracker-in-eZ-Platform_31431606.html) — <span class="smalltext">This tutorial is a step-by-step guide to building an eZ Platform website from the ground up. </span>
-   [eZ Enterprise Beginner Tutorial - It's a Dog's World](32868209.html) — <span class="smalltext">This tutorial will guide you through the process of making and customizing a front page for your website. For this purpose we will use a feature of eZ Platform Enterprise Edition called Landing Page.</span>
-   [Creating a Tweet Field Type](Creating-a-Tweet-Field-Type_31429766.html) — <span class="smalltext">This tutorial aims at covering the creation and development of a custom eZ Platform Field Type https://doc.ez.no/display/DEVELOPER/Field+Types+reference.</span>
-   [Extending PlatformUI with new navigation](Extending-PlatformUI-with-new-navigation_31430235.html) — <span class="smalltext">This tutorial aims at providing a step-by-step guide on how to extend the JavaScript application provided by the PlatformUI bundle https://github.com/ezsystems/PlatformUIBundle.</span>

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Community Resources](Community-Resources_31429530.html)</span>
4.  <span>[How to Contribute](How-to-Contribute_31429587.html)</span>

 Developer : Report and follow issues: The bugtracker 



The development of eZ projects is organized using a bugtracker. It can be found here: <a href="https://jira.ez.no" class="uri">https://jira.ez.no</a>. Its role is to centralize references to all improvements, bug fixes and documentation being added to eZ projects.

The first thing you should do in order to be able to get involved and have feedback on what is happening on eZ projects is to create a JIRA account.

**Note:** The term "issue" is used to refer to a bugtracker item regardless of its type (bug, improvement, story, etc.)

# How to find an existing issue

When you have a great idea or if you have found a bug, you may want to create a new issue to let everyone know about it. Before doing that, you should make sure no one has made a similar report before.

In order to do that, you should use the search page available in the top menu (under **Issues/Search for issues**) or the search box in the top right corner. Using filters and keywords you should be able to search and maybe find an issue to update instead of creating a new one.

# How to improve existing issues

Existing issues need to be monitored, sorted and updated in order to be processed in the best way possible.

In case of bugs, trying to reproduce them, in order to confirm that they are (still) valid, is a great help for developers who will later troubleshoot and fix them. By doing that you can also provide extra information, if needed, such as:

-   Extra steps to reproduce
-   Context/environment-specific information
-   Links to duplicate or related issues

In case of improvements, you can add extra use cases and spot behaviors that might be tricky or misleading.

# How to follow an issue

Every issue has a "Start watching this issue" link. It lets you receive notifications each time the issue is updated.

This way you can get and provide feedback during the issue's life. You are also informed about ongoing development regarding the issue and can try out patches before they are integrated into the product.

# How to report an issue

If you cannot find an issue matching what you are about to report using the search page, you need to create a new one.
Click **Create** at the top of the bugtracker window and fill in the form:

-   **Project**: Select **eZ Publish/Platform** if your issue affects platform as a standalone project, or **eZ Studio** if eZ Platform Enterprise Edition is needed in order to reproduce the issue.
-   **Issue type**: Choose **Bug** or **Improvement** depending on what you are reporting, do not use other issue types (they are for internal use only).
-   **Summary**: Write a short sentence describing what you are reporting.
-   **Security level**: Select security if you are reporting a security issue. It will make your issue visible only to you and the core dev team until it is fixed and distributed.
-   **Priority**: Select the priority you consider the issue to be. Please try to keep a cool head while selecting it. A 1 pixel alignment bug is not a "blocker" :)
-   **Component/s**: This is important, as it will make your issue appear on the radar (dashboards, filters) of people dealing with various parts of eZ projects.
-   **Affect version/s**: Add the versions of the application you experienced the issue on.
-   **Fix version/s**: Leave blank.
-   **Assignee**: Leave blank, unless you are willing to work on the issue yourself.
-   **Reporter**: Leave as is (yourself).
-   **Environment**: Enter specific information regarding your environment that could be relevant in the context of the issues.
-   **Description**: This is the most important part of the issue report. In case of a bug, it **must** contain explicit steps to reproduce to your issue. Anybody should be able to reproduce it at first try. In case of an improvement, it needs to contain use cases and detailed information regarding the expected behavior.
-   **Labels**: Leave blank.
-   **Epic Link**: Leave blank.
-   **Sprint**: Leave blank.

 

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>

 Developer : Under the Hood: How eZ Platform Works 



Contributing to the doc

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
This part of the documentation is still a <span class="status-macro aui-lozenge aui-lozenge-current">WORK-IN-PROGRESS</span>. Would you like to contribute to it?

If you have any thoughts or tips to share, let us know in the comments below, visit our <a href="http://ez-community-on-slack.herokuapp.com/">Slack channel</a> or take a look at other ways to [Contribute to Documentation](https://doc.ez.no/display/DEVELOPER/Contribute+to+Documentation).

-   [Philosophy & Guiding Principles: The eZ Way](31429705.html)
-   [Architecture: An Open Source PHP CMS Built On Symfony2 Full Stack](31429707.html)
-   [Content Model: Content is King!](31429709.html)
-   [Interfacing with eZ: APIs and GUIs](31429711.html)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>
4.  <span>[Introduction](Introduction_31429657.html)</span>

 Developer : What is eZ Platform? 



eZ Platform is an open-source, Symfony-based CMS. With its modern architecture and flexibility it lets you customize, extend and scale your sites and apps with ease. It is built on top of the Symfony full-stack framework and enables you to tailor your content model and distribute your content however you like.

 

**Take control of your content:**

Seamlessly deliver content on your site or app and use our fully featured REST API to integrate content from apps or deliver Content as a Service.

**Take advantage of Symfony, the leading PHP framework:**

Develop in a very similar way to pure Symfony, with the same templating system, Twig, the same library for deployment and version dependency, Composer, and many other Symfony bundles and components.

**Speed up time-to-market:**

Developers who use Symfony can start customizing and extending eZ Platform right out of the gate. New to Symfony? You have plenty to gain.

**Start with clean code:**

eZ carries a substantially low level of technical debt compared to many other CMSs.

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>
4.  <span>[Introduction](Introduction_31429657.html)</span>

 Developer : What is eZ Platform Enterprise Edition? 



eZ Platform Enterprise Edition is a commercial addition and extension to eZ Platform. It makes use of everything that the platform has to offer, and expands it capabilities.

Enterprise contains a new intuitive, easy-to-learn editing interface called Studio UI, but also adds new functionalities to the existing interfaces. The main features available in eZ Enterprise are:

 

**Inline editing of content:**

eZ Enterprise's Studio UI lets you create block-based Landing Pages using drag-and-drop. This makes building them easy for editors even with no web design experience or HTML knowledge, using prebuilt elements such as headers, banners, image galleries, content lists, tags and more. At the same time, developers can customize Landing Pages by creating adaptable layouts and offering their own custom blocks to be placed in them.

<span class="confluence-link"><span class="confluence-link">[Working with a Landing Page](https://doc.ez.no/display/USER/3.+Creating+content%2C+basic#id-3.Creatingcontent,basic-WorkingwithaLandingPage(Enterprise))</span></span> (in the User doc) describes how to use the Inline editor.

**Creating Landing Pages with customizable blocks:**

You can quickly switch between working on and previewing Landing Pages, which makes for comfortable editing and better control of your content.

[Creating Landing Page blocks (Enterprise)](31430614.html) shows how to create and customize you own blocks.

**Scheduling automatic publication of content on Landing Pages:**

Using a special Schedule Block you can set up content on your Landing Pages to be published according to a custom schedule, at predefined dates and times. A Timeline slider lets you preview what the pages will look like at any time.

<span class="confluence-link"> </span>[<span class="confluence-link">Scheduling</span>](https://doc.ez.no/display/USER/5.+Publishing#id-5.Publishing-Scheduling(Enterprise)) (User doc) presents how to use this block to plan airtimes.

**Content review workflow:**

Flex Workflow is a collaboration feature. You can send your content draft to any user and let them look through, modify it and send it onward through your review process.

<span class="confluence-link"> </span>[<span class="confluence-link">Review workflow</span>](https://doc.ez.no/display/USER/5.+Publishing#id-5.Publishing-Reviewworkflow(Enterprise)) (User doc) describes how to send and receive content for review.

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>
4.  <span>[Introduction](Introduction_31429657.html)</span>

 Developer : Why eZ? 



<span class="jira-issue"> <a href="https://jira.ez.no/browse/COM-19966?src=confmacro" class="jira-issue-key"><img src="https://jira.ez.no/images/icons/issuetypes/newfeature.png" class="icon" />COM-19966</a> - <span class="summary">Developer Feedback Section</span> <span class="aui-lozenge aui-lozenge-subtle aui-lozenge-complete jira-macro-single-issue-export-pdf">Open</span> </span>






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>
4.  <span>[Under the Hood: How eZ Platform Works](31429659.html)</span>

 Developer : Philosophy & Guiding Principles: The eZ Way 








1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>
4.  <span>[Under the Hood: How eZ Platform Works](31429659.html)</span>

 Developer : Architecture: An Open Source PHP CMS Built On Symfony2 Full Stack 



<span style="color: rgb(0,0,0);">This page describes the new generation eZ CMS architecture introduced as of eZ Platform and eZ Studio in 2015. However, this architecture has already been battle-tested by large multinational companies as part of eZ Publish Platform 5.x series since 2012.</span>

<span style="color: rgb(0,0,0);">
</span>

# Overview

<span style="color: rgb(128,128,128);">TODO: Illustration of layers: Symfony &gt; eZ Platform &gt; eZ Services</span>

## Symfony Full stack

## eZ Platform

# eZ Platform Architecture details

<span style="color: rgb(0,0,0);text-decoration: none;"> </span><span style="color: rgb(0,0,0);text-decoration: none;"> </span>

<span class="confluence-embedded-file-wrapper confluence-embedded-manual-size"><img src="attachments/31429707/31431654.png" class="confluence-embedded-image" width="600" /></span>

<span style="color: rgb(0,0,0);text-decoration: none;">
</span>

<span style="color: rgb(0,0,0);text-decoration: none;">The architecture is layered and uses clearly defined APIs between the layers.</span>

-   <span style="color: rgb(0,0,0);text-decoration: none;">The **business logic** is defined in a new kernel. This business logic is exposed to applications via an API (the <span style="color: rgb(0,0,0);text-decoration: none;"><span style="color: rgb(0,0,0);text-decoration: none;">[Public API](eZ-Platform-Public-PHP-API_31429583.html)</span></span>). Developers rely on this to develop websites and web applications using Symfony to organize the way they develop the user interface layer. </span>

-   <span style="color: rgb(0,0,0);text-decoration: none;">User interfaces are developed using the Twig template engine but directly querying the <span style="color: rgb(0,0,0);text-decoration: none;"><span style="color: rgb(0,0,0);text-decoration: none;"><span style="color: rgb(0,0,0);text-decoration: none;">[Public API](eZ-Platform-Public-PHP-API_31429583.html)</span></span></span>.</span>

-   <span style="color: rgb(0,0,0);text-decoration: none;">Integration of eZ Platform in other applications is done using the <span style="color: rgb(0,0,0);text-decoration: none;"> </span>[<span style="color: rgb(0,0,0);text-decoration: none;"><span class="confluence-link">Rest API</span></span>](REST-API-Guide_31430286.html), which itself relies also on the <span style="color: rgb(0,0,0);text-decoration: none;"><span style="color: rgb(0,0,0);text-decoration: none;"><span style="color: rgb(0,0,0);text-decoration: none;">[Public API](eZ-Platform-Public-PHP-API_31429583.html)</span></span></span>.</span>

-   <span style="color: rgb(0,0,0);text-decoration: none;">Finally, the development of extensions for eZ Platform is done using the Symfony framework when it comes to the structure of the code, and once again relying on the Public API when it comes to accessing content management functions.</span>

<span style="color: rgb(0,0,0);text-decoration: none;">At a lower level, the new architecture also totally redefined the way the system stores data. While this is not finalized in version 5.0 (where the new storage system is only shipped with MySQL support), the architecture, when finalized will rely on a storage API that will be used to develop drivers to any kind of storage subsystem.</span>

<span style="color: rgb(0,0,0);text-decoration: none;">A motto for this new architecture is to **heavily use APIs** that will be maintained on the long term to **ease upgrades and provide lossless couplings** between all parts of the architecture, <span style="color: rgb(0,0,0);text-decoration: none;">at the same time</span> improving the migration capabilities of the system. </span>

 

 

#### In this topic:

-   [Overview](#Architecture:AnOpenSourcePHPCMSBuiltOnSymfony2FullStack-Overview)
    -   [Symfony Full stack](#Architecture:AnOpenSourcePHPCMSBuiltOnSymfony2FullStack-SymfonyFullstack)
    -   [eZ Platform](#Architecture:AnOpenSourcePHPCMSBuiltOnSymfony2FullStack-eZPlatform)
-   [eZ Platform Architecture details](#Architecture:AnOpenSourcePHPCMSBuiltOnSymfony2FullStack-eZPlatformArchitecturedetails)

## Attachments:

<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [ez5-architecture 5.4.5.png](attachments/31429707/31431654.png) (image/png)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>
4.  <span>[Under the Hood: How eZ Platform Works](31429659.html)</span>

 Developer : Content Model: Content is King! 



Everyone knows that Content is King, and in eZ Platform, everything is Content!

Take a look at the content model underlying eZ Platform.

 

### Content model overview

The content structure in eZ is based on ideas borrowed from Object-Oriented programming, as seen in popular languages such as C\#, Java or PHP.

In this understanding an "object" in the eZ Platform is called a Content Item and represents <span class="DEF">a single piece of content: an article, a blog post, an image, a product, etc.</span> Each Content item is an instance of a "class," called a Content Type.

 

 

<span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"></span>
An introduction to the eZ content model aimed at non-developer users, is available at [Under the hood, concepts and organization](https://doc.ez.no/display/USER/2.+Under+the+hood%2C+concepts+and+organization).

 

 

#### Related topics:

[Content items, Content Types and Fields](31430275.html)

[Locations](https://doc.ez.no/display/DEVELOPER/Repository#Repository-LocationsLocations)

[Content Relations](Repository_31432023.html#Repository-ContentRelations)

[Internationalization](Internationalization_31429671.html)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>
4.  <span>[Under the Hood: How eZ Platform Works](31429659.html)</span>

 Developer : Interfacing with eZ: APIs and GUIs 



You can interface with eZ Platform using both APIs and a GUI.

eZ Platform offers two APIs:

-   the [REST API](REST-API-Guide_31430286.html) allows you to interact with an eZ Platform installation using the HTTP protocol, following a <span>REST</span> interaction model,
-   the [Public (PHP) API](Public-API-Guide_31430303.html) exposes a Repository which allows you to create, read, update, manage and delete all objects available in eZ Platform, first and foremost content, but also related objects like sections, locations, content types, content types groups, languages and so on.

 

The graphical interface available through the [backend interface](Extending-eZ-Platform_31429689.html) allows editors and content managers to easily create and manipulate content without developer knowledge. The GUI also covers a number of fundamental administrative operations available in an Admin Panel.

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
You can find a description and guide for using the GUI for non-developers in a [separate documentation center](https://doc.ez.no/display/USER/Documentation).

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Tutorials](Tutorials_31429522.html)</span>
4.  <span>[Creating a Tweet Field Type](Creating-a-Tweet-Field-Type_31429766.html)</span>

 Developer : Implement the Tweet\\Value class 



The Value class of a Field Type is by design very simple. It is meant to be stateless, and as lightweight as possible. Therefore, this class must contain as little logic as possible, as this is the responsibility of the Type class .

The Value will at least contain:

-   public properties, used to store the actual data 

-   an implementation of the `__toString()` method (required by the Value interface we inherit from)

By default, the constructor from `      FieldType\Value    ` will be used, and allows you to pass a hash of property/value pairs. In our example, we can see that we can override it as well if we want.

The Tweet Field Type is going to store three things:

-   The tweet’s URL

-   The tweet’s author URL

-   The body, as an HTML string  

At this point, we don’t care where those are stored. All we care about is what we want our Field Type to expose as an API. We end up with the following properties:

**eZ/FieldType/Tweet/Value.php**

``` brush:
/**
* Tweet URL on twitter.com (http://twitter.com/UserName/status/id).
* @var string
*/
public $url;

 
/**
* Author's tweet URL (http://twitter.com/UserName)
* @var string
*/
public $authorUrl;

 
/**
* The tweet's embed HTML
* @var string
*/
public $contents;
```

The only thing left to honor the `      FieldType\Value    ` interface is the `      __toString()` method. Let’s say that ours will return the tweet’s URL:

**eZ/FieldType/Tweet/Value.php**

``` brush:
public function __toString()
{
   return $this->url;
}
```

**Tutorial path**






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Tutorials](Tutorials_31429522.html)</span>
4.  <span>[Creating a Tweet Field Type](Creating-a-Tweet-Field-Type_31429766.html)</span>

 Developer : Implement the Tweet\\Type class 



As said in the introduction, the Type class of a Field Type must implement `eZ\Publish\SPI\FieldType\FieldType` (later referred to as "Field Type interface").

All native Field Types also extend the `eZ\Publish\Core\FieldType\FieldType` abstract class that implements this interface and provides implementation facilities through a set of abstract methods of its own. In this case, Type classes implement a mix of methods from the Field Type interface and from the abstract Field Type.

Let’s go over those methods and their implementation.

#### Identification method: `getFieldTypeIdentifier()`

It must return the string that uniquely identifies this Field Type (DataTypeString in legacy). We will use "`eztweet`":

**eZ/FieldType/Tweet/Type**

``` brush:
public function getFieldTypeIdentifier()
{
   return 'eztweet';
}
```

#### Value handling methods: `createValueFromInput()` and `checkValueStructure()`

Both methods are used by the abstract Field Type implementation of `acceptValue()`. This Field Type interface method checks and transforms various input values into the type's own Value class: `eZ\FieldType\Tweet\Value`. This method must:

-   either return the Value object it was able to create out of the input value,
-   or return this value untouched. The API will detect this and inform that the input value was not accepted.

The only acceptable value for our type is the URL of a tweet (we could of course imagine more possibilities). This should do:

 

``` brush:
protected function createValueFromInput( $inputValue )
{
   if ( is_string( $inputValue ) )
   {
       $inputValue = new Value( array( 'url' => $inputValue ) );
   }
 
   return $inputValue;
}
```

Use this method to provide convenient ways to set an attribute’s value using the API. This can be anything from primitives to complex business objects.

Next, we will implement `     checkValueStructure()`. It is called by the abstract Field Type to ensure that the Value fed to the Type is acceptable. In our case, we want to be sure that `Tweet` `     \Value::$url` is a string:

 

``` brush:
protected function checkValueStructure( BaseValue $value )
{
   if ( !is_string( $value->url ) )
   {
       throw new eZ\Publish\Core\Base\Exceptions\InvalidArgumentType(
           '$value->url',
           'string',
           $value->url
       );
   }
}
```

Yes, we execute the same check as in `createValueFromInput()`. But both methods aren't responsible for the same thing. The first will, *if given something else than a Value of its type*, try to convert it to one. `checkValueStructure()` will always be used, even if the Field Type is directly fed a `Value` object, and not a string.

#### Value initialization: `getEmptyValue()`

This method provides what is considered as an empty value of this type, depending on our business requirements. No extra initialization is required in our case.

 

``` brush:
public function getEmptyValue()
{
   return new Value;
}
```

If you run the unit tests at this point, you should get about five failures, all of them on the `fromHash()` or `     toHash()` methods.

#### Validation methods: `validateValidatorConfiguration()` and `validate()`

The Type class is also responsible for validating input data (to a `Field`), as well as configuration input data (to a `FieldDefinition`). In this tutorial, we will run two validation operations on input data:

-   validate submitted urls, ensuring they actually reference a twitter status;

-   limit input to a known list of authors, as an optional validation step.

`     validateValidatorConfiguration()` will be called when an instance of the Field Type is added to a Content Type, to ensure that the validator configuration is valid. For a TextLine (length validation), it means checking that both min length and max length are positive integers, and that min is lower than max.

When an instance of the type is added to a Content Type, `validateValidatorConfiguration()` receives the configuration for the validators used by the Type as an array. It must return an array of error messages if errors are found in the configuration, and an empty array if no errors were found.

For TextLine, the provided array looks like this:

 

``` brush:
array(
   'StringLengthValidator' => array(
       'minStringLength' => 0,
       'maxStringLength' => 100
   )
);
```

The structure of this array is totally free, and up to each type implementation. We will in this tutorial mimic what is done in native Field Types:

Each level one key is the name of a validator, as acknowledged by the Type. That key contains a set of parameter name / parameter value rows. We must check that:

-   all the validators in this array are known to the type

-   arguments for those validators are valid and have sane values

We do not need to include mandatory validators if they don’t have options. Here is an example of what our Type expects as validation configuration:

 

``` brush:
array(
   ‘TweetAuthorValidator’ => array(
       ‘AuthorList’ => array( ‘johndoe’, ‘janedoe’ )
   )
);
```

The configuration says that tweets must be either by johndoe or by janedoe. If we had not provided TweetAuthorValidator at all, it would have been ignored.

We will iterate over the items in `$validatorConfiguration` and:

add errors for those we don’t know about;

check that provided arguments are known and valid:

-   TweetAuthorValidator accepts a non-empty array of valid Twitter usernames

 

``` brush:
public function validateValidatorConfiguration( $validatorConfiguration )
{
   $validationErrors = array();

   foreach ( $validatorConfiguration as $validatorIdentifier => $constraints )
   {
       // Report unknown validators
       if ( !$validatorIdentifier != 'TweetAuthorValidator' )
       {
           $validationErrors[] = new ValidationError( "Validator '$validatorIdentifier' is unknown" );
           continue;
       }
 
       // Validate arguments from TweetAuthorValidator
       if ( !isset( $constraints['AuthorList'] ) || !is_array( $constraints['AuthorList'] ) )
       {
           $validationErrors[] = new ValidationError( "Missing or invalid AuthorList argument" );
           continue;
       }
 
       foreach ( $constraints['AuthorList'] as $authorName )
       {
           if ( !preg_match( '/^[a-z0-9_]{1,15}$/i', $authorName ) )
           {
               $validationErrors[] = new ValidationError( "Invalid twitter username" );
           }
       }
   }

 
   return $validationErrors;
}
```

`     validate()` is the method that runs the actual validation on data, when a content item is created with a Field of this type:

 

``` brush:
   public function validate( FieldDefinition $fieldDefinition, SPIValue $fieldValue )
   {
       $errors = array();

       if ( $this->isEmptyValue( $fieldValue ) )
       {
           return $errors;
       }
 
       // Tweet Url validation
       if ( !preg_match( '#^https?://twitter.com/([^/]+)/status/[0-9]+$#', $fieldValue->url, $m ) )
           $errors[] = new ValidationError( "Invalid twitter status url %url%", null, array( $fieldValue->url ) );

       $validatorConfiguration = $fieldDefinition->getValidatorConfiguration();
       if ( isset( $validatorConfiguration['TweetAuthorValidator'] ) )
       {
           if ( !in_array( $m[1], $validatorConfiguration['TweetAuthorValidator']['AuthorList'] ) )
           {
               $errors[] = new ValidationError(
                   "Twitter user %user% is not in the approved author list",
                   null,
                   array( $m[1] )
               );
           }
       }
 
       return $errors;
   }
```

First, we validate the url with a regular expression. If it doesn’t match, we add an instance of `     ValidationError   ` to the return array. Note that the tested value isn’t directly embedded in the message but passed as an argument. This ensures that the variable is properly encoded in order to prevent attacks, and allows for singular/plural phrases using the second parameter.

Then, if our Field Type instance’s configuration contains a `     TweetAuthorValidator   ` key, we check that the username in the status url matches one of the valid authors.

#### Metadata handling methods: `getName()` and `getSortInfo()`.

Field Types require two methods related to Field metadata:

-   ` getName()       ` is used to generate a name out of a Field value, either to name a Content item (naming pattern in legacy) or to generate a part for an URL Alias.

-   ` getSortInfo()       ` is used by the persistence layer to obtain the value it can use to sort & filter on a Field of this type

Obviously, a tweet’s full URL isn’t really suitable as a name. Let’s use a subset of it: `     <username>-<tweetId>   ` should be reasonable enough, and suitable for both sorting and naming.

 

We can assume that this method will not be called if the Field is empty, and will assume that the URL is a valid twitter URL:

 

``` brush:
public function getName( SPIValue $value )
{
   return preg_replace(
       '#^https?://twitter\.com/([^/]+)/status/([0-9]+)$#',
       '$1-$2',
       (string)$value->url );
}

 
protected function getSortInfo( CoreValue $value )
{
   return $this->getName( $value );
}
```

In `     getName()` we run a regular expression replace on the URL to extract the part we’re interested in.

This name is a perfect match for `     getSortInfo()` as it allows us to sort on the tweet’s author and on the tweet’s ID.

#### Field Type serialization methods: `fromHash()` and `toHash()`

Both methods defined in the Field Type interface, are core to the REST API. They are used to export values to serializable hashes.

In our case, it is quite easy:

-   ` toHash()       ` will build a hash with every property from `Tweet\Value`;

-   ` fromHash()       ` will instantiate a `Tweet\Value` with the hash it receives.  

 

``` brush:
public function fromHash( $hash )
{
   if ( $hash === null )
   {
       return $this->getEmptyValue();
   }
   return new Value( $hash );
}
 
public function toHash( SPIValue $value )
{
   if ( $this->isEmptyValue( $value ) )
   {
       return null;
   }
   return array(
       'url' => $value->url
   );
}
```

#### Persistence methods: `fromPersistenceValue` and `toPersistenceValue`

Storage of Field Type data is done through the persistence layer (SPI).

Field Types use their own Value objects to expose their contents using their own domain language. However, to store those objects, the Type needs to map this custom object to a structure understood by the persistence layer: `PersistenceValue`. This simple value object has three properties:

-   `data` – standard data, stored using the storage engine's native features
-   `externalData` – external data, stored using a custom storage handler
-   `sortKey` – sort value used for sorting

The role of those mapping methods is to convert a `Value` of the Field Type into a `PersistenceValue` and the other way around.

About external storage

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
Whatever is stored in {{externalData}} requires an external storage handler to be written. Read more about external storage on [Field Type API and best practices](Field-Type-API-and-best-practices_31430767.html).

External storage is beyond the scope of this tutorial, but many examples can be found in existing Field Types.

We will follow a simple implementation here: the `Tweet\Value` object will be serialized as an array to the `code` property using `fromHash()` and `toHash()`:

**Tweet\\Type**

``` brush:
/**
 * @param \EzSystems\TweetFieldTypeBundle\eZ\Publish\FieldType\Tweet\Value $value
 * @return \eZ\Publish\SPI\Persistence\Content\FieldValue
 */
public function toPersistenceValue( SPIValue $value )
{
    if ( $value === null )
    {
        return new PersistenceValue(
            array(
                "data" => null,
                "externalData" => null,
                "sortKey" => null,
            )
        );
    }
    return new PersistenceValue(
        array(
            "data" => $this->toHash( $value ),
            "sortKey" => $this->getSortInfo( $value ),
        )
    );
}
/**
 * @param \eZ\Publish\SPI\Persistence\Content\FieldValue $fieldValue
 * @return \EzSystems\TweetFieldTypeBundle\eZ\Publish\FieldType\Tweet\Value
 */
public function fromPersistenceValue( PersistenceValue $fieldValue )
{
    if ( $fieldValue->data === null )
    {
        return $this->getEmptyValue();
    }
    return new Value( $fieldValue->data );
}
```

 

##### Fetching data from the Twitter API

As explained in the tutorial's introduction, we will enrich our tweet's URL with the embed version, fetched using the Twitter API. To do so, we will, when `toPersistenceValue()` is called, fill in the value's contents property from this method, before creating the `PersistenceValue` object.

First, we need a twitter client in `Tweet\Type`. For convenience, we provide one in this tutorial's bundle:

-   The `Twitter\TwitterClient` class:
-   The `Twitter\TwitterClientInterface` interface
-   An `ezsystems.tweetbundle.twitter.client` service that uses the class above.

The interface has one method: `getEmbed( $statusUrl )` that, given a tweet's URL, returns the embed code as a string. The implementation is very simple, for the sake of simplicity, but gets the job done. Ideally, it should at the very least handle errors, but it is not necessary here.

###### Injecting the Twitter client into `Tweet\Type`

Our Field Type doesn't have a constructor yet. We will create one, with an instance of `Twitter\TwitterClientInterface` as the argument, and store it in a new protected property:

**eZ/Publish/FieldType/Tweet/Type.php:**

``` brush:
use EzSystems\TweetFieldTypeBundle\Twitter\TwitterClientInterface;
 
class Type extends FieldType
{
    /** @var TwitterClientInterface */
    protected $twitterClient;

    public function __construct( TwitterClientInterface $twitterClient )
    {
        $this->twitterClient = $twitterClient;
    }
}
```

###### Completing the value using the twitter client

As described above, before creating the `PersistenceValue` object in `toPersistenceValue`, we will fetch the tweet's embed contents using the client, and assign it to `Tweet\Value::$data`:

**eZ/Publish/FieldType/Tweet/Type.php**

``` brush:
 public function toPersistenceValue( SPIValue $value )
{
    // if ( $value === null )
    // {...}


    if ( $value->contents === null )
    {
        $value->contents = $this->twitterClient->getEmbed( $value->url );
    }
    return new PersistenceValue(
    // array(...)
}
```

And that's it! When the persistence layer stores content from our type, the value will be completed with what the twitter API returns.

 

**Tutorial path**






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Cookbook](Cookbook_31429528.html)</span>

 Developer : Creating Landing Page layouts (Enterprise) 



# Description

<span class="status-macro aui-lozenge aui-lozenge-current">V1.2</span>

A Landing Page has a customizable <span class="DEF"><span class="DEF">layout</span></span> with multiple zones where you can place predefined blocks with content.

By default eZ Enterprise comes with a number of preset layouts. You can, however, add custom layouts with zones to your configuration.

# Solution

## Defining the layout

A Landing Page layout is composed of zones.

### Zone structure

Each zone contains the following parameters: **<span style="color: rgb(255,0,0);">
</span>**

| Name             | Description                  |
|------------------|------------------------------|
| &lt;zone\_id&gt; | *Required*. A unique zone ID |
| &lt;name&gt;     | *Required*. Zone name        |

### Defining a zone layout

You can define a new layout file (e.g. in Twig) for a zone and include it in a Landing page layout.<span style="color: rgb(255,0,0);">
</span>

A Zone is a container for blocks. The best way to display blocks in the zone is to iterate over a blocks array and render the blocks in a loop.

<span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"></span>
 For eZ Enterprise, the `data-studio-zone` attribute is required to allow dropping the Content into specific zones.

**Example zone.html.twig**

``` brush:
<div data-studio-zone="{{ zones[0].id }}">                                       
    {# If a zone with [0] index contains any blocks #}
    {% if zones[0].blocks %}                                                    
        {# for each block #}
        {% for block in zone[0].blocks %}                                               
            {# create a new layer with appropriate id #}
            <div class="landing-page__block block_{{ block.type }}">            
                {# render the block by using the "ez_block:renderBlockAction" controller #}
                {{ render_esi(controller('ez_block:renderBlockAction', {        
                        {# id of the current content #}
                        'contentId': contentInfo.id,                            
                        {# id of the current block #}
                        'blockId': block.id                                     
                    })) 
                }}
            </div>        
        {% endfor %}    
    {% endif %}
</div>
```

 

## Creating and configuring layouts

In the Demo installation the layout configuration is stored in ezstudio-demo-bundle/Resources/config/default\_layouts.yml:

**Example default\_layouts.yml**

``` brush:
layouts:
    1:  
        identifier: 1                       
        name: One column
        description: 'One column'
        thumbnail: '/bundles/ezstudiodemo/images/layouts/1.png'
        template: eZStudioDemoBundle:layouts:1.html.twig
        zones:
            first:
                name: First zone

    1_2:
        identifier: 1_2 
        name: Two zones in columns, narrow left, wide right
        description: Two zones in columns, narrow left, wide right
        thumbnail: '/bundles/ezstudiodemo/images/layouts/1_2.png'
        template: eZStudioDemoBundle:layouts:1_2.html.twig
        zones:
            first:
                name: First zone
            second:
                name: Second zone

    1_2__1:   
        identifier: 1_2__1
        name: Three zones, two columns, narrow left, wide right in first row and one row
        description: Three zones, two columns, narrow left, wide right in first row and one row
        thumbnail: '/bundles/ezstudiodemo/images/layouts/1_2__1.png'
        template: eZStudioDemoBundle:layouts:1_2__1.html.twig
        zones:
            first:
                name: First zone
            second:
                name: Second zone
            third:
                name: Third zone
```

 

The following parameters need to be included in the settings of the default\_layouts.yml file:

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th align="left">Parameter</th>
<th align="left">Type</th>
<th align="left">Description</th>
<th align="left">Required</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td align="left"><p><strong>layouts</strong></p></td>
<td align="left">string</td>
<td align="left">Layout config root</td>
<td align="left">Yes</td>
</tr>
<tr class="even">
<td align="left"><p><strong>number</strong></p></td>
<td align="left">string</td>
<td align="left">Unique key of the layout</td>
<td align="left">Yes</td>
</tr>
<tr class="odd">
<td align="left"><p>{ID}/<strong>identifier</strong></p></td>
<td align="left">string</td>
<td align="left">ID of the Layout</td>
<td align="left">Yes</td>
</tr>
<tr class="even">
<td align="left"><p>{ID}/<strong>name</strong></p></td>
<td align="left">string</td>
<td align="left">Name of the Layout</td>
<td align="left">Yes</td>
</tr>
<tr class="odd">
<td align="left"><p>{ID}/<strong>description</strong></p></td>
<td align="left">string</td>
<td align="left">Description of Layout</td>
<td align="left">Yes</td>
</tr>
<tr class="even">
<td align="left"><p>{ID}/<strong>thumbnail</strong></p></td>
<td align="left">string</td>
<td align="left">&lt;path&gt; to thumbnail image</td>
<td align="left">Yes</td>
</tr>
<tr class="odd">
<td align="left"><p>{ID}/<strong>template</strong></p></td>
<td align="left">string</td>
<td align="left"><p>&lt;path&gt; to template View</p>
<p>For example:<br />
<em>eZStudioDemoBundle:layouts:1.html.twig</em></p>
<p><em>&lt;bundle&gt;:&lt;directory&gt;:&lt;file name&gt;</em></p></td>
<td align="left">Yes</td>
</tr>
<tr class="even">
<td align="left"><p>{ID}/<strong>zones</strong></p></td>
<td align="left">string</td>
<td align="left"><p>Collection of zones</p></td>
<td align="left">Yes</td>
</tr>
<tr class="odd">
<td align="left">{ID}/{zone}/<strong>zone_id</strong></td>
<td align="left">string</td>
<td align="left">ID of the zone</td>
<td align="left">Yes</td>
</tr>
<tr class="even">
<td align="left">{ID}/{zone}/<strong>name</strong></td>
<td align="left">string</td>
<td align="left">Zone name</td>
<td align="left">Yes</td>
</tr>
</tbody>
</table>

 

 

#### In this topic:

-   [Description](#CreatingLandingPagelayouts(Enterprise)-Description)
-   [Solution](#CreatingLandingPagelayouts(Enterprise)-Solution)
    -   [Defining the layout](#CreatingLandingPagelayouts(Enterprise)-Definingthelayout)
        -   [Zone structure](#CreatingLandingPagelayouts(Enterprise)-Zonestructure)
        -   [Defining a zone layout](#CreatingLandingPagelayouts(Enterprise)-Definingazonelayout)
    -   [Creating and configuring layouts](#CreatingLandingPagelayouts(Enterprise)-Creatingandconfiguringlayouts)

 

#### Related topics:

[Landing Page Field Type (Enterprise)](31430521.html)

[Creating Landing Page blocks (Enterprise)](31430614.html)

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>
4.  <span>[Under the Hood: How eZ Platform Works](31429659.html)</span>
5.  <span>[Content Model: Content is King!](31429709.html)</span>

 Developer : Content items, Content Types and Fields 



# <span id="Contentitems,ContentTypesandFields-Content_items" class="confluence-anchor-link"></span>Content items

A Content item is the basic unit of content that is managed in the platform.

The substance of a Content item is made up of different Fields and their values, as defined by the Content Type. These Fields can cover data ranging from single variables or text lines to media files or passages of formatted text.

Aside from the Fields, each Content item is also characterized by general data that controls the Content item's place in the system.

### Content item general information

**Content ID** – <span class="inline-comment-marker" data-ref="23099922-bf2a-4357-ac57-0617cef6131b">a unique number by which</span> the Content item is identified in the system. These numbers are not recycled, so if an item is deleted, its ID number will not be reused when a new one is created.

**Name** – a user-friendly name for the Content item. The name is generated automatically based on a pattern specified in the Content Type definition.

<span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"></span>
Content item Name is always searchable, even if the Field(s) used to generate it are not.

**Type** – the Content Type on which the Content item is based.

**Owner** – a reference to the user who initially created the Content item. This reference is set by the system the first time the Content item is published. The ownership of an item cannot be modified and will not change even if the owner is removed from the system.

**Creation time** – exact date and time when the Content item was published for the first time. This is set by the system and cannot be modified.

**Modification time** – exact date and time when the Content item was last modified. This is set by the system and cannot be modified manually, but will change every time the item is published again.

**Status** – the current state of the Content item. It can have three statuses: 0 – Draft, 1 – Published and 2 – Archived. When an item is created, its status is set to *draft*. After publishing the status changes to *published*. When a published Content item is moved to T<span class="inline-comment-marker" data-ref="54c5c2c9-a808-45d5-a670-ad18d2c155d3">rash</span>, this item becomes *archived*. If a published item is removed from the Trash (or removed without being put in the Trash first), it will be permanently deleted. 

**Section ID** – <span class="inline-comment-marker" data-ref="08edbf1a-ee6c-4e7c-9895-0194a2d8be23">the unique number of the Section</span> to which the Content item belongs. New Content items are placed in the Standard section by default. <span class="inline-comment-marker" data-ref="d3ba0868-4c89-4866-8f45-fed10ec1dce8">This behavior can be changed</span>, but content must always belong to some Section.

**Versions** – total number of versions of this Content item. A new version is created every time the Content item is modified and it is this new version that is edited. The previous / published version along with earlier versions remain untouched and its status changed to *<span class="inline-comment-marker" data-ref="7b35161c-ef49-4c9f-8f92-095c9c0d8279">Archived</span>*. A Content item always has at least one version. 

<span class="confluence-embedded-file-wrapper image-center-wrapper"><img src="attachments/31430275/31431657.png" alt="Diagram of an example Content item" class="confluence-embedded-image image-center" /></span>

The Fields that are available in a Content item are defined by the Content Type to which the Content item belongs.

 

# <span id="Contentitems,ContentTypesandFields-Content_Types" class="confluence-anchor-link"></span>Content Types

### Content Type metadata

Each Content Type is characterized by a set of metadata which define the general behavior of its instances:

**Name** – a user-friendly name that describes the Content Type. This name is used in the interface, but not internally by the system. It can consist of letters, digits, spaces and special characters; the maximum length is 255 characters. (Mandatory.)

<span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"></span>
Note that even if your Content Type defines a Field meant to store a name for the Content item (for example, a title of an article or product name), this will not be the same as this Name, as this one is a piece of metadata, not a Field.

**Identifier** – an identifier for internal use in configuration files, templates, PHP code, etc<span class="inline-comment-marker" data-ref="7c6fcdc9-2b3e-42b3-9cb3-23d12d166141">. It must be unique, can only contain lowercase letters, digits and underscores; the maximum length is 50 characters. (Mandatory.)
</span>

**Description** – a detailed description of the Content Type. (Optional.)

**Content name pattern** – a pattern for naming a new Content item based on this Content Type. The pattern usually consists of [Field identifiers](#Contentitems,ContentTypesandFields-Field_identifier) that tell the system about which Fields it should use when generating the name of a Content item. Each Field identifier has to be surrounded with angle brackets. Text outside the angle brackets will be included literally. If no pattern is provided, the system will automatically use the first Field. (Optional.)

**<span class="inline-comment-marker" data-ref="5f116753-2ea1-4670-a688-d832390debe6">URL alias name pattern</span>** – a pattern which controls how the virtual URLs of the Locations will be generated when Content items are created based on this Content Type. Note that only the last part of the virtual URL is affected. The pattern works in the same way as the Content name pattern. Text outside the angle brackets will be converted using the selected method of URL transformation. If no pattern is provided, the system will automatically use the name of the Content item itself. (Optional.)

**Container** – a flag which indicates if Content items based on this Content Type are allowed to have sub-items or not.

<span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"></span>
This flag was added for convenience and only affects the interface. In other words, it doesn't control any actual low-level logic, it simply controls the way the graphical user interface behaves.

**Default field for sorting children** – rule for sorting sub-items. If the instances of this Content Type can serve as containers, their children will be sorted according to what is selected here.

**Default sort order** – another rule for sorting sub-items. This decides the sort order for the criterion chosen above.

**Default content availability** – a flag which indicates if Content items of this Content Type should be available even without a corresponding language version. If this flag is not set, a Content item of this Type will not be available when it does not have a language version corresponding to the current siteaccess. By setting this flag you can make instances of this Content Type available regardless of the language criterion.

<span class="confluence-embedded-file-wrapper image-center-wrapper confluence-embedded-manual-size"><img src="attachments/31430275/31431659.png" alt="Creating a new Content Type" class="confluence-embedded-image image-center" width="500" /></span>

### Field definitions

Aside from the metadata, a Content Type contains any number of Field definitions (but has to contain at least one). They determine what Fields of what Field Types will be included in all Content items created based on this Content Type.

A Content Type and its Field definitions can be modified after creation, even if there are already Content items based on it in the system. When a Content Type is modified, each of its instances will be changed as well. If a new Field definition is added to a Content Type, this Field will appear (empty) in every relevant Content item. If a Field definition is deleted from the Content Type, all the corresponding Fields will be removed from Content items of this type.

<span class="confluence-embedded-file-wrapper image-center-wrapper"><img src="attachments/31430275/31431660.png" alt="Diagram of an example Content Type" class="confluence-embedded-image image-center" /></span>

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
<span class="status-macro aui-lozenge aui-lozenge-current">V1.3</span>

You can assign each Field defined in a Content Type to a group by selecting one of the groups in the Category drop-down. [Available groups can be configured in the content repository](Repository_31432023.html#Repository-ContentRepositoryConfiguration).

 

 

# <span id="Contentitems,ContentTypesandFields-Fields" class="confluence-anchor-link"></span>Fields

A Field is the smallest unit of storage in the content model and the building block that all Content items consist of. Every Field belongs to a Field Type.

### Field value validation

The values entered in a field may undergo validation, which means the system makes sure that they are correct for the chosen Field Type and can be used without a problem.

Whether validation is performed or not depends on the settings of a particular Field Type. Validation cannot be turned off for a Field if its Field Type supports it.

### Field details

Aside from the Field Type, the Field definition in a Content Type provides the following information:

**Name** – a user-friendly name that describes the Field. This name is used in the interface, but not internally by the system. It can consist of letters, digits, spaces and special characters; the maximum length is 255 characters. If no name is provided, a unique one is automatically generated.

**<span id="Contentitems,ContentTypesandFields-Field_identifier" class="confluence-anchor-link"></span>Identifier** – an identifier for internal use in configuration files, templates, PHP code, etc. It can only contain lowercase letters, digits and underscores; the maximum length is 50 characters. This identifier is also used in name patterns for the Content Type.

**Description** – a detailed description of the Field.

**Required** – a flag which indicates if the Field must have a value for the system to accept the Content item. In other words, if a Field is flagged as Required, a user will not be able to save or publish a Content item without filling in this Field.

<span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"></span>
Note that the Required flag is in no way related to Field validation. A Field's value is validated whether the Field is set as required or not.

[**Searchable**](Search_31429673.html)– a flag which indicates if the value of the Field will be indexed for searching.

<span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"></span>
The Searchable flag is not available for some Fields, because some Field Types do not allow searching through their values.

**[Translatable](Internationalization_31429671.html)** – a flag which indicates if the value of the Field can be translated. This is independent of the Field Type, which means that even Fields of Types such as "Float" or "Image" can be set as translatable.

 

Depending on the Field Type, there may also be other, specific information to fill in. For example, the "Country" Field Type allows you to select the default country, as well as to allow selecting multiple countries at the same time.

<span class="confluence-embedded-file-wrapper confluence-embedded-manual-size"><img src="attachments/31430275/31431661.png" alt="Diagram of content model" class="confluence-embedded-image" width="610" /></span>

 

#### In this topic:

-   [Content items](#Contentitems,ContentTypesandFields-Content_itemsContentitems)
    -   [Content item general information](#Contentitems,ContentTypesandFields-Contentitemgeneralinformation)
-   [Content Types](#Contentitems,ContentTypesandFields-Content_TypesContentTypes)
    -   [Content Type metadata](#Contentitems,ContentTypesandFields-ContentTypemetadata)
    -   [Field definitions](#Contentitems,ContentTypesandFields-Fielddefinitions)
-   [Fields](#Contentitems,ContentTypesandFields-FieldsFields)
    -   [Field value validation](#Contentitems,ContentTypesandFields-Fieldvaluevalidation)
    -   [Field details](#Contentitems,ContentTypesandFields-Fielddetails)

 

## Attachments:

<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [content\_model\_item\_diagram.png](attachments/31430275/31431657.png) (image/png)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [Admin Panel - New Content Type.png](attachments/31430275/31431659.png) (image/png)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [content\_model\_type\_diagram.png](attachments/31430275/31431660.png) (image/png)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [content\_model\_diagram.png](attachments/31430275/31431661.png) (image/png)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[API](API_31429524.html)</span>
4.  <span>[eZ Platform Public PHP API](eZ-Platform-Public-PHP-API_31429583.html)</span>
5.  <span>[Public API Guide](Public-API-Guide_31430303.html)</span>

 Developer : Browsing, finding, viewing 



We will start by going through the various ways to find and retrieve content from eZ Platform using the API. While this will be covered in further dedicated documentation, it is necessary to explain a few basic concepts of the Public API. In the following recipes, you will learn about the general principles of the API as they are introduced in individual recipes.

## Displaying values from a Content item

In this recipe, we will see how to fetch a Content item from the repository, and obtain its Field's content. 

Let's first see the full code. You can see the Command line version at <a href="https://github.com/ezsystems/CookbookBundle/blob/master/Command/ViewContentCommand.php" class="uri">https://github.com/ezsystems/CookbookBundle/blob/master/Command/ViewContentCommand.php</a>.

**Viewing content**

``` brush:
$repository = $this->getContainer()->get( 'ezpublish.api.repository' );
$contentService = $repository->getContentService();
$contentTypeService = $repository->getContentTypeService();
$fieldTypeService = $repository->getFieldTypeService();

try
{
    $content = $contentService->loadContent( 66 );
    $contentType = $contentTypeService->loadContentType( $content->contentInfo->contentTypeId );
    // iterate over the field definitions of the content type and print out each field's identifier and value
    foreach( $contentType->fieldDefinitions as $fieldDefinition )
    {
        $output->write( $fieldDefinition->identifier . ": " );
        $fieldType = $fieldTypeService->getFieldType( $fieldDefinition->fieldTypeIdentifier );
        $field = $content->getField( $fieldDefinition->identifier );

        // We use the Field's toHash() method to get readable content out of the Field
        $valueHash = $fieldType->toHash( $field->value );
        $output->writeln( $valueHash );
    }
}
catch( \eZ\Publish\API\Repository\Exceptions\NotFoundException $e )
{
    // if the id is not found
    $output->writeln( "No content with id $contentId" );
}
catch( \eZ\Publish\API\Repository\Exceptions\UnauthorizedException $e )
{
    // not allowed to read this content
    $output->writeln( "Anonymous users are not allowed to read content with id $contentId" );
}
```

Let's analyze this code block by block.

``` brush:
$repository = $this->getContainer()->get( 'ezpublish.api.repository' );
$contentService = $repository->getContentService();
$contentTypeService = $repository->getContentTypeService();
$fieldTypeService = $repository->getFieldTypeService();
```

This is the initialization part. As explained above, everything in the Public API goes through the repository via dedicated services. We get the repository from the service container, using the method `get()` of our container, obtained via `$this->getContainer()`. Using our `$repository` variable, we fetch the two services we will need using `getContentService()` and `getFieldTypeService()`.

``` brush:
try
{
    // iterate over the field definitions of the content type and print out each field's identifier and value
    $content = $contentService->loadContent( 66 );
```

Everything starting from line 5 is about getting our Content and iterating over its Fields. You can see that the whole logic is part of a `try/catch` block. Since the Public API uses Exceptions for error handling, this is strongly encouraged, as it will allow you to conditionally catch the various errors that may happen. We will cover the exceptions we expect in a later paragraph.

The first thing we do is use the Content Service to load a Content item using its ID, 66: `$contentService->loadContent   ` `( 66 )`. As you can see on the API doc page, this method expects a Content ID, and returns a <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Content.html">Content Value Object</a>.

``` brush:
foreach( $contentType->fieldDefinitions as $fieldDefinition )
{
    // ignore ezpage
    if( $fieldDefinition->fieldTypeIdentifier == 'ezpage' )
        continue;
    $output->write( $fieldDefinition->identifier . ": " );
    $fieldType = $fieldTypeService->getFieldType( $fieldDefinition->fieldTypeIdentifier );
    $fieldValue = $content->getFieldValue( $fieldDefinition->identifier );
    $valueHash = $fieldType->toHash( $fieldValue );
    $output->writeln( $valueHash );
}
```

This block is the one that actually displays the value.

It iterates over the Content item's Fields using the Content Type's FieldDefinitions (`$contentType->fieldDefinitions`).

For each Field Definition, we start by displaying its identifier (`$fieldDefinition->identifier`). We then get the Field Type instance using the Field Type Service (`$fieldTypeService->getFieldType( $fieldDefinition->fieldTypeIdentifier )`). This method expects the requested Field Type's identifier, as a string (ezstring, ezxmltext, etc.), and returns an `eZ\Publish\API\Repository\FieldType` object.

The Field Value object is obtained using the `getFieldValue()` method of the Content Value Object which we obtained using `ContentService::loadContent()`.

Using the Field Type object, we can convert the Field Value to a hash using the `toHash()` method, provided by every Field Type. This method returns a primitive type (string, hash) out of a Field instance.

With this example, you should get a first idea on how you interact with the API. Everything is done through services, each service being responsible for a specific part of the repository (Content, Field Type, etc.).

Loading Content in different languages

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
Since we didn't specify any language code, our Field object is returned in the given Content item's main language. If you'd prefer it to fall back to the SiteAccess language(s), then take advantage of TranslationHelpers. Or if you want to use an altogether different language, you can specify a language code in the `getField()` call:

``` brush:
$content->getFieldValue( $fieldDefinition->identifier, 'fre-FR' )
```

**Exceptions handling**

``` brush:
catch ( \eZ\Publish\API\Repository\Exceptions\NotFoundException $e )
{
    $output->writeln( "<error>No content with id $contentId found</error>" );
}
catch ( \eZ\Publish\API\Repository\Exceptions\UnauthorizedException $e )
{
    $output->writeln( "<error>Permission denied on content with id $contentId</error>" );
}
```

As said earlier, the Public API uses <a href="http://php.net/exceptions">Exceptions</a> to handle errors. Each method of the API may throw different exceptions, depending on what it does. Which exceptions can be thrown is usually documented for each method. In our case, `loadContent()` may throw two types of exceptions: `NotFoundException`, if the requested ID isn't found, and `UnauthorizedException` if the currently logged in user isn't allowed to view the requested content.

It is a good practice to cover each exception you expect to happen. In this case, since our Command takes the Content ID as a parameter, this ID may either not exist, or the referenced Content item may not be visible to our user. Both cases are covered with explicit error messages.

## Traversing a Location subtree

This recipe will show how to traverse a Location's subtree. The full code implements a command that takes a Location ID as an argument and recursively prints this location's subtree.

Full code

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
<a href="https://github.com/ezsystems/CookbookBundle/blob/master/Command/BrowseLocationsCommand.php" class="uri">https://github.com/ezsystems/CookbookBundle/blob/master/Command/BrowseLocationsCommand.php</a>

In this code, we introduce the <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/LocationService.html">LocationService</a>. This service is used to interact with Locations. We use two methods from this service: <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/LocationService.html#method_loadLocation"><code>loadLocation()</code></a>, and `     loadLocationChildren()   `.

**Loading a Location**

``` brush:
try
{
    // load the starting location and browse
    $location = $this->locationService->loadLocation( $locationId );
    $this->browseLocation( $location, $output );
}
catch ( \eZ\Publish\API\Repository\Exceptions\NotFoundException $e )
{
    $output->writeln( "<error>No location found with id $locationId</error>" );
}
catch( \eZ\Publish\API\Repository\Exceptions\UnauthorizedException $e )
{
    $output->writeln( "<error>Current users are not allowed to read location with id $locationId</error>" );
}
```

As for the ContentService, `loadLocation()` returns a Value Object, here a `     Location   `. Errors are handled with exceptions: `     NotFoundException   ` if the Location ID couldn't be found, and `     UnauthorizedException   ` if the current repository user isn't allowed to view this Location.

**Iterating over a Location's children**

``` brush:
private function browseLocation( Location $location, OutputInterface $output, $depth = 0 )
{
    $childLocationList = $this->locationService->loadLocationChildren( $location, $offset = 0, $limit = -1 );
    // If offset and limit had been specified to something else then "all", then $childLocationList->totalCount contains the total count for iteration use
    foreach ( $childLocationList->locations as $childLocation )
    {
        $this->browseLocation( $childLocation, $output, $depth + 1 );
    }
}
```

`LocationService::loadLocationChildren()` returns a <a href="https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/LocationList.php">LocationList</a> Value Objects that we can iterate over.

Note that unlike `loadLocation()`, we don't need to care for permissions here: the currently logged-in user's permissions will be respected when loading children, and Locations that can't be viewed won't be returned at all.

Full code

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
Should you need more advanced children fetching methods, the `         SearchService       ` is what you are looking for.

## Viewing Content Metadata

Content is a central piece in the Public API. You will often need to start from a Content item, and dig in from its metadata. Basic content metadata is made available through `     ContentInfo   ` objects. This Value Object mostly provides primitive fields: `contentTypeId`, `publishedDate` or `mainLocationId`. But it is also used to request further Content-related Value Objects from various services.

The full example implements an `ezpublish:cookbook:view_content_metadata` command that prints out all the available metadata, given a Content ID.

Full code

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
<a href="https://github.com/ezsystems/CookbookBundle/blob/master/Command/ViewContentMetaDataCommand.php" class="uri">https://github.com/ezsystems/CookbookBundle/blob/master/Command/ViewContentMetaDataCommand.php</a>

We introduce here several new services: <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/URLAliasService.html"><code>URLAliasService</code></a>, <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/UserService.html"><code>UserService</code></a> and <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/SectionService.html"><code>SectionService</code></a>. The concept should be familiar to you now.

**Services initialization**

``` brush:
/** @var $repository \eZ\Publish\API\Repository\Repository */
$repository = $this->getContainer()->get( 'ezpublish.api.repository' );
$contentService = $repository->getContentService();
$locationService = $repository->getLocationService();
$urlAliasService = $repository->getURLAliasService();
$sectionService = $repository->getSectionService();
$userService = $repository->getUserService();
```

### Setting the Repository User

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
In a command line script, the repository runs as if executed by the anonymous user. In order to identify it as a different user, you need to use the `         UserService       ` as follows:

``` brush:
$administratorUser = $userService->loadUser( 14 );
$repository->setCurrentUser( $administratorUser );
```

This may be crucial when writing maintenance or synchronization scripts.

This is of course not required in template functions or controller code, as the HTTP layer will take care of identifying the user, and automatically set it in the repository.

<span class="status-macro aui-lozenge aui-lozenge-current">V1.6</span>

Since v1.6.0, as the `setCurrentUser` method is deprecated, you need to use the following code:

``` brush:
$permissionResolver = $repository->getPermissionResolver();
$user = $userService->loadUserByLogin('admin');
$permissionResolver->setCurrentUserReference($permissionResolver);
```

### The ContentInfo Value Object

We will now load a `ContentInfo` object using the provided ID and use it to get our Content item's metadata

``` brush:
$contentInfo = $contentService->loadContentInfo( $contentId );
```

### Locations

**Getting Content Locations**

``` brush:
// show all locations of the content
$locations = $locationService->loadLocations( $contentInfo );
$output->writeln( "<info>LOCATIONS</info>" );
foreach ( $locations as $location )
{
    $urlAlias = $urlAliasService->reverseLookup( $location );
    $output->writeln( "  $location->pathString  ($urlAlias->path)" );
}
```

We first use `     LocationService     ::loadLocations()` to **get** the **Locations** for our `ContentInfo`. This method returns an array of <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Location.html"><code>Location</code></a> Value Objects. In this example, we print out the Location's path string (/path/to/content). We also use <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/URLAliasService.html#method_reverseLookup">URLAliasService::reverseLookup()</a> to get the Location's main <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/URLAlias.html">URLAlias</a>.

 

### Relations

We now want to list relations from and to our Content. Since relations are versioned, we need to feed the <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/ContentService.html#method_loadRelations"><code>ContentService::loadRelations()</code></a> with a `     VersionInfo   ` object. We can get the current version's `VersionInfo` using <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/ContentService.html#method_loadVersionInfo"><code>ContentService::loadVersionInfo()</code></a>. If we had been looking for an archived version, we could have specified the version number as the second argument to this method.

**Browsing a Content's relations**

``` brush:
// show all relations of the current version
$versionInfo = $contentService->loadVersionInfo( $contentInfo );
$relations = $contentService->loadRelations( $versionInfo );
if ( !empty( $relations ) )
{
    $output->writeln( "<info>RELATIONS</info>" );
    foreach ( $relations as $relation )
    {
        $name = $relation->destinationContentInfo->name;
        $output->write( "  Relation of type " . $this->outputRelationType( $relation->type ) . " to content $name" );
    }
}
```

We can iterate over the <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Relation.html">Relation</a> objects array we got from `loadRelations()`, and use these Value Objects to get data about our relations. It has two main properties: `destinationContentInfo`, and `sourceContentInfo`. They also hold the relation type (embed, common, etc.), and the optional Field this relations is made with.

### ContentInfo properties

We can of course get our Content item's metadata by using the Value Object's properties.

**Primitive object metadata**

``` brush:
// show meta data
$output->writeln( "\n<info>METADATA</info>" );
$output->writeln( "  <info>Name:</info> " . $contentInfo->name );
$output->writeln( "  <info>Type:</info> " . $contentType->identifier );
$output->writeln( "  <info>Last modified:</info> " . $contentInfo->modificationDate->format( 'Y-m-d' ) );
$output->writeln( "  <info>Published:</info> ". $contentInfo->publishedDate->format( 'Y-m-d' ) );
$output->writeln( "  <info>RemoteId:</info> $contentInfo->remoteId" );
$output->writeln( "  <info>Main Language:</info> $contentInfo->mainLanguageCode" );
$output->writeln( "  <info>Always available:</info> " . ( $contentInfo->alwaysAvailable ? 'Yes' : 'No' ) );
```

### Owning user

We can use <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/UserService.html#method_loadUser"><code>UserService::loadUser()</code></a> with Content `ownerId` property of our `ContentInfo` to load the Content's owner as a `     User   ` Value Object.

``` brush:
$owner = $userService->loadUser( $contentInfo->ownerId );
$output->writeln( "  <info>Owner:</info> " . $owner->contentInfo->name );
```

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
To get the current version's creator, and not the content's owner, you need to use the `creatorId` property from the current version's `VersionInfo` object.

### Section

The Section's ID can be found in the `sectionId` property of the `ContentInfo` object. To get the matching Section Value Object, you need to use the `SectionService::loadSection()` method.

``` brush:
$section = $sectionService->loadSection( $contentInfo->sectionId );
$output->writeln( "  <info>Section:</info> $section->name" );
```

### Versions

To conclude we can also iterate over the Content's version, as `     VersionInfo   ` Value Objects.

``` brush:
$versionInfoArray = $contentService->loadVersions( $contentInfo );
if ( !empty( $versionInfoArray ) )
{
    $output->writeln( "\n<info>VERSIONS</info>" );
    foreach ( $versionInfoArray as $versionInfo )
    {
        $creator = $userService->loadUser( $versionInfo->creatorId );
        $output->write( "  Version $versionInfo->versionNo " );
        $output->write( " by " . $creator->contentInfo->name );
        $output->writeln( " " . $this->outputStatus( $versionInfo->status ) . " " . $versionInfo->initialLanguageCode );
    }
}
```

We use the `     ContentService::loadVersions()   ` method and get an array of `VersionInfo` objects.

## Search

In this section we will cover how the <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/SearchService.html"><code>SearchService</code></a> can be used to search for Content, by using a <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query.html"><code>Query</code></a> and a combinations of <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion.html"><code>Criteria</code></a> you will get a <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Search/SearchResult.html"><code>SearchResult</code></a> object back containing list of Content and count of total hits. In the future this object will also include facets, spell checking and "more like this" when running on a backend that supports it *(for instance Solr)*.

##### Difference between filter and query

Query object contains two properties you can set criteria on, `filter` and `query`, and while you can mix and match use and use both at the same time, there is one distinction between the two:

-   `query:` Has an effect on scoring *(relevancy)* calculation, and thus also on the default sorting if no `sortClause` is specified, *when used with Solr and Elastic.*
    -   Typically you'll use this for `FullText` search criterion, and otherwise place everything else on `filter`.

### Performing a simple full text search

Full code

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
<a href="https://github.com/ezsystems/CookbookBundle/blob/master/Command/FindContentCommand.php" class="uri">https://github.com/ezsystems/CookbookBundle/blob/master/Command/FindContentCommand.php</a>

In this recipe, we will run a simple full text search over every compatible attribute.

#### Query and Criterion objects

We introduce here a new object: `Query`. It is used to build up a Content query based on a set of `Criterion` objects.

 

``` brush:
$query = new \eZ\Publish\API\Repository\Values\Content\Query();
// Use 'query' over 'filter' for FullText to get hit score (relevancy) with Solr/Elastic
$query->query = new Query\Criterion\FullText( $text );
```

 

Multiple criteria can be grouped together using "logical criteria", such as <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion/LogicalAnd.html">LogicalAnd</a> or <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion/LogicalOr.html">LogicalOr</a>. Since in this case we only want to run a text search, we simply use a <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion/FullText.html"><code>FullText</code></a> criterion object.

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
The full list of criteria can be found on your installation in the following directory <a href="https://github.com/ezsystems/ezpublish-kernel/tree/master/eZ/Publish/API/Repository/Values/Content/Query/Criterion">vendor/ezsystems/ezpublish-kernel/eZ/Publish/API/Repository/Values/Content/Query/Criterion</a>. Additionally you may look at integration tests like <a href="https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Tests/SearchServiceTest.php">vendor/ezsystems/ezpublish-kernel/eZ/Publish/API/Repository/Tests/SearchServiceTest.php</a> for more details on how these are used.

 

#### Running the search query and using the results

The `Query` object is given as an argument to <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/SearchService.html#method_findContent"><code>SearchService::findContent()</code></a>. This method returns a `SearchResult` object. This object provides you with various information about the search operation (number of results, time taken, spelling suggestions, or facets, as well as, of course, the results themselves.

``` brush:
$result = $searchService->findContent( $query );
$output->writeln( 'Found ' . $result->totalCount . ' items' );
foreach ( $result->searchHits as $searchHit )
{
    $output->writeln( $searchHit->valueObject->contentInfo->name );
}
```

The `searchHits` properties of the `SearchResult` object is an array of `SearchHit` objects. In `valueObject` property of `SearchHit`, you will find the `Content` object that matches the given `Query`.

Tip

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
 If you you are searching using a unique identifier, for instance using the Content ID or Content remote ID criterion, then you can use <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/SearchService.html#method_findSingle"><code>SearchService::findSingle()</code></a>, this takes a Criterion and returns a single Content item, or throws a `NotFound` exception if none is found.

 

### Retrieving Sort Clauses for parent location

<span class="status-macro aui-lozenge aui-lozenge-current">V1.7.0</span>

You can use the method $parentL`ocation->getSortClauses()` to return an array of Sort Clauses for direct use on `LocationQuery->sortClauses`.

 

### Performing an advanced search

Full code

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
<a href="https://github.com/ezsystems/CookbookBundle/blob/master/Command/FindContent2Command.php" class="uri">https://github.com/ezsystems/CookbookBundle/blob/master/Command/FindContent2Command.php</a>

As explained in the previous chapter, Criterion objects are grouped together using logical criteria. We will now see how multiple criteria objects can be combined into a fine grained search `Query`.

``` brush:
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content;
 
// [...]
 
$query = new Query();
$criterion1 = new Criterion\Subtree( $locationService->loadLocation( 2 )->pathString );
$criterion2 = new Criterion\ContentTypeIdentifier( 'folder' );
$query->filter = new Criterion\LogicalAnd(
    array( $criterion1, $criterion2 )
);
 
$result = $searchService->findContent( $query );
```

A <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion/Subtree.html"><code>Subtree</code></a> criterion limits the search to the subtree with pathString, which looks like: `/1/2/`. A <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion/ContentTypeId.html"><code>ContentTypeId</code></a> Criterion to limit the search to Content of Content Type 1. Those two criteria are grouped with a `LogicalAnd` operator. The query is executed as before, with `SearchService::findContent()`.

### Performing a fetch like search

Full code

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
<a href="https://github.com/ezsystems/CookbookBundle/blob/master/Command/FindContent3Command.php" class="uri">https://github.com/ezsystems/CookbookBundle/blob/master/Command/FindContent3Command.php</a>

A search isn't only meant for searching, it also provides the future interface for what you in eZ Publish 4.x would know as a content "fetch". And as this is totally backend agnostic, in future versions this will be powered by either Solr or ElasticSearch meaning it also replaces "ezfind" fetch functions.

Following the examples above we now change it a bit to combine several criteria with both an AND and an OR condition.

``` brush:
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content;
 
// [...]
 
$query = new Query();
$query->filter = new Criterion\LogicalAnd(
    array(
        new Criterion\ParentLocationId( 2 ),
        new Criterion\LogicalOr(
            array(
                new Criterion\ContentTypeIdentifier( 'folder' ),
                new Criterion\ContentTypeId( 2 )
            )
        )
    )
);
 
$result = $searchService->findContent( $query );
```

A `     ParentLocationId   ` criterion limits the search to the children of location 2. An array of "`ContentTypeId"` Criteria to limit the search to Content of ContentType's with id 1 or 2 grouped in a `LogicalOr` operator. Those two criteria are grouped with a `LogicalAnd` operator. As always the query is executed as before, with `SearchService::findContent()`.

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
Want to do a subtree filter? Change the location filter to use the Subtree criterion filter as shown in the advanced search example above.

 

#### Using in() instead of OR

The above example is fine, but it can be optimized a bit by taking advantage of the fact that all filter criteria support being given an array of values (IN operator) instead of a single value (EQ operator).

You can also use the <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion/ContentTypeIdentifier.html"><code>ContentTypeIdentifier</code></a> Criterion:

``` brush:
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content;
 
// [...]
 
$query = new Query();
$query->filter = new Criterion\LogicalAnd(
    array(
        new Criterion\ParentLocationId( 2 ),
        new Criterion\ContentTypeIdentifier( array( 'article', 'folder' ) )
    )
);
 
$result = $searchService->findContent( $query );
```

Tip

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
All filter criteria are capable of doing an "IN" selection, the ParentLocationId<span> above could, for example, have been provided "array( 2, 43 )" to include second level children in both your content tree (2) and your media tree (43).</span>

### Performing a Faceted Search

<span class="status-macro aui-lozenge aui-lozenge-current">DOC IS WIP (EZP-26453)</span>

Under construction

<span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"></span>
Faceted Search is not fully implemented yet, only partial implementation exists for use with Content *(and ContentInfo)* search on Solr, limited to visitors for:

-   `ContentType` & `Section`<span>, </span><span>with</span><span> limitations:</span>
    -   <span>FacetBuilder: Only uses `minCount` and `limit` properties.</span>
    -   <span>Facet:</span><span> Returns</span><span> </span>`entries` group data as id's, while it is going to be returned as identifiers as stated in <a href="https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Search/Facet/ContentTypeFacet.php#L21">API documentation</a>.
-   `User`<span>, with limitations:</span>
    -   FacetBuilder: Only uses `minCount` and `limit` properties, hard-coded to creator as `type` which has not been documented in API while owner, group and modifier is currently not supported.
-   For further info see the corresponding Epic: <span class="jira-issue"> <a href="https://jira.ez.no/browse/EZP-26465?src=confmacro" class="jira-issue-key"><img src="https://jira.ez.no/images/icons/issuetypes/epic.png" class="icon" />EZP-26465</a> - <span class="summary">Search Facets</span> <span class="aui-lozenge aui-lozenge-subtle aui-lozenge-current jira-macro-single-issue-export-pdf">Specification</span> </span>

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
<span>You can register </span><a href="https://github.com/ezsystems/ezplatform-solr-search-engine/blob/v1.1.1/lib/Resources/config/container/solr/facet_builder_visitors.yml">custom facet builder visitors</a> with Solr for Content(Info) search.

Contribution wanted

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
<span>The link above is also the starting point for contributing visitors for other API </span><a href="https://github.com/ezsystems/ezpublish-kernel/tree/master/eZ/Publish/API/Repository/Values/Content/Query/FacetBuilder">FacetBuilders</a><span> and </span><a href="https://github.com/ezsystems/ezpublish-kernel/tree/master/eZ/Publish/API/Repository/Values/Content/Search/Facet">Facets</a><span>. As for integration tests, fixtures that will need adjustments are found in</span><a href="https://github.com/ezsystems/ezpublish-kernel/tree/master/eZ/Publish/API/Repository/Tests/_fixtures/Solr">ezpublish-kernel</a><span>, and those missing in that link but <a href="https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Tests/SearchServiceTest.php#L2474">defined in SearchServiceTest</a>, are basically not implemented yet.</span>

To be able to take advantage of facets, we can set the `Query->facetBuilders` property, which will result in relevant facets being returned on `SearchResult->facets`. All facet builders can share the following properties:

-   `minCount`: The minimum of hits of a given grouping, e.g. minimum number of content items in a given facet for it to be returned
-   `limit`: Maximum number of facets to be returned; only X number of facets with the greatest number of hits will be returned.

As an example, let's `apply UserFacet`<span> to be able to group content according to the creator:</span>

``` brush:
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query\FacetBuilder;
 
// [...]
 
$query = new Query();
$query->filter = new Criterion\ContentTypeIdentifier(['article']);
$query->facetBuilders[] = new FacetBuilder\UserFacetBuilder(
    [
        // 'type' => 'creator', // this is currently implied, expect api change here once facets are implemented fully
        'minCount' => 2,
        'limit' => 5
    ]
);
 
$result = $searchService->findContentInfo( $query );
list( $userId, $articleCount ) = $result->facets[0]->entries;
```

### Performing a pure search count

In many cases you might need the number of Content items matching a search, but with no need to do anything else with the results.

Thanks to the fact that the " searchHits " property of the <a href="http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Search/SearchResult.html"><code>SearchResult</code></a> object always refers to the total amount, it is enough to run a standard search and set $limit to 0. This way no results will be retrieved, and the search will not be slowed down, even when the number of matching results is huge.

 

``` brush:
use eZ\Publish\API\Repository\Values\Content\Query;
 
// [...]
 
$query = new Query();
$query->limit = 0;
 
// [...] ( Add criteria as shown above )
 
$resultCount = $searchService->findContent( $query )->totalCount;
```

 

 

#### In this topic:

-   [Displaying values from a Content item](#Browsing,finding,viewing-DisplayingvaluesfromaContentitem)
-   [Traversing a Location subtree](#Browsing,finding,viewing-TraversingaLocationsubtree)
-   [Viewing Content Metadata](#Browsing,finding,viewing-ViewingContentMetadata)
    -   [Setting the Repository User](#Browsing,finding,viewing-SettingtheRepositoryUser)
    -   [The ContentInfo Value Object](#Browsing,finding,viewing-TheContentInfoValueObject)
    -   [Locations](#Browsing,finding,viewing-Locations)
    -   [Relations](#Browsing,finding,viewing-Relations)
    -   [ContentInfo properties](#Browsing,finding,viewing-ContentInfoproperties)
    -   [Owning user](#Browsing,finding,viewing-Owninguser)
    -   [Section](#Browsing,finding,viewing-Section)
    -   [Versions](#Browsing,finding,viewing-Versions)
-   [Search](#Browsing,finding,viewing-Search)
    -   [Performing a simple full text search](#Browsing,finding,viewing-Performingasimplefulltextsearch)
    -   [Retrieving Sort Clauses for parent location](#Browsing,finding,viewing-RetrievingSortClausesforparentlocation)
    -   [Performing an advanced search](#Browsing,finding,viewing-Performinganadvancedsearch)
    -   [Performing a fetch like search](#Browsing,finding,viewing-Performingafetchlikesearch)
    -   [Performing a Faceted Search](#Browsing,finding,viewing-PerformingaFacetedSearch)
    -   [Performing a pure search count](#Browsing,finding,viewing-Performingapuresearchcount)

## Comments:

<table>
<colgroup>
<col width="100%" />
</colgroup>
<tbody>
<tr class="odd">
<td align="left"><a href=""></a>
<p>Note that when making searches for front end use you should use the `$languageFilter` parameter of the `findLocations` and `findContent` functions and `Criterion\Visibility::VISIBLE` to filter the results accordingly.  If not you may get results you do not wish.<br />
<br />
Example:</p>
<div class="code panel pdl" style="border-width: 1px;">
<div class="codeContent panelContent pdl">
<pre class="brush: php; gutter: false; theme: Eclipse" style="font-size:12px;"><code>
$query = new LocationQuery([
 &#39;filter&#39; =&gt; new Criterion\LogicalAnd([
 new Criterion\Visibility(Criterion\Visibility::VISIBLE),
 new Criterion\ParentLocationId($parentLocation-&gt;id),
 ];),
 &#39;sortClauses&#39; =&gt; $parentLocation-&gt;getSortClauses(),
]);
$searchService-&gt;findLocations($query,
 [&#39;languages&#39; =&gt; $configResolver-&gt;getParameter(&#39;languages&#39;)]);</code></pre>
</div>
</div>
<div class="smallfont" align="left" style="color: #666666; width: 98%; margin-bottom: 10px;">
<img src="images/icons/contenttypes/comment_16.png" width="16" height="16" /> Posted by wizhippo at Jan 13, 2017 19:28
</div></td>
</tr>
</tbody>
</table>






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>
4.  <span>[Under the Hood: How eZ Platform Works](31429659.html)</span>
5.  <span>[Content Model: Content is King!](31429709.html)</span>
6.  <span>[Content items, Content Types and Fields](31430275.html)</span>
7.  <span>[Field Types reference](Field-Types-reference_31430495.html)</span>

 Developer : Landing Page Field Type (Enterprise) 



Landing Page Field Type represents a page with a layout consisting of multiple zones; each of which can in turn contain blocks.

<span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"></span>
Landing Page Field Type is only used in the Landing Page Content Type that is included in eZ Enterprise.

The structure of the Landing Page Content Type should not be modified, as it may cause errors.

| Name           | Internal name   | Expected input  |
|----------------|-----------------|-----------------|
| `Landing page` | `ezlandingpage` | `string (JSON)` |

 

# Layout and zones

Layout is the way in which a Landing Page is divided into zones. <span class="DEF"><span class="DEF">Zones are organized structures that are deployed over a layout in a particular position</span></span>.

The placement of zones is defined in a template which is a part of the layout configuration. You can modify the template in order to define your own system of zones.

For information on how to create and configure new blocks for the Landing Page, see [Creating Landing Page layouts (Enterprise)](31430259.html).

 

# Blocks

For information on how to create and configure new blocks for the Landing Page, see [Creating Landing Page blocks (Enterprise).](31430614.html)

 

# Rendering Landing Pages

<span lang="en">Landing page rendering takes place while editing or viewing.</span>

When rendering a Landing Page, its zones are passed to the layout as a `zones` array with a `blocks` array each. You can simply access them using twig (e.g.** **`{{ zones[0].id }}` ).

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
Each div that's a zone or zone's container should have data attributes:

-   `data-studio-zones-container` for a div containing zones
-   `data-studio-zone` with zone ID as a value for a zone container

 

To render a block inside the layout, use twig `render_esi()` function to call `           ez_block:renderBlockAction`.

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
`               ez_block             ` is an alias to `EzSystems\LandingPageFieldTypeBundle\Controller\BlockControlle`**`r`**

 

An action has the following parameters:

-   `             contentId` – ID of content which can be accessed by `             contentInfo.id           `
-   `             blockId` – ID of block which you want to render

 

Example usage:

``` brush:
{{ render_esi(controller('ez_block:renderBlockAction', {
        'contentId': contentInfo.id,
        'blockId': block.id
    })) 
}}
```

 

As a whole a sample layout could look as follows:

**landing\_page\_simple\_layout.html.twig**

``` brush:
{# a layer of the required "data-studio-zones-container" attribute, in which zones will be displayed #}
<div data-studio-zones-container>
     {# a layer of the required attribute for the displayed zone #}
     <div data-studio-zone="{{ zones[0].id }}">                                     
        {# If a zone with [0] index contains any blocks #}
        {% if zones[0].blocks %}                                                    
            {# for each block #}
            {% for block in blocks %}                                               
                {# create a new layer with appropriate id #}
                <div class="landing-page__block block_{{ block.type }}">            
                    {# render the block by using the "ez_block:renderBlockAction" controller #}   
                    {# contentInfo.id is the id of the current content item, block.id is the id of the current block #}
                    {{ render_esi(controller('ez_block:renderBlockAction', {        
                            'contentId': contentInfo.id,                            
                            'blockId': block.id                                     
                        })) 
                    }}
                </div>
            {% endfor %}
        {% endif %}
    </div>
</div>
```

 

## Viewing template

Your view is populated with data (parameters) retrieved from the `getTemplateParameters()` method which must be implemented in your block's class.

Example:

``` brush:
/**
    * @param \EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\BlockValue $blockValue
    *
    * @return array
    */
   public function getTemplateParameters(BlockValue $blockValue)
   {
       $attributes = $blockValue->getAttributes();
       $limit = (isset($attributes['limit'])) ? $attributes['limit'] : 10;
       $offset = (isset($attributes['offset'])) ? $attributes['offset'] : 0;
       $parameters = [
           'title' => $attributes['title'],
           'limit' => $limit,
           'offset' => $offset,
           'feeds' => $this->RssProvider->getFeeds($attributes['url']),
       ];
       return $parameters;
   }
```

 

 

#### In this topic:

-   [Layout and zones](#LandingPageFieldType(Enterprise)-Layoutandzones)
-   [Blocks](#LandingPageFieldType(Enterprise)-Blocks)
-   [Rendering Landing Pages](#LandingPageFieldType(Enterprise)-RenderingLandingPages)
    -   [Viewing template](#LandingPageFieldType(Enterprise)-Viewingtemplate)

#### Related topics:

[Creating Landing Page layouts (Enterprise)](31430259.html)

[Creating Landing Page blocks (Enterprise)](31430614.html)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Cookbook](Cookbook_31429528.html)</span>

 Developer : Creating Landing Page blocks (Enterprise) 



# Description

<span class="status-macro aui-lozenge aui-lozenge-current">V1.2</span>

A Landing Page has a customizable <span class="DEF"><span class="DEF">layout</span></span> with multiple zones where you can place predefined blocks with content.

By default eZ Enterprise comes with a number of preset Landing Page blocks. You can, however, add custom blocks to your configuration.

# Solution

## Block configuration

In the Demo installation the layout configuration is stored in `ezstudio-demo-bundle/Resources/config/default_layouts.yml`:

**Example default\_layouts.yml**

``` brush:
blocks:
    gallery:
        views:
            gallery:
                template: eZStudioDemoBundle:blocks:gallery.html.twig
                name: Default Gallery Block template
    keyword:
        views:
            keyword:
                template: eZStudioDemoBundle:blocks:keyword.html.twig
                name: Default Keyword Block template
    rss:
        views:
            rss:
                template: eZStudioDemoBundle:blocks:rss.html.twig
                name: Default RSS Block template
    tag:
        views:
            tag:
                template: eZStudioDemoBundle:blocks:tag.html.twig
                name: Default Tag Block template
```

 

## Creating a new block

### Creating a class for the block

The class for the block must implement the `BlockType` interface:

``` brush:
EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\BlockType
```

Most methods are implemented in a universal way by using <span>the `AbstractBlockType` abstract class:</span>

``` brush:
EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\AbstractBlockType 
```

If your block does not have specific attributes or a structure, you can extend the `           AbstractBlockType         ` **** class, which contains simple generic converters designated for the block attributes.

<span>For example:</span>

``` brush:
<?php
namespace AcmeDemoBundle\Block;

use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\AbstractBlockType;

/**
* RSS block
* Renders feed from a given URL.
*/
class RSSBlock extends AbstractBlockType
{
   // Class body
}
```

<span>
</span>

### Describing a class definition

A block **must** have a definition set using two classes:

#### BlockAttributeDefinition

The `               BlockAttributeDefinition             ` class defines the attributes of a block<span>:
</span>

<table>
<colgroup>
<col width="33%" />
<col width="33%" />
<col width="33%" />
</colgroup>
<thead>
<tr class="header">
<th align="left">Attribute</th>
<th align="left">Type</th>
<th align="left">Definition</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td align="left">$id</td>
<td align="left">string</td>
<td align="left">block attribute ID</td>
</tr>
<tr class="even">
<td align="left">$name</td>
<td align="left">string</td>
<td align="left">block attribute name</td>
</tr>
<tr class="odd">
<td align="left">$type</td>
<td align="left">string</td>
<td align="left">block attribute type, available options are:<br />

<ul>
<li><code>                         integer                       </code></li>
<li><code>                         string                       </code></li>
<li><code>                         url                       </code></li>
<li><code>                         text                       </code></li>
<li><code>                         embed                       </code></li>
<li><code>                         select                       </code></li>
<li><code>                         multiple                       </code></li>
</ul></td>
</tr>
<tr class="even">
<td align="left">$regex</td>
<td align="left">string</td>
<td align="left">block attribute regex used for validation</td>
</tr>
<tr class="odd">
<td align="left">$regexErrorMessage</td>
<td align="left">string</td>
<td align="left">message displayed when regex does not match</td>
</tr>
<tr class="even">
<td align="left">$required</td>
<td align="left">bool</td>
<td align="left"><code>TRUE</code> if attribute is required</td>
</tr>
<tr class="odd">
<td align="left">$inline</td>
<td align="left">bool</td>
<td align="left">indicates whether block attribute input should be rendered inline in a form</td>
</tr>
<tr class="even">
<td align="left">$values</td>
<td align="left">array</td>
<td align="left">array of chosen values</td>
</tr>
<tr class="odd">
<td align="left">$options</td>
<td align="left">array</td>
<td align="left">array of available options</td>
</tr>
</tbody>
</table>

<span style="color: rgb(0,0,0);">
</span>

#### BlockDefinition

The `               BlockDefinition             ` class describes a block:

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th align="left">Attribute</th>
<th align="left">Type</th>
<th align="left">Definition</th>
<th align="left">Note</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td align="left"><p>$type</p></td>
<td align="left">string</td>
<td align="left">block type</td>
<td align="left"> </td>
</tr>
<tr class="even">
<td align="left">$name</td>
<td align="left">string</td>
<td align="left">block name</td>
<td align="left"> </td>
</tr>
<tr class="odd">
<td align="left">$category</td>
<td align="left">string</td>
<td align="left">block category</td>
<td align="left"> </td>
</tr>
<tr class="even">
<td align="left">$thumbnail</td>
<td align="left">string</td>
<td align="left">path to block thumbnail image</td>
<td align="left"> </td>
</tr>
<tr class="odd">
<td align="left">$templates</td>
<td align="left">array</td>
<td align="left">array of available paths of templates</td>
<td align="left"><p>Retrieved from the config file (default_layouts.yml)</p></td>
</tr>
<tr class="even">
<td align="left">$attributes</td>
<td align="left">array</td>
<td align="left">array of block attributes (objects of <code>                     BlockAttributeDefinition                   </code> class)</td>
<td align="left"> </td>
</tr>
</tbody>
</table>

<span style="color: rgb(0,0,0);">
</span>

 

When extending `AbstractBlockType` you **must** implement at least 3 methods:

<span class="expand-control-icon"><img src="images/icons/grey_arrow_down.png" class="expand-control-image" /></span><span class="expand-control-text">createBlockDefinition()</span>

This method must return an **` EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockDefinition`**  object.

Example of a Gallery block:

``` brush:
/**
 * Creates BlockDefinition object for block type.
 *
 * @return \EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockDefinition
 */
public function createBlockDefinition()
{
    return new BlockDefinition(
        'gallery',
        'Gallery Block',
        'default',
        'bundles/ezsystemslandingpagefieldtype/images/thumbnails/gallery.svg',
        [], 
        [
            new BlockAttributeDefinition(
                'contentId',
                'Folder',
                'embed',
                '/^([a-zA-Z]:)?(\/[a-zA-Z0-9_\/-]+)+\/?/',
                'Choose an image folder'
            ),
        ]
    );
}
```

<span class="expand-control-icon"><img src="images/icons/grey_arrow_down.png" class="expand-control-image" /></span><span class="expand-control-text">getTemplateParameters(BlockValue $blockValue)</span>

This method returns an array of parameters to be displayed in rendered view of block. <span>You can access them directly in a block template (e. g. via twig </span> `{{ title }}` <span>).</span>

 

<span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"></span>
When parameters are used in the template you call them directly without the `parameters` array name:

| Correct                                                                | Not Correct                                                                               |
|------------------------------------------------------------------------|-------------------------------------------------------------------------------------------|
| `                         <h1>{{ title }}</h1>                       ` | ~~`                           <h1>{{ parameters.title }}</h1>                         `~~ |

 

Example of the `getTemplateParameters()` method implementation:

``` brush:
/**
* @param \EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\BlockValue $blockValue
*
* @return array
*/
public function getTemplateParameters(BlockValue $blockValue)
{
    $attributes = $blockValue->getAttributes();
    $limit = (isset($attributes['limit'])) ? $attributes['limit'] : 10;
    $offset = (isset($attributes['offset'])) ? $attributes['offset'] : 0;
    $parameters = [
        'title' => $attributes['title'],
        'limit' => $limit,
        'offset' => $offset,
        'feeds' => $this->RssProvider->getFeeds($attributes['url']),
    ];
    
    return $parameters;
}
```

<span> </span> <span>
</span>

<span class="expand-control-icon"><img src="images/icons/grey_arrow_down.png" class="expand-control-image" /></span><span class="expand-control-text">checkAttributesStructure(array $attributes)</span>

This method validates the input fields for a block. You can specify your own conditions to throw the `InvalidBlockAttributeException` exception.

This `InvalidBlockAttributeException` exception has the following parameters:

| Name                                                                                                                                                                                                                                                     | Description                                                                                                                                                                                                                                                                   |
|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| <span class="pl-s1"> <span class="pl-smi"> **blockType** </span> </span>                                                                                                                                                                                 | <span class="pl-s1"> <span class="pl-smi">name of a block</span> </span>                                                                                                                                                                                                      |
| <span class="pl-s1"> <span class="pl-smi"> <span class="pl-s1"> <span class="pl-smi"> **attribute** </span> </span> </span> </span>                                                                                                                      | <span class="pl-s1"> <span class="pl-smi"> <span class="pl-s1"> <span class="pl-smi">name of the block's attribute which failed validation</span> </span> </span> </span>                                                                                                     |
| <span class="pl-s1"> <span class="pl-smi"> <span class="pl-s1"> <span class="pl-smi"> <span class="pl-s1"> <span class="pl-smi"> **message** </span> </span> </span> </span> </span> </span>                                                             | <span class="pl-s1"> <span class="pl-smi"> <span class="pl-s1"> <span class="pl-smi"> <span class="pl-s1"> <span class="pl-smi">a short information about an error</span> </span> </span> </span> </span> </span>                                                             |
| <span class="pl-s1"> <span class="pl-smi"> <span class="pl-s1"> <span class="pl-smi"> <span class="pl-s1"> <span class="pl-smi"> <span class="pl-s1"> <span class="pl-smi"> **previous** </span> </span> </span> </span> </span> </span> </span> </span> | <span class="pl-s1"> <span class="pl-smi"> <span class="pl-s1"> <span class="pl-smi"> <span class="pl-s1"> <span class="pl-smi"> <span class="pl-s1"> <span class="pl-smi">previous exception, null by default</span> </span> </span> </span> </span> </span> </span> </span> |

<span class="pl-s1"> </span> <span class="pl-s1"> <span class="pl-smi"> <span class="pl-s1"> <span class="pl-smi"> <span class="pl-s1"> <span class="pl-smi"> <span class="pl-s1"> <span class="pl-smi">
</span> </span> </span> </span> </span> </span> </span> </span>

<span>For example:</span>

``` brush:
/**
 * Checks if block's attributes are valid.
 *
 * @param array $attributes
 *
 * @throws \EzSystems\LandingPageFieldTypeBundle\Exception\InvalidBlockAttributeException
 */
public function checkAttributesStructure(array $attributes)
{
    if (!isset($attributes['url'])) {
        throw new InvalidBlockAttributeException('RSS', 'url', 'URL must be set.');
    }

    if (isset($attributes['limit']) && (($attributes['limit'] < 1) || (!is_numeric($attributes['limit'])))) {
        throw new InvalidBlockAttributeException('RSS', 'limit', 'Limit must be a number greater than 0.');
    }

    if (isset($attributes['offset']) && (($attributes['offset'] < 0) || (!is_numeric($attributes['limit'])))) {
        throw new InvalidBlockAttributeException('RSS', 'offset', 'Offset must be a number no less than 0.');
    }
}
```

<span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"></span>
When the class is created make sure it is added to a container.

 

### Adding the class to the container

 The **services.yml** file must contain info about your block class.

<span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"></span>
The description of your class must contain a tag which provides:

-   tag name: **landing\_page\_field\_type.block\_type**
-   tag alias: &lt;name of a block&gt;

 

For example:

``` brush:
acme.landing_page.block.rss:                                             # service id
       class: AcmeDemoBundle\FieldType\LandingPage\Model\Block\RSSBlock # block's class with namespace
       tags:                                                            # service definition must contain tag with 
           - { name: landing_page_field_type.block_type, alias: rss}    # "landing_page_field_type.block_type" name and block name as an alias
```

## Custom editing UI

If you want to add a custom editing UI to your new block, you need to provide the code for the custom popup UI in Javascript (see the code for <a href="https://github.com/ezsystems/StudioUIBundle/blob/ea683e0443bc3660e9ee25fe24e435d99e1133ff/Resources/public/js/views/blocks/ezs-scheduleblockview.js">eZS.ScheduleBlockView</a> or <a href="https://github.com/ezsystems/StudioUIBundle/blob/162d6b9b967cb549f32bc06c4405d3809d8546f0/Resources/public/js/views/blocks/ezs-tagblockview.js">eZS.TagBlockView</a> for examples).

Once it is ready, create a plugin for `eZS.LandingPageCreatorView` that makes a use of the `addBlock` public method from `eZS.LandingPageCreatorView`, see the example below:

``` brush:
YUI.add('ezs-addcustomblockplugin', function (Y) {
    'use strict';

    var namespace = 'Any.Namespace.Of.Your.Choice',

    Y.namespace(namespace);
    NS = Y[namespace];

    NS.Plugin.AddCustomBlock = Y.Base.create('addCustomBlockPlugin', Y.Plugin.Base, [], {
        initializer: function () {
            this.get('host').addBlock('custom', NS.CustomBlockView);
        },
    }, {
        NS: 'dashboardPlugin'
    });

    Y.eZ.PluginRegistry.registerPlugin(
        NS.Plugin.AddCustomBlock, ['landingPageCreatorView']
    );
});
```

Upcoming feature - multiple block templates

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
The ability to configure different templates (views) for one Landing Page block is upcoming. See <a href="https://jira.ez.no/browse/EZS-1008">EZS-1008</a> to follow its progress.

 

# Example

### Block Class

**TagBlock.php**

``` brush:
<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\Block;

use EzSystems\LandingPageFieldTypeBundle\Exception\InvalidBlockAttributeException;
use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockDefinition;
use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockAttributeDefinition;
use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\AbstractBlockType;
use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\BlockType;
use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\BlockValue;

/**
 * Tag block
 * Renders simple HTML.
 */
class TagBlock extends AbstractBlockType implements BlockType
{
    /**
     * Returns array of parameters required to render block template.
     *
     * @param array $blockValue Block value attributes
     *
     * @return array Template parameters
     */
    public function getTemplateParameters(BlockValue $blockValue)
    {
        return ['block' => $blockValue];
    }

    /**
     * Creates BlockDefinition object for block type.
     *
     * @return \EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockDefinition
     */
    public function createBlockDefinition()
    {
        return new BlockDefinition(
            'tag',
            'Tag Block',
            'default',
            'bundles/ezsystemslandingpagefieldtype/images/thumbnails/tag.svg',
            [],
            [
                new BlockAttributeDefinition(
                    'content',
                    'Content',
                    'text',
                    '/[^\\s]/',
                    'Provide html code'
                ),
            ]
        );
    }

    /**
     * Checks if block's attributes are valid.
     *
     * @param array $attributes
     *
     * @throws \EzSystems\LandingPageFieldTypeBundle\Exception\InvalidBlockAttributeException
     */
    public function checkAttributesStructure(array $attributes)
    {
        if (!isset($attributes['content'])) {
            throw new InvalidBlockAttributeException('Tag', 'content', 'Content must be set.');
        }
    }
}
```

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
<span class="status-macro aui-lozenge aui-lozenge-current">V1.7</span>

If you want to make sure that your block is only available in the Element menu in a specific situation, you can override the `isAvailable` method, which makes the block accessible by default:

``` brush:
public function isAvailable()
    {
        return true;
    }
```

 

### service.yml configuration

**services.yml**

``` brush:
ezpublish.landing_page.block.tag:
    class: EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\Block\TagBlock
    tags:
        - { name: landing_page_field_type.block_type, alias: tag }
```

### <span>Block template</span>

    {{ block.attributes.content|raw }}

 

#### In this topic:

-   [Description](#CreatingLandingPageblocks(Enterprise)-Description)
-   [Solution](#CreatingLandingPageblocks(Enterprise)-Solution)
    -   [Block configuration](#CreatingLandingPageblocks(Enterprise)-Blockconfiguration)
    -   [Creating a new block](#CreatingLandingPageblocks(Enterprise)-Creatinganewblock)
        -   [Creating a class for the block](#CreatingLandingPageblocks(Enterprise)-Creatingaclassfortheblock)
        -   [Describing a class definition](#CreatingLandingPageblocks(Enterprise)-Describingaclassdefinition)
        -   [Adding the class to the container](#CreatingLandingPageblocks(Enterprise)-Addingtheclasstothecontainer)
    -   [Custom editing UI](#CreatingLandingPageblocks(Enterprise)-CustomeditingUI)
-   [Example](#CreatingLandingPageblocks(Enterprise)-Example)
    -   [Block Class](#CreatingLandingPageblocks(Enterprise)-BlockClass)
    -   [service.yml configuration](#CreatingLandingPageblocks(Enterprise)-service.ymlconfiguration)
    -   [Block template](#CreatingLandingPageblocks(Enterprise)-Blocktemplate)

 

#### Related topics:

[Creating Landing Page layouts (Enterprise)](31430259.html)

[Landing Page Field Type (Enterprise)](31430521.html)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Migrating to eZ Platform - Follow the Ibex!](31429532.html)</span>
4.  <span>[Coming to eZ Platform from eZ Publish Platform](Coming-to-eZ-Platform-from-eZ-Publish-Platform_31429598.html)</span>
5.  <span>[Upgrading from 5.4.x and 2014.11 to 16.xx](Upgrading-from-5.4.x-and-2014.11-to-16.xx_31430322.html)</span>

 Developer : Migrating legacy Page field (ezflow) to Landing Page (Enterprise) 



To move your legacy Page field / eZ Flow configuration to eZ Platform Enterprise Edition you can use a script that will aid in the migration process.

The script will automatically migrate only data – to move custom views, layouts, blocks etc., you will have to provide their business logic again.

<span class="aui-icon aui-icon-small aui-iconfont-error confluence-information-macro-icon"></span>
The migration script will operate on your current database.

Make sure to **back up your database** in case of an unexpected error.

 

To use the script, do the following:

<span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"></span>
Make a note of the paths to .ini files which define your legacy blocks. You will need these paths later.

**1.** Add `ezflow-migration-toolkit` to `composer.json` in your clean Platform installation.

**composer.json**

``` brush:
"ezsystems/ezflow-migration-toolkit": "^1.0.0"
```

**2.** Add `ezflow-migration-toolkit` to `AppKernel.php`.

**AppKernel.php**

``` brush:
new EzSystems\EzFlowMigrationToolkitBundle\EzSystemsEzFlowMigrationToolkitBundle()
```

**3.** Clear cache.

``` brush:
app/console cache:clear
```

**4.** Run the script with the following parameters:

-   absolute path of your legacy application
-   list of .ini files which define your legacy blocks

**Script command**

``` brush:
app/console ezflow:migrate <legacy path> —ini=<block definitions> [—ini=<another block definition> ...]
```

**Example of the migration script command**

``` brush:
app/console ezflow:migrate /var/www/legacy.application.com/ —ini=extension/myapplication/settings/block.ini.append.php
```

**5.** You will be warned about the need to create a backup of your database. **Proceed only if you are sure you have done it.**

A `MigrationBundle` will be generated in the `src/` folder.

You will see a report summarizing the results of the migration.

**6.** Add `MigrationBundle` to `AppKernel.php`.

**AppKernel.php**

``` brush:
new MigrationBundle\MigrationBundle()
```

**7.** Clear cache again.

 

At this point you can already view the initial effects of the migration, but they will still be missing some of your custom content.

The `MigrationBundle` generates placeholders for layouts in the form of frames with a data dump.

For blocks that could not be mapped to existing Landing Page blocks, it will also generate PHP file templates that you need to fill with your own business logic.

 

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Tutorials](Tutorials_31429522.html)</span>
4.  <span>[Building a Bicycle Route Tracker in eZ Platform](Building-a-Bicycle-Route-Tracker-in-eZ-Platform_31431606.html)</span>

 Developer : Part 1: Setting up eZ Platform 



<span class="confluence-embedded-file-wrapper image-right-wrapper confluence-embedded-manual-size"><img src="attachments/31431610/31431916.png" class="confluence-embedded-image image-right" height="250" /></span>

The first step is to get eZ Platform running on your server. In Part 1, we'll walk you through that, step by step.

-   [Step 1 - Getting Ready](Step-1---Getting-Ready_31431834.html)
-   [Step 2 - Create your content model](Step-2---Create-your-content-model_31431844.html)
-   [Step 3 - Customizing the general layout](Step-3---Customizing-the-general-layout_31428488.html)

**Tutorial path**

## Attachments:

<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [Content\_Repository.png](attachments/31431610/31431916.png) (image/png)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Tutorials](Tutorials_31429522.html)</span>
4.  <span>[Building a Bicycle Route Tracker in eZ Platform](Building-a-Bicycle-Route-Tracker-in-eZ-Platform_31431606.html)</span>

 Developer : Part 2: Working on the Ride 



You will now work on the display of a single Ride on its own page. <span class="confluence-embedded-file-wrapper image-right-wrapper confluence-embedded-manual-size"><img src="attachments/30708529/31427691.png" class="confluence-embedded-image image-right" height="250" /></span>

-   [Step 1 - Display content of a Ride](Step-1---Display-content-of-a-Ride_31431852.html)
-   [Step 2 - Display the list of Rides on the homepage](Step-2---Display-the-list-of-Rides-on-the-homepage_32866555.html)
-   [Congrats!](31431873.html)

**Tutorial path**






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Tutorials](Tutorials_31429522.html)</span>
4.  <span>[Building a Bicycle Route Tracker in eZ Platform](Building-a-Bicycle-Route-Tracker-in-eZ-Platform_31431606.html)</span>

 Developer : Part 3: Adding features 



**A sneak peak...**

If you would like a sneak peak at our efforts, take a look at the <a href="https://jira.ez.no/issues/?jql=component%20%3D%20%22Beginner%20Tutorial%22%20AND%20project%20%3D%20EZP">Beginner Tutorial Component in Jira</a>.

**We're constantly improving and extending this tutorial, and our process is open.**

We're preparing a lot of training material on the Bike Ride theme for you for tutorials, developer training, and certification:

-   <a href="https://jira.ez.no/issues/?jql=component%20%3D%20%22BikeRide%2FTutorial%22%20AND%20project%20%3D%20EZP">Bike Ride Tutorial in JIRA</a>
-   <a href="https://jira.ez.no/issues/?jql=component%20%3D%20%22BikeRide%2FDevTrain%22">Bike Ride Developer Training in JIRA</a>
-   <a href="https://jira.ez.no/issues/?jql=component%20%3D%20%22BikeRide%2FCert%22">Bike Ride Certification Course in JIRA</a>

**Want to join in the fun ?**

Read about how you can [Contribute to Documentation](Contribute-to-Documentation_31429594.html)!

Questions ?

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
If you have any questions, feel free to reach out to us or our <a href="http://share.ez.no/get-involved/exchange">awesome community</a> for help!

 

 

 

<span class="status-macro aui-lozenge aui-lozenge-current">TO BE CONTINUED</span>

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Tutorials](Tutorials_31429522.html)</span>
4.  <span>[Building a Bicycle Route Tracker in eZ Platform](Building-a-Bicycle-Route-Tracker-in-eZ-Platform_31431606.html)</span>
5.  <span>[Part 2: Working on the Ride](31431613.html)</span>

 Developer : Congrats! 



<span class="confluence-embedded-file-wrapper image-right-wrapper confluence-embedded-manual-size"><img src="attachments/thumbnails/30711113/30711865" class="confluence-embedded-image confluence-thumbnail image-right" height="150" /></span>

### Success: you have just built your first website

Now you have created your first website with eZ Platform.

The website is simple and efficient.

**You learned**

-   How to do a quick install of eZ Platform
-   How the files in an eZ Platform project are organized
-   Where you should put your asset files
-   How to param your eZ Platform to use templating
-   How to use Twig templates to display the content from your database

 

<span class="status-macro aui-lozenge aui-lozenge-current">WORK IN PROGRESS</span>

> This tutorial will evolve quickly, let us know on <a href="http://share.ez.no/get-involved/exchange#slack">Slack</a>, <a href="http://share.ez.no/forums/suggestions">Forums</a> or even comments on this page what Features you want to implement first after this Tutorial. Thank you!

**Tutorial path**






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Tutorials](Tutorials_31429522.html)</span>

 Developer : eZ Enterprise Beginner Tutorial - It's a Dog's World 



This tutorial will guide you through the process of making and customizing a front page for your website. For this purpose we will use a feature of eZ Platform Enterprise Edition called **Landing Page**. 

Landing Page is a special type of page that lets <span class="inline-comment-marker" data-ref="7c3e91d5-8490-4e10-9868-0d6533f19dcd">the Editor</span> easily create and customize a complex, multi-zone entrance point to your website. In this tutorial you will learn both how to make use of out-of-the-box elements of the feature and how to extend it to fit your specific needs.

## Intended audience

This tutorial is intended for a beginner with basic knowledge of the workings of eZ Platform. Ideally, you should be familiar with the concepts covered in the [Building a Bicycle Route Tracker in eZ Platform tutorial](Building-a-Bicycle-Route-Tracker-in-eZ-Platform_31431606.html).

## Learning outcomes

After going through this tutorial, you will:

-   Have a working knowledge of Landing Page functionality and architecture
-   Be able to create a Landing Page and customize its layout
-   Be able to prepare and customize Schedule Blocks
-   Be able to create a custom block to be placed on a Landing Page

# The Story Behind the Tutorial

*You have been commissioned with creating a website for the It's a Dog's World magazine, a periodical for dog owners. It's a Dog's World is a magazine focused on content-rich articles, a comprehensive encyclopedia of <span class="inline-comment-marker" data-ref="79690b32-2a5f-490c-9ad3-9bdee7ff5359">dog breeds</span> and useful dog care advice.*

*Your main objective is to create a welcome page that would showcase the magazine's three most important types of content: articles, dog breed information and tips.*

We will do this by means of a Landing Page, making use of its specific blocks, and crafting our own as well.

<span class="confluence-embedded-file-wrapper image-center-wrapper confluence-embedded-manual-size"><img src="attachments/32868209/32868208.png" title="It&#39;s a Dog&#39;s World - final result" alt="It&#39;s a Dog&#39;s World - final result" class="confluence-embedded-image image-center" width="600" /></span>

### Why use a Landing Page?

A Landing Page is particularly fitted to what you need to do in this tutorial. You can build and customize it once, and later the magazine's editor can create and publish <span class="inline-comment-marker" data-ref="836a2b30-3b87-4ec8-a381-29ccddff48e5">new content</span> that will automatically land in the correct place on the front page.

For showcasing articles we will use a Schedule Block, a special Landing Page element that lets you plan the times and order at which content will air.

We will display entries from the Dog Breed encyclopedia using a Content List Block. This block will automatically find all Dog Breed Content items and display their previews in a separate column.

Finally, we will display one random tip of the day using a special, custom block we will build during this tutorial.

## Table of contents

The tutorial goes through four steps:

-   [Step 1 - Getting your starter website](Step-1---Getting-your-starter-website_32868226.html)
-   [Step 2 - Preparing the Landing Page](Step-2---Preparing-the-Landing-Page_32868235.html)
-   [Step 3 - Using existing blocks](Step-3---Using-existing-blocks_32868245.html)
-   [Step 4 - Creating a custom block](Step-4---Creating-a-custom-block_32868249.html)

 

------------------------------------------------------------------------

 

 

[Start the tutorial](Step-1---Getting-your-starter-website_32868226.html) <span class="confluence-link" title="Black Rightwards Arrow">➡</span>

**Tutorial path**

## Attachments:

<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [iadw\_main\_screen.png](attachments/32868209/32868528.png) (image/png)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [iadw\_main\_screen.png](attachments/32868209/32869503.png) (image/png)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [iadw\_main\_screen.png](attachments/32868209/32868208.png) (image/png)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>

 Developer : API Reference 



<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
See the online [API](API_31429524.html) reference for full API documentation

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>

 Developer : API 



An Application Programming Interface (API) allows you to connect your code to eZ Platform.

From the eZ Blog: <a href="http://ez.no/Blog/How-would-you-explain-what-an-API-is-to-your-mom" class="uri">http://ez.no/Blog/How-would-you-explain-what-an-API-is-to-your-mom</a>

eZ Platform offers two APIs:

1.  The [REST API](https://doc.ez.no/display/DEVELOPER/REST+API+Guide) allows you to interact with an eZ Platform installation using the HTTP protocol, following a <span>REST</span> interaction model
2.  The [Public (PHP) API](https://doc.ez.no/display/DEVELOPER/Public+API+Guide) exposes a Repository which allows you to create, read, update, manage and delete all objects available in eZ Platform, first and foremost content, but also related objects like sections, locations, content types, content types groups, languages and so on.

There is also a [JavaScript API Client](JS-Client_31429579.html), useful for working with eZ Platform as a <a href="http://ez.no/Blog/Content-as-a-Service-CaaS-Decoupled-CMS-and-Headless-CMS-101">headless CMS</a>.

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Tutorials](Tutorials_31429522.html)</span>
4.  <span>[Extending PlatformUI with new navigation](Extending-PlatformUI-with-new-navigation_31430235.html)</span>

 Developer : Alter the JavaScript Application routing 



## PlatformUI routing mechanism

The essential task of the PlatformUI Application component is to handle the routing. It is based on <a href="http://yuilibrary.com/yui/docs/app/#hash-based-urls-only">the routing capabilities provided by the YUI App component</a> and it uses hash-based URIs. By default, the PlatformUI Application will recognize and handle <a href="https://github.com/ezsystems/PlatformUIBundle/blob/master/Resources/public/js/apps/ez-platformuiapp.js#L720">several routes which are declared in the app component itself</a>.

A route is described by an object with the following properties:

-   `path`: the path to match
-   `view`: the identifier of the main view to render when the route is matched
-   `callbacks`: a list of *middlewares* to execute
-   `name`: an optional name to generate links
-   `sideViews`: an optional side view configuration
-   `service`: an optional reference to a view service constructor

## Modifying the routing from the bundle with a plugin

To tweak any behavior in the application, the way to go is to write a plugin and in this case a plugin for the Application.

### Declaring the module providing plugin

The module has to be declared in the extension bundle's `yui.yml` file. It can be done in the following way:

``` brush:
system:
    default:
        yui:
            modules:
                # use your own prefix, not "ez-"
                ezconf-listapplugin: # module identifier
                    dependencyOf: ['ez-platformuiapp']
                    requires: ['ez-pluginregistry', 'plugin', 'base'] # depends on the plugin code
                    path: %extending_platformui.public_dir%/js/apps/plugins/ezconf-listappplugin.js
```

This configuration means we are declaring a module whose identifier is `ezconf-listapplugin`. It will be added to the dependency list of the module `ez-platformuiapp` (the one providing the application component). The plugin module requires `ez-pluginregistry`, `plugin` and `base.` It is stored on the disk in `%extending_platformui.public_dir%/js/apps/plugins/ezconf-listappplugin.js`.

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
`%extending_platformui.public_dir%` is a container parameter which was added in the previous step. It is here to avoid repeating again and again the base path to the public directory. Of course, it is also perfectly possible to write the full path to the module.

### Module creation

Before creating the actual plugin code, we have to first create the module in the configured file. The minimal module code is:

**%extending\_platformui.public\_dir%/js/apps/plugins/ezconf-listappplugin.js**

``` brush:
YUI.add('ezconf-listapplugin', function (Y) {
    // module code goes here!
    // this function will executed when the module loaded in the app,
    // not when the file is loaded by the browser
    // the Y parameter gives access to the YUI env, for instance the components
    // defined by others modules.
}); 
```

<span class="aui-icon aui-icon-small aui-iconfont-error confluence-information-macro-icon"></span>
The first parameter of `YUI.add` should be exactly the module identifier used in `yui.yml` otherwise the module won't be correctly loaded in the application. If the module code does not seem to be taken into account, it is the very first thing to check.

### Base plugin code

After the module creation, it is time to create the minimal Application plugin:

**%extending\_platformui.public\_dir%/js/apps/plugins/ezconf-listappplugin.js**

``` brush:
YUI.add('ezconf-listapplugin', function (Y) {
    // Good practices:
    // * use a custom namespace. 'eZConf' is used as an example here.
    // * put the plugins in a 'Plugin' sub namespace
    Y.namespace('eZConf.Plugin');

    Y.eZConf.Plugin.ListAppPlugin = Y.Base.create('ezconfListAppPlugin', Y.Plugin.Base, [], {
        initializer: function () {
            var app = this.get('host'); // the plugged object is called host

            console.log("Hey, I'm a plugin for PlatformUI App!");
            console.log("And I'm plugged in ", app);
        },
    }, {
        NS: 'ezconfTypeApp' // don't forget that
    });

    // registering the plugin for the app
    // with that, the plugin is automatically instantiated and plugged in
    // 'platformuiApp' component.
    Y.eZ.PluginRegistry.registerPlugin(
        Y.eZConf.Plugin.ListAppPlugin, ['platformuiApp']
    );
});
```

The added code creates a plugin class and registers it under `Y.eZConf.Plugin.ListAppPlugin`, then the PlatformUI plugin registry is configured so that this plugin is automatically instantiated and plugged in the PlatformUI App component.

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
The PlatformUI's plugin system comes almost entirely from <a href="http://yuilibrary.com/yui/docs/plugin/">the YUI plugin</a>. While that's not a strict requirement, you should use the *Advanced Plugins* strategy mentioned in the YUI documentation. That's why in this example and in most cases, the plugin will have the `plugin` and `base` YUI plugin as dependencies. `base` also provides the low level foundations for most PlatformUI component, so reading <a href="http://yuilibrary.com/yui/docs/base/">the Base YUI documentation</a> will also help you understand several concepts used all over the application.

At this point, if you open PlatformUI in your favorite browser with the console open, you should see the result of the `console.log` calls in the above code.

### Adding a route to the application

Finally, the plugin is ready to add a new route to the application. As written in the previous code sample, the plugged object, the application here, is available through `this.get('host')` in the plugin. The App object provides <a href="http://yuilibrary.com/yui/docs/api/classes/App.html#method_route">a <code>route</code> method</a> allowing to add route.

**%extending\_platformui.public\_dir%/js/apps/plugins/ezconf-listappplugin.js**

``` brush:
YUI.add('ezconf-listapplugin', function (Y) {
    Y.namespace('eZConf.Plugin');

    Y.eZConf.Plugin.ListAppPlugin = Y.Base.create('ezconfListAppPlugin', Y.Plugin.Base, [], {
        initializer: function () {
            var app = this.get('host'); // the plugged object is called host

            app.route({
                name: "eZConfList",
                path: "/ezconf/list",
                view: "dashboardView", // let's display the dashboard since we don't have a custom view... yet :)
                // we want the navigationHub (top menu) but not the discoveryBar
                // (left bar), we can try different options
                sideViews: {'navigationHub': true, 'discoveryBar': false},
                callbacks: ['open', 'checkUser', 'handleSideViews', 'handleMainView'],
            });
        },
    }, {
        NS: 'ezconfTypeApp' // don't forget that
    });

    Y.eZ.PluginRegistry.registerPlugin(
        Y.eZConf.Plugin.ListAppPlugin, ['platformuiApp']
    );
});
```

Now, if you refresh your browser, you still need not see any visible change but the application should recognize the `/ezconf/list` hash URI. Going to `/ez#/ezconf/list` should display the same thing as `/ez#/dashboard`.

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
The PlatformUI Application component extends the YUI App component, as a result <a href="http://yuilibrary.com/yui/docs/api/classes/App.html">the complete API of this component</a> can be used.

Results and next step:

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
The resulting code can be seen in <a href="https://github.com/ezsystems/ExtendingPlatformUIConferenceBundle/tree/3_routing">the 3_routing tag on GitHub</a>, this step result can also be viewed as <a href="https://github.com/ezsystems/ExtendingPlatformUIConferenceBundle/compare/2_configuration...3_routing">a diff between tags <code>2_configuration</code> and <code>3_routing</code></a>.

The next step is then [to define a new view and to use it when the newly added route is matched](Define-a-View_31430243.html).

**Tutorial path**






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>
4.  <span>[Extending eZ Platform](Extending-eZ-Platform_31429689.html)</span>

 Developer : An Introduction to Extending eZ Platform 



Contributing to the doc

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
This part of the documentation is still a <span class="status-macro aui-lozenge aui-lozenge-current">WORK-IN-PROGRESS</span>. Would you like to contribute to it?

If you have any thoughts or tips to share, let us know in the comments below, visit our <a href="http://ez-community-on-slack.herokuapp.com/">Slack channel</a> or take a look at other ways to [Contribute to Documentation](Contribute-to-Documentation_31429594.html).

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>

 Developer : Asset Management 



eZ Platform supports multiple binary file handling mechanisms by means of an `IOHandler` interface. This feature is used by the <span class="confluence-link"> [BinaryFile](BinaryField-Field-Type_31430501.html) </span>, [<span class="confluence-link">Media</span>](Media-Field-Type_31430525.html)and [<span class="confluence-link">Image</span>](Image-Field-Type_31430513.html)Field Types.

# Native IO handler 

The IO API is organized around two types of handlers:

-   `eZ\Publish\IO\IOMetadataHandler`: Stores & reads metadata (validity, size, etc.)
-   `eZ\Publish\IO\IOBinarydataHandler`: Stores & reads binarydata (actual contents)

The IOService uses both.

## Configuration

IO handling can now be configured using semantic configuration. Assigning the IO handlers to ezplatform itself is configurable per siteaccess. This is the default configuration:

``` brush:
ezpublish:
    system:
        default:
            io:
                metadata_handler: default
                binarydata_handler: default
```

Metadata and binarydata handlers are configured in the `ez_io` extension. This is what the configuration looks like for the default handlers. It declares a metadata handler and a binarydata handler, both labelled 'default'. Both handlers are of type 'flysystem', and use the same flysystem adapter, labelled 'default' as well.

``` brush:
ez_io:
    metadata_handlers:
        default:
            flysystem:
                adapter: default
    binarydata_handlers:
        default:
            flysystem:
                adapter: default
```

The 'default' flysystem adapter's directory is based on your site settings, and will automatically be set to `%ezpublish_legacy.root_dir%/$var_dir$/$storage_dir$` (example: `/path/to/ezpublish_legacy/var/ezdemo_site/storage`).

### Configure the permissions of generated files

<span class="status-macro aui-lozenge aui-lozenge-current">V1.5</span>

``` brush:
ezpublish:
    system:
        default:
            io:
                permissions: 
                    files: 0750 #default is 0644
                    directories: 0640 #default is 0755
```

Both `files` and `directories` rules are optional.

Default values are 0644 for files and 0755 for directories.

## <a href="https://github.com/ezsystems/ezpublish-kernel/blob/native_io_spec/doc/specifications/io/native_io_handlers.md#the-native-flysystem-handler"></a>The native Flysystem handler

<a href="https://github.com/ezsystems/ezpublish-kernel/blob/native_io_spec/doc/specifications/io/flysystem.thephpleague.com">league/flysystem</a> (along with <a href="https://github.com/1up-lab/OneupFlysystemBundle/">FlysystemBundle</a>) is an abstract file handling library.

It is used as the default way to read & write content binary files in eZ Platform. It can use the `local` filesystem *(our default configuration and the one we officially support)*, but is also able to read/write to `sftp`, `zip` or cloud filesystems *(`azure`, `rackspace`, `S3`)*.

### Handler options

#### Adapter

The adapter is the 'driver' used by flysystem to read/write files. Adapters can be declared using `oneup_flysystem` as follows:

``` brush:
oneup_flysystem:
    adapters:
        default:
            local:
                directory: "/path/to/directory"
```

 

The way to configure other adapters can be found on the <a href="https://github.com/1up-lab/OneupFlysystemBundle/blob/master/Resources/doc/index.md#step3-configure-your-filesystems">bundle's online documentation</a>. Note that we do not use the Filesystem configuration described in this documentation, only the adapters.

## The DFS Cluster handler

For clustering use we provide a custom metadata handler that stores metadata about your assets in the database. This is done as it is faster then accessing the remote NFS or S3 instance in order to read metadata. For further reading on setting this up, see [Clustering](Clustering_31430387.html).

 

#### In this topic:

-   [Native IO handler ](#AssetManagement-NativeIOhandler)
    -   [Configuration](#AssetManagement-Configuration)
        -   [Configure the permissions of generated files](#AssetManagement-Configurethepermissionsofgeneratedfiles)
    -   [The native Flysystem handler](#AssetManagement-ThenativeFlysystemhandler)
        -   [Handler options](#AssetManagement-Handleroptions)
    -   [The DFS Cluster handler](#AssetManagement-TheDFSClusterhandler)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Cookbook](Cookbook_31429528.html)</span>

 Developer : Authenticating a user with multiple user providers 



# Description

Symfony provides native support for <a href="http://symfony.com/doc/2.3/book/security.html#using-multiple-user-providers">multiple user providers</a>. This makes it easy to integrate any kind of login handlers, including SSO and existing 3rd party bundles (e.g. <a href="https://github.com/Maks3w/FR3DLdapBundle">FR3DLdapBundle</a>, <a href="https://github.com/hwi/HWIOAuthBundle">HWIOauthBundle</a>, <a href="https://github.com/FriendsOfSymfony/FOSUserBundle">FOSUserBundle</a>, <a href="http://github.com/BeSimple/BeSimpleSsoAuthBundle">BeSimpleSsoAuthBundle</a>, etc.).

However, to be able to use *external* user providers with eZ, a valid eZ user needs to be injected into the repository. This is mainly for the kernel to be able to manage content-related permissions (but not limited to this).

Depending on your context, you will either want to create an eZ user `on-the-fly`, return an existing user, or even always use a generic user.

# Solution

Whenever an *external* user is matched (i.e. one that does not come from eZ repository, like coming from LDAP), eZ kernel fires an `MVCEvents::INTERACTIVE_LOGIN` event. Every service listening to this event will receive an `eZ\Publish\Core\MVC\Symfony\Event\InteractiveLoginEvent` object which contains the original security token (that holds the matched user) and the request.

It's then up to the listener to retrieve an eZ user from the repository and to assign it back to the event object. This user will be injected into the repository and used for the rest of the request.

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
If no eZ user is returned, the anonymous user will be used.

### User exposed and security token

When an *external* user is matched, a different token will be injected into the security context, the `InteractiveLoginToken`. This token holds a `UserWrapped` instance which contains the originally matched user and the *API user* (the one from the eZ repository).

Note that the *API user* is mainly used for permission checks against the repository and thus stays *under the hood*.

### Customizing the user class

It is possible to customize the user class used by extending `ezpublish.security.login_listener` service, which defaults to `eZ\Publish\Core\MVC\Symfony\Security\EventListener\SecurityListener`.

You can override `getUser()` to return whatever user class you want, as long as it implements `eZ\Publish\Core\MVC\Symfony\Security\UserInterface`.

# Example

<span>Here is a very simple example using the in-memory user provider.</span>

**app/config/security.yml**

``` brush:
security:
    providers:
        # Chaining in_memory and ezpublish user providers
        chain_provider:
            chain:
                providers: [in_memory, ezpublish]
        ezpublish:
            id: ezpublish.security.user_provider
        in_memory:
            memory:
                users:
                    # You will then be able to login with username "user" and password "userpass"
                    user:  { password: userpass, roles: [ 'ROLE_USER' ] }
    # The "in memory" provider requires an encoder for Symfony\Component\Security\Core\User\User
 encoders:
        Symfony\Component\Security\Core\User\User: plaintext
```

### Implementing the listener

**services.yml in your AcmeTestBundle**

``` brush:
parameters:
    acme_test.interactive_event_listener.class: Acme\TestBundle\EventListener\InteractiveLoginListener

services:
    acme_test.interactive_event_listener:
        class: %acme_test.interactive_event_listener.class%
        arguments: [@ezpublish.api.service.user]
        tags:
            - { name: kernel.event_subscriber } 
```

<span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"></span>
Do not mix `MVCEvents::INTERACTIVE_LOGIN` event (specific to eZ Platform) and `SecurityEvents::INTERACTIVE_LOGIN` event (fired by Symfony security component)

**Interactive login listener**

``` brush:
<?php
namespace Acme\TestBundle\EventListener;

use eZ\Publish\API\Repository\UserService;
use eZ\Publish\Core\MVC\Symfony\Event\InteractiveLoginEvent;
use eZ\Publish\Core\MVC\Symfony\MVCEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class InteractiveLoginListener implements EventSubscriberInterface
{
    /**
     * @var \eZ\Publish\API\Repository\UserService
     */
    private $userService;

    public function __construct( UserService $userService )
    {
        $this->userService = $userService;
    }

    public static function getSubscribedEvents()
    {
        return array(
            MVCEvents::INTERACTIVE_LOGIN => 'onInteractiveLogin'
        );
    }

    public function onInteractiveLogin( InteractiveLoginEvent $event )
    {
        // We just load a generic user and assign it back to the event.
        // You may want to create users here, or even load predefined users depending on your own rules.
        $event->setApiUser( $this->userService->loadUserByLogin( 'lolautruche' ) );
    }
} 
```

**
**

#### In this topic:

-   [Description](#Authenticatingauserwithmultipleuserproviders-Description)
-   [Solution](#Authenticatingauserwithmultipleuserproviders-Solution)
    -   [User exposed and security token](#Authenticatingauserwithmultipleuserproviders-Userexposedandsecuritytoken)
    -   [Customizing the user class](#Authenticatingauserwithmultipleuserproviders-Customizingtheuserclass)
-   [Example](#Authenticatingauserwithmultipleuserproviders-Example)
    -   [Implementing the listener](#Authenticatingauserwithmultipleuserproviders-Implementingthelistener)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>
4.  <span>[Under the Hood: How eZ Platform Works](31429659.html)</span>
5.  <span>[Content Model: Content is King!](31429709.html)</span>
6.  <span>[Content items, Content Types and Fields](31430275.html)</span>
7.  <span>[Field Types reference](Field-Types-reference_31430495.html)</span>

 Developer : Author Field Type 



<span class="sd">Field Type representing a list of authors, consisting of author name, and author email.</span>

 

| Name     | Internal name | Expected input | Output   |
|----------|---------------|----------------|----------|
| `Author` | `ezauthor`    | `Mixed`        | `String` |

## Description

This Field Type allows the storage and retrieval of additional authors. For each author, it is capable of handling a name and an e-mail address. It is typically useful when there is a need for storing information about additional authors who have written/created different parts of a Content item.

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Get Started with eZ Platform](Get-Started-with-eZ-Platform_31429520.html)</span>
4.  <span>[Step 1: Installation](31429538.html)</span>

 Developer : Avoiding Problems 



<span class="status-macro aui-lozenge aui-lozenge-current">WORK-IN-PROGRESS</span>

This page will list many potential problems and gotchas that you may encounter while installing, configuring, and running eZ Platform. If you stumble upon an obstacle, take a look here to see if your case isn't covered. Want to add to this page? Check out our instructions for [contributing to our documentation](https://doc.ez.no/display/DEVELOPER/Contribute+to+Documentation).

## Enable Swap on Systems with Limited RAM

If you're having difficulty completing installation on a system with limited RAM (1GB or 2GB, for example), check that you've enabled swap. This allows your Operating System to use the hard disk to supplement RAM when it runs out. Running \``php -d memory_limit=-1 app/console ezplatform:install --env prod clean`\` on a system with swap enabled should yield success. When a system runs out of RAM, you may see \`Killed\` when trying to clear the cache (e.g., \`php app/console --env=prod cache:clear\` from your project's root directory).

## Upload Size Limit

To make use of PlatformUI, you need to define the maximum upload sizeto be consistent with the maximum file size defined in the Content Type using a File, Media or Image Field Definition.

This is done by setting `LimitRequestBody` for Apache or` client_max_body_size` for Nginx.

For instance, if one of those Field definitions is configured to accept files up to 10MB, then `client_max_body_size` (in case of Nginx) should be set above 10MB, with a safe margin, for example to 15MB.

## Initial Install Options

If you accepted all the defaults when doing a \`composer install\`, but realize you need to go back and change some of those options, look in \`app/config/parameters.yml\` – that's where they're stored.

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>

 Developer : Best Practices 



# Structuring an eZ Platform Project

Since release 2015.10, eZ Platform is very close to the <a href="https://github.com/symfony/symfony-standard">standard Symfony distribution</a>. It comes with default settings that will let you get started in a few minutes.

## The AppBundle

Most projects can use the provided `AppBundle`, in the `src` folder. It is enabled by default. The project's PHP code (controllers, event listeners, etc.) can be placed there.<span> </span>

<span>Reusable libraries should be packaged so that they can easily be managed using Composer.</span>

## <span>Templates</span>

<span>Project templates should go into `app/Resources/views`.</span>

<span>They can then be referenced in code without any prefix, for example `app/Resources/views/content/full.html.twig` can be referenced in twig templates or PHP as `content/full.html.twig`.</span>

## <span>Assets</span>

<span>Project assets should go into the `web` folder, and can be referenced as relative to the root, for example `web/js/script.js` can be referenced as `js/script.js` from templates.</span>

<span><span style="color: rgb(44,45,48);">All project assets are accessible through the `web/assets` path.</span></span>

## Configuration

Configuration may go into `app/config`. However, services definitions from `AppBundle` should go into `src/AppBundle/Resources/config`.

## Versioning a project

The recommended method is to version the whole ezplatform repository. Per installation configuration should use `parameters.yml`.

 

# eZ Platform Configuration

eZ Platform configuration is delivered using a number of dedicated configuration files. This config covers everything from selecting the content repository to siteaccesses to language settings.

## Configuration format

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
Config files can have different formats. The recommended one is YAML, which is used by default in the kernel (and in examples throughout the documentation). However, you can also have configuration in XML or PHP formats.

 

Basic configuration handling in eZ Platform is similar to the usual Symfony config. To use it, you define key/value pairs in your configuration files. Internally and by convention, keys follow a dot syntax where the different segments follow your configuration hierarchy. Keys are usually prefixed by a namespace corresponding to your application. Values can be anything, including arrays and deep hashes.

## Configuration files

Main configuration files are located in the `app/config` folder.

If you use the provided `AppBundle`, service definitions from it should go into `src/AppBundle/Resources/config`.

-   `parameters.yml` contains infrastructure-related configuration. It is created based on the default settings defined in `parameters.yml.dist`.
-   `config.yml` contains configuration stemming from Symfony and covers settings such as search engine or cache configuration.
-   `ezplatform.yml` contains general configuration that is specific for eZ Platform, like for example siteaccess settings.
-   `security.yml` is the place for security-related settings.
-   `routing.yml` defines routes that will be used throughout the application.

Configuration can be made environment-specific using separate files for each environment. These files will contain additional settings and point to the general (not environment-specific) configuration that will be applied in other cases.

Here you can read more about <a href="http://symfony.com/doc/current/best_practices/configuration.html">how configuration is handled in Symfony</a>.

## Specific configuration

The configuration of specific aspects of eZ Platform is described in the respective topics in [The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html).

#### Selected configuration topics:

-   <span class="confluence-link">[View provider
    ](Content-Rendering_31429679.html#ContentRendering-Viewproviderconfiguration)</span>
-   [Logging and debug](Devops_31432029.html#Devops-LoggingandDebugConfiguration)
-   [Content repository](Repository_31432023.html#Repository-ContentRepositoryConfiguration)
-   <span class="confluence-link">[Authentication](Security_31429685.html#Security-Configuration)</span>
-   [Sessions](Sessions_31429667.html#Sessions-Configuration)
-   [Siteaccess](SiteAccess_31429665.html#SiteAccess-Basics)

#### In this topic:

-   [Structuring an eZ Platform Project](#BestPractices-StructuringaneZPlatformProject)
    -   [The AppBundle](#BestPractices-TheAppBundle)
    -   [Templates](#BestPractices-Templates)
    -   [Assets](#BestPractices-Assets)
    -   [Configuration](#BestPractices-Configuration)
    -   [Versioning a project](#BestPractices-Versioningaproject)
-   [eZ Platform Configuration](#BestPractices-eZPlatformConfiguration)
    -   [Configuration format](#BestPractices-Configurationformat)
    -   [Configuration files](#BestPractices-Configurationfiles)
    -   [Specific configuration](#BestPractices-Specificconfiguration)

#### Related topics:

<span class="confluence-link">[Creating a new design using Bundle Inheritance](Design_31429681.html#Design-CreatinganewdesignusingBundleInheritance)</span>






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>
4.  <span>[Under the Hood: How eZ Platform Works](31429659.html)</span>
5.  <span>[Content Model: Content is King!](31429709.html)</span>
6.  <span>[Content items, Content Types and Fields](31430275.html)</span>
7.  <span>[Field Types reference](Field-Types-reference_31430495.html)</span>

 Developer : BinaryField Field Type 



This Field Type represents and handles a binary file. It also counts the number of times the file has been downloaded from the `content/download` module.

| Name         | Internal name  | Expected input | Output  |
|--------------|----------------|----------------|---------|
| `BinaryFile` | `ezbinaryfile` | `Mixed`        | `Mixed` |

## Description

This Field Type allows the storage and retrieval of a single file. It is capable of handling virtually any file type and is typically used for storing legacy document types such as PDF files, Word documents, spreadsheets, etc. The maximum allowed file size is determined by the "Max file size" class attribute edit parameter and the "`upload_max_filesize`" directive in the main PHP configuration file ("php.ini").

## PHP API Field Type 

### Value Object

`eZ\Publish\Core\FieldType\BinaryFile\Value` offers the following properties.

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
Note that both `BinaryFile` and Media Value and Type inherit from the `BinaryBase` abstract Field Type, and share common properties.

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th align="left">Attribute</th>
<th align="left">Type</th>
<th align="left">Description</th>
<th align="left">Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td align="left"><code>id</code></td>
<td align="left">string</td>
<td align="left"><span>Binary file identifier. This ID depends on the </span><a href="https://doc.ez.no/display/DEVELOPER/Clustering#Clustering-Binaryfilesclustering">IO Handler</a><span> that is being used. With the native, default handlers (FileSystem and Legacy), the ID is the file path, relative to the binary file storage root dir (<code>var/&lt;vardir&gt;/storage/original</code> by default).</span></td>
<td align="left">application/63cd472dd7819da7b75e8e2fee507c68.pdf</td>
</tr>
<tr class="even">
<td align="left"><code>fileName</code></td>
<td align="left">string</td>
<td align="left">The human readable file name, as exposed to the outside. Used when sending the file for download in order to name the file.</td>
<td align="left">20130116_whitepaper_ezpublish5 light.pdf</td>
</tr>
<tr class="odd">
<td align="left"><code>fileSize</code></td>
<td align="left">int</td>
<td align="left">File size, in bytes.</td>
<td align="left">1077923</td>
</tr>
<tr class="even">
<td align="left"><code>mimeType</code></td>
<td align="left">string</td>
<td align="left">The file's mime type.</td>
<td align="left">application/pdf</td>
</tr>
<tr class="odd">
<td align="left"><code>uri</code></td>
<td align="left">string</td>
<td align="left"><p>The binary file's content/download URI. If the URI doesn't include a host or protocol, it applies to the request domain.</p></td>
<td align="left">/content/download/210/2707</td>
</tr>
<tr class="even">
<td align="left"><code>downloadCount</code></td>
<td align="left">integer</td>
<td align="left">Number of times the file was downloaded</td>
<td align="left">0</td>
</tr>
<tr class="odd">
<td align="left"><code>path</code></td>
<td align="left">string</td>
<td align="left"><p><strong>*deprecated*<br />
</strong> Renamed to <code>id</code> starting from eZ Publish 5.2. Can still be used, but it is recommended not to use it anymore as it will be removed.</p></td>
<td align="left"> </td>
</tr>
</tbody>
</table>

### Hash format

The hash format mostly matches the value object. It has the following keys:

-   `id`
-   `path` (for backwards compatibility)
-   `fileName`
-   `fileSize`
-   `mimeType`
-   `uri`
-   `downloadCount`

## REST API specifics

Used in the REST API, a BinaryFile Field will mostly serialize the hash described above. However there are a couple specifics worth mentioning.

### Reading content: url property

When reading the contents of a field of this type, an extra key is added: url. This key gives you the absolute file URL, protocol and host included.

Example: <a href="http://example.com/var/ezdemo_site/storage/original/application/63cd472dd7819da7b75e8e2fee507c68.pdf" class="uri">http://example.com/var/ezdemo_site/storage/original/application/63cd472dd7819da7b75e8e2fee507c68.pdf</a>

### Creating content: data property

When creating BinaryFile content with the REST API, it is possible to provide data as a base64 encoded string, using the "`data`" fieldValue key:

``` brush:
<field>
    <fieldDefinitionIdentifier>file</fieldDefinitionIdentifier>
    <languageCode>eng-GB</languageCode>
    <fieldValue>
        <value key="fileName">My file.pdf</value>
        <value key="fileSize">17589</value>
        <value key="data"><![CDATA[/9j/4AAQSkZJRgABAQEAZABkAAD/2wBDAAIBAQIBAQICAgICAgICAwUDAwMDAwYEBAMFBwYHBwcG
...
...]]></value>
    </fieldValue>
</field>
```

 






