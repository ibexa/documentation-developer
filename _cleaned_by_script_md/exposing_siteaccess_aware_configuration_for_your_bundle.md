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

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>
4.  <span>[Repository](Repository_31432023.html)</span>
5.  <span>[List of Limitations](List-of-Limitations_31430459.html)</span>

 Developer : BlockingLimitation 



A generic Limitation type to use when no other Limitation has been implemented. Without any limitation assigned, a LimitationNotFoundException is thrown.

It is called "blocking" because it will always tell the permissions system that the User does not have access to any Policy it is assigned to, making the permissions system move on to the next Policy.

 

|                 |                                                                                       |
|-----------------|---------------------------------------------------------------------------------------|
| Identifier      | `n/a` (configured for `ezjscore` limitation `           FunctionList` out of the box) |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\BlockingLimitation`                 |
| Type Class      | `eZ\Publish\Core\Limitation\BlockingLimitationType`                                   |
| Criterion used  | MatchNone                                                                             |
| Role Limitation | no                                                                                    |

###### Possible values

<table>
<colgroup>
<col width="33%" />
<col width="33%" />
<col width="33%" />
</colgroup>
<tbody>
<tr class="odd">
<td align="left">Value</td>
<td align="left">UI value</td>
<td align="left">Description</td>
</tr>
<tr class="even">
<td align="left"><code>&lt;mixed&gt;</code></td>
<td align="left"><code>&lt;mixed&gt;</code></td>
<td align="left"><p>This is a generic Limitation which does not validate the values provided to it. Make sure to validate the values passed to this limitation in your own logic.</p></td>
</tr>
</tbody>
</table>

###### Configuration

As this is a generic Limitation, you can configure your custom Limitations to use it, out of the box FunctionList uses it in the following way:

``` brush:
    # FunctionList is a ezjscore limitations, it only applies to ezjscore policies not used by
    # API/platform stack so configuring to use "blocking" limitation to avoid LimitationNotFoundException
    ezpublish.api.role.limitation_type.function_list:
        class: %ezpublish.api.role.limitation_type.blocking.class%
        arguments: ['FunctionList']
        tags:
            - {name: ezpublish.limitationType, alias: FunctionList}
```

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Tutorials](Tutorials_31429522.html)</span>
4.  <span>[Creating a Tweet Field Type](Creating-a-Tweet-Field-Type_31429766.html)</span>

 Developer : Build the bundle 



<span>FieldTypes, like any other eZ Platform extensions, must be provided as Symfony 2 bundles. This chapter covers the creation and organization of this bundle.</span>

First, we explain how to generate the skeleton for a standard Symfony 2 bundle using the console: [Create the bundle](Create-the-bundle_31429782.html). Then, we explain what structure we suggest for storing a Field Type inside a bundle: [Structure the bundle](Structure-the-bundle_31429784.html).

**Tutorial path**






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Tutorials](Tutorials_31429522.html)</span>
4.  <span>[Extending PlatformUI with new navigation](Extending-PlatformUI-with-new-navigation_31430235.html)</span>

 Developer : Build the content list 



## Two ways to generate pages in PlatformUI

As written in the [PlatformUI technical introduction](Extending-eZ-Platform_31429689.html), pages in PlatformUI can be generated either by the browser based on the REST API (or any other API) responses or by doing part of the rendering on the server side for instance with some Twig templates called by a Symfony controller. Both options are perfectly valid and choosing one or the other is mainly a matter of taste. This step will examine both strategies even if the later steps will be based on the server-side rendering.

## Browser side rendering

In this case, the browser uses the REST API to fetch the necessary objects/structures and then the logic of transforming that to an HTML page is written in JavaScript and executed by the browser.

### View service to fetch the Location list

#### Minimal view service

The first thing to do is to create a view service. A view service is a component extending `Y.eZ.ViewService`. So we first need to declare and create a module and then this module will create the minimal view service class:

**yui.yml**

``` brush:
ezconf-listviewservice:
     requires: ['ez-viewservice']
     path: %extending_platformui.public_dir%/js/views/services/ezconf-listviewservice.js
```

Then in `ezconf-listviewservice.js` we can write the minimal view service:

**Minimal ListViewService**

``` brush:
YUI.add('ezconf-listviewservice', function (Y) {
    Y.namespace('eZConf');

    Y.eZConf.ListViewService = Y.Base.create('ezconfListViewService', Y.eZ.ViewService, [], {
        initializer: function () {
            console.log("Hey, I'm the ListViewService");
        },
    });
});
```

This is the minimal view service, it only writes a "hello world" message in the console when instantiated but for now it's not used anywhere in the application.

#### Configure the route to use the view service

To really use our view service in the application, we have to change the route so that the PlatformUI application instantiates and uses the view service when building the page. To do that, we have to add the route `service` property to hold the constructor function of the view service so the application plugin that adds the route will also have to require the `ezconf-listviewservice` module:

**yui.yml**

``` brush:
 ezconf-listapplugin:
     requires: ['ez-pluginregistry', 'plugin', 'base', 'ezconf-listview', 'ezconf-listviewservice'] # the view module has been added
     dependencyOf: ['ez-platformuiapp']
```

After doing that, `Y.eZConf.ListViewService` becomes available in the application plugin code and we can change the `eZConfList` route to:

**Creating a route with a view service**

``` brush:
app.route({
    name: "eZConfList",
    path: "/ezconf/list",
    view: "ezconfListView",
    service: Y.eZConf.ListViewService, // constructor function to use to instantiate the view service
    sideViews: {'navigationHub': true, 'discoveryBar': false},
    callbacks: ['open', 'checkUser', 'handleSideViews', 'handleMainView'],
});
```

After this change, the `Y.eZConf.ListViewService` is used when a user reaches the `eZConfList` route.

#### Fetching Locations from the view service

A view service is responsible for fetching data so it can be rendered. For a given route, the view service is instantiated the first time the route is accessed and then the same instance is reused. On that instance, the `_load` method is automatically called. This is where the loading logic should be in most cases. This method also receives a callback as its only parameter. This callback function should be called once the loading is finished. Typically, a view service will use the <a href="http://ezsystems.github.io/javascript-rest-client/">JavaScript REST Client</a> to request <span class="confluence-link">[eZ Platform REST API](REST-API-Guide_31430286.html)</span>. To do that, a JavaScript REST Client instance is available in the `capi` attribute of the view service.

In this tutorial, we want to display the Content in a flat list and filter this list by Content Types. For now, let's fetch everything; to do that, the view service will create a REST view to search for every Location in the repository:

**ezconf-listviewservice.js**

``` brush:
YUI.add('ezconf-listviewservice', function (Y) {
    Y.namespace('eZConf');

    Y.eZConf.ListViewService = Y.Base.create('ezconfListViewService', Y.eZ.ViewService, [], {
        initializer: function () {
            console.log("Hey, I'm the ListViewService");
        },

        // _load is automatically called when the view service is configured for
        // a route. callback should be executed when everything is finished
        _load: function (callback) {
            var capi = this.get('capi'), // REST API JavaScript client
                contentService = capi.getContentService(),
                query = contentService.newViewCreateStruct('ezconf-list', 'LocationQuery');

            // searching for "everything"
            query.body.ViewInput.LocationQuery.Criteria = {SubtreeCriterion: "/1/"};
            contentService.createView(query, Y.bind(function (err, response) {
                // parsing the response and storing the location list in the "location" attribute
                var locations;

                locations = Y.Array.map(response.document.View.Result.searchHits.searchHit, function (hit) {
                    var loc = new Y.eZ.Location({id: hit.value.Location._href});

                    loc.loadFromHash(hit.value.Location);
                    return loc;
                });
                this.set('locations', locations);
                callback();
            }, this));
        },
    }, {
        ATTRS: {
            locations: {
                value: [],
            }
        }
    });
});
```

At this point, if you refresh the PlatformUI application and follow the link added [in the previous step](Configure-the-navigation_31430245.html), you should see a new REST API request to `/api/ezp/v2/views` in the network panel of the browser:

<span class="confluence-embedded-file-wrapper confluence-embedded-manual-size"><img src="attachments/31430249/31430248.png" class="confluence-embedded-image confluence-content-image-border" height="400" /></span>

The Locations are built in the application but not yet used anywhere.

#### Passing the Location to the view

Now that we have the Locations, we have to give them to the view. For that, we have to implement the `_getViewParameters` method in the view service. This method is automatically called when view service loading is finished, it should return an object that will be used as a configuration object for the main view.

In our case, we just want to give the Location list to the view, so the `_getViewParameters` method is quite simple:

**\_getViewParameters of the view service**

``` brush:
_getViewParameters: function () {
    return {
        locations: this.get('locations'),
    };
},
```

With that code, the view will receive the Location list as an attribute under the name `locations`.

Why implement \_load and \_getViewParameters and not load and getViewParameters?

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
When implementing a custom view service, you should always implement the protected `_load` and `_getViewParameters` methods, not their public counterparts `load` and `getViewParameters`. By implementing the protected versions, you keep the opportunity for a developer to write a plugin to enhance your view service.

### View to display a list of Location

The view now receives the Location list in the `locations` attribute so we have to change the view to take that into account. For now, let's change it to just display the Location it receives as an unordered HTML list of links to those Locations. To do that, we have to:

1.  Declare the `locations` attribute in the view
2.  Give that list to the template in a form it can understand
3.  Update the template to generate the list

Point 2 is required because Handlebars is not able to understand the complex model objects generated by YUI. So we have to transform those complex object into plain JavaScript objects. After doing the changes in steps 1 and 2, the view looks like this:

**ezconf-listview.js**

``` brush:
YUI.add('ezconf-listview', function (Y) {
    Y.namespace('eZConf');

    Y.eZConf.ListView = Y.Base.create('ezconfListView', Y.eZ.TemplateBasedView, [], {
        initializer: function () {
            console.log("Hey, I'm the list view");
        },

        render: function () {
            this.get('container').setHTML(
                this.template({
                    locations: this._getJsonifiedLocations(),
                })
            );
            return this;
        },

        _getJsonifiedLocations: function () {
            // to get usable objects in the template
            return Y.Array.map(this.get('locations'), function (loc) {
                return loc.toJSON();
            });
        },
    }, {
        ATTRS: {
            locations: {
                value: [],
            }
        }
    });
});
```

Then the template has to be changed to something like:

**ezconflistview.hbt**

``` brush:
<h1 class="ezconf-list-title">List view</h1>

<ul class="ezconf-list">
{{#each locations}}
    <li><a href="{{path 'viewLocation' id=id languageCode=contentInfo.mainLanguageCode}}">{{ contentInfo.name }}</a></li>
{{/each}}
</ul>
```

PlatformUI provides a `path` template helper that allows you to generate a route URL in PlatformUI. It expects a route name and the route parameters.

Results

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
The resulting code can be been in <a href="https://github.com/ezsystems/ExtendingPlatformUIConferenceBundle/releases/tag/6_1_list_client">the <code>6_1_list_client</code> tag on GitHub</a>, this step result can also be viewed as <a href="https://github.com/ezsystems/ExtendingPlatformUIConferenceBundle/compare/5_navigation...6_1_list_client">a diff between tags <code>5_navigation</code> and <code>6_1_list_client</code></a>.

The rest of this tutorial is focused on the server side rendering strategy. Completing the browser side rendering strategy to get the expected features is left as an exercise.

## Server side rendering

In this case a part of the rendering is delegated to the server. When building a PlatformUI page this way, the application will just do one or more AJAX request(s) and inject the result in the UI. The PlatformUI *Admin part* is built this way. To be easily usable in the JavaScript application, the server response has to be structured so that the application can retrieve and set the page title, the potential notifications to issue and the actual page content. This is done by generating an HTML fragment, in the following way:

**Example of server side response**

``` brush:
<div data-name="title">Title to set in the application</div>
<div data-name="html">
    <p>Page content</p>
</div>
<ul data-name="notification">
    <li data-state="done">I'm a "done" notification to display in the application</li>
</ul>
```

### View service to fetch an HTML fragment

#### Minimal view service

In the case, the minimal view service is exactly the same as the one produced in [the previous Minimal view service paragraph](#Buildthecontentlist-Buildthecontentlist-Minimalviewservice).

#### Configure the route to use the view service

The eZConfList route also has to be configured exactly in the same way as in [the previous Configure the route to use the view service paragraph](#Buildthecontentlist-Buildthecontentlist-Configuretheroutetousetheviewservice).

#### Generate the HTML fragment server side

This will be done by a Symfony Controller that will use the Search Service and a Twig template to generate the HTML code. As you can see in <a href="https://github.com/ezsystems/ExtendingPlatformUIConferenceBundle/commit/01c43cee899e295109060ab89a7ea705e8171cd0#diff-2e1a19129e23e2d757512a5da45ffa54R1">this Github commit</a>, it's a very basic Symfony Controller that extends `EzSystems\PlatformUIBundle\Controller\Controller`.

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
Extending `EzSystems\PlatformUIBundle\Controller\Controller` is not strictly required. By doing that, the actions provided by the controller are automatically restricted to authenticated users. This base controller also provides the base API to handle notifications if needed.

To learn how to write Symfony controllers, please read <a href="http://symfony.com/doc/current/book/controller.html">the Symfony Controller documentation</a>.

The `list` action in `ListController` uses the following Twig template:

**list.html.twig**

``` brush:
{% extends "eZPlatformUIBundle::pjax_admin.html.twig" %}

{% block header_title %}
    <h1 class="ezconf-list-title">List view</h1>
{% endblock %}

{% block content %}
<ul class="ezconf-list">
{% for value in results.searchHits %}
    <li><a href="">{{ value.valueObject.contentInfo.name }}</a></li>
{% endfor %}
</ul>
{% endblock %}

{% block title %}List{% endblock %}
```

Again, it's a quite a regular template but to ease the generation of the expected structured HTML fragment, this template extends` eZPlatformUIBundle::pjax_admin.html.twig` and redefines a few blocks, the main one being `content` where the actual page content is supposed to be generated.

#### Update the view service to fetch the generated HTML fragment

We now have a Symfony Controller able to generate our Location list but this list is not yet available in the application. As in [Fetching Locations from the view service](#Buildthecontentlist-Buildthecontentlist-FetchingLocationsfromtheviewservice) and <span class="toc-item-body"><a href="http://doc.ez.no#Buildthecontentlist-PassingtheLocationtotheview">Passing the Location to the view</a></span>, we have to add the code in the view service. But in the case of a server side rendering, we can reuse <span class="blob-code-inner">`Y.eZ.`<span class="pl-smi x x-first x-last">`ServerSideViewService` which provides the base API to parse an HTML fragment which also provides a ready to use `_getViewParameters` method. All we have to do then is to implement the loading logic in `_load`:</span></span>

**ezconf-listviewservice.js**

``` brush:
YUI.add('ezconf-listviewservice', function (Y) {
    Y.namespace('eZConf');

    Y.eZConf.ListViewService = Y.Base.create('ezconfListViewService', Y.eZ.ServerSideViewService, [], {
        initializer: function () {
            console.log("Hey, I'm the ListViewService");
        },

        _load: function (callback) {
            var uri = this.get('app').get('apiRoot') + 'list';

            Y.io(uri, { // YUI helper to do AJAX request, see http://yuilibrary.com/yui/docs/io/
                method: 'GET',
                on: {
                    success: function (tId, response) {
                        this._parseResponse(response); // provided by Y.eZ.ServerSideViewService
                        callback(this);
                    },
                    failure: this._handleLoadFailure, // provided by Y.eZ.ServerSideViewService
                },
                context: this,
            });
        },
    });
});
```

The resulting `_load` method will just do an AJAX request to the action provided by our Symfony controller.

At this point, if you refresh your browser, nothing should have changed but you should see the AJAX request in the network panel of your browser.

<span class="confluence-embedded-file-wrapper confluence-embedded-manual-size"><img src="attachments/31430249/31430247.png" class="confluence-embedded-image confluence-content-image-border" width="916" height="400" /></span>

### View to handle the server side generated code

#### Change the view to be server side view

To have a visual change, we now have to change the `ListView` to be a server side view. This operations involves removing some code added in [the Define a View step](Define-a-View_31430243.html). Basically, the View does not need any template but it will inherit from `Y.eZ.ServerSideView`. As a result, the view module definition becomes:

**View module definition**

``` brush:
ezconf-listview:
    requires: ['ez-serversideview']
    path: %extending_platformui.public_dir%/js/views/ezconf-listview.js
```

And the View component also has to be simplified to:

**ezconf-listview.js**

``` brush:
YUI.add('ezconf-listview', function (Y) {
    Y.namespace('eZConf');

    Y.eZConf.ListView = Y.Base.create('ezconfListView', Y.eZ.ServerSideView, [], {
        initializer: function () {
            console.log("Hey, I'm the list view");
            this.containerTemplate = '<div class="ez-view-ezconflistview"/>'; // make sure we keep the same class on the container
        },
    });
});
```

At this point, you should see the same list as the one that was generated in [Browser side rendering](#Buildthecontentlist-Buildthecontentlist-Browsersiderendering) section. The only difference lies in the non-working links being generated in the server side solution.

#### Navigating in the app from the view

There are several ways to fix the link issue. In this step we are going to add some metadata to the generated HTML links, then we'll change the view to recognize the enhanced links and finally we'll change the server side view to achieve the navigation.

The server side code has no knowledge of the JavaScript application routing mechanism as a result, it can not directly generate any PlatformUI Application URI, but we know while generating the HTML fragment that we want each link to allow the navigation to the `viewLocation` route for the Location being displayed. We can then change the Twig template to add the necessary metadata on each link so that the application has a way of guessing where the user is supposed to go when clicking on the link:

**"content" block in the Twig template**

``` brush:
{% block content %}
<ul class="ezconf-list">
{% for value in results.searchHits %}
    <li><a class="ezconf-list-location" href=""
        data-route-name="viewLocation"
        data-route-id="{{ path('ezpublish_rest_loadLocation', {locationPath: value.valueObject.pathString|trim('/')}) }}"
        data-route-languageCode="{{ value.valueObject.contentInfo.mainLanguageCode }}"
        >{{ value.valueObject.contentInfo.name }}</a></li>
{% endfor %}
</ul>
{% endblock %}
```

For each link we are basically saying to the application that the user should directed to the `viewLocation` route for the given Location id and the given language code.

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
In PlatformUI code, the Locations, Content items and Content Types are identified by their REST id, that is the REST resource URL which allows you to fetch the object in the REST API. That's why we are using the `path` Twig template function to build the Location id.

Then we have to change the view to add a special behavior when the user clicks on them. The view can not directly trigger the navigation to the expected route. So in this case, we are firing an application level event with all the data we have on the link and we'll let the view service handle this application level event to take the user to the expected page. So, we have to configure our view to recognize the click on the links and to fire the `navigateTo` custom event:

**ezconf-listview.js**

``` brush:
YUI.add('ezconf-listview', function (Y) {
    Y.namespace('eZConf');

    Y.eZConf.ListView = Y.Base.create('ezconfListView', Y.eZ.ServerSideView, [], {
        // this is YUI View mechanic to subscribe to DOM events (click, submit,
        // ...) and synthetic event (some custom event provided by YUI) like
        // 'tap' here.
        events: {
            '.ezconf-list-location': {
                // tap is 'fast click' (touch friendly)
                'tap': '_navigateToLocation'
            }
        },

        initializer: function () {
            console.log("Hey, I'm the list view");
            this.containerTemplate = '<div class="ez-view-ezconflistview"/>';
        },

        _navigateToLocation: function (e) {
            var link = e.target;

            e.preventDefault(); // don't want the normal link behavior

            // tell the view service we want to navigate somewhere
            // it's a custom event that will be bubble up to the view service
            // (and the app)
            // the second parameter is the data to add in the event facade, this
            // can be used by any event handler function bound to this event.
            this.fire('navigateTo', {
                routeName: link.getData('route-name'),
                routeParams: {
                    id: link.getData('route-id'),
                    languageCode: link.getData('route-languagecode'),
                }
            });
        },
    });
});
```

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
The DOM event handling is one of the main YUI View features. It is documented in <a href="http://yuilibrary.com/yui/docs/view/#handling-dom-events">the YUI View guide</a>.

Now the click on the Location link is transformed in a `navigateTo` event, we have to subscribe to that event in the view service to trigger the expected navigation:

**ezconf-listviewservice.js**

``` brush:
YUI.add('ezconf-listviewservice', function (Y) {
    Y.namespace('eZConf');

    Y.eZConf.ListViewService = Y.Base.create('ezconfListViewService', Y.eZ.ServerSideViewService, [], {
        initializer: function () {
            console.log("Hey, I'm the ListViewService");

            // we catch the `navigateTo` event no matter from where it comes
            // when bubbling, the event is prefixed with the name of the
            // component which fired the event first.
            // so in this case we could also write
            // this.on('ezconflistview:navigateTo', function (e) {});
            // `e` is the event facade. It contains various informations about
            // the event and if any the custom data passed to fire().
            this.on('*:navigateTo', function (e) {
                this.get('app').navigateTo(
                    e.routeName,
                    e.routeParams
                );
            });
        },

        _load: function (callback) {
            // [...] skip to keep the example short
        },
    });
});
```

With that in place and after a refresh, the Location list should allow you to the navigate to the expected Location in PlatformUI.

Application level events

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
PlatformUI uses a lot of custom application level events thanks to <a href="http://yuilibrary.com/yui/docs/event-custom/">the EventTarget YUI component</a>. Those events are very similar to <a href="http://yuilibrary.com/yui/docs/event/">DOM events</a> but they are attached to the application components instead of the DOM elements. Like for DOM events, there is <a href="http://yuilibrary.com/yui/docs/event-custom/#bubbling">a bubbling mechanism</a>. For instance, here the view is firing an event and unless the propagation of the event is stopped, it will bubble to the view service and then to the application. The event basically follows [the components tree until the application](Extending-eZ-Platform_31429689.html). **An application level event is way for a deeply nested component to communicate with a higher level component.**

Results and next step

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
The resulting code can be seen in <a href="https://github.com/ezsystems/ExtendingPlatformUIConferenceBundle/releases/tag/6_2_list_server">the <code>6_2_list_server</code> tag on GitHub</a>, this step result can also be viewed as <a href="https://github.com/ezsystems/ExtendingPlatformUIConferenceBundle/compare/5_navigation...6_2_list_server">a diff between tags <code>5_navigation</code> and <code>6_2_list_server</code></a>.

The next step is then [to add the pagination](Paginate-results_31430251.html).

**Tutorial path**

## Attachments:

<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [nw\_panel.png](attachments/31430249/31430247.png) (image/png)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [restview.png](attachments/31430249/31430248.png) (image/png)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Tutorials](Tutorials_31429522.html)</span>

 Developer : Building a Bicycle Route Tracker in eZ Platform 



# Building a Website with eZ Platform

<span class="confluence-embedded-file-wrapper image-right-wrapper confluence-embedded-manual-size"><img src="attachments/31431606/31431605.png" class="confluence-embedded-image image-right" height="250" /></span>

 This tutorial is a step-by-step guide to building an eZ Platform website from the ground up. <span style="color: rgb(0,51,102);">All instructions and steps are based on version [<span style="color: rgb(0,51,102);">1.7.0</span>](eZ-Platform-v1.7.0-LTS_32868941.html)</span><span style="color: rgb(0,51,102);"> of eZ Platform released on December 15, 2016.</span>

This tutorial applies a learning-by-doing method to demonstrate how <a href="https://ezplatform.com/">eZ Platform</a> can be used to build a great website.

Throughout this guide we will take you through the process of building a website in a series of steps using best practices for the most effective developer experience.

 

## Intended Audience

This tutorial is intended for users who have little or no previous experience with the eZ Platform user interface.

Some general knowledge of web development would certainly be helpful.

To follow this tutorial, you should:

-   Have basic knowledge of HTML and CSS.
-   Have basic knowledge of the database you've selected.

 

<span class="confluence-embedded-file-wrapper"><img src="attachments/32868603/32868702.png" class="confluence-embedded-image" /></span>
 

## Learning Outcomes

After going through this tutorial, you will:

-   Have a basic understanding of setting up an eZ Platform application.

-   Have some hands-on experience designing, developing and deploying a demo eZ Platform website.
-   Have developed the skills to run your own eZ Platform website.

# The Story Behind the Tutorial - Bike Rides

We'll work according to the following story:

**The Story**

*A good friend has a spreadsheet which details all her bike rides, and she knows you are a professional webmaster. She asks for your help in building a website detailing the rides. She wants to upload photos from each ride.*
*She has no experience with web development. Some of her friends are interested in browsing and searching her "ride log". In the near future, she wants to be able to add rides by herself, and even open this possibility to her friends.*

**Specifications**

The "customer" requirements are:

-   A list of all rides in table form
-   Viewing photos of a ride

**More to come...**

-   <span class="status-macro aui-lozenge aui-lozenge-current aui-lozenge-subtle">WORK IN PROGRESS</span> *Ordering rides
    *
-   <span class="status-macro aui-lozenge aui-lozenge-current aui-lozenge-subtle">WORK IN PROGRESS</span> *Searching for a ride by starting place or length in km*
-   <span class="status-macro aui-lozenge aui-lozenge-current aui-lozenge-subtle">WORK IN PROGRESS</span> *Commenting on rides*

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
# Getting Help

If you have any questions, feel free to reach out to us or our <a href="http://share.ez.no/get-involved/exchange">awesome community</a> for help!

<span class="char" title="Black Rightwards Arrow"> </span>
<span class="char" title="Black Rightwards Arrow"> </span>

 

Next: <span class="confluence-link">[Part 1: Setting up eZ Platform](31431610.html)</span> <span class="char" title="Black Rightwards Arrow">➡
</span>

<span class="char" title="Black Rightwards Arrow">
</span>

 

 

 

**Tutorial path**

 

 

 

 

## Attachments:

<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [pulley-ibex.png](attachments/31431606/32113253.png) (image/png)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [pulley\_ibex.png](attachments/31431606/32113252.png) (image/png)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [pulley-ibex.png](attachments/31431606/31431605.png) (image/png)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>

 Developer : Bundles 



# Introduction

eZ CMS is based on the Symfony2 framework and follows its organization of the app. Like in Symfony, where <a href="http://symfony.com/doc/current/book/bundles.html">&quot;everything is a bundle&quot;</a>, your eZ application is going to be a collection of bundles.

## What is a bundle?

A bundle in Symfony (and eZ) is a separate part of your application that implements a feature. You can create bundles yourself or make use of available open-source bundles. You can also reuse the bundles you create in other projects or share them with the community.

Many eZ CMS functionalities are provided through separate bundles included in the installation.

## How to use bundles?

By default, a clean eZ Platform installation contains an AppBundle where you can place your code.

To learn more about organizing your eZ project, see [Best Practices](Best-Practices_31429687.html).

## How to create bundles?

You can generate a new bundle using a `generate:bundle` command. See <a href="http://symfony.com/doc/current/bundles/SensioGeneratorBundle/commands/generate_bundle.html">Symfony documentation on generating bundles</a>.

In addition to <a href="http://symfony.com/doc/bundles/">Symfony Bundles</a>, eZ provides a set of bundles out of the box and some optional ones.

### How to remove a bundle?

To remove a bundle (either one you created yourself, or an out-of-the-box one that you do not need) see the <a href="http://symfony.com/doc/current/bundles/remove.html">How to Remove a Bundle</a>instruction in Symfony doc.

# Configuration

## EzPublishCoreBundle Configuration

 

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
To get an overview of EzPublishCoreBundle's configuration, run the following command-line script:

``` brush:
php app/console config:dump-reference ezpublish
```

## Default page

Default page is the default page to show or redirect to.

If set, it will be used for default redirection after user login, overriding Symfony's `default_target_path`, giving the opportunity to configure it by siteaccess.

**ezplatform.yml**

``` brush:
ezpublish:
    system:
        ezdemo_site:
            default_page: "/Getting-Started"

        ezdemo_site_admin:
            # For admin, redirect to dashboard after login.
            default_page: "/content/dashboard"
```

This setting **does not change anything to Symfony behavior** regarding redirection after login. If set, it will only substitute the value set for `default_target_path`. It is therefore still possible to specify a custom target path using a dedicated form parameter.

**Order of precedence is not modified.**

 

#### In this topic:

-   [Introduction](#Bundles-Introduction)
    -   [What is a bundle?](#Bundles-Whatisabundle?)
    -   [How to use bundles?](#Bundles-Howtousebundles?)
    -   [How to create bundles?](#Bundles-Howtocreatebundles?)
        -   [How to remove a bundle?](#Bundles-Howtoremoveabundle?)
-   [Configuration](#Bundles-Configuration)
    -   [EzPublishCoreBundle Configuration](#Bundles-EzPublishCoreBundleConfiguration)
    -   [Default page](#Bundles-Defaultpage)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>
4.  <span>[Under the Hood: How eZ Platform Works](31429659.html)</span>
5.  <span>[Content Model: Content is King!](31429709.html)</span>
6.  <span>[Content items, Content Types and Fields](31430275.html)</span>
7.  <span>[Field Types reference](Field-Types-reference_31430495.html)</span>

 Developer : Checkbox Field Type 



This field type represents a Checkbox status, checked or unchecked.

| Name       | Internal name | Expected input type |
|------------|---------------|---------------------|
| `Checkbox` | `ezboolean`   | `boolean`           |

## Description

The Checkbox Field Type stores the current status for a checkbox input, checked of unchecked, by storing a boolean value.

## PHP API Field Type 

### Value object

##### Properties

The Value class of this Field Type contains the following properties:

| Property | Type      | Default value | Description                                                                                       |
|----------|-----------|---------------|---------------------------------------------------------------------------------------------------|
| `$bool`  | `boolean` | `false`       | This property will be used for the checkbox status, which will be represented by a boolean value. |

**Value object content examples**

``` brush:
use eZ\Publish\Core\FieldType\Checkbox\Type;
 
// Instantiates a checkbox value with a default state (false)
$checkboxValue = new Checkbox\Value();
 
// Checked
$value->bool = true; 
 
// Unchecked
$value->bool = false;
```

##### Constructor

<span>The </span>`Checkbox\Value`<span> constructor accepts a boolean value:</span>

**Constructor example**

``` brush:
use eZ\Publish\Core\FieldType\Checkbox\Type;
 
// Instantiates a checkbox value with a checked state
$checkboxValue = new Checkbox\Value( true );
```

##### String representation

As this Field Type is not a string but a bool, it will return "1" (true) or "0" (false) in cases where it is cast to string.

 

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>

 Developer : Clustering 



# Introduction

Clustering in eZ Platform refers to setting up your install with several web servers for handling more load and/or for failover.

## Server setup overview

This diagram illustrates how clustering of eZ Platform is typically set up, the parts illustrate the different roles needed for a successful cluster setup. The number of web servers, Memcached servers, Solr servers, Varnish servers, Database servers, NFS servers, as well as whether some servers play several of these roles *(typically running Memcached across the web server)* is up to you and your performance needs.

The minimal requirements are the following *(with what is currently supported in italics)*:

-   Shared HTTP cache *(using Varnish)*
-   Shared Persistence cache and Sessions *(using Memcached, or experimentally also Redis)*
-   Shared Database *(using MySQL/MariaDB)*
-   Shared Filesystem *(using NFS, or experimentally also S3)*

For further details on requirements, see <span class="confluence-link"> [Requirements page](31429536.html) </span>.

While this is not a complete list, further recommendations include:

-   Using [Solr](Solr-Bundle_31430592.html) for better search and better search performance
-   Using a CDN for improved performance and faster ping time worldwide
-   Using Active/Passive Database for failover
-   In general: Make sure to use later versions of PHP and MySQL/MariaDB within [<span class="confluence-link">what is supported</span>](31429536.html) <span class="confluence-link"> </span> for your eZ Platform version to get more performance out of each server.

<span class="confluence-embedded-file-wrapper confluence-embedded-manual-size"><img src="attachments/31430387/31430385.png" class="confluence-embedded-image" width="500" /></span>

## Binary files clustering

eZ Platform supports multi-server by means of custom IO handlers. They will make sure that files are correctly synchronized among the multiple clients that might use the data.

# Configuration

<span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"></span>
Memcached must not be bound to the local address if clusters are in use, or user logins will fail. To avoid this, in `/etc/memcached.conf` take a look under `# Specify which IP address to listen on. The default is to listen on all IP addresses`

For development environments, change the address below to `                 -l 0.0.0.0               `

For production environments, follow this more secure instruction from the memcached man:

> -l &lt;addr&gt;
> Listen on &lt;addr&gt;; default to INADDR\_ANY. &lt;addr&gt; may be specified as host:port. If you don't specify a port number, the value you specified with -p or -U is used. You may specify multiple addresses separated by comma or by using -l multiple times. This is an important option to consider as there is no other way to secure the installation. Binding to an internal or firewalled network interface is suggested.

## DFS IO Handler

### What it is meant for

The DFS IO handler (`legacy_dfs_cluster)` can be used to store binary files on an NFS server. It will use a database to manipulate metadata, making up for the potential inconsistency of network based filesystems.

### <a href="https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/io/legacy_dfs_cluster.md#configuration"></a>Configuration

You need to configure both metadata and binarydata handlers.

As the binarydata handler, create a new Flysystem local adapter configured to read/write to the NFS mount point on each local server. As metadata handler handler, create a dfs one, configured with a doctrine connection. 

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
<span class="status-macro aui-lozenge aui-lozenge-current">V1.8.0</span>

Note: the default database install will now include the dfs table *in the same database*

For production, we strongly recommend creating the DFS table in its own database, using the `vendor/ezsystems/ezpublish-kernel/data/mysql/dfs_schema.sql` file.
In our example, we will use one named `dfs`. 

``` brush:
# new doctrine connection for the dfs legacy_dfs_cluster metadata handler.
doctrine:
    dbal:
        connections:
            dfs:
                driver: pdo_mysql
                host: 127.0.0.1
                port: 3306
                dbname: ezdfs
                user: root
                password: "rootpassword"
                charset: UTF8

# define the flysystem handler
oneup_flysystem:
    adapters:
        nfs_adapter:
            local:
                directory: "/<path to nfs>/$var_dir$/$storage_dir$"

# define the ez handlers
ez_io:
    binarydata_handlers:
        nfs:
            flysystem:
                adapter: nfs_adapter
    metadata_handlers:
        dfs:
            legacy_dfs_cluster:
                connection: doctrine.dbal.dfs_connection

# set the application handlers
ezpublish:
    system:
        default:
            io:
                metadata_handler: dfs
                binarydata_handler: nfs
```

#### Customizing the storage directory

eZ Publish 5.x required the NFS adapter directory to be set to `$var_dir$/$storage_dir$` part for the NFS path. This is no longer required with eZ Platform, but the default prefix used to serve binary files will still match this expectation.

If you decide to change this setting, make sure you also set `io.url_prefix` to a matching value. If you set the NFS adapter's directory to "/path/to/nfs/storage", use this configuration so that the files can be served by Symfony:

``` brush:
ezpublish:
    system:
        default:
            io:
                url_prefix: "storage"
```

<span>
</span>

<span>As an alternative, you may serve images from NFS using a dedicated web server. If in the example above, this server listens on </span> <a href="http://static.example.com/">http://static.example.com</a> <span> and uses </span> `/path/to/nfs/storage` <span> as the document root, configure </span> `io.url_prefix` <span> as follows:</span>

 

``` brush:
ezpublish:
    system:
        default:
            io:
                url_prefix: "http://static.example.com/"
```

You can read more about that on [Binary files URL handling](Repository_31432023.html#Repository-BinaryfilesURLhandling).

### Web server rewrite rules

The default eZ Platform rewrite rules will let image requests be served directly from disk. With native support, files matching `^/var/([^/]+/)?storage/images(-versioned)?/.*` have to be passed through `/web/app.php`.

In any case, this specific rewrite rule must be placed without the ones that "ignore" image files and just let the web server serve the files.

#### <a href="https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/io/legacy_dfs_cluster.md#apache"></a>Apache

``` brush:
RewriteRule ^/var/([^/]+/)?storage/images(-versioned)?/.* /app.php [L]
```

#### <a href="https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/io/legacy_dfs_cluster.md#nginx"></a>nginx

``` brush:
rewrite "^/var/([^/]+/)?storage/images(-versioned)?/(.*)" "/app.php" break;
```

 

 

#### In this topic:

-   [Introduction](#Clustering-Introduction)
    -   [Server setup overview](#Clustering-Serversetupoverview)
    -   [Binary files clustering](#Clustering-Binaryfilesclustering)
-   [Configuration](#Clustering-Configuration)
    -   [DFS IO Handler](#Clustering-DFSIOHandler)
        -   [What it is meant for](#Clustering-Whatitismeantfor)
        -   [Configuration](#Clustering-Configuration.1)
        -   [Web server rewrite rules](#Clustering-Webserverrewriterules)

#### Related:

-   [Overview of steps to set up Cluster](Steps-to-set-up-Cluster_31432321.html)[:](#Clustering-Persistencecacheconfiguration)
    -   [Configure Persistence Cache](Repository_31432023.html#Repository-Persistencecacheconfiguration)
    -   [Set up Varnish](HTTP-Cache_31430152.html#HTTPCache-UsingVarnish)
    -   <span class="confluence-link"> [Configure sessions](Sessions_31429667.html) </span>
-   [Performance](Performance_33555232.html)

## Attachments:

<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [Server setup.png](attachments/31430387/31430385.png) (image/png)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [Server setup 5.x doc.png](attachments/31430387/31430386.png) (image/png)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Migrating to eZ Platform - Follow the Ibex!](31429532.html)</span>

 Developer : Coming to eZ Platform from eZ Publish Platform 



eZ Publish Platform (5.x) was a transitional version of the eZ CMS, bridging the gap between the earlier generation called eZ Publish (sometimes referred to as *legacy*), and the current eZ Platform Enterprise Edition for Developers.

<span class="confluence-embedded-file-wrapper image-left-wrapper confluence-embedded-manual-size"><img src="attachments/31429520/32866977.png" class="confluence-embedded-image image-left" height="250" /></span>

eZ Publish Platform introduced a new Symfony-based technology stack that could be run along the old (*legacy*) one. This fluid change allows eZ Publish users to migrate to eZ Platform Enterprise Edition for Developers in two steps, using the 5.x version as an intermediary stepping stone.

The migration process from eZ Publish Platform to eZ Platform Enterprise Edition for Developers is described in [Upgrading from 5.4.x and 2014.11 to 16.xx](Upgrading-from-5.4.x-and-2014.11-to-16.xx_31430322.html).

 

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>

 Developer : Community Resources 



## Let's Connect!

In the course of its development eZ Platform has been deeply rooted in its community. This remains true, with many invaluable contributions by dedicated community members who play a key role in the continuous development of eZ Platform. 

eZ partners, customers, independent developers, designers, and digital content enthusiasts can contribute to important web projects, influence the [eZ roadmap](https://doc.ez.no/display/MAIN/eZ+Platform+and+eZ+Studio+Release+Process+and+Roadmap), and ensure the platform stays on top of market trends and organizations' needs.

This section provides information about the benefits you can draw from the community and about how you can contribute to eZ Platform's development yourself.

 

 

-   [Professional Training Services](Professional-Training-Services_31429585.html)
-   [Resources](Resources_31429588.html)
-   [How to Contribute](How-to-Contribute_31429587.html)
    -   [GitHub 101](GitHub-101_31429590.html)
    -   [Report and follow issues: The bugtracker](31429592.html)
    -   [Contribute to Documentation](Contribute-to-Documentation_31429594.html)
    -   [Development guidelines](Development-guidelines_31430575.html)
    -   [Contributing translations](Contributing-translations_34079215.html)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Get Started with eZ Platform](Get-Started-with-eZ-Platform_31429520.html)</span>
4.  <span>[Step 2: Going Deeper](31429542.html)</span>
5.  <span>[Using Composer](Using-Composer_31431588.html)</span>

 Developer : Composer for Frontend Developers 



If you are a web designer or working on the CSS on your website, this page contains is all you need to know about Composer.

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
<a href="https://getcomposer.org/">Composer</a> is an opensource PHP packaging system to manage dependencies.

This makes it easy to adapt package installs and updates to your workflow, allowing you to test new/updated packages in a development environment, put the changes in your version control system (git, Subversion, Mercurial, etc.), pull in those changes on a staging environment and, when approved, put it in production.

# Troubleshooting

You may experience some latency in dependency resolution: everything is going normally.

If you are interested by the process, do your Composer commands with the `--verbose` option activated.

### Option `verbose -v`

Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug.

#### Usage:

``` brush:
php -d memory_limit=-1 composer.phar <command> --verbose (-v|vv|vvv)
```

# Useful commands

## install

The `install` command reads the composer.lock file from the current directory, processes it, and downloads and installs all the libraries and dependencies outlined in that file. If the file does not exist it will look for composer.json and do the same.

### Usage

``` brush:
php -d memory_limit=-1 composer.phar install --dry-run --prefer-dist
```

In this example the `dry-run` option is mentioned to prevent you from doing anything critical. (This option outputs the operations but will not execute anything and implicitly enables the verbose mode).

### Documentation with complete usage:

``` brush:
php -d memory_limit=-1 composer.phar install [--prefer-source] [--prefer-dist] [--dry-run] [--dev] [--no-dev] [--no-plugins] [--no-custom-installers] [--no-scripts] [--no-progress] [-v|vv|vvv|--verbose] [-o|--optimize-autoloader] [packages1] ... [packagesN]
```

## update

 The `update` command reads the composer.json file from the current directory, processes it, and updates, removes or installs all the dependencies.

### Interesting options:

To limit the update operation to a few packages, you can list the package(s) you want to update as such:

``` brush:
php -d memory_limit=-1 composer.phar update vendor/package1 foo/mypackage 
```

 You may also use an asterisk (\*) pattern to limit the update operation to package(s) from a specific vendor:

``` brush:
php -d memory_limit=-1 composer.phar update vendor/package1 foo/* 
```

 

 

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Get Started with eZ Platform](Get-Started-with-eZ-Platform_31429520.html)</span>
4.  <span>[Step 2: Going Deeper](31429542.html)</span>
5.  <span>[Using Composer](Using-Composer_31431588.html)</span>

 Developer : Composer for System Administrators 



<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
<a href="https://getcomposer.org/">Composer</a> is an opensource PHP packaging system to manage dependencies.

This makes it easy to adapt package installs and updates to your workflow, allowing you to test new/updated packages in a development environment, put the changes in your version control system (git, Subversion, Mercurial, etc.), pull in those changes on a staging environment and, when approved, put it in production.

composer.phar or composer ?

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
The following examples use a `composer install` global command, as alternative use `php composer.phar <command>`.
Read the answer in the FAQ:[What Composer command-line do you have to use ?](https://doc.ez.no/pages/viewpage.action?pageId=23529122)

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
See <a href="https://getcomposer.org/doc/00-intro.md">the Composer documentation</a> for further information

# Technical prerequisites

Composer requires PHP 5.3.2+ to run.

# Useful Composer commands for System Administrators

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
Note: as usual with CLI, you can type:

    $> php composer.phar help [--xml] [--format="..."] [--raw] [command_name]

to get help for the command.

 

On this page you will find some useful commands and an extract of the Composer Documentation. The interesting options part is an extract of available options

## show

The `show` command displays detailed information about a package, or lists all available packages.

### Usage:

``` brush:
 php composer.phar show [-i|--installed] [-p|--platform] [-a|--available] [-s|--self] [-N|--name-only] [-P|--path] [package] [version]
```

## require

The `require` command adds required packages to your composer.json and installs them. If you do not want to install the new dependencies immediately, you can call it with `--no-update`

### Usage:

``` brush:
php composer.phar require [--dev] [--prefer-source] [--prefer-dist] [--no-progress] [--no-update] [--update-no-dev] [--update-with-dependencies] [packages1] ... [packagesN]
```

### Interesting options

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th align="left"> </th>
<th align="left"> </th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td align="left"> --prefer-source</td>
<td align="left">Forces installation from package sources when possible, including VCS information.</td>
</tr>
<tr class="even">
<td align="left"> --prefer-dist</td>
<td align="left"><p>Forces installation from package dist even for dev versions.</p></td>
</tr>
<tr class="odd">
<td align="left"> --no-progress</td>
<td align="left"><p>Do not output download progress.</p></td>
</tr>
<tr class="even">
<td align="left"> --no-update</td>
<td align="left"><p>Disables the automatic update of the dependencies.</p></td>
</tr>
<tr class="odd">
<td align="left"> --update-with-dependencies</td>
<td align="left"><p>Allows inherited dependencies to be updated with explicit dependencies.</p></td>
</tr>
</tbody>
</table>

 

## search

The `search` command searches for packages by its name.

### Example :

``` brush:
$> php composer.phar search symfony composer
```

 can return to you a list like this:

 

**** <span class="collapse-source expand-control"><span class="expand-control-icon icon"> </span><span class="expand-control-text">Expand source</span></span>

``` brush:
symfony/assetic-bundle Integrates Assetic into Symfony2
symfony/monolog-bundle Symfony MonologBundle
ezsystems/ngsymfonytools-bundle Bundle of the legacy netgen/ngsymfonytools extension
symfony-cmf/routing Extends the Symfony2 routing component for dynamic routes and chaining several routers
doctrine/doctrine-bundle Symfony DoctrineBundle
nelmio/cors-bundle Adds CORS (Cross-Origin Resource Sharing) headers support in your Symfony2 application
tedivm/stash-bundle Incorporates the Stash caching library into Symfony.
egulias/listeners-debug-command-bundle Symfony 2 console command to debug listeners
hautelook/templated-uri-router Symfony2 RFC-6570 compatible router and URL Generator
hautelook/templated-uri-bundle Symfony2 Bundle that provides a RFC-6570 compatible router and URL Generator.
symfony/swiftmailer-bundle Symfony SwiftmailerBundle
white-october/pagerfanta-bundle Bundle to use Pagerfanta with Symfony2
symfony/icu Contains an excerpt of the ICU data and classes to load it.
symfony/symfony The Symfony PHP framework
sensio/distribution-bundle The base bundle for the Symfony Distributions
symfony/symfony The Symfony PHP framework
symfony/console Symfony Console Component
symfony/filesystem Symfony Filesystem Component
symfony/finder Symfony Finder Component
symfony/process Symfony Process Component
symfony/yaml Symfony Yaml Component
symfony/translation Symfony Translation Component
symfony/debug Symfony Debug Component
symfony/routing Symfony Routing Component
symfony/icu Contains an excerpt of the ICU data to be used with symfony/intl.
symfony/config Symfony Config Component
symfony/validator Symfony Validator Component
symfony/stopwatch Symfony Stopwatch Component
symfony-cmf/symfony-cmf Symfony Content Management Framework
```

## validate

The `validate` command validates a given composer.json.

###  Usage

``` brush:
 $> php composer.phar validate [--no-check-all] [file]
```

### Interesting options

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th align="left">option</th>
<th align="left">description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td align="left"><p> --no-check-all </p></td>
<td align="left">Do not make a complete validation</td>
</tr>
<tr class="even">
<td align="left"><p> --profile </p></td>
<td align="left">Display timing and memory usage information</td>
</tr>
<tr class="odd">
<td align="left"> --working-dir (-d)</td>
<td align="left">If specified, use the given directory as working directory.</td>
</tr>
</tbody>
</table>

# Automate installation

Note that you can add some scripts to the Composer dependencies installation.

The available events are :

-   **pre-install-cmd**
-   **post-install-cmd**
-   **pre-update-cmd**
-   **post-update-cmd**
-   **pre-status-cmd**
-   **post-status-cmd**
-   **pre-package-install**
-   **post-package-install**
-   **pre-package-update**
-   **post-package-update**
-   **pre-package-uninstall**
-   **post-package-uninstall**
-   **pre-autoload-dump**
-   **post-autoload-dump**
-   **post-root-package-install**
-   **post-create-project-cmd**
-   **pre-archive-cmd**
-   **post-archive-cmd**

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
See <a href="https://getcomposer.org/doc/articles/scripts.md">the Composer documentation</a> about scripts for more information

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Tutorials](Tutorials_31429522.html)</span>
4.  <span>[Extending PlatformUI with new navigation](Extending-PlatformUI-with-new-navigation_31430235.html)</span>

 Developer : Conclusion 



## Potential improvements and bugs

We now have a basic interface but it already has some bugs and it could be improved in a lots of ways. Here is a list of things that are left as exercises:

-   Improve the look and feel and output: it's partially of done in commit <a href="https://github.com/ezsystems/ExtendingPlatformUIConferenceBundle/commit/13d5a0b2f4d957425a751a2cc4cbd6566ed0b57a">13d5a0b2</a> but can probably improved further.
-   Reload only the table, not the full view when filtering.
-   Sorting.
-   More filters, more columns, etc.
-   The server side code deserves to be refactored.
-   Unit tests.
-   **\[bug\]** Highlight is buggy in navigation because we have several routes while the navigation item added in [Configure the navigation](Configure-the-navigation_31430245.html) only recognizes the first route we add.
-   **\[bug\]** 'eng-GB' hardcoded when getting Content Type name.

## Documentation pages to go further

This tutorial talks and uses a lots of concepts coming from Symfony, eZ Platform, PlatformUI itself or YUI. Here is a list of documentation pages that are worth reading to completely understand what's going on behind the scenes:

### Symfony-related documentation pages

-   From a Symfony point of view, in this tutorial we mainly wrote a controller and with the associated routing configuration, <a href="http://symfony.com/doc/current/book/controller.html">the Controller book page</a> is definitively the most important Symfony related page to read
-   We also defined a Controller as a service in this tutorial, this is detailed in <a href="http://symfony.com/doc/current/cookbook/controller/service.html">How to Define Controllers as Services</a>.
-   <a href="http://twig.sensiolabs.org/doc/templates.html">Twig for Template Designers</a> explains how to write Twig templates

### eZ Platform-related documentation pages

-   The Public API is described in both the <span class="confluence-link"> </span> <span class="confluence-link"> <span class="confluence-link"> [Public API basics page](Getting-started-with-the-Public-API_31430305.html) </span> </span> and in [the Public API Cookbook](Public-API-Guide_31430303.html).
-   For any usage beyond what is covered in those pages, you can refer to <a href="http://apidoc.ez.no/sami/trunk/NS/html/index.html">the auto-generated API doc</a>.
-   While extending PlatformUI, you'll also have to work with the [REST API which has its own section in the documentation](REST-API-Guide_31430286.html).
-   There is also <a href="http://ezsystems.github.io/javascript-rest-client/">an auto-generated API doc for the JavaScript REST Client</a>.

### PlatformUI-related documentation pages

-   [The PlatformUI technical introduction](https://doc.ez.no/display/DEVELOPER/Backend+interface) gives an overview of the architecture and explains some its concepts.
-   PlaformUI also has <a href="http://ezsystems.github.io/platformui-javascript-api/">an auto-generated API doc</a>.

### YUI-related documentation pages

The whole YUI documentation could be useful when working with PlatformUI, but amongst others things here is a list of the most important pages:

-   For the very low level foundations, the guides about <a href="http://yuilibrary.com/yui/docs/attribute/">Attribute</a> and <a href="http://yuilibrary.com/yui/docs/base/">Base</a> (almost everything in PlatformUI is YUI Base object with attributes), <a href="http://yuilibrary.com/yui/docs/event-custom/">EventTarget</a> (custom events) and <a href="http://yuilibrary.com/yui/docs/plugin/">Plugin</a> (for tweaking almost any PlatformUI components) can be very useful
-   A large part of the application is about manipulating the DOM and subscribing to DOM events, this is covered in the <a href="http://yuilibrary.com/yui/docs/node/">Node</a> and <a href="http://yuilibrary.com/yui/docs/event/">DOM Events</a> guides.
-   The PlatformUI Application is based on the YUI App Framework which itself is mainly described in <a href="http://yuilibrary.com/yui/docs/app/">the App Framework</a>, <a href="http://yuilibrary.com/yui/docs/router/">Router</a> and <a href="http://yuilibrary.com/yui/docs/view/">View</a> guides.

**Tutorial path**






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Tutorials](Tutorials_31429522.html)</span>
4.  <span>[Extending PlatformUI with new navigation](Extending-PlatformUI-with-new-navigation_31430235.html)</span>

 Developer : Configure the navigation 



## PlatformUI Navigation Hub

As written in the [PlatformUI technical introduction](Extending-eZ-Platform_31429689.html), the Navigation Hub gives access to 4 navigation zones which have a set of navigation items. Each Navigation Item is actually a View in the Navigation Hub which can generate one or more links in the menu. Most Navigation Items can even be seen as a View of a given application route. A Navigation Item View is also responsible for handling its *selected state*. This means that the Navigation Items are notified when the application matches a new route and the view can then decide to react accordingly.

PlatformUI comes with 3 different implementations of Navigation Item. They all generate a link to a route with a given anchor text and they differ by the ability to check if the newly matched route in the application is the route they represent:

-   the base implementation is `Y.eZ.NavigationItemView`. When the matched application route changes, it sets its selected state if the navigation item route name matches the name of the new matched route in the application
-   the `Y.eZ.NavigationItemParameterView` implementation adds a check on a route parameter. So to appear selected, the route names must match and a given route parameter should be the same in both the application matched route and in the route the view is representing
-   the `Y.eZ.NavigationItemSubtreeView` also adds a match on a route parameter, but in this case it considers the `id` route parameter and checks whether the matched id in the application route is a descendant of a given Location id.

The default structure of the Navigation Hub is defined in the <a href="https://github.com/ezsystems/PlatformUIBundle/blob/master/Resources/public/js/views/services/ez-navigationhubviewservice.js#L377">Navigation Hub view service attributes</a>.

## Adding a new navigation item

### Plugin for the Navigation Hub view service

Since the menu structure is defined in the Navigation Hub view service, we need to write a plugin for the Navigation Hub view service. Again, we'll create a module that will define a plugin. So the first thing to do is to declare our new module in `yui.yml`:

**yui.yml**

``` brush:
ezconf-navigationplugin:
    requires: ['ez-pluginregistry', 'ez-viewservicebaseplugin'] # ez-viewservicebaseplugin instead of plugin, base for plugins for view services
    dependencyOf: ['ez-navigationhubviewservice']
    path: %extending_platformui.public_dir%/js/views/services/plugins/ezconf-navigationplugin.js
```

View service plugins are a bit special, they need to follow a specific interface provided by `Y.eZ.Plugin.ViewServiceBase` which is defined in the `ez-viewservicebaseplugin` module, so our module needs to require it.

Then, the base plugin can be written on disk. It is very close to the base plugin written in the [Alter the JavaScript Application routing step](Alter-the-JavaScript-Application-routing_31430241.html):

**ezconf-navigationplugin.js**

``` brush:
YUI.add('ezconf-navigationplugin', function (Y) {
    Y.namespace('eZConf.Plugin');

    // view service plugins must extend Y.eZ.Plugin.ViewServiceBase
    // Y.eZ.Plugin.ViewServiceBase provides several method allowing to deeply
    // hook into the view service behaviour
    Y.eZConf.Plugin.NavigationPlugin = Y.Base.create('ezconfNavigationPlugin', Y.eZ.Plugin.ViewServiceBase, [], {
        initializer: function () {
            var service = this.get('host'); // the plugged object is called host

            console.log("Hey, I'm a plugin for NavigationHubViewService");
            console.log("And I'm plugged in ", service);
        },
    }, {
        NS: 'ezconfNavigation'
    });

    Y.eZ.PluginRegistry.registerPlugin(
        Y.eZConf.Plugin.NavigationPlugin, ['navigationHubViewService']
    );
});
```

At this point, if you refresh you browser, the navigation hub should remain the same but you should see new messages in the console.

### Adding a new navigation item

Now that we have plugin plugged in the Navigation Hub View service, we can change the menu structure. Among others methods, the Navigation Hub view service has an <a href="http://ezsystems.github.io/platformui-javascript-api/classes/eZ.NavigationHubViewService.html#method_addNavigationItem"><code>addNavigationItem</code> method</a> to add a navigation item in a given zone, so we can use it in our plugin to add a new item:

**ezconf-navigationplugin.js**

``` brush:
YUI.add('ezconf-navigationplugin', function (Y) {
    Y.namespace('eZConf.Plugin');

    Y.eZConf.Plugin.NavigationPlugin = Y.Base.create('ezconfNavigationPlugin', Y.eZ.Plugin.ViewServiceBase, [], {
        initializer: function () {
            var service = this.get('host');

            console.log("Hey, I'm a plugin for NavigationHubViewService");
            console.log("And I'm plugged in ", service);

            console.log("Let's add the navigation item in the Content zone");
            service.addNavigationItem({
                Constructor: Y.eZ.NavigationItemView,
                config: {
                    title: "List contents",
                    identifier: "ezconf-list-contents",
                    route: {
                        name: "eZConfList" // same route name of the one added in the app plugin
                    }
                }
            }, 'platform'); // identifier of the zone called "Content" in the UI
        },
    }, {
        NS: 'ezconfNavigation'
    });

    Y.eZ.PluginRegistry.registerPlugin(
        Y.eZConf.Plugin.NavigationPlugin, ['navigationHubViewService']
    );
});
```

At this point, if you refresh you browser, you should see a new entry in the *Content* zone called *List contents*. Clicking on this link should even get you to the page defined [in the previous step](Define-a-View_31430243.html). And you can also notice that the navigation item gets a special style (a green bottom border) when the `eZConfList` route is matched and that it loses this style if you navigate elsewhere.

Results and next step:

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
The resulting code can be seen in <a href="https://github.com/ezsystems/ExtendingPlatformUIConferenceBundle/releases/tag/5_navigation">the 5_navigation tag on GitHub</a>, this step result can also be viewed as <a href="https://github.com/ezsystems/ExtendingPlatformUIConferenceBundle/compare/4_view...5_navigation">a diff between tags <code>4_view</code> and <code>5_navigation</code></a>.

The next step is then [to build and display the content list](Build-the-content-list_31430249.html).

**Tutorial path**






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>

 Developer : Content Rendering 



# Introduction

## The ViewController

eZ Platform comes with a native controller to display your content, known as the **`ViewController`** . It is called each time you try to reach a Content item from its **Url Alias** (human readable, translatable URI generated for any content based on URL patterns defined per Content Type). It is able to render any content created in the admin interface or via the [Public API Guide](Public-API-Guide_31430303.html).

It can also be called straight by its direct URI: 

`/view/content/<contentId>/full/true/<locationId>`

` /view/content/<contentId>`

A Content item can also have different **view types** (full page, abstract in a list, block in a landing page, etc.). By default the view type is **full** (for full page), but it can be anything (*line*, *block, etc*.).

# Configuration

## View provider configuration

The **configured ViewProvider** allows you to configure template selection when using the `ViewController`, either directly from a URL or via a sub-request.

eZ Publish 4.x terminology

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
In eZ Publish 4.x, it was known as **template override system *by configuration*** (`override.ini`).
However this only reflects old overrides for `node/view/*.tpl` and `content/view/*.tpl`.

### Principle

The **configured ViewProvider** takes its configuration from your siteaccess in the `           content_view         ` <span> section</span>. This configuration is a hash built in the following way:

**app/config/ezplatform.yml**

``` brush:
ezpublish:
    system:
        # Can be a valid siteaccess, siteaccess group or even "global"
        front_siteaccess:
            # Configuring the ViewProvider
            content_view:
                # The view type (full/line are standard, but you can use custom ones)
                full:
                    # A simple unique key for your matching ruleset
                    folderRuleset:
                        # The template identifier to load, following the Symfony bundle notation for templates
                        # See http://symfony.com/doc/current/book/controller.html#rendering-templates
                        template: eZDemoBundle:full:small_folder.html.twig
                        # Hash of matchers to use, with their corresponding values to match against
                        match:
                            # Key is the matcher "identifier" (class name or service identifier)
                            # Value will be passed to the matcher's setMatchingConfig() method.
                            Identifier\ContentType: [small_folder, folder]
```

Important note about template matching

<span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"></span>
**Template matching will NOT work if your content contains a Field Type that is not supported by the repository**. It can be the case when you are in the process of migrating from eZ Publish 4.x, where custom datatypes have been developed.

In this case the repository will throw an exception, which is caught in the `ViewController`, <span>and *if* you are using LegacyBridge it will end up doing a </span> [**<span class="confluence-link">fallback to legacy kernel</span>**](https://doc.ez.no/display/EZP/Legacy+template+fallback).

The list of Field Types supported out of the box [is available here](Field-Types-reference_31430495.html).

Tip

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
You can define your template selection rules in a different configuration file. <span class="confluence-link"> [Read the cookbook recipe to learn more about it](Importing-settings-from-a-bundle_31429803.html) </span>.

<span>You can also </span> <span class="confluence-link"> <span> <span class="confluence-link"> [use your own custom controller to render a content/location](#ContentRendering-Customcontrollers) </span> </span> </span> <span>.</span>

#### Deprecated `location_view         `

Until eZ Publish Platform 5.4, the main view action was `location_view`. This is deprecated since eZ Platform 15.12 (1.0). Only `content_view` should be used to view content, with a location as an option.

Existing `location_view` rules will be, *when possible*, converted transparently to `content_view`, with a deprecation notice. However, it is not possible to do so when the rule uses a custom controller.
In any case, `location_view` rules should be converted to `content_view` ones, as `location_view` will be removed in the next kernel major version.

## View Matchers

To be able to select the right templates for the right conditions, the view provider uses matcher objects which implement the `eZ\Publish\Core\MVC\Symfony\View\ContentViewProvider\Configured\Matcher` interface.

#### Matcher identifier

The matcher identifier can comply to 3 different formats:

1.  **Relative qualified class name** (e.g. `Identifier\ContentType`). This is the most common case and used for native matchers. It will then be relative to `eZ\Publish\Core\MVC\Symfony\Matcher\ContentBased`.
2.  **Full qualified class name** (e.g. `\Foo\Bar\MyMatcher`). This is a way to specify a **custom matcher** that doesn't need specific dependency injection. Please note that it **must** start with a `\`.
3.  **Service identifier**, as defined in Symfony service container. This is the way to specify a more **complex custom matcher** that has dependencies.

Injecting the Repository

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
If your matcher needs the repository, simply make it implement `eZ\Publish\Core\MVC\RepositoryAwareInterface` or extend the `eZ\Publish\Core\MVC\RepositoryAware` abstract class. The repository will then be correctly injected before matching.

#### Matcher value

The value associated with the matcher is being passed to its `setMatchingConfig()` method. It can be anything that is supported by the matcher.

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
Native matchers support both **scalar values** or **arrays of scalar values**. Passing an array amounts to applying a logical OR.

#### Combining matchers

It is possible to combine multiple matchers:

``` brush:
# ...
match:
    Identifier\ContentType: [small_folder, folder]
    Identifier\ParentContentType: frontpage
```

The example above can be translated as "Match any content whose **ContentType** identifier is ***small\_folder* OR *folder*** , **AND** having *frontpage* as **ParentContentType** identifier".

### <span id="ContentRendering-Available_matchers" class="confluence-anchor-link"></span>Available matchers

The following table presents all native matchers.

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th align="left">Identifier</th>
<th align="left">Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td align="left"><code>Id\Content</code></td>
<td align="left">Matches the ID number of the Content item.</td>
</tr>
<tr class="even">
<td align="left"><code>Id\ContentType</code></td>
<td align="left">Matches the ID number of the Content Type that the Content item is an instance of.</td>
</tr>
<tr class="odd">
<td align="left"><code>Id\ContentTypeGroup</code></td>
<td align="left"><span>Matches the ID number of the group containing the Content Type that the Content item is an instance of.<br />
</span></td>
</tr>
<tr class="even">
<td align="left"><code>Id\Location</code></td>
<td align="left">Matches the ID number of a Location.<br />
<em>In the case of a Content item, matched against the main location.</em></td>
</tr>
<tr class="odd">
<td align="left"><code>Id\ParentContentType</code></td>
<td align="left">Matches the ID number of the parent Content Type.<br />
<em>In the case of a Content item, matched against the main location.</em></td>
</tr>
<tr class="even">
<td align="left"><code>Id\ParentLocation</code></td>
<td align="left"><p>Matches the ID number of the parent Location.<br />
<em>In the case of a Content item, matched against the main location.</em></p></td>
</tr>
<tr class="odd">
<td align="left"><code>Id\Remote</code></td>
<td align="left">Matches the remoteId of either content or Location, depending on the object matched.</td>
</tr>
<tr class="even">
<td align="left"><code>Id\Section</code></td>
<td align="left">Matches the ID number of the Section that the Content item belongs to.</td>
</tr>
<tr class="odd">
<td align="left"><code>Id\State</code></td>
<td align="left"><em>Not supported yet.</em></td>
</tr>
<tr class="even">
<td align="left"><code>Identifier\ContentType</code></td>
<td align="left"><span>Matches the identifier of the Content Type that the Content item is an instance of.</span></td>
</tr>
<tr class="odd">
<td align="left"><code>Identifier\ParentContentType</code></td>
<td align="left"><p><span>Matches the identifier of the parent Content Type.<br />
<em>In the case of a Content item, matched against the main Location.</em> </span></p></td>
</tr>
<tr class="even">
<td align="left"><code>Identifier\Section</code></td>
<td align="left">Matches the identifier of the Section that the Content item belongs to.</td>
</tr>
<tr class="odd">
<td align="left"><code>Identifier\State</code></td>
<td align="left"><em>Not supported yet.</em></td>
</tr>
<tr class="even">
<td align="left"><code>Depth</code></td>
<td align="left"><span>Matches the depth of the Location. The depth of a top level Location is 1.</span></td>
</tr>
<tr class="odd">
<td align="left"><code>UrlAlias</code></td>
<td align="left"><p><span>Matches the virtual URL of the Location (i.e. <code>/My/Content-Uri</code>).</span></p>
<p><span> <strong>Important: Matches when the UrlAlias of the location starts with the value passed.</strong><br />
<em>Not supported for Content (aka content_view).</em> </span></p></td>
</tr>
</tbody>
</table>

## <span class="confluence-link">Default view templates</span>

<span class="confluence-link">Content view</span> uses default templates to render content unless custom view rules are used.

Those templates can be customized by means of container- and siteaccess-aware parameters.

### Overriding the default template for common view types

Templates for the most common view types (content/full, line, embed, or block) can be customized by setting one the `ezplatform.default.content_view_templates` variables:

| Controller                                              | ViewType | Parameter                                         | Default value                                           |
|---------------------------------------------------------|----------|---------------------------------------------------|---------------------------------------------------------|
| `ez_content:viewAction`                                 | `full`   | `ezplatform.default_view_templates.content.full`  | `"EzPublishCoreBundle:default:content/full.html.twig"`  |
| `                 ez_content:viewAction               ` | `line`   | `ezplatform.default_view_templates.content.line`  | `"EzPublishCoreBundle:default:content/line.html.twig"`  |
| `                 ez_content:viewAction               ` | `embed`  | `ezplatform.default_view_templates.content.embed` | `"EzPublishCoreBundle:default:content/embed.html.twig"` |
| `ez_page:viewAction`                                    | `n/a`    | `ezplatform.default_view_templates.block`         | `"EzPublishCoreBundle:default:block/block.html.twig"`   |

#### Example

Add this configuration to `app/config/config.yml` to use `app/Resources/content/view/full.html.twig` as the default template when viewing Content with the `full` view type:

``` brush:
parameters:
    ezplatform.default_view_templates.content.full: "content/view/full.html.twig"
```

### Customizing the default controller

The controller used to render content by default can also be changed. The `ezsettings.default.content_view_defaults` container parameter contains a hash that defines how content is rendered by default. It contains a set of classic <a href="https://github.com/ezsystems/ezpublish-kernel/blob/v6.0.0/eZ/Bundle/EzPublishCoreBundle/Resources/config/default_settings.yml#L21-L33">content view rules for the common view types</a>. This hash can be redefined to whatever suits your requirements, including custom controllers, or even matchers.

# Usage

## Content view templates

A content view template is like any other template, with several specific aspects.

### <span id="ContentRendering-Availablevariables" class="confluence-anchor-link"></span>Available variables

| Variable name                                    | Type                                                                                                                                                                                            | Description                                                                                                                                                                                                                   |
|--------------------------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **`location`**                                   | <a href="https://github.com/ezsystems/ezp-next/blob/master/eZ/Publish/Core/Repository/Values/Content/Location.php">eZ\Publish\Core\Repository\Values\Content\Location</a> | The Location object. Contains meta information on the content (<a href="https://github.com/ezsystems/ezp-next/blob/master/eZ/Publish/Core/Repository/Values/Content/ContentInfo.php">ContentInfo</a>)   
                                                                                                                                                                                                                                                      (only when accessing a Location)                                                                                                                                                                                               |
| `                 content               `        | <a href="https://github.com/ezsystems/ezp-next/blob/master/eZ/Publish/Core/Repository/Values/Content/Content.php">eZ\Publish\Core\Repository\Values\Content\Content</a>   | The Content item, containing all Fields and version information (<a href="https://github.com/ezsystems/ezp-next/blob/master/eZ/Publish/Core/Repository/Values/Content/VersionInfo.php">VersionInfo</a>) |
| `                 noLayout               `       | Boolean                                                                                                                                                                                         | If true, indicates if the Content item/Location is to be displayed without any pagelayout (i.e. AJAX, sub-requests, etc.).                                                                                                    
                                                                                                                                                                                                                                                      It's generally `false` when displaying a Content item in view type **full**.                                                                                                                                                   |
| `                 viewBaseLayout               ` | String                                                                                                                                                                                          | The base layout template to use when the view is requested to be generated outside of the pagelayout (when `noLayout` is true).                                                                                               |

### Template inheritance and sub-requests

Like any template, a content view template can use <a href="http://symfony.com/doc/current/book/templating.html#template-inheritance-and-layouts">template inheritance</a>. However keep in mind that your content may be also requested via <a href="http://symfony.com/doc/current/book/templating.html#embedding-controllers">sub-requests</a> (see below how to render [embedded content items](#ContentRendering-EmbeddingContentitems)), in which case you probably don't want the global layout to be used.

If you use different templates for embedded content views, this should not be a problem. If you'd rather use the same template, you can use an extra `noLayout` view parameter for the sub-request, and conditionally extend an empty pagelayout:

``` brush:
{% extends noLayout ? viewbaseLayout : "AcmeDemoBundle::pagelayout.html.twig" %}

{% block content %}
...
{% endblock %}
```

## Content and Location view providers

### View\\Manager & View\\Provider

The role of the `           (eZ\Publish\Core\MVC\Symfony\)View\Manager         ` is to select the right template for displaying a given Content item or Location. It aggregates objects called *Content and Location view providers* which respectively implement the `eZ\Publish\Core\MVC\Symfony\View\Provider\Content` and `eZ\Publish\Core\MVC\Symfony\View\Provider\Location` interfaces.

Each time a content item is to be displayed through the `Content\ViewController`, the `View\Manager` iterates over the registered Content or Location `View\Provider` objects and calls `getView` `()`.

#### Provided View\\Provider implementations

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th align="left">Name</th>
<th align="left">Usage</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td align="left"><code>                  View provider configuration                </code></td>
<td align="left"><p>Based on application configuration.<br />
Formerly known as <em>Template override system</em>.</p></td>
</tr>
<tr class="even">
<td align="left"><p><code>eZ\Publish\Core\MVC\Legacy\View\Provider\Content</code></p>
<p><code>eZ\Publish\Core\MVC\Legacy\View\Provider\Location</code></p></td>
<td align="left"><p>Forwards view selection to the legacy kernel by running the old content/view module.<br />
Pagelayout used is the one configured in <code>ezpublish_legacy.&lt;scope&gt;.view_default_layout</code>.<br />
For more details about the <code>&lt;scope&gt;</code> please refer to the <a href="https://doc.ez.no/display/DEVELOPER/SiteAccess#SiteAccess-Configuration">scope configuration</a> documentation.</p></td>
</tr>
</tbody>
</table>

### Custom View\\Provider

#### Difference between `View\Provider\Location` and `View\Provider\Content`

-   A `View\Provider\Location` only deals with `Location` objects and implements `eZ\Publish\Core\MVC\Symfony\View\Provider\Location` interface.
-   A `View\Provider\Content` only deals with `ContentInfo` objects and implements `eZ\Publish\Core\MVC\Symfony\View\Provider\Content` interface.

#### When to develop a custom `View\Provider\(Location|Content)`

-   You want a custom template selection based on a very specific state of your application
-   You depend on external resources for view selection
-   You want to override the default one (based on configuration) for some reason

`View\Provider` objects need to be properly registered in the service container with the `           ezpublish.location_view_provider         ` or `           ezpublish.content_view_provider         ` service tag.

``` brush:
parameters:
    acme.location_view_provider.class: Acme\DemoBundle\Content\MyLocationViewProvider

services:
    acme.location_view_provider:
        class: %ezdemo.location_view_provider.class%
        tags:
            - {name: ezpublish.location_view_provider, priority: 30}
```

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th align="left">Tag attribute name</th>
<th align="left">Usage</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td align="left">priority</td>
<td align="left"><p>An integer giving the priority to the <code>                   View\Provider\(Content|Location)                 </code> in the <code>View\Manager</code>.</p>
<p>The priority range is <strong>from -255 to 255</strong></p></td>
</tr>
</tbody>
</table>

#### Example

**Custom View\\Provider\\Location**

``` brush:
<?php

namespace Acme\DemoBundle\Content;

use eZ\Publish\Core\MVC\Symfony\View\ContentView;
use eZ\Publish\Core\MVC\Symfony\View\Provider\Location as LocationViewProvider;
use eZ\Publish\API\Repository\Values\Content\Location;

class MyLocationViewProvider implements LocationViewProvider
{
    /**
     * Returns a ContentView object corresponding to $location, or void if not applicable
     *
     * @param \eZ\Publish\API\Repository\Values\Content\Location $location
     * @param string $viewType
     * @return \eZ\Publish\Core\MVC\Symfony\View\ContentView|null
     */
    public function getView( Location $location, $viewType )
    {
        // Let's check location Id
        switch ( $location->id )
        {
            // Special template for home page, passing "foo" variable to the template
            case 2:
                return new ContentView( "AcmeDemoBundle:$viewType:home.html.twig", array( 'foo' => 'bar' ) );
        }
 
        // ContentType identifier (formerly "class identifier")
        switch ( $location->contentInfo->contentType->identifier )
        {
            // For view full, it will load AcmeDemoBundle:full:small_folder.html.twig
            case 'folder':
                return new ContentView( "AcmeDemoBundle:$viewType:small_folder.html.twig" );
        }
    }
}
```

## <span style="color: rgb(0,98,147);">Rendering Content items
</span>

### <span style="color: rgb(0,98,147);">Content item Fields</span>

As stated above, a view template receives the requested Content item, holding all Fields.

In order to display the Fields' value the way you want, you can either manipulate the Field Value object itself, or use a custom template.

#### Getting raw Field value

Having access to the Content item in the template, you can use <a href="https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/Repository/Values/Content/Content.php">its public methods</a> to access all the information you need. You can also use the **ez\_field\_value** helper to get the <span class="confluence-link"> [field's value only](Field-Types-reference_31430495.html)</span>. It will return the correct language if there are several, based on language priorities.

``` brush:
{# With the following, myFieldValue will be in the Content item's main language, regardless of the current language #}
{% set myFieldValue = content.getFieldValue( 'some_field_identifier' ) %}
 
{# Here myTranslatedFieldValue will be in the current language if a translation is available. If not, the Content item's main language will be used #}
{% set myTranslatedFieldValue = ez_field_value( content, 'some_field_identifier' ) %}
```

#### Using the Field Type's template block

All built-in Field Types come with <a href="https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Bundle/EzPublishCoreBundle/Resources/views/content_fields.html.twig">their own Twig template</a>. You can render any Field using this default template using the `ez_render_field()` helper.

``` brush:
{{ ez_render_field( content, 'some_field_identifier' ) }}
```

Refer to [<span class="confluence-link">ez\_render\_field</span>](#ContentRendering-ez_render_field)<span class="confluence-link"> </span> for further information.

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
As this makes use of reusable templates, **using `ez_render_field()` is the recommended way and is to be considered the best practice**.

### Content name

The **name** of a Content item is its generic "title", generated by the repository based on the Content Type's naming pattern. It often takes the form of a normalized value of the first field, but might be a concatenation of several fields. There are 2 different ways to access this special property:

-   Through the name property of ContentInfo (not translated).
-   Through VersionInfo with the TranslationHelper (translated).

#### Translated name

<span>The *translated name* is held in a `VersionInfo` object, in the names property which consists of hash indexed by locale. You can easily retrieve it in the right language via the `TranslationHelper` service.</span>

``` brush:
<h2>Translated content name: {{ ez_content_name( content ) }}</h2>
<h3>Also works from ContentInfo: {{ ez_content_name( content.contentInfo ) }}</h3>
```

The helper will by default follow the prioritized languages order. If there is no translation for your prioritized languages, the helper will always return the name in the main language.

You can also **force a locale** in a second argument:

``` brush:
{# Force fre-FR locale. #}
<h2>{{ ez_content_name( content, 'fre-FR' ) }}</h2>
```

#### Name property in ContentInfo

This property is the actual content name, but **in main language only** (so it is not translated).

``` brush:
<h2>Content name: {{ content.contentInfo.name }}</h2>
```

``` brush:
$contentName = $content->contentInfo->name;
```

#### <span>Exposing additional variables</span>

It is possible to expose additional variables in a content view template. See<span class="confluence-link"> [parameters injection in content views](Injecting-parameters-in-content-views_31430331.html)</span>.

## Embedding images

<span class="status-macro aui-lozenge aui-lozenge-current">V1.4</span>

The Rich Text Field allows you to embed other Content items within the Field.

Content items that are identified as images will be rendered in the Rich Text Field using a dedicated template.

You can determine which Content Types will be treated as images and rendered using this template in the `ezplatform.content_view.image_embed_content_types_identifiers` parameter. By default it is set to cover the Image Content Type, but you can add other types that you want to be treated as images, for example:

``` brush:
parameters:
    ezplatform.content_view.image_embed_content_types_identifiers: ['image', 'photo', 'banner']
```

The template used when rendering embedded images can be set in the `ezplatform.default_view_templates.content.embed_image` container parameter:

``` brush:
parameters:
    ezplatform.default_view_templates.content.embed_image: 'content/view/embed/image.html.twig
```

## Adding Links

### Links to other Locations

Linking to other locations is fairly easy and is done with a <a href="http://symfony.com/doc/2.3/book/templating.html#linking-to-pages">native <code>path()</code> Twig helper</a> (or `url()` if you want to generate absolute URLs). You just have to pass it the Location object and `path()` will generate the URLAlias for you.

``` brush:
{# Assuming "location" variable is a valid eZ\Publish\API\Repository\Values\Content\Location object #}
<a href="{{ path( location ) }}">Some link to a location</a>
```

If you don't have the Location object, but only its ID, you can generate the URLAlias the following way:

``` brush:
<a href="{{ path( "ez_urlalias", {"locationId": 123} ) }}">Some link to a location, with its Id only</a>
```

You can also use the Content ID. In that case the generated link will point to the Content item's main Location.

``` brush:
<a href="{{ path( "ez_urlalias", {"contentId": 456} ) }}">Some link from a contentId</a>
```

Under the hood

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
In the backend, `path()` uses the Router to generate links.

This makes it also easy to generate links from PHP, via the `router` service.

See also: [Cross-siteaccess links](https://doc.ez.no/display/DEVELOPER/SiteAccess#SiteAccess-Cross-siteacesslinks)

## Embedding Content items

Rendering an embedded content from a Twig template is pretty straightforward as you just need to **do a subrequest with `ez_content` controller**.

### Using `ez_content` controller

This controller is exactly the same as [the ViewController presented above](#ContentRendering-TheViewController). It has one main `viewAction`, that renders a Content item.

You can use this controller from templates with the following syntax:

``` brush:
{{ render(controller("ez_content:viewAction", {"contentId": 123, "viewType": "line"})) }}
```

The example above renders the Content item whose ID is **123** with the view type **line**.

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
Reference of `ez_content` controller follows the syntax of *controllers as a service*, <a href="http://symfony.com/doc/current/cookbook/controller/service.html">as explained in Symfony documentation</a>.

#### Available arguments

As with any controller, you can pass arguments to `ez_content:viewLocation` or `ez_content:viewContent` to fit your needs.

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th align="left">Name</th>
<th align="left">Description</th>
<th align="left">Type</th>
<th align="left">Default value</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td align="left"><code>contentId</code></td>
<td align="left"><p>ID of the Content item you want to render.<br />
<strong>Only for <code>ez_content:viewContent</code></strong>  </p></td>
<td align="left">integer</td>
<td align="left">N/A</td>
</tr>
<tr class="even">
<td align="left"><code>locationId</code></td>
<td align="left">ID of the Location you want to render.<br />
<strong>Only for <code>ez_content:viewLocation</code></strong>  </td>
<td align="left">integer</td>
<td align="left">Content item's main location, if defined</td>
</tr>
<tr class="odd">
<td align="left"><code>viewType</code></td>
<td align="left"><p>The view type you want to render your Content item/Location in.<br />
Will be used by the ViewManager to select a corresponding template, according to defined rules. </p>
<p>Example: full, line, my_custom_view, etc.</p></td>
<td align="left">string</td>
<td align="left">full</td>
</tr>
<tr class="even">
<td align="left"><code>layout</code></td>
<td align="left"><p>Indicates if the sub-view needs to use the main layout (see<span class="confluence-link"> </span> <a href="#ContentRendering-Availablevariables"><span class="confluence-link">available variables in a view template</span></a>)</p>
<p> </p></td>
<td align="left">boolean</td>
<td align="left">false</td>
</tr>
<tr class="odd">
<td align="left"><code>params</code></td>
<td align="left"><p>Hash of variables you want to inject to sub-template, key being the exposed variable name.</p>
<div class="code panel pdl" style="border-width: 1px;">
<div class="codeContent panelContent pdl">
<pre class="brush: php; gutter: false; theme: Eclipse" style="font-size:12px;"><code>{{ render(
      controller( 
          &quot;ez_content:viewAction&quot;, 
          {
              &quot;contentId&quot;: 123,
              &quot;viewType&quot;: &quot;line&quot;,
              &quot;params&quot;: { &quot;some_variable&quot;: &quot;some_value&quot; }
          }
      )
) }}</code></pre>
</div>
</div></td>
<td align="left">hash</td>
<td align="left">empty hash</td>
</tr>
</tbody>
</table>

## <span class="js-issue-title">Rendering blocks</span>

You can specify which controller will be called for a specific block view match, much like defining custom controllers for location view or content view match.

Also, since there are two possible actions with which one can view a block: `ez_page:viewBlock` and `ez_page:viewBlockById`, it is possible to specify a controller action with a signature matching either one of the original actions.

Example of configuration in `app/config/ezplatform.yml`:

``` brush:
ezpublish:
    system:
        eng_frontend_group:
            block_view:
                ContentGrid:
                    template: NetgenSiteBundle:block:content_grid.html.twig
                    controller: NetgenSiteBundle:Block:viewContentGridBlock
                    match:
                        Type: ContentGrid
```

## Binary and Media download

Unlike image files, files stored in BinaryFile or Media Fields may be limited to certain User Roles. As such, they are not publicly downloadable from disk, and are instead served by Symfony, using a custom route that runs the necessary checks. This route is automatically generated as the `url` property for those Fields values.

### The content/download route

The route follows this pattern: `/content/download/{contentId}/{fieldIdentifier}/{filename}`. Example: `/content/download/68/file/My-file.pdf.`

It also accepts optional query parameters:

-   `version`: <span>the version number that the file must be downloaded for. Requires the versionview permission. If not specified, the published version is used.</span>
-   `inLanguage`: <span>The language the file should be downloaded in. If not specified, the most prioritized language for the siteaccess will be used.</span>

The [<span class="confluence-link">ez\_render\_field</span>](#ContentRendering-ez_render_field) <span class="confluence-link"> </span>twig helper will by default generate a working link.

#### REST API: The `uri` property contains a valid download URL

The `uri` property of Binary Fields in REST contain a valid URL, of the same format as the Public API, prefixed with the same host as the REST Request.

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
For [<span class="confluence-link">more information about REST API</span> see the documentation](REST-API-Guide_31430286.html).

## []()Custom controllers

In some cases, displaying a Content item/Location via the built-in `ViewController` is not sufficient to show everything you want. In such cases you may want to **use your own custom controller** to display the current Content item/Location instead.

Typical use cases include access to:

-   Settings (coming from `ConfigResolver` or `ServiceContainer`)
-   Current Content item's `ContentType` object
-   Current Location's parent
-   Current Location's children count
-   Main Location and alternative Locations for the current Content item
-   etc.

There are three ways in which you can apply a custom controller:

-   Configure a custom controller alongside regular matcher rules to use **both** your custom controller and the `ViewController` (recommended).
-   **Override** the built-in `ViewController` with the custom controller in a specific situation.
-   **Replace** the `ViewController` with the custom controller for the whole bundle.

### Enriching ViewController with a custom controller

**This is the recommended way of using a custom controller**

To use your custom controller on top of the built-in `ViewController` you need to point to both the controller and the template in the configuration, for example:

**ezplatform.yml**

``` brush:
ezpublish:
    system:
        default:
            content_view:
                full:
                    article:
                        controller: AcmeTestBundle:Default:articleViewEnhanced
                        template: AcmeTestBundle:full:article.html.twig
                        match:
                            Identifier\ContentType: [article]
```

With this configuration, the following controller will forward the request to the built-in `ViewController` with some additional parameters:

**Controller**

``` brush:
<?php

namespace Acme\TestBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use eZ\Bundle\EzPublishCoreBundle\Controller;

class DefaultController extends Controller
{
    public function articleViewEnhancedAction( $locationId, $viewType, $layout = false, array $params = array() )
    {
        // Add custom parameters to existing ones.
        $params += array( 'myCustomVariable' => "Hey, I'm a custom message!" );
        // Forward the request to the original ViewController
        // And get the response. Possibly alter it (here we change the smax-age for cache).
        $response = $this->get( 'ez_content' )->viewLocation( $locationId, $viewType, $layout, $params );
        $response->setSharedMaxAge( 600 );

        return $response;
    }
}
```

Always ensure that you add new parameters to existing `$params` associative array using <a href="http://php.net/manual/en/language.operators.array.php"><strong><code>+</code></strong> union operator</a> or `array_merge()`. **Not doing so (e.g. only passing your custom parameters array) can result in unexpected issues with content preview**. Previewed content and other parameters are indeed passed in `$params`.

These parameters can then be used in templates, for example:

**article.html.twig**

``` brush:
{% extends noLayout ? viewbaseLayout : "eZDemoBundle::pagelayout.html.twig" %}

{% block content %}
    <h1>{{ ez_render_field( content, 'title' ) }}</h1>
    <h2>{{ myCustomVariable }}</h2>
    {{ ez_render_field( content, 'body' ) }}
{% endblock %}
```

### Using only your custom controller

If you want to apply only your custom controller in a given match situation and not use the `ViewController` at all, in the configuration you need to indicate the controller, but no template, for example:

**ezplatform.yml**

``` brush:
ezpublish:
    system:
        default:
            content_view:
                full:
                    folder:
                        controller: AcmeTestBundle:Default:viewFolder
                        match:
                            Identifier\ContentType: [folder]
                            Identifier\Section: [standard]
```

In this example, as the `ViewController` is not applied, the custom controller takes care of the whole process of displaying content, including pointing to the template to be used (in this case, `AcmeTestBundle::custom_controller_folder.html.twig`):

**Controller**

``` brush:
<?php

namespace Acme\TestBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use eZ\Bundle\EzPublishCoreBundle\Controller;

class DefaultController extends Controller
{
    public function viewFolderAction( $locationId, $layout = false, $params = array() )
    {
        $repository = $this->getRepository();
        $location = $repository->getLocationService()->loadLocation( $locationId );
        // Check if content is not already passed. Can be the case when using content preview.
        $content = isset( $params['content'] ) ? $params['content'] : $repository->getContentService()->loadContentByContentInfo( $location->getContentInfo() )
        $response = new Response();
        $response->headers->set( 'X-Location-Id', $locationId );
        // Caching for 1h and make the cache vary on user hash
        $response->setSharedMaxAge( 3600 );
        $response->setVary( 'X-User-Hash' );
        return $this->render(
            'AcmeTestBundle::custom_controller_folder.html.twig',
            array(
                'location' => $location,
                'content' => $content,
                'foo' => 'Hey world!!!',
                'osTypes' => array( 'osx', 'linux', 'windows' )
            ) + $params
        );
    }
}
```

Here again custom parameters can be used in the template, e.g.:

**custom\_controller\_folder.html.twig**

``` brush:
{% extends "eZDemoBundle::pagelayout.html.twig" %}

{% block content %}
<h1>{{ ez_render_field( content, 'title' ) }}</h1>
    <h1>{{ foo }}</h1>
    <ul>
    {% for os in osTypes %}
        <li>{{ os }}</li>
    {% endfor %}
    </ul>
{% endblock %}
```

### Overriding the built-in ViewController

One other way to keep control of what is passed to the view is to use your own controller instead of the built-in `ViewController`. As base `ViewController` is defined as a service, with a service alias, this can be easily achieved from your bundle's configuration:

``` brush:
parameters:
    my.custom.view_controller.class: Acme\TestBundle\MyViewController

services:
    my.custom.view_controller:
        class: %my.custom.view_controller.class%
        arguments: [@some_dependency, @other_dependency]

    # Change the alias here and make it point to your own controller
    ez_content:
        alias: my.custom.view_controller
```

<span class="aui-icon aui-icon-small aui-iconfont-error confluence-information-macro-icon"></span>
Doing so will completely override the built-in `ViewController`! Use this at your own risk!

### Custom controller structure

Your custom controller can be any kind of <a href="http://symfony.com/doc/current/book/page_creation.html#step-2-create-the-controller">controller supported by Symfony</a> (including <a href="http://symfony.com/doc/current/cookbook/controller/service.html">controllers as a service</a>).

The only requirement here is that your action method must have a similar signature to `ViewController::viewLocation()` or `ViewController::viewContent()` (depending on what you're matching of course). However, note that not all arguments are mandatory, since <a href="http://symfony.com/doc/current/book/routing.html#route-parameters-and-controller-arguments">Symfony is clever enough to know what to inject into your action method</a>. That is why **you aren't forced to mimic the `ViewController`'s signature strictly**. For example, if you omit `$layout` and `$params` arguments, it will still be valid. Symfony will just avoid injecting them into your action method.

#### Built-in ViewController signatures

**viewLocation() signature**

``` brush:
/**
 * Main action for viewing content through a location in the repository.
 *
 * @param int $locationId
 * @param string $viewType
 * @param boolean $layout
 * @param array $params
 *
 * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
 * @throws \Exception
 *
 * @return \Symfony\Component\HttpFoundation\Response
 */
public function viewLocation( $locationId, $viewType, $layout = false, array $params = array() )
```

**viewContent() signature**

``` brush:
/**
 * Main action for viewing content.
 *
 * @param int $contentId
 * @param string $viewType
 * @param boolean $layout
 * @param array $params
 *
 * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
 * @throws \Exception
 *
 * @return \Symfony\Component\HttpFoundation\Response
 */
public function viewContent( $contentId, $viewType, $layout = false, array $params = array() )
```

<span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"></span>
Controller selection doesn't apply to `block_view` since you can already [use your own controller to display blocks](https://doc.ez.no/display/DEVELOPER/Content+Rendering#ContentRendering-Renderingblocks).

Caching

<span class="aui-icon aui-icon-small aui-iconfont-error confluence-information-macro-icon"></span>
When you use your own controller, **it is your responsibility to define cache rules**, like with every custom controller!

So don't forget to **set cache rules** and the appropriate **`X-Location-Id` header** in the returned `Response` object.

<a href="https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/MVC/Symfony/Controller/Content/ViewController.php#L76">See built-in ViewController</a> for more details on this.

## Query controller

<span class="status-macro aui-lozenge aui-lozenge-current">V1.4</span>

The Query controller is a predefined custom content view controller that runs a Repository Query.

It is meant to be used as a custom controller in a view configuration, along with match rules. It can use properties of the viewed Content item or Location as parameters to the Query. It makes it easy to retrieve content without writing custom PHP code and display the results in a template.

### Use-case examples

-   List of Blog posts in a Blog
-   List of Images in a Gallery

### Usage example

We will take the blog posts use case mentioned above as an example. It assumes a "Blog" container that contains a set of "Blog post" items. The goal is, when viewing a Blog, to list the Blog posts it contains.

Three items are required:

-   a `LocationChildren` QueryType - It will generate a Query retrieving the children of a given location id
-   a View template - It will render the Blog, and list the Blog posts it contains
-   a `content_view` configuration - It will instruct Platform, when viewing a Content item of type Blog, to use the Query Controller, the view template, and the `LocationChildren` QueryType. It will also map the id of the viewed Blog to the QueryType parameters, and set which twig variable the results will be assigned to.

#### The LocationChildren QueryType

QueryTypes are described in more detail in the [next section](#ContentRendering-QueryTypesobjects). In short, a QueryType can build a Query object, optionally based on a set of parameters. The following example will build a Query that retrieves the sub-items of a Location:

**src/AppBundle/QueryType/LocationChildrenQueryType.php**

``` brush:
<?php
namespace AppBundle\QueryType;

use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\ParentLocationId;
use eZ\Publish\Core\QueryType\QueryType;

class LocationChildrenQueryType implements QueryType
{
    public function getQuery(array $parameters = [])
    {
        return new LocationQuery([
            'filter' => new ParentLocationId($parameters['parentLocationId']),
        ]);
    }

    public function getSupportedParameters()
    {
        return ['parentLocationId'];
    }

    public static function getName()
    {
        return 'LocationChildren';
    }
}
```

Any class will be registered as a QueryType when it:

-   implements the QueryType interface,
-   is located in the QueryType subfolder of a bundle, and in a file named "SomethingQueryType.php"

If the QueryType has dependencies, it can be manually tagged as a service using the `ezpublish.query_type` service tag, but it is not required in that case.

#### The content\_view configuration

We now need a view configuration that matches content items of type "Blog", and uses the QueryController to fetch the blog posts:

**app/config/ezplatform.yml**

``` brush:
ezpublish:
      system:
            site_group:
                content_view:
                    full:
                        blog:
                            controller: "ez_query:locationQueryAction"
                            template: "content/view/full/blog.html.twig"
                            match:
                                Identifier\ContentType: "blog"
                            params:
                                query:
                                    query_type: 'LocationChildren'
                                    parameters:
                                        parentLocationId: "@=location.id"
                                    assign_results_to: 'blog_posts'
```

The view's controller action is set to the QueryController's `locationQuery` action (`ez_query:locationQueryAction`). Other actions are available that run a different type of search (contentInfo or content).

The QueryController is configured in the `query` array, inside the `params` of the content\_view block:

-   `query_type` specifies the QueryType to use, based on its name.
-   `parameters` is a hash where parameters from the QueryType are set. Arbitrary values can be used, as well as properties from the currently viewed location and content. In that case, the id of the currently viewed location is mapped to the QueryType's `parentLocationId` parameter: `             parentLocationId: "@=location.id"           `
-   <span> `assign_results_to` sets which twig variable the search results will be assigned to.</span>

#### <span>The view template</span>

<span>Results from the search are assigned to the `blog_posts` variable as a `SearchResult` object. In addition, since the usual view controller is used, the currently viewed `location` and `content` are also available.</span>

**app/Resources/views/content/full/blog.html.twig**

``` brush:
<h1>{{ ez_content_name(content) }}</h1>
 
{% for blog_post in blog_posts.searchHits %}
  <h2>{{ ez_content_name(blog_post.valueObject.contentInfo) }}</h2>
{% endfor %} 
```

### Configuration details

#### `controller`

Three Controller Actions are available, each for a different type of search:

-   `locationQueryAction` runs a Location Search
-   `contentQueryAction` runs a Content Search
-   `contentInfoQueryAction` runs a Content Info search

 

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
See [Search](Search_31429673.html) documentation page for more details about different types of search

#### `params`

The Query is configured in a `query` hash in `params`, you could specify the QueryType name, additional parameters and the Twig variable that you will assign the results to for use in the template.

-   #### `query_type`

    -   Name of the Query Type that will be used to run the query, defined by the class name.

-   #### `parameters`

    -   Query Type parameters that can be provided in two ways:

    1.  As scalar values, for example an identifier, an id, etc.
    2.  Using the Expression language. This simple script language, similar to Twig syntax, lets you write expressions that get value from the current content and/or location:

    -   -   For example, `@=location.id                   ` will be evaluated to the currently viewed location's ID.`                     content`, `location` and `view` are available as variables in expressions.

-   #### `assign_results_to`

    -   This is the name of the Twig variable that will be assigned the results.
    -   Note that the results are the SearchResult object returned by the SearchService.

### <span>Query Types objects</span>

QueryTypes are objects that build a Query. They are different from [Public API queries](https://doc.ez.no/display/DEVELOPER/Public+API+Guide).

To make a new QueryType available to the Query Controller, you need to create a PHP class that implements the QueryType interface, then register it as such in the Service Container.

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
For more information about the [Service Container](Service-Container_31432100.html), read the page

### <span class="anchor">The QueryType interface</span>

There you can view the PHP QueryType interface. Three methods are described:

1.  `getQuery()`
2.  `getSupportedParameters()`
3.  `getName()`

**** <span class="collapse-source expand-control"><span class="expand-control-icon icon"> </span><span class="expand-control-text">Expand source</span></span>

``` brush:
interface QueryType
{
 /**
 * Builds and returns the Query object
 *
 * The Query can be either a Content or a Location one.
 *
 * @param array $parameters A hash of parameters that will be used to build the Query
 * @return \eZ\Publish\API\Repository\Values\Content\Query
 */
 public function getQuery(array $parameters = []);
 
 /**
 * Returns an array listing the parameters supported by the QueryType
 * @return array
 */
 public function getSupportedParameters();
 
 /**
 * Returns the QueryType name
 * @return string
 */
 public static function getName();
}
```

#### Parameters

A QueryType may accept parameters, including string, arrays and other types, depending on the implementation. They can be used in any way, such as:

-   customizing an element's value (limit, ContentType identifier, etc)
-   conditionally adding/removing criteria from the query
-   setting the limit/offset

The implementations should use Symfony's `OptionsResolver` for parameters handling and resolution.

### <span class="anchor">QueryType example: latest content</span>

Let's see an example for QueryType creation.

This QueryType returns a Query that searches for **the 10 last published Content items, order by reverse publishing date**.
It accepts an optional `type` parameter, that can be set to a ContentType identifier:

 

``` brush:
<?php
namespace AppBundle\QueryType;
use eZ\Publish\Core\QueryType\QueryType;
use eZ\Publish\API\Repository\Values\Content\Query;
class LatestContentQueryType implements QueryType
{
    public function getQuery(array $parameters = [])
    {
        $criteria[] = new Query\Criterion\Visibility(Query\Criterion\Visibility::VISIBLE);
        if (isset($parameters['type'])) {
            $criteria[] = new Query\Criterion\ContentTypeIdentifier($parameters['type']);
        }
        // 10 is the default limit we set, but you can have one defined in the parameters
        return new Query([
            'filter' => new Query\Criterion\LogicalAnd($criteria),
            'sortClauses' => [new Query\SortClause\DatePublished()],
            'limit' => isset($parameters['limit']) ? $parameters['limit'] : 10,
        ]);
    }
    public static function getName()
    {
        return 'AppBundle:LatestContent';
    }
    /**
     * Returns an array listing the parameters supported by the QueryType.
     * @return array
     */
    public function getSupportedParameters()
    {
        return ['type', 'limit'];
    }
}
```

### <span class="anchor">Naming of QueryTypes</span>

Each QueryType is named after what is returned by `getName()`. **Names must be unique.** A warning will be thrown during compilation if there is a conflict, and the resulting behavior will be unpredictable.

QueryType names should use a unique namespace, in order to avoid conflicts with other bundles. We recommend that the name is prefixed with the bundle's name: `AcmeBundle:LatestContent`. A vendor/company's name could also work for QueryTypes that are reusable throughout projects: `Acme:LatestContent`.

### <span class="anchor">Registering the QueryType into the service container</span>

In addition to creating a class for a `QueryType`, you must also register the QueryType with the Service Container. This can be done in two ways: by convention, and with a service tag.

#### <span class="anchor">By convention</span>

Any class named `<Bundle>\QueryType\*QueryType`, that implements the QueryType interface, will be registered as a custom QueryType.
Example: `AppBundle\QueryType\LatestContentQueryType`.

#### <span class="anchor">Using a service tag</span>

If the proposed convention doesn't work for you, QueryTypes can be manually tagged in the service declaration:

``` brush:
acme.query.latest_content:
    class: AppBundle\Query\LatestContent
    tags:
        - {name: ezpublish.query_type}
```

The effect is exactly the same as registering by convention.

More content...

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
Follow the FieldType creation Tutorial and learn how to [Register the Field Type as a service](Register-the-Field-Type-as-a-service_31429774.html)

### <span class="anchor">The OptionsResolverBasedQueryType abstract class</span>

An abstract class based on Symfony's `OptionsResolver` eases implementation of QueryTypes with parameters.

It provides final implementations of `getQuery()` and `getDefinedParameters()`.

A `doGetQuery()` method must be implemented instead of `getQuery()`. It is called with the parameters processed by the OptionsResolver, meaning that the values have been validated, and default values have been set.

In addition, the `configureOptions(OptionsResolver $resolver)` method must configure the OptionsResolver.

The LatestContentQueryType can benefit from the abstract implementation:

-   validate that `type` is a string, but make it optional
-   validate that `limit` is an int, with a default value of 10

 

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
For further information see the <a href="http://symfony.com/doc/current/components/options_resolver.html">Symfony's Options Resolver documentation page</a>

``` brush:
<?php
namespace AppBundle\QueryType;
use eZ\Publish\API\Repository\Values\Content\Query;
use Symfony\Component\OptionsResolver\OptionsResolver;
class OptionsBasedLatestContentQueryType extends OptionsResolverBasedQueryType implements QueryType
{
    protected function doGetQuery(array $parameters)
    {
        $criteria[] = new Query\Criterion\Visibility(Query\Criterion\Visibility::VISIBLE);
        if (isset($parameters['type'])) {
            $criteria[] = new Query\Criterion\ContentTypeIdentifier($parameters['type']);
        }
        return new Query([
            'criterion' => new Query\Criterion\LogicalAnd($criteria),
            'sortClauses' => [new Query\SortClause\DatePublished()],
            'limit' => $parameters,
        ]);
    }
    public static function getName()
    {
        return 'AppBundle:LatestContent';
    }
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setAllowedTypes('type', 'string');
        $resolver->setAllowedValues('limit', 'int');
        $resolver->setDefault('limit', 10);
    }
}
```

### <span class="anchor">Using QueryTypes from PHP code</span>

All QueryTypes are registered in a registry, the QueryType registry.

It is available from the container as `ezpublish.query_type.registry`

``` brush:
<?php
class MyCommand extends ContainerAwareCommand
{
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $queryType     = $this->getContainer()->get('ezpublish.query_type.registry')->getQueryType('AcmeBundle:LatestContent');
        $query         = $queryType->getQuery(['type' => 'article']);
        $searchResults = $this->getContainer()->get('ezpublish.api.service.search')->findContent($query);
        foreach ($searchResults->searchHits as $searchHit) {
            $output->writeln($searchHit->valueObject->contentInfo->name);
        }
    }
}
```

## ESI

Just like for regular Symfony controllers, you can take advantage of ESI and use different cache levels:

**Using ESI**

``` brush:
{{ render_esi(controller("ez_content:viewAction", {"contentId": 123, "viewType": "line"})) }}
```

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
Only scalable variables can be sent via render\_esi (not object)

## Asynchronous rendering

Symfony also supports asynchronous content rendering with the help of <a href="http://mnot.github.com/hinclude/">hinclude.js</a> library.

**Asynchronous rendering**

``` brush:
{{ render_hinclude(controller("ez_content:viewAction", {"contentId": 123, "viewType": "line"})) }}
```

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
Only scalable variables can be sent via render\_hinclude (not object)

### Display a default text

If you want to display a default text while a controller is loaded asynchronously, you have to pass a second parameter to your render\_hinclude twig function.

**Display a default text during asynchronous loading of a controller**

``` brush:
{{ render_hinclude(controller('EzCorporateDesignBundle:Header:userLinks'), {'default': "<div style='color:red'>loading</div>"}) }}
```

See also: [Custom controllers](#ContentRendering-Customcontrollers)

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
<a href="http://mnot.github.com/hinclude/">hinclude.js</a> needs to be properly included in your layout to work.

Please <a href="http://symfony.com/doc/current/book/templating.html#asynchronous-content-with-hinclude-js">refer to Symfony documentation</a> for all available options.

# Reference

Symfony & Twig template functions/filters/tags

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
For template functionality provided by Symfony Framework, see <a href="http://symfony.com/doc/current/reference/twig_reference.html">Symfony Twig Extensions Reference page</a>. For those provided by the underlying Twig template engine, see <a href="http://twig.sensiolabs.org/documentation#reference">Twig Reference page</a>

## Twig functions reference

See [Twig Functions Reference](Twig-Functions-Reference_32114025.html) for detailed information on all available Twig functions.

# Extensibility

## Events

### Introduction

This section presents the events that are triggered by eZ Platform.

### eZ Publish Core

<table>
<colgroup>
<col width="33%" />
<col width="33%" />
<col width="33%" />
</colgroup>
<thead>
<tr class="header">
<th align="left">Event name</th>
<th align="left">Triggered when...</th>
<th align="left">Usage</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td align="left"><strong><code>ezpublish.siteaccess</code></strong></td>
<td align="left">After the SiteAccess matching has occurred.</td>
<td align="left"><p>Gives further control on the matched SiteAccess.</p>
<p>The event listener method receives an <code>eZ\Publish\Core\MVC\Symfony\Event\PostSiteAccessMatchEvent</code> object.</p></td>
</tr>
<tr class="even">
<td align="left"><strong><code>ezpublish.pre_content_view</code></strong></td>
<td align="left">Right before a view is rendered for a Content item, via the content view controller.</td>
<td align="left"><p>This event is triggered by the view manager and allows you to inject additional parameters to the content view template.</p>
The event listener method receives an <code>eZ\Publish\Core\MVC\Symfony\Event\PreContentViewEvent </code>object.
<p> </p></td>
</tr>
<tr class="odd">
<td align="left"><code>                 ezpublish.api.contentException               </code></td>
<td align="left">The API throws an exception that could not be caught internally (missing field type, internal error...).</td>
<td align="left"><p>This event allows further programmatic handling (like rendering a custom view) for the exception thrown.</p>
<p>The event listener method receives an <code>eZ\Publish\Core\MVC\Symfony\Event\APIContentExceptionEvent</code> object.</p></td>
</tr>
</tbody>
</table>

#### In this topic:

-   [Introduction](#ContentRendering-Introduction)
    -   [The ViewController](#ContentRendering-TheViewController)
-   [Configuration](#ContentRendering-Configuration)
    -   [View provider configuration](#ContentRendering-Viewproviderconfiguration)
    -   [View Matchers](#ContentRendering-ViewMatchers)
    -   [Default view templates](#ContentRendering-Defaultviewtemplates)
-   [Usage](#ContentRendering-Usage)
    -   [Content view templates](#ContentRendering-Contentviewtemplates)
    -   [Content and Location view providers](#ContentRendering-ContentandLocationviewproviders)
    -   [Rendering Content items](#ContentRendering-RenderingContentitems)
    -   [Embedding images](#ContentRendering-Embeddingimages)
    -   [Adding Links](#ContentRendering-AddingLinks)
    -   [Embedding Content items](#ContentRendering-EmbeddingContentitems)
    -   [Rendering blocks](#ContentRendering-Renderingblocks)
    -   [Binary and Media download](#ContentRendering-BinaryandMediadownload)
    -   [Custom controllers](#ContentRendering-Customcontrollers)
    -   [Query controller](#ContentRendering-Querycontroller)
    -   [ESI](#ContentRendering-ESI)
    -   [Asynchronous rendering](#ContentRendering-Asynchronousrendering)
-   [Reference](#ContentRendering-Reference)
    -   [Twig functions reference](#ContentRendering-Twigfunctionsreference)
-   [Extensibility](#ContentRendering-Extensibility)
    -   [Events](#ContentRendering-Events)

#### Related topics:

[Injecting parameters in content views](Injecting-parameters-in-content-views_31430331.html)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>
4.  <span>[Repository](Repository_31432023.html)</span>
5.  <span>[List of Limitations](List-of-Limitations_31430459.html)</span>

 Developer : ContentTypeLimitation 



A Limitation to specify if the User has access to Content with a specific Content Type.

|                 |                                                                          |
|-----------------|--------------------------------------------------------------------------|
| Identifier      | `Class`                                                                  |
| Value Class     | `eZ\Publish\API\Repository\Values\User\Limitation\ContentTypeLimitation` |
| Type Class      | `eZ\Publish\Core\Limitation\ContentTypeLimitationType`                   |
| Criterion used  | `eZ\Publish\API\Repository\Values\Content\Query\Criterion\ContentTypeId` |
| Role Limitation | no                                                                       |

###### Possible values

<table>
<colgroup>
<col width="33%" />
<col width="33%" />
<col width="33%" />
</colgroup>
<tbody>
<tr class="odd">
<td align="left">Value</td>
<td align="left">UI value</td>
<td align="left">Description</td>
</tr>
<tr class="even">
<td align="left"><code>&lt;ContentType_id&gt;</code></td>
<td align="left"><code>&lt;ContentType_name&gt;</code></td>
<td align="left"><p>All valid <code>ContentType</code> ids can be set as value(s)</p></td>
</tr>
</tbody>
</table>

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Community Resources](Community-Resources_31429530.html)</span>
4.  <span>[How to Contribute](How-to-Contribute_31429587.html)</span>

 Developer : Contribute to Documentation 



While we are doing our best to make sure our documentation fulfills all your needs, there is always place for improvement. If you'd like to contribute to our docs, you can do the following:

-   **Add comments.** Whenever you notice a mistake or possible improvement in any of the topics, leave a comment or suggestion at the bottom of the page.
-   **Create a JIRA issue.** You can also report any omissions or inaccuracies you find by creating a JIRA issue. See [Report and follow issues: The bugtracker](31429592.html) on how to do this. Remember to add the "Documentation" component to your issue to make sure we don't lose track of it.
-   **Visit Slack.** The \#documentation-contrib channel on <a href="http://ez-community-on-slack.herokuapp.com">eZ Community Slack team</a> is the place to drop your comments, suggestions, or proposals for things you'd like to see covered in documentation. (You can use the link to get an auto-invite to Slack).
-   **Contact the Doc Team.** If you'd like to add to any part of the documentation, you can also contact the Doc Team directly at <script type="text/javascript">
    <!--
    h='&#x65;&#122;&#46;&#110;&#x6f;&#46;';a='&#64;';n='&#100;&#x6f;&#x63;&#x2d;&#116;&#x65;&#x61;&#x6d;';e=n+a+h;
    document.write('<a h'+'ref'+'="ma'+'ilto'+':'+e+'" clas'+'s="em' + 'ail">'+e+'<\/'+'a'+'>');
    // -->
    </script><noscript>&#100;&#x6f;&#x63;&#x2d;&#116;&#x65;&#x61;&#x6d;&#32;&#x61;&#116;&#32;&#x65;&#122;&#32;&#100;&#x6f;&#116;&#32;&#110;&#x6f;&#32;&#100;&#x6f;&#116;&#32;</noscript>

 

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Community Resources](Community-Resources_31429530.html)</span>
4.  <span>[How to Contribute](How-to-Contribute_31429587.html)</span>

 Developer : Contributing translations 



If you'd like to see eZ Platform in your language, you can contribute to the translations. Contributing is made easy by using Crowdin, which allows you to translate elements of the interface in context.

# How to translate the interface using Crowdin

If you wish to contribute to an existing translation of PlatformUI or start a new one, <span class="inline-comment-marker" data-ref="b52fbf5d-a27a-42e7-b153-f1509bb55b71">the best way</span> is to start with in-context translation (but you can also [translate directly on the Crowdin website](#Contributingtranslations-Translatingoutsidein-context)).

## Preparing to use in-context

To start translating, you need an option to turn in-context translation on and off. To do this, set a browser cookie. There are several ways to do this, but we will highlight a couple here.

### Using bookmarks

You can easily create two bookmarks to toggle in-context on/off.

Right-click your browser's bookmark bar, and create a new bookmark, with the following label and link:

-   Enable in-context: `javascript:(function() {document.cookie='ez_in_context_translation=1;path=/;'; location.reload();})()`
-   Disable in-context: `javascript:(function()  {document.cookie='ez_in_context_translation=;expires=Mon, 05 Jul 2000  00:00:00 GMT;path=/;'; location.reload();})()`

Then click on the bookmarks from PlatformUI to enable/disable in-context.

### Using the debugging console

Another way is to open the development console and run these lines:

-   enable: `document.cookie='ez_in_context_translation=1;path=/;'; location.reload();`
-   disable: `document.cookie='ez_in_context_translation=;expires=Mon, 05 Jul 2000 00:00:00 GMT;path=/;'; location.reload();`

## Using in-context translation

The first time you enable in-context, if you're not logged into Crowdin, it will ask you to log in or register an account. Once done, it will ask you which language you want to translate to, from the list of languages configured in Crowdin.

Choose your language and you can start translating right away. Strings in the interface that can be translated will be outlined in red (untranslated), blue (translated) or green (approved). When moving over them, an edit button will show up on the top left corner of the outline. Click on it, and edit the string in the window that shows up.

### <span class="confluence-embedded-file-wrapper image-center-wrapper confluence-embedded-manual-size"><img src="attachments/31429671/33554862.png" title=" In-context translation of Platform UI" alt=" In-context translation of Platform UI" class="confluence-embedded-image image-center" width="800" height="480" /></span>

#### Troubleshooting

Make sure you clear your browser's cache in addition to eZ Platform's. Some of the translation resources use aggressive HTTP cache.

## Translating outside in-context

If you prefer not to use in-context, simply visit <a href="https://crowdin.com/project/ezplatform">eZ Platform's Crowdin page</a>, choose a language and you will see a list of files containing strings. Here you can suggest your translations.

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
If the language you want to translate to is not available, you can ask for it to be added in the <a href="https://crowdin.com/project/ezplatform/discussions">Crowdin discussion forum for eZ Platform</a>.

# Install new translation package

To make use of the UI translations, you need to<span class="inline-comment-marker" data-ref="9504e97b-17fd-4ff0-bae5-958311e12228"> install the new translation package in your project.</span>

## Translation packages per language

To allow users to install only what they need, we have split every language into a dedicated package.

All translation packages are published on <a href="https://github.com/ezplatform-i18n">ezplatform-i18n organisation on github</a>

## Install a new language in your project

<span class="inline-comment-marker" data-ref="9370cf8d-c018-4086-aaa3-d6723bb71444">If you want to install a new language in your project, you just have to install the corresponding package.</span>

For example, if you want to translate your application into French, you just have to run:

    composer require ezplatform-i18n/ezplatform-i18n-fr_fr

and then clear the cache.

Now you can reload your eZ Platform administration page which will be translated in French (if your browser is configured to fr\_FR.)

# Full translation workflow

<span class="inline-comment-marker" data-ref="20756fb2-d2e8-4028-812b-0513d0ba73d9">You can read a full description of how new translations are prepared and dis</span>tributed in <a href="https://github.com/ezsystems/ezplatform/blob/1.8/doc/i18n/translation_workflow.md">the documentation of GitHub</a>.

#### In this topic:

-   [How to translate the interface using Crowdin](#Contributingtranslations-HowtotranslatetheinterfaceusingCrowdin)
    -   [Preparing to use in-context](#Contributingtranslations-Preparingtousein-context)
        -   [Using bookmarks](#Contributingtranslations-Usingbookmarks)
        -   [Using the debugging console](#Contributingtranslations-Usingthedebuggingconsole)
    -   [Using in-context translation](#Contributingtranslations-Usingin-contexttranslation)
        -   [](#Contributingtranslations-)
    -   [Translating outside in-context](#Contributingtranslations-Translatingoutsidein-context)
-   [Install new translation package](#Contributingtranslations-Installnewtranslationpackage)
    -   [Translation packages per language](#Contributingtranslations-Translationpackagesperlanguage)
    -   [Install a new language in your project](#Contributingtranslations-Installanewlanguageinyourproject)
-   [Full translation workflow](#Contributingtranslations-Fulltranslationworkflow)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Cookbook](Cookbook_31429528.html)</span>

 Developer : Converting request parameters into API objects 



# Description

In lots of cases, a request will provide a contentId or a locationId. Before using them, you will have to load API object within your controller.

# Solution

For example:

``` brush:
public function listBlogPostsAction( $locationId )
{
    $location = $repository->getLocationService()->loadLocation( $locationId );
```

Thanks to the param converter, you can directly have the API object at your disposal. All you have to do is:

-   For Locations:
    -   In your controller's signature, type int the variable to Location.
    -   Make sure a parameter named "locationId" is provided by the request.
-   For Content items:
    -   In your controller's signature, typeint the variable to Content
    -   Make sure a parameter named "contentId" is provided by the request

# Example

Example using Locations:

``` brush:
use eZ\Publish\API\Repository\Values\Content\Location;

public function listBlogPostsAction( Location $location )
{
    // use my $location object
```

## Further information

If you want to understand how it works, you can check <a href="http://symfony.com/doc/master/bundles/SensioFrameworkExtraBundle/annotations/converters.html">Symfony's param converter documentation</a> and the <a href="https://github.com/ezsystems/ezpublish-kernel/pull/1128">pull request implementing the Repository ParamConverters</a>.

## Migrating your current application

<a href="https://github.com/ezsystems/DemoBundle/pull/129/files">See example pull request on the DemoBundle</a> which provides a few concrete examples.

#### In this topic:

-   [Description](#ConvertingrequestparametersintoAPIobjects-Description)
-   [Solution](#ConvertingrequestparametersintoAPIobjects-Solution)
-   [Example](#ConvertingrequestparametersintoAPIobjects-Example)
    -   [Further information](#ConvertingrequestparametersintoAPIobjects-Furtherinformation)
    -   [Migrating your current application](#ConvertingrequestparametersintoAPIobjects-Migratingyourcurrentapplication)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>

 Developer : Cookbook 



This Cookbook contains recipes for doing specific tasks and solving challenges that you may encounter while working with eZ Platform.

 

Contributing recipes

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
Know a nice trick? Found an interesting solution? Let us know in the comments or take a look at how to [Contribute to Documentation](Contribute-to-Documentation_31429594.html).

 

#### Available recipes:

-   [Authenticating a user with multiple user providers](Authenticating-a-user-with-multiple-user-providers_31429790.html)
-   [Converting request parameters into API objects](Converting-request-parameters-into-API-objects_31429807.html)
-   [Creating custom notifications for Flex Workflow](Creating-custom-notifications-for-Flex-Workflow_33555728.html)
-   [Creating Landing Page blocks (Enterprise)](31430614.html)
-   [Creating Landing Page layouts (Enterprise)](31430259.html)
-   [Displaying children of a Content item](Displaying-children-of-a-Content-item_32868706.html)
-   [Displaying content with simple templates](Displaying-content-with-simple-templates_34079211.html)
-   [Executing long-running console commands](Executing-long-running-console-commands_31429811.html)
-   [Exposing SiteAccess-aware configuration for your bundle](Exposing-SiteAccess-aware-configuration-for-your-bundle_31429794.html)
-   [Importing settings from a bundle](Importing-settings-from-a-bundle_31429803.html)
-   [Injecting parameters in content views](Injecting-parameters-in-content-views_31430331.html)
-   [Listening to Core events](Listening-to-Core-events_31429796.html)
-   [Making cross-origin HTTP requests](Making-cross-origin-HTTP-requests_31430329.html)
-   [Paginating API search results](Paginating-API-search-results_31429798.html)
-   [Retrieving root location](Retrieving-root-location_31429800.html)
-   [Steps to set up Cluster](Steps-to-set-up-Cluster_31432321.html)
-   [Using RouteReference](Using-RouteReference_31430391.html)

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>
4.  <span>[Under the Hood: How eZ Platform Works](31429659.html)</span>
5.  <span>[Content Model: Content is King!](31429709.html)</span>
6.  <span>[Content items, Content Types and Fields](31430275.html)</span>
7.  <span>[Field Types reference](Field-Types-reference_31430495.html)</span>

 Developer : Country Field Type 



This Field Type represents one or multiple countries.

| Name      | Internal name | Expected input |
|-----------|---------------|----------------|
| `Country` | `ezcountry`   | `array`        |

## Description

This Field Type makes possible to store and retrieve data representing countries.

## PHP API Field Type 

### Input expectations

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th align="left">Type</th>
<th align="left">Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td align="left"><code>array</code></td>
<td align="left"><div class="code panel pdl" style="border-width: 1px;">
<div class="codeContent panelContent pdl">
<pre class="brush: php; gutter: true; theme: Eclipse" style="font-size:12px;"><code>array(
    &quot;JP&quot; =&gt; array(
        &quot;Name&quot; =&gt; &quot;Japan&quot;,
        &quot;Alpha2&quot; =&gt; &quot;JP&quot;,
        &quot;Alpha3&quot; =&gt; &quot;JPN&quot;,
        &quot;IDC&quot; =&gt; 81
    )
);</code></pre>
</div>
</div></td>
</tr>
</tbody>
</table>

<span class="nx">Note: When you set an array directly on Content field you don't need to provide all this information, the Field Type will assume it is a hash and in this case will accept a simplified structure described below under [To / From Hash format](#CountryFieldType-ToFromHashFormat).</span>

### Validation

This Field Type validates if the multiple countries are allowed by the field definition, and if the Alpha2 is valid according to the countries configured in eZ Platform.

### Settings

The field definition of this Field Type can be configured with one option:

| Name         | Type      | Default value | Description                                                                             |
|--------------|-----------|---------------|-----------------------------------------------------------------------------------------|
| `isMultiple` | `boolean` | `false`       | This setting allows (if true) or denies (if false) the selection of multiple countries. |

**Country FieldType example settings**

``` brush:
$settings = array(
    "isMultiple" => true
);
```

### <span id="CountryFieldType-ToFromHashFormat" class="confluence-anchor-link"></span>To / From Hash format

The format used for serialization is simpler than the full format, this is also available when setting value on the content field, by setting the value to an array instead of the Value object. Example of that shown below:

**Value object content example**

``` brush:
$content->fields["countries"] = array( "JP", "NO" );
```

The format used by the toHash method is the Alpha2 value, however the input is capable of accepting either Name, Alpha2 or Alpha3 value as shown below in the Value object section.

### Value object

##### Properties

The Value class of this field type contains the following properties:

| Property     | Type      | Description                                                                                |
|--------------|-----------|--------------------------------------------------------------------------------------------|
| `$countries` | `array[]` | This property will be used for the country selection provided as input, as its attributes. |

**Value object content example**

``` brush:
$value->countries = array(
    "JP" => array(
        "Name" => "Japan",
        "Alpha2" => "JP",
        "Alpha3" => "JPN",
        "IDC" => 81
    )
)
```

##### Constructor

<span>The `Country`</span>`\Value`<span> constructor will initialize a new Value object with the value provided. It expects an array as input.</span>

**Constructor example**

``` brush:
// Instantiates a Country Value object
$countryValue = new Country\Value(
    array(
        "JP" => array(
            "Name" => "Japan",
            "Alpha2" => "JP",
            "Alpha3" => "JPN",
            "IDC" => 81
        )
    )
);
```

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Tutorials](Tutorials_31429522.html)</span>
4.  <span>[Creating a Tweet Field Type](Creating-a-Tweet-Field-Type_31429766.html)</span>
5.  <span>[Build the bundle](Build-the-bundle_31429768.html)</span>

 Developer : Create the bundle 



Custom Field Types follow the Symfony 2 extension mechanism: <a href="http://symfony.com/doc/current/cookbook/bundles/index.html">bundles</a>. We can get started with a bundle using the built-in Symfony 2 bundle generator.

### Generating the bundle

From the eZ Platform root, run the following:

``` brush:
php app/console generate:bundle
```

First, we are asked for the namespace. As the vendor, we will use EzSystems as the root namespace. This must of course be changed to whatever identifies you as a vendor (your name, company name, etc). We then choose a preferably unique name for the Field Type itself, and make the name end with Bundle. Here we’ve chosen TweetFieldTypeBundle.

 

``` brush:
Bundle namespace: EzSystems/TweetFieldTypeBundle<enter>
```

We must next input the bundle’s name. Nothing exotic here: we concatenate the vendor’s namespace and the bundle’s namespace, which is the default. Just hit Enter:

``` brush:
Bundle name [EzSystemsTweetFieldTypeBundle]:<enter>
```

We are then asked for the target directory. We will begin within the `src` folder, but we could (and should!) version it and have it moved to `vendor` at some point. Again, this is the default, and we just hit Enter.

``` brush:
Target directory [/home/bertrand/www/ezpublish5/src]:<enter>
```

We must then specify which format the configuration must be generated as. We will use yml, since it is what we use in eZ Platform itself. Of course, any other format could be used.

``` brush:
Configuration format (yml, xml, php, or annotation): yml<enter>
```

The generator will then offer to create the whole directory structure for us. Since our bundle isn’t really a standard Symfony full stack bundle, we decline.

``` brush:
Do you want to generate the whole directory structure [no]? no<enter>
```

 

We then get a summary of what will be generated:

``` brush:
You are going to generate a "EzSystems\TweetFieldTypeBundle\EzSystemsTweetFieldTypeBundle" bundle
in "/home/bertrand/www/ezpublish5/src/" using the "yml" format.
Do you confirm generation [yes]?<enter>
```

After generation, the wizard will offer to update the kernel with our bundle (answer "yes"), and to update the app’s routing with our bundle’s route file (answer "no").

``` brush:
Generating the bundle code: OK
Checking that the bundle is autoloaded: OK
Confirm automatic update of your Kernel [yes]? <enter>
Enabling the bundle inside the Kernel: OK
Confirm automatic update of the Routing [yes]? no <enter>
```

Our bundle should now be generated. Navigate to `src/EzSystems/EzSystemsTweetBundle` and you should see the following structure:

``` brush:
$ ls -l src/EzSystems/TweetFieldTypeBundle
Controller
DependencyInjection
EzSystemsTweetFieldTypeBundle.php
Resources
Tests
```

Feel free to delete the Controller folder, since we won’t use it in this tutorial. It could have been useful, had our Field Type required an interface of its own.

**Tutorial path**






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Tutorials](Tutorials_31429522.html)</span>
4.  <span>[Extending PlatformUI with new navigation](Extending-PlatformUI-with-new-navigation_31430235.html)</span>

 Developer : Create the extension Bundle 



To extend PlatformUI, the very first thing to do is to create a Symfony bundle. For that, you can use <a href="http://symfony.com/doc/current/bundles/SensioGeneratorBundle/commands/generate_bundle.html">the Symfony generate bundle command</a> in the following way:

``` brush:
$ app/console generate:bundle --namespace=EzSystems/ExtendingPlatformUIConferenceBundle --dir=src --format=yml --no-interaction
```

This will generate a new bundle skeleton in `src/EzSystems/ExtendingPlatformUIConferenceBundle`, add it to the application kernel and configure eZ Platform to use the generated `routing.yml` without asking any question. Of course, you are free to tweak the bundle's namespace and directory or to integrate the PlatformUI extension code in an existing bundle.

Results and next step:

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
If you run this exact command, you will pretty much get <a href="https://github.com/ezsystems/ExtendingPlatformUIConferenceBundle/tree/1_bundle">the code available under the 1_bundle tag on Github</a>.

The next step is then to [prepare the bundle to handle PlatformUI specific configuration](Set-up-the-configuration_31430239.html).

**Tutorial path**






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Tutorials](Tutorials_31429522.html)</span>

 Developer : Creating a Tweet Field Type 



## About this tutorial

 

This tutorial aims at covering the creation and development of a custom eZ Platform [Field Type](https://doc.ez.no/display/DEVELOPER/Field+Types+reference).
We will do this by implementing a *Tweet* Field Type. It will:

-   Accept as input the URL of a tweet (https://twitter.com/&lt;username&gt;/status/&lt;id&gt;)

-   Fetch the tweet using the Twitter oEmbed API (<a href="https://dev.twitter.com/docs/embedded-tweets" class="uri">https://dev.twitter.com/docs/embedded-tweets</a>)

-   Store the tweet’s embed contents and URL

-   Display the tweet's embedded version when displaying the field from a template

 

<span class="confluence-embedded-file-wrapper"><img src="attachments/31429766/31429765.png" class="confluence-embedded-image" /></span>

### About Field Types

Field Types are the most granular building blocks for content managed by eZ Platform. The system comes with about [30 native types](Field-Types-reference_31430495.html) that cover most common needs (Text line, Rich text, Email, Author list, Content relation, Map location, Float, etc.)

Field Types are responsible for:

-   Storing data, either using the native storage engine mechanisms, or specific means

-   Validating input data

-   Making the data searchable (if applicable)

-   Displaying an instance of the type

Custom Field Types are a very powerful type of extension, since they allow you to hook deep into the content model.

You can find the in-depth [documentation about Field Types and their best practices here](Field-Type-API-and-best-practices_31430767.html). It describes how each component of a Field Type interacts with the various layers of the system, and how to implement those.

 

## Getting the code

The code created throughout this tutorial is available on GitHub: <a href="https://github.com/ezsystems/TweetFieldTypeBundle" class="uri">https://github.com/ezsystems/TweetFieldTypeBundle</a>.

 

## Steps

### The bundle

Field Types, like any other eZ Platform plugin, must be provided as Symfony2 bundles. This chapter covers the creation and organization of this bundle.

Read more about [creating](Create-the-bundle_31429782.html) and [structuring the bundle](Structure-the-bundle_31429784.html).

### API

This part covers the implementation of the eZ Platform API elements required to implement a custom Field Type.

Read more about [implementing the Tweet\\Value class](31429770.html) and [the Tweet\\Type class](31429772.html).

### Converter

Storing data from any Field Type into the Legacy Storage Engine requires that your custom data is mapped to the data model.

Read more about [implementing the Legacy Storage Engine Converter](Implement-the-Legacy-Storage-Engine-Converter_31429776.html).

### Templating

Displaying a Field Type's data is done through a <a href="http://twig.sensiolabs.org/doc/intro.html">Twig template</a>.

Read more about [implementing the Field Type template](Introduce-a-template_31429779.html).

### PlatformUI integration

Viewing and editing values of the Field Type in PlatformUI requires that you extend PlatformUI, using mostly Javascript.

You should ideally read the general <a href="https://github.com/ezsystems/PlatformUIBundle/blob/master/docs/extensibility.md">extensibility documentation for PlatformUI</a>. The part about <a href="https://github.com/ezsystems/PlatformUIBundle/blob/master/docs/extensibility.md#templates-1">templating</a> covers view templates. Edit templates are not documented at the time of writing, but <a href="http://www.netgenlabs.com/">Netgen</a> <span> has published a tutorial that </span>covers the topic: <a href="http://www.netgenlabs.com/Blog/Adding-support-for-a-new-field-type-to-eZ-Publish-Platform-UI" class="uri">http://www.netgenlabs.com/Blog/Adding-support-for-a-new-field-type-to-eZ-Publish-Platform-UI</a>.

**Tutorial Path**

## Attachments:

<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [fieldtype tutorial, final result.PNG](attachments/31429766/31429765.png) (image/png)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Cookbook](Cookbook_31429528.html)</span>

 Developer : Creating custom notifications for Flex Workflow 



<span style="color: rgb(0,0,0);text-decoration: none;">To create a custom notification you have to provide two plugins in the `flex-workflow` bundle, one for the `notificationsPopupView` and second for the `notificationIndicatorView`.</span>

<span style="color: rgb(0,0,0);text-decoration: none;">We will start from creating a plugin for `notificationIndicatorView` which is responsible for displaying a text in the notification bar (this green stripe in the bottom when you get new notification)</span>

<span style="color: rgb(0,0,0);text-decoration: none;">We have to start from adding dependencies in yui.yml (placed in `./Resources/config/yui.yml`):</span><span style="color: rgb(0,0,0);text-decoration: none;"> </span>

``` brush:
mb-notificationmessagecreatorplugin:
    requires: ['plugin', 'ez-pluginregistry']
    dependencyOf: ['fw-notificationindicatorview']
    path: %mybundle.public_dir%/js/plugins/mb-notificationmessagecreatorplugin.js
```

<span style="color: rgb(0,0,0);text-decoration: none;">
</span><span style="color: rgb(0,0,0);text-decoration: none;">Now we can create our plugin (as we declared in the yui.yml, we need to create it in `./js/plugins`), it will be stored in a file named `mb-notificationmessagecreatorplugin.js`:</span><span style="color: rgb(0,0,0);text-decoration: none;"> </span>

``` brush:
YUI.add('mb-notificationmessagecreatorplugin', function (Y) {
    'use strict';

    var PLUGIN_NAME = 'mbNotificationMessageCreatorPlugin';

    /**
     * Add the notification message creator
     *
     * @module mb-notificationmessagecreatorplugin
     */
    Y.namespace('mb.Plugin');

    /**
     * @namespace mb.Plugin
     * @class mbNotificationMessageCreator
     * @constructor
     * @extends Plugin.Base
     */
    Y.mb.Plugin.NotificationMessageCreator = Y.Base.create(PLUGIN_NAME, Y.Plugin.Base, [], {
        initializer: function () {
            var notificationIndicatorView = this.get('host');

            /**
             * This will add a message creator to the `notificationIndicatorView`.
             * In the public method `addNotificationMessageCreator` we have to provide:
             * 1. The notification type.
             * 2. The callback to be invoked to create the message in the notification bar.
             */

 
           notificationIndicatorView.addNotificationMessageCreator('myNotificationType',
 this._createNotificationMessage.bind(this));
        },

        /**
         * Creates a notification message.
         *
         * @method _createNotificationMessage
         * @protected
         * @param notification {Object} the notification
         * @return {String}
         */
        _createNotificationMessage: function (notification) {
            /**
             * In this method we have to return a string which will be displayed in the notification bar.
             * To this method is passed the notification object provided from backend.
             * In this tutorial we assume that the message is in object `data`.
             */
            return notification.data.message;
        },

    }, {
        NS: PLUGIN_NAME
    });

    Y.eZ.PluginRegistry.registerPlugin(
         Y.mb.Plugin.NotificationMessageCreator, ['notificationIndicatorView']
    );
});
```

<span style="color: rgb(0,0,0);text-decoration: none;">Now we can create a plugin for the `notificationsPopupView`, it will be responsible for creating a proper notification struct, again we start from creating dependency in yui.yml:</span><span style="color: rgb(0,0,0);text-decoration: none;"> </span>

``` brush:
mb-notificationstructparserplugin:
    requires: ['plugin', 'ez-pluginregistry']
    dependencyOf: ['fw-notificationspopupview']
    path: %mybundle.public_dir%/js/plugins/mb-notificationstructparserplugin.js
```

<span style="color: rgb(0,0,0);text-decoration: none;">And we create a plugin named `mb-notificationstructparserplugin`:</span>

``` brush:
YUI.add('mb-notificationstructparserplugin', function (Y) {
    'use strict';

    var PLUGIN_NAME = 'mbNotificationStructParserPlugin',
        TIMESTAMP_MULTIPLIER = 1000;

    /**
     * Add the notification struct parser
     *
     * @module mb-notificationstructparserplugin
     */
    Y.namespace('mb.Plugin');

    /**
     * @namespace mb.Plugin
     * @class mbNotificationStructParser
     * @constructor
     * @extends Plugin.Base
     */
    Y.mb.Plugin.NotificationStructParser = Y.Base.create(PLUGIN_NAME, Y.Plugin.Base, [], {
        initializer: function () {
            var notificationsPopupView = this.get('host');

            /**
             * This will add notification parser to the `notificationsPopupView`.
             * In the public method `addNotificationStructParser` we have to provide:
             * 1. The notification type.
             * 2. The callback to be invoked to create the proper notification struct.
             */
            notificationsPopupView.addNotificationStructParser('myNotificationType', this._createNotificationStruct.bind(this));
        },

        /**
         * Creates a notification structure required to render notifications
         *
         * @method _createNotificationStruct
         * @protected
         * @param item {Object} notification data
         * @return {Object}
         */
        _createNotificationStruct: function (item) {
            var creationDate = new Date(item.created * TIMESTAMP_MULTIPLIER);

            /**
             * In this method we have to return an object with proper notification struct.
             * The proper struct looks like this:
             * {
             *     id: {Number} the notification id
             *     isPending: {Number} is notification pending (0 or 1)
             *     date: {String} the date of notification
             *     time: {String} the time of notification
             *     type: {String} the notification type
             *     messageType: {String} the type message
             *     link: {String} the url to redirect user on click (if omitted will only close popup)
             *     shortText: {String} the short description text
             *     text: {String} the long description text (if omitted only shortText will be displayed)
             * }
             */
            return {
                id: item.id,
                isPending: parseInt(item.isPending, 10),
                type: item.type,
                date: Y.Date.format(creationDate, {format: '%x'}),
                time: Y.Date.format(creationDate, {format: '%X'}),
                link: item.data.link,
                messageType: item.data.contentName,
                shortText: item.data.message,
                text: item.data.message
            };
        },
    }, {
        NS: PLUGIN_NAME
    });

    Y.eZ.PluginRegistry.registerPlugin(
         Y.mb.Plugin.NotificationStructParser, ['notificationsPopupView']
    );
});
```

<span style="color: rgb(0,0,0);text-decoration: none;">Now we can clear cache (`php app/console --env=prod cache:clear`) and our notification should be displayed properly. In the image below you can check what is what in the notification struct:</span><span style="color: rgb(0,0,0);text-decoration: none;"> </span><span style="color: rgb(0,0,0);text-decoration: none;"> </span>

<span style="color: rgb(0,0,0);text-decoration: none;"><span class="confluence-embedded-file-wrapper confluence-embedded-manual-size"><img src="attachments/33555728/33555726.png" class="confluence-embedded-image" width="600" /></span>
</span>

 

## Attachments:

<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [notification.png](attachments/33555728/33555726.png) (image/png)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>
4.  <span>[Under the Hood: How eZ Platform Works](31429659.html)</span>
5.  <span>[Content Model: Content is King!](31429709.html)</span>
6.  <span>[Content items, Content Types and Fields](31430275.html)</span>
7.  <span>[Field Types reference](Field-Types-reference_31430495.html)</span>

 Developer : Date Field Type 



This Field Type represents a date without time information.

| Name   | Internal name | Expected input type |
|--------|---------------|---------------------|
| `Date` | `ezdate`      | `mixed`             |

## Description

This Field Type makes it possible to store and retrieve date information.

#### PHP API Field Type 

### Input expectations

If input value is of type **`string`** or **`integer`**, it will be passed directly to the <a href="http://www.php.net/manual/en/datetime.construct.php">PHP's built-in <strong><code>\DateTime</code></strong> class constructor</a>, therefore the same input format expectations apply.

It is also possible to directly pass an instance of **`\DateTime`**.

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th align="left">Type</th>
<th align="left">Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td align="left"><code>string</code></td>
<td align="left"><code>&quot;2012-08-28 12:20 Europe/Berlin&quot;</code></td>
</tr>
<tr class="even">
<td align="left"><pre><code>integer</code></pre></td>
<td align="left"><pre><code>1346149200</code></pre></td>
</tr>
<tr class="odd">
<td align="left"><pre><code>\DateTime</code></pre></td>
<td align="left"><pre><code>new \DateTime()</code></pre></td>
</tr>
</tbody>
</table>

<span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"></span>
Time information is **not stored**.

Before storing, the provided input value will be set to the the beginning of the day in the given or the environment timezone.

### Value object

##### Properties

The Value class of this field type contains the following properties:

| Property | Type        | Description                                      |
|----------|-------------|--------------------------------------------------|
| `$date`  | `\DateTime` | This property will be used for the text content. |

##### String representation

String representation of the date value will generate the date string in the format "l d F Y" as accepted by <a href="http://www.php.net/manual/en/function.date.php">PHP's built-in <strong><code>date()</code></strong> function</a>.

Example:

> `Wednesday 22 May 2013`

##### Constructor

The constructor for this value object will initialize a new Value object with the value provided. It accepts an instance of <a href="http://www.php.net/manual/en/datetime.construct.php">PHP's built-in <strong><code>\DateTime</code></strong> class</a>.

### Hash format

Hash value of this Field Type is an array with two keys:

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th align="left"><div class="tablesorter-header-inner">
Key
</div></th>
<th align="left"><div class="tablesorter-header-inner">
Type
</div></th>
<th align="left"><div class="tablesorter-header-inner">
Description
</div></th>
<th align="left"><div class="tablesorter-header-inner">
Example
</div></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td align="left"><p><code>timestamp</code></p></td>
<td align="left"><code>integer</code></td>
<td align="left">Time information as a <a href="http://en.wikipedia.org/wiki/Unix_time">timestamp</a>.</td>
<td align="left"><p><code>1400856992</code></p></td>
</tr>
<tr class="even">
<td align="left"><p><code>rfc850</code></p></td>
<td align="left"><code>string</code></td>
<td align="left"><p>Time information as a string in <a href="http://tools.ietf.org/html/rfc850">RFC 850 date format</a>.</p>
<p>As input, this will have higher precedence over the <strong><code>timestamp</code></strong> value.</p></td>
<td align="left"><code>&quot;Friday, 23-May-14 14:56:14 GMT+0000&quot;</code></td>
</tr>
</tbody>
</table>

**Example of the hash value in PHP**

``` brush:
$hash = array(
    "timestamp" => 1400856992,
    "rfc850" => "Friday, 23-May-14 14:56:14 GMT+0000"
);
```

### Validation

This Field Type does not perform any special validation of the input value.

### Settings

The field definition of this Field Type can be configured with one option:

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th align="left">Name</th>
<th align="left">Type</th>
<th align="left">Default value</th>
<th align="left">Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td align="left"><pre><code>defaultType</code></pre></td>
<td align="left"><pre><code>mixed</code></pre></td>
<td align="left"><pre><code>Type::DEFAULT_EMPTY</code></pre></td>
<td align="left"><p>One of the <strong><code>DEFAULT_*</code></strong> constants, used by the administration interface for setting the default field value.</p>
<p>See below for more details.</p></td>
</tr>
</tbody>
</table>

<span style="color: rgb(0,0,0);">Following **`defaultType`** default value options are available as constants in the </span>**`eZ\Publish\Core\FieldType\Date\Type`**<span style="color: rgb(0,0,0);">** **class:</span>

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th align="left">Constant</th>
<th align="left">Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td align="left"><pre><code>DEFAULT_EMPTY</code></pre></td>
<td align="left">Default value will be empty.</td>
</tr>
<tr class="even">
<td align="left"><pre><code>DEFAULT_CURRENT_DATE</code></pre></td>
<td align="left">Default value will use current date.</td>
</tr>
</tbody>
</table>

**Date FieldType example settings**

``` brush:
use eZ\Publish\Core\FieldType\Date\Type;

$settings = array(
    "defaultType" => Type::DEFAULT_EMPTY
);
```

## Template rendering

The template called by [the **ez\_render\_field()** Twig function](ez_render_field_32114041.html) while rendering a Date field has access to the following parameters:

| Parameter | Type     | Default | Description                                                                                                                       |
|-----------|----------|---------|-----------------------------------------------------------------------------------------------------------------------------------|
| `locale`  | `string` |         | Internal parameter set by the system based on current request locale or if not set calculated based on the language of the field. |

Example:

``` brush:
{{ ez_render_field(content, 'date') }}
```

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>
4.  <span>[Under the Hood: How eZ Platform Works](31429659.html)</span>
5.  <span>[Content Model: Content is King!](31429709.html)</span>
6.  <span>[Content items, Content Types and Fields](31430275.html)</span>
7.  <span>[Field Types reference](Field-Types-reference_31430495.html)</span>

 Developer : DateAndTime Field Type 



This Field Type represents a full date including time information.

| Name          | Internal name | Expected input type |
|---------------|---------------|---------------------|
| `DateAndTime` | `ezdatetime`  | `mixed`             |

## Description

This Field Type makes possible to store and retrieve a full date including time information.

## PHP API Field Type 

### Input expectations

If input value is of type **`string`** or **`integer`**, it will be passed directly to the <a href="http://www.php.net/manual/en/datetime.construct.php">PHP's built-in <strong><code>\DateTime</code></strong> class constructor</a>, therefore the same input format expectations apply.

It is also possible to directly pass an instance of **`\DateTime`**.

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th align="left">Type</th>
<th align="left">Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td align="left"><code>string</code></td>
<td align="left"><code>&quot;2012-08-28 12:20 Europe/Berlin&quot;</code></td>
</tr>
<tr class="even">
<td align="left"><pre><code>integer</code></pre></td>
<td align="left"><pre><code>1346149200</code></pre></td>
</tr>
<tr class="odd">
<td align="left"><pre><code>\DateTime</code></pre></td>
<td align="left"><pre><code>new \DateTime()</code></pre></td>
</tr>
</tbody>
</table>

### Value object

##### Properties

The Value class of this field type contains the following properties:

| Property | Type        | Description                                                |
|----------|-------------|------------------------------------------------------------|
| `$value` | `\DateTime` | The date and time value as an instance of **`\DateTime`**. |

##### Constructor

The constructor for this value object will initialize a new Value object with the value provided. It accepts an instance of PHP's built-in **`\DateTime`** class.

##### String representation

String representation of the date value will generate the date string in the format "D Y-d-m H:i:s" as accepted by <a href="http://www.php.net/manual/en/function.date.php">PHP's built-in <strong><code>date()</code></strong> function</a>.

Example:

> `Wed 2013-22-05 12:19:18`
>
> ``

### Hash format

Hash value of this Field Type is an array with two keys:

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th align="left">Key</th>
<th align="left">Type</th>
<th align="left">Description</th>
<th align="left">Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td align="left"><p><code>timestamp</code></p></td>
<td align="left"><code>integer</code></td>
<td align="left">Time information as a <a href="http://en.wikipedia.org/wiki/Unix_time">timestamp</a>.</td>
<td align="left"><p><code>1400856992</code></p></td>
</tr>
<tr class="even">
<td align="left"><p><code>rfc850</code></p></td>
<td align="left"><code>string</code></td>
<td align="left"><p>Time information as a string in <a href="http://tools.ietf.org/html/rfc850">RFC 850 date format</a>.</p>
<p>As input, this will have higher precedence over the <strong><code>timestamp</code></strong> value.</p></td>
<td align="left"><code>&quot;Friday, 23-May-14 14:56:14 GMT+0000&quot;</code></td>
</tr>
</tbody>
</table>

``` brush:
$hash = array(
    "timestamp" => 1400856992,
    "rfc850" => "Friday, 23-May-14 14:56:14 GMT+0000"
);
```

### Validation

This Field Type does not perform any special validation of the input value.

### Settings

The field definition of this Field Type can be configured with several options:

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th align="left">Name</th>
<th align="left">Type</th>
<th align="left">Default value</th>
<th align="left">Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td align="left"><code>useSeconds</code></td>
<td align="left"><code>boolean</code></td>
<td align="left"><code>false</code></td>
<td align="left">Used to control displaying of seconds in the output.</td>
</tr>
<tr class="even">
<td align="left"><pre><code>defaultType</code></pre></td>
<td align="left"><pre><code>mixed</code></pre></td>
<td align="left"><pre><code>Type::DEFAULT_EMPTY</code></pre></td>
<td align="left"><p>One of the <strong><code>DEFAULT_*</code></strong> constants, used by the administration interface for setting the default field value.</p>
<p>See below for more details.</p></td>
</tr>
<tr class="odd">
<td align="left"><pre><code>dateInterval</code></pre></td>
<td align="left"><pre><code>null|\DateInterval</code></pre></td>
<td align="left"><pre><code>null</code></pre></td>
<td align="left"><p>This setting complements <strong><code>defaultType</code></strong> setting and can be used only when latter is set to <strong><code>Type::DEFAULT_CURRENT_DATE_ADJUSTED</code></strong>.</p>
<p>In that case the default input value when using administration interface will be adjusted by the given <strong><code>\DateInterval</code></strong>.</p></td>
</tr>
</tbody>
</table>

<span style="color: rgb(0,0,0);">Following **`defaultType`** default value options are available as constants in the </span>**`eZ\Publish\Core\FieldType\DateAndTime\Type`**<span style="color: rgb(0,0,0);">** **class:</span>

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th align="left">Constant</th>
<th align="left">Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td align="left"><pre><code>DEFAULT_EMPTY</code></pre></td>
<td align="left">Default value will be empty.</td>
</tr>
<tr class="even">
<td align="left"><pre><code>DEFAULT_CURRENT_DATE</code></pre></td>
<td align="left">Default value will use current date.</td>
</tr>
<tr class="odd">
<td align="left"><pre><code>DEFAULT_CURRENT_DATE_ADJUSTED</code></pre></td>
<td align="left"><span><span>Default value will use current date, adjusted by the interval defined in </span></span><strong><code>dateInterval</code></strong><span style="line-height: 1.4285715;"> setting</span><span style="line-height: 1.4285715;">.</span></td>
</tr>
</tbody>
</table>

**DateAndTime FieldType example settings**

``` brush:
use eZ\Publish\Core\FieldType\DateAndTime\Type;

$settings = array(
    "useSeconds" => false,
    "defaultType" => Type::DEFAULT_EMPTY,
    "dateInterval" => null
);
```

## Template rendering

The template called by [the **ez\_render\_field()** Twig function](ez_render_field_32114041.html) while rendering a Date field has access to the following parameters:

| Parameter | Type     | Default | Description                                                                                                                       |
|-----------|----------|---------|-----------------------------------------------------------------------------------------------------------------------------------|
| `locale`  | `string` |         | Internal parameter set by the system based on current request locale or if not set calculated based on the language of the field. |

Example:

``` brush:
{{ ez_render_field(content, 'datetime') }}
```

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Tutorials](Tutorials_31429522.html)</span>
4.  <span>[Extending PlatformUI with new navigation](Extending-PlatformUI-with-new-navigation_31430235.html)</span>

 Developer : Define a View 



## Views in PlatformUI

Each route defines a View to render when the route is matched. As explained in the [PlatformUI technical introduction](Extending-eZ-Platform_31429689.html#ExtendingeZPlatform-Technicalarchitecture), this kind of view is called a **Main View**. Like any view, it can have an arbitrary number of sub-views.

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
**Good practice:** keep the views small and do not hesitate to create sub-views. This eases the maintenance and allows you to reuse the small sub-views in different context.

A View is responsible for generating the User Interface and handling the user input (click, keyboard, drag and drop, etc.). In its lifecycle, a view first receives a set of parameters, then it is rendered and added to DOM.

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
PlatformUI reuses the <a href="http://yuilibrary.com/yui/docs/view/#views-models-and-addtarget">YUI View system</a>. `Y.View` is designed to be a very simple component. PlatformUI extends this concept to have views with more features like templates or asynchronous behavior.

## Creating and using a custom Main View

### Creating a new View

As for the plugin in the previous step, the first thing to do is to declare a new module in the extension bundle `yui.yml` file:

**New module in yui.yml**

``` brush:
ezconf-listview:
    requires: ['ez-view']
    path: %extending_platformui.public_dir%/js/views/ezconf-listview.js
```

Our basic view will extend the PlatformUI basic view which is available in the `ez-view` module. As a result, `ez-view` has to be added in the module requirements.

Then we have to create the corresponding module file. In this file, we'll create a new View component by extending `Y.eZ.View` provided by `ez-view`.

**%extending\_platformui.public\_dir%/js/views/ezconf-listview.js**

``` brush:
YUI.add('ezconf-listview', function (Y) {
    Y.namespace('eZConf');

    Y.eZConf.ListView = Y.Base.create('ezconfListView', Y.eZ.View, [], {
        initializer: function () {
            console.log("Hey, I'm the list view");
        },

        render: function () {
            // this.get('container') is an auto generated <div>
            // here, it's not yet in the DOM of the page and it will be added
            // after the execution of render().
            this.get('container').setContent(
                "Hey, I'm the listView and I was rendered it seems"
            );
            this.get('container').setStyles({
                background: '#fff',
                fontSize: '200%',
            });
            return this;
        },
    });
});
```

This code creates the `Y.eZConf.ListView` by extending `Y.eZ.View`. The newly created view component has a custom `render` method. As its name suggests, this method is called when the view needs to be rendered. For now, we are directly manipulating the DOM. `this.get('container')` in a View allows you to retrieve the container DOM node, it's actually <a href="http://yuilibrary.com/yui/docs/node/">a Y.Node instance</a> that is automatically created and added to the page when the View is needed in the application.

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
A View is responsible for handling only what happens in its own container. While it's technically possible, it is a very bad practice for a View to handle anything that is outside its own container.

At this point, if you open/refresh PlatformUI in your browser, nothing will have really changed, because the newly added View is not used anywhere yet.

### Using it as a Main View

Now that we have a View, it's time to change the route configuration added in the previous step so that our custom route uses it. To do that, we'll have to change the application plugin to register the new view as a main view in the application and then to define the custom route with that view. Since we want to use the new view in the plugin, the `ezconf-listview` module becomes a dependency of the plugin module. The plugin module declaration becomes:

``` brush:
ezconf-listapplugin:
    requires: ['ez-pluginregistry', 'plugin', 'base', 'ezconf-listview'] # we've added 'ezconf-listview'
    dependencyOf: ['ez-platformuiapp']
    path: %extending_platformui.public_dir%/js/apps/plugins/ezconf-listappplugin.js
```

Then in the plugin, `Y.eZConf.ListView` becomes available; we can register it as a potential main view and change the route to use it:

**ezconf-listappplugin.js**

``` brush:
YUI.add('ezconf-listapplugin', function (Y) {
    Y.namespace('eZConf.Plugin');

    Y.eZConf.Plugin.ListAppPlugin = Y.Base.create('ezconfListAppPlugin', Y.Plugin.Base, [], {
        initializer: function () {
            var app = this.get('host'); // the plugged object is called host

            console.log("Hey, I'm a plugin for PlatformUI App!");
            console.log("And I'm plugged in ", app);

            console.log('Registering the ezconfListView in the app');
            app.views.ezconfListView = {
                type: Y.eZConf.ListView,
            };

            console.log("Let's add a route");
            app.route({
                name: "eZConfList",
                path: "/ezconf/list",
                view: "ezconfListView", // because we registered the view in app.views.ezconfListView
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

After doing that, `/ez#/ezconf/list` should no longer display the dashboard, but you should see the message generated by `Y.eZConf.ListView`.

### Using a template

Manipulating the DOM in a view render method is fine for small changes but not very handy as soon as you want to generate a more complex UI. It's also a great way to separate pure UI/markup code from the actual view logic.

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
In PlatformUI, most views are using a template to generate their own markup, those templates are interpreted by <a href="http://yuilibrary.com/yui/docs/handlebars/">the Handlebars.js template engine embed into YUI</a>.

The templates are made available in the application by defining them as modules in `yui.yml`. The template modules are a bit special though. To be recognized as a template and correctly handled by the application, a template module has a `type` property that should be set to `template`. Also, to get everything ready *automatically*, the module name should follow a naming convention. The module name should consist of the lowercase View internal name (the first `Y.Base.create` parameter) where the template is supposed to be used followed by the suffix `-ez-template`. In our case, the internal name of `Y.eZConf.ListView` is `ezconfListView`, so if we want to use a template in this view, the module for this template should be `ezconflistview-ez-template`. The template module must also be added as a dependency of the view module using it (`ezconf-listview` in this case). As a result, the modules declaration for the template and the view will be:

``` brush:
ezconf-listview:
    requires: ['ez-templatebasedview', 'ezconflistview-ez-template']
    path: %extending_platformui.public_dir%/js/views/ezconf-listview.js
ezconflistview-ez-template: # internal view name + '-ez-template' suffix
    type: 'template' # mandatory so that the template is available in JavaScript
    path: %extending_platformui.public_dir%/templates/ezconflistview.hbt
```

In `yui.yml`, we also have to change the `ezconf-listview` module to now require <span class="blob-code-inner"> <span class="pl-s"> <span class="pl-s"> `ez-` <span class="x x-first x-last"> `templatebasedview` instead of `ez-view` so that `Y.eZConf.ListView` can inherit from `Y.eZ.TemplateBasedView` instead of `Y.eZ.View.` </span> </span> </span> </span> Once that is in place, the rendering logic can be changed to use the template:

``` brush:
YUI.add('ezconf-listview', function (Y) {
    Y.namespace('eZConf');

    Y.eZConf.ListView = Y.Base.create('ezconfListView', Y.eZ.TemplateBasedView, [], { // Y.eZ.TemplateBasedView now!
        initializer: function () {
            console.log("Hey, I'm the list view");
        },

        render: function () {
            // when extending Y.eZ.TemplateBasedView
            // this.template is the result of the template
            // compilation, it's a function. You can pass an object
            // in parameters and each property will be available in the template
            // as a variable named after the property.
            this.get('container').setHTML(
                this.template({
                    "name": "listView"
                })
            );
            this.get('container').setStyles({
                background: '#fff',
                fontSize: '200%',
            });
            return this;
        },
    });
});
```

And the last part of the chain is the Handlebars template file itself:

**ezconflistview.hbt**

``` brush:
<h1 class="ezconf-list-title">List view</h1>

Hey, I'm the {{ name }} and I'm rendered with the template!
```

At this point, `/ez#/ezconf/list` should display the <span class="blob-code-inner"> <span class="pl-s"> <span class="pl-s"> <span class="x x-first x-last"> `Y.eZConf.ListView` </span> </span> </span> </span> rendered with the template.

### Adding a CSS

We've just moved the markup logic from the view component to a template file. It is also time to do the same for the CSS styles that are still in the `render` method. For that, a CSS file can be created on the disk to replace the inline styles:

**list.css**

``` brush:
.ez-view-ezconflistview {
    background: #fff;
}

.ez-view-ezconflistview .ezconf-list-title {
    margin-top: 0;
}
```

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
By default, a view container element has an auto-generated class built from the internal view name.

**Good practice:** using that auto-generated class to write the CSS rule greatly limits the risk of side effects when styling a view.

 

Then this file has to be listed in the extension bundle `css.yml` configuration file:

**css.yml**

``` brush:
system:
    default:
        css:
            files:
                - %extending_platformui.css_dir%/views/list.css
```

After this is done, a custom view is now used when reaching `/ez#/ezconf/list` and the UI is now styled with a custom external stylesheet.

Results and next step:

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
The resulting code can be seen in <a href="https://github.com/ezsystems/ExtendingPlatformUIConferenceBundle/tree/4_view">the 4_view tag on GitHub</a>, this step result can also be viewed as <a href="https://github.com/ezsystems/ExtendingPlatformUIConferenceBundle/compare/3_routing...4_view">a diff between tags <code>3_routing</code> and <code>4_view</code></a>.

The next step is then [to configure the navigation](Configure-the-navigation_31430245.html) so that user can easily reach the new page.

**Tutorial path**






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>

 Developer : Design 



# Introduction

This page covers design in eZ Platform in a general aspect. If you want to learn about how to display content and build your content templates, you might want to check [Content Rendering](Content-Rendering_31429679.html).

To apply a template to any part of your webpage, you need three (optionally four) elements:

1.  An entry in the configuration that defines which template should be used in what situation
2.  The template file itself
3.  Assets used by the template (for example, CSS or JS files, images, etc.)
4.  (optional) A custom controller used when the template is read which allows you more detailed control over the page.

# Configuration

Each template must be mentioned in a configuration file together with a definition of the situation in which it is used. You can use the `ezplatform.yml` file located in the `app/config/` folder, or create your own separate configuration file in that folder that will list all your templates.

<span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"></span>
If you decide to create a new configuration file, you will need to import it by including an import statement in `ezplatform.yml`. Add the following code at the beginning of `ezplatform.yml`:

``` brush:
imports:
    - { resource: <your_file_name>.yml }
```

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
If you are using the recommended .yml files for configuration, here are the basic rules for this format:

The configuration is based on pairs of a key and its value, separated by a colon, presented in the following form: key: value. The value of the key may contain further keys, with their values containing further keys, and so on. This hierarchy is marked using indentation – each level lower in the hierarchy must be indented in comparison with its parent.

A short configuration file can look like this:

**Sample configuration file**

``` brush:
ezpublish:
    system:
        default:
            user:
                layout: pagelayout.html.twig
            content_view:
                full:
                    article:
                        template: full\article.html.twig
                        match:
                            Identifier\ContentType: [article]
                    blog_post:
                        controller: app.controller.blog:showBlogPostAction
                        template: full\blog_post.html.twig
                        match:
                            Identifier\ContentType: [blog_post]
                line:
                    article:
                        template: line\article.html.twig
                        match:
                            Identifier\ContentType: [article]
```

This is what individual keys in the configuration mean:

-   **`ezpublish`** and **`system`** are obligatory at the start of any configuration file which defines views.
-   **`default`** defines the siteaccess for which the configuration will be used. "default", as the name suggests, determines what views are used when no other configuration is chosen. You can also have separate keys defining views for other siteaccesses.
-   **`user`** and **`layout`** point to the main template file that is used in any situation where no other template is defined. All other templates extend this one. See [below](#Design-pagelayout)for more information.
-   **`content_view`** defines the view provider.

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
In earlier versions of eZ CMS, `location_view` was used as the view provider. It is now deprecated.

-   **`full`** and **`line`** determine the kind of view to be used (see below).
-   **`article`** and **`blog_post`** are the keys that start the configuration for one individual case of using a template. You can name these keys any way you want, and you can have as many of them as you need.
-   **`template`** names the template to be used in this case, including the folder it is stored in (starting from `app/Resources/views`).
-   **`controller`** defines the controller to be used in this case. Optional, if this key is absent, the default controller is used.
-   **`match`** defines the situation in which the template will be used. There are different criteria which can be used to "match" a template to a situation, for example a Content Type, a specific Location ID, Section, etc. You can view the full list of matchers here: <span class="confluence-link"> [View provider configuration](Content-Rendering_31429679.html#ContentRendering-Viewproviderconfiguration) </span>. You can specify more than one matcher for any template; the matchers will be linked with an AND operator.

 

In the example above, three different templates are mentioned, two to be used in full view, and one in line view. Notice that two separate templates are defined for the "article" Content Type. They use the same matcher, but will be used in different situations – one when an Article is displayed in full view, and one in line view. Their templates are located in different folders. The line template will also make use of a custom controller, while the remaining cases will employ the default one.

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
#### Full, line and other views

Each Content item can be rendered differently, using different templates, depending on the type of view it is displayed in. The default, built-in views are **full** (used when the Content item is displayed by itself, as a full page), **line** (used when it is displayed as an item in the list, for example a listing of contents of a folder), and **embed** (used when one Content item is embedded in another). Other, custom view types can be created, but only these three have built-in controllers in the system.

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
See <span class="confluence-link"> [View provider configuration](Content-Rendering_31429679.html#ContentRendering-Viewproviderconfiguration) </span> for more details.

## Template file

Templates in eZ Platform are written in the Twig templating language.

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
#### Twig templates in short

At its core, a Twig template is an HTML frame of the page that will be displayed. Inside this frame you define places (and manners) in which different parts of your Content items will be displayed (rendered).

Most of a Twig template file can look like an ordinary HTML file. This is also where you can define places where Content items or their fields will be embedded.

 

The configuration described above lets you select one template to be used in a given situation, but this does not mean you are limited to only one file per case. It is possible to include other templates in the main template file. For example, you can have a single template for the footer of a page and include it in many other templates. Such templates do not need to be mentioned in the configuration .yml file.

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
See <a href="http://symfony.com/doc/current/book/templating.html#including-templates">Including Templates</a> in Symfony documentation for more information on including templates.

 

<span id="Design-pagelayout" class="confluence-anchor-link"></span>The main template for your webpage (defined per siteaccess) is placed in the `pagelayout.html.twig` file. This template will be used by default for those parts of the website where no other templates are defined.

A `pagelayout.html.twig` file exists already in Demo Bundles, but if you are using a clean installation, you need to create it from scratch. This file is typically located in a bundle, for example using the built-in AppBundle: `src/AppBundle/Resources/views`.<span> The name of the bundle must the added whenever the file is called, like in the example below.</span>

Any further templates will extend and modify this one, so they need to start with a line like this:

``` brush:
{% extends "AppBundle::pagelayout.html.twig" %}
```

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
Although using AppBundle is recommended, you could also place the template files directly in `<installation_folder>/app                 /`Resources/views . Then the files could <span class="confluence-link">be referenced in code without any prefix. See [Best Practices](Best-Practices_31429687.html) for more information.
</span>

Template paths

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
In short, the `Resources/views` part of the path is automatically added whenever a template file is referenced. What you need to provide is the bundle name, name of any subfolder within `/views/`, and file name, all three separated by colons (:)

To find out more about the way of referencing template files placed in bundles, see <a href="http://symfony.com/doc/current/book/templating.html#referencing-templates-in-a-bundle">Referencing Templates in a Bundle</a> in Symfony documentation.

Templates can be extended using a Twig <a href="http://twig.sensiolabs.org/doc/functions/block.html"><code>block</code></a>tag. This tag lets you define a named section in the template that will be filled in by the child template. For example, you can define a "title" block in the main template. Any child template that extends it can also contain a "title" block. In this case the contents of the block from the child template will be placed inside this block in the parent template (and override what was inside this block):

**pagelayout.html.twig**

``` brush:
{# ... #}
    <body>
        {% block title %}
            <h1>Default title</h1>
        {% endblock %}
    </body>
{# ... #}
```

**child.html.twig**

``` brush:
{% extends "AppBundle::pagelayout.html.twig" %}
{% block title %}
    <h1>Specific title</h1>
{% endblock %}
```

In the simplified example above, when the `child.html.twig` template is used, the "title" block from it will be placed in and will override the "title" block from the main template – so "Specific title" will be displayed instead of "Default title."

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
Alternatively, you can place templates inside one another using the <a href="http://twig.sensiolabs.org/doc/functions/include.html"><code>include</code></a>function.

See <a href="http://twig.sensiolabs.org/doc/templates.html">http://twig.sensiolabs.org/doc/templates.html#</a> for detailed documentation on how to use Twig.

#### Embed content in templates

Now that you know how to create a general layout with Twig templates, let's take a look at the ways in which you can render content inside them.

There are several ways of placing Content items or their Fields inside a template. You can do it using one of the <span class="confluence-link"> <span class="confluence-link"> [Twig functions described in detail here](Content-Rendering_31429679.html#ContentRendering-Reference) </span> </span>.

As an example, let's look at one of those functions: **[ez\_render\_field](ez_render_field_32114041.html)** . It renders one selected Field of the Content item. In its simplest form this function can look like this:

``` brush:
{{ ez_render_field( content, 'description' ) }}
```

This renders the value of the Field with identifier "description" of the current Content item (signified by "content"). You can additionally choose a special template to be used for this particular Field:

``` brush:
{{ ez_render_field( 
       content, 
       'description',
       { 'template': 'AppBundle:fields:description.html.twig' }
   ) }}
```

<span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"></span>
As you can see in the case above, templates can be created not only for whole pages, but also for individual Fields.

Another way of embedding Content items is using the **render\_esi** function (which is not an eZ-specific function, but a Symfony standard). This function lets you easily select a different Content item and embed it in the current page. This can be used, for instance, if you want to list the children of a Content item in its parent.

``` brush:
{{ render_esi(controller('ez_content:viewAction', {locationId: 33, viewType: 'line'} )) }}
```

This example renders the Content item with Location ID 33 using the line view. To do this, the function applies the 'ez\_content:viewAction' controller. This is the default controller for rendering content, but can be substituted here with any custom controller of your choice.

### Assets

Asset files such as CSS stylesheets, JS scripts or image files can be defined in the templates and need to be included in the directory structure in the same way as with any other web project. Assets are placed in the `web/` folder in your installation.

Instead of linking to stylesheets or embedding images like usually, you can use the <a href="http://symfony.com/doc/current/book/templating.html#linking-to-assets"><code>asset</code></a>function.

### Controller

While it is absolutely possible to template a whole website using only Twig, a custom PHP controller gives many more options of customizing the behavior of the pages.

See [Custom controllers](Content-Rendering_31429679.html#ContentRendering-Customcontrollers) for more information.

# Usage

## Creating a new design using Bundle Inheritance

Due to the fact that eZ Platform is built using the Symfony 2 framework, it is possible to benefit from most of its stock features such as Bundle Inheritance. To learn more about this concept in general, check out the <a href="http://symfony.com/doc/current/cookbook/bundles/override.html">related Symfony documentation</a>.

Bundle Inheritance allows you to customize a template from a parent bundle. This is very convenient when creating a custom design for an already existing piece of code.

The following example shows how to create a customized version of a template from the DemoBundle.

### Creating a bundle

Create a new bundle to host your design using the dedicated command (from your app installation):

``` brush:
php app/console generate:bundle
```

### Configuring bundle to inherit from another

Following the related <a href="http://symfony.com/doc/current/cookbook/bundles/inheritance.html">Symfony documentation</a>, modify your bundle to make it inherit from the "eZDemoBundle". Then copy a template from the DemoBundle in the new bundle, following the same directory structure. Customize this template, clear application caches and reload the page. You custom design should be available.

### Known limitation

If you are experiencing problems with routes not working after adding your bundle, take a look at <a href="https://jira.ez.no/browse/EZP-23575">this issue</a>.

# Reference

## Twig Helper

eZ Platform comes with a Twig helper as a <a href="http://symfony.com/doc/master/cookbook/templating/global_variables.html">global variable</a> named **`ezpublish`** .

This helper is accessible from all Twig templates and allows you to easily retrieve useful information.

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th align="left">Property</th>
<th align="left">Description</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td align="left"><code>ezpublish.siteaccess</code></td>
<td align="left"><p>Returns the current siteaccess.</p></td>
</tr>
<tr class="even">
<td align="left"><code>                 ezpublish.rootLocation               </code></td>
<td align="left">Returns the root Location object</td>
</tr>
<tr class="odd">
<td align="left"><code>ezpublish.requestedUriString</code></td>
<td align="left">Returns the requested URI string (also known as semanticPathInfo).</td>
</tr>
<tr class="even">
<td align="left"><code>ezpublish.systemUriString</code></td>
<td align="left">Returns the &quot;system&quot; URI string. System URI is the URI for internal content controller. If current route is not an URLAlias, then the current Pathinfo is returned.</td>
</tr>
<tr class="odd">
<td align="left"><code>ezpublish.viewParameters</code></td>
<td align="left">Returns the view parameters as a hash.</td>
</tr>
<tr class="even">
<td align="left"><code>ezpublish.viewParametersString</code></td>
<td align="left">Returns the view parameters as a string.</td>
</tr>
<tr class="odd">
<td align="left"><code>ezpublish.legacy</code></td>
<td align="left">Returns legacy information.</td>
</tr>
<tr class="even">
<td align="left"><code>ezpublish.translationSiteAccess</code></td>
<td align="left">Returns the translation SiteAccess for a given language, or null if it cannot be found.</td>
</tr>
<tr class="odd">
<td align="left"><code>ezpublish.availableLanguages</code></td>
<td align="left">Returns the list of available languages.</td>
</tr>
<tr class="even">
<td align="left"><code> ezpublish.configResolver</code></td>
<td align="left">Returns the config resolver.</td>
</tr>
</tbody>
</table>

### Legacy

<span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"></span>
`ezpublish.legacy` is only available **when viewing content in legacy fallback** (e.g. no corresponding Twig templates)

The `ezpublish.legacy` property returns an object of type <a href="http://api.symfony.com/2.8/Symfony/Component/HttpFoundation/ParameterBag.html">ParameterBag</a>, which is a container for key/value pairs, and contains additional properties to retrieve/handle legacy information.

| Property                                                | Description                                                     |
|---------------------------------------------------------|-----------------------------------------------------------------|
| `                 ezpublish.legacy.all               `  | Returns all the parameters, with all the contained information. |
| `                 ezpublish.legacy.keys               ` | Returns the parameter keys only.                                |
| `                 ezpublish.legacy.get               `  | Returns a parameter by name.                                    |
| `                 ezpublish.legacy.has               `  | Returns true if the parameter is defined.                       |

## Listing the available parameters

You can list the available parameters in `ezpublish.legacy` by using the `ezpublish.legacy.keys` property, as shown in the following example:

**Example on retrieving the available parameters under ezpublish.legacy**

``` brush:
{{ dump(ezpublish.legacy.keys()) }}
```

which will give a result similar to:

    array
      0 => string 'view_parameters' (length=15)
      1 => string 'path' (length=4)
      2 => string 'title_path' (length=10)
      3 => string 'section_id' (length=10)
      4 => string 'node_id' (length=7)
      5 => string 'navigation_part' (length=15)
      6 => string 'content_info' (length=12)
      7 => string 'template_list' (length=13)
      8 => string 'cache_ttl' (length=9)
      9 => string 'is_default_navigation_part' (length=26)
      10 => string 'css_files' (length=9)
      11 => string 'js_files' (length=8)
      12 => string 'css_files_configured' (length=20)
      13 => string 'js_files_configured' (length=19)

## Retrieving legacy information

Legacy information is accessible by using the `ezpublish.legacy.get` property, which will allow you to access all data contained in <a href="http://doc.ez.no/eZ-Publish/Technical-manual/4.x/Templates/The-pagelayout/Variables-in-pagelayout#module_result">$module_result</a>, from the legacy kernel.

This allows you to import information directly into twig templates. For more details please check the available examples on using the `ezpublish.legacy.get` property for retrieving <a href="https://confluence.ez.no/display/EZP/Legacy+template+fallback#Legacytemplatefallback-Persistentvariable">persistent variables</a> and <a href="https://confluence.ez.no/display/EZP/Legacy+template+fallback#Legacytemplatefallback-Assets">assets</a>.

As a usage example, if you want to access the legacy information related to 'content\_info' you can do it, as shown in the following example:

**Example on accessing 'content\_info' under ezpublish.legacy**

``` brush:
{{ ezpublish.legacy.get('content_info') }}
```

The previous call will return the contents on the 'content\_info' as an `array`, and if we `dump` it the result will be similar to the following:

    array
      'object_id' => string '57' (length=2)
      'node_id' => string '2' (length=1)
      'parent_node_id' => string '1' (length=1)
      'class_id' => string '23' (length=2)
      'class_identifier' => string 'landing_page' (length=12)
      'remote_id' => string '8a9c9c761004866fb458d89910f52bee' (length=32)
      'node_remote_id' => string 'f3e90596361e31d496d4026eb624c983' (length=32)
      'offset' => boolean false
      'viewmode' => string 'full' (length=4)
      'navigation_part_identifier' => string 'ezcontentnavigationpart' (length=23)
      'node_depth' => string '1' (length=1)
      'url_alias' => string '' (length=0)
      'current_language' => string 'eng-GB' (length=6)
      'language_mask' => string '3' (length=1)
      'main_node_id' => string '2' (length=1)
      'main_node_url_alias' => boolean false
      'persistent_variable' => 
        array
          'css_files' => 
            array
              0 => string 'video.css' (length=9)
          'js_files' => 
            array
              0 => string 'video.js' (length=8)
      'class_group' => boolean false
      'state' => 
        array
          2 => string '1' (length=1)
      'state_identifier' => 
        array
          0 => string 'ez_lock/not_locked' (length=18)
      'parent_class_id' => string '1' (length=1)
      'parent_class_identifier' => string 'folder' (length=6)
      'parent_node_remote_id' => string '629709ba256fe317c3ddcee35453a96a' (length=32)
      'parent_object_remote_id' => string 'e5c9db64baadb82ab8db54f0e2192ec3' (length=32)

Additionally, for retrieving information contained in 'content\_info' such as the current language of the content in the page you can do it like in the following example:

**Example on retrieving 'current\_language'**

``` brush:
{{ ezpublish.legacy.get('content_info')['current_language'] }}
```

#### In this topic:

-   [Introduction](#Design-Introduction)
-   [Configuration](#Design-Configuration)
    -   [Template file](#Design-Templatefile)
        -   [Assets](#Design-Assets)
        -   [Controller](#Design-Controller)
-   [Usage](#Design-Usage)
    -   [Creating a new design using Bundle Inheritance](#Design-CreatinganewdesignusingBundleInheritance)
        -   [Creating a bundle](#Design-Creatingabundle)
        -   [Configuring bundle to inherit from another](#Design-Configuringbundletoinheritfromanother)
        -   [Known limitation](#Design-Knownlimitation)
-   [Reference](#Design-Reference)
    -   [Twig Helper](#Design-TwigHelper)
        -   [Legacy](#Design-Legacy)
    -   [Listing the available parameters](#Design-Listingtheavailableparameters)
    -   [Retrieving legacy information](#Design-Retrievinglegacyinformation)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Community Resources](Community-Resources_31429530.html)</span>
4.  <span>[How to Contribute](How-to-Contribute_31429587.html)</span>

 Developer : Development guidelines 



These are the development/coding guidelines for eZ Platform kernel, they are the same if you intend to write Bundles, hack on eZ Platform itself or create new functionality for or on top of eZ Platform.

Like most <span>development</span> guidelines these aims to improve security, maintainability, performance and readability of our software. They follow industry standards but sometimes extend them to cater specifically to our needs for eZ Platform ecosystem. The next sections will cover all relevant technologies from a high level point of view.

 

## HTTP

eZ Platform is a web software that is reached via HTTP in most cases, out of the box in eZ Platform kernel this is specifically: web (usually HTML) or REST.

We aim to follow the <a href="http://trac.tools.ietf.org/wg/httpbis/trac/wiki#HTTP1.1Deliverables">latest</a> stable HTTP specification, and industry best practice:

-   **Expose our data in a RESTful way**
    -   GET, HEAD, OPTIONS & TRACE methods are <a href="http://tools.ietf.org/html/draft-ietf-httpbis-p2-semantics-21#section-5.2.1">safe</a> (otherwise known as <a href="http://en.wiktionary.org/wiki/nullipotent">nullipotent</a>), as in: should never cause changes to resources (note: things like writing a line in a log file are not considered resource changes)
    -   PUT & DELETE methods are <a href="http://tools.ietf.org/html/draft-ietf-httpbis-p2-semantics-21#section-5.2.2">idempotent</a>, as in multiple identical requests should all have the same result as a single request
    -   GET & HEAD methods should be <a href="http://tools.ietf.org/html/draft-ietf-httpbis-p2-semantics-21#section-5.2.3">cacheable</a> both on client side, server-side and proxies between, as further defined in the HTTP <a href="http://tools.ietf.org/html/draft-ietf-httpbis-p6-cache-21">specification</a>
    -   As PUT is for replacing a resource, we should use <a href="http://tools.ietf.org/html/rfc5789">PATCH</a> in cases where only partial replacement is intended
-   **Authenticated traffic**
    -   Should use HTTPS
-   **Session based traffic**
    -   Should follow recommendations for *Authenticated traffic*
    -   Should use a per user session <a href="http://en.wikipedia.org/wiki/Cross-site_request_forgery">CSRF</a> token on all requests using un-safe HTTP methods (POST, PUT, DELETE, PATCH, ...)
    -   Should expire session id, session data and CSRF token on login, logout and session time out, except:
        -   On login session data from previous session id is moved to new session id, keeping for instance shopping basket on login
    -   Should avoid timing attacks by using a random amount of time for login operation
    -   Should never use Session id in URI's. And this feature ("SID") must always be disabled on production servers
-   **Sessions**
    -   Should not be used to store large amounts of data; store data in database and id's in session if needed
    -   Should not store critical data: if user deletes his cookies or closes his browser session data is lost
    -   Should use an ID generated with enough randomness to prevent prediction or brute-force attacks
-   **Cookies (especially session cookies)**
    -   Should never store sensitive data in cookies (only exception is session id in session cookie)
    -   Should always set *Full domain* to avoid <a href="http://en.wikipedia.org/wiki/Session_fixation#Attacks_using_cross-subdomain_cooking">cross-subdomain cooking</a> when on shared domain.
    -   Should set *HttpOnly* flag to reduce risk of attacks such as <a href="http://en.wikipedia.org/wiki/Session_fixation#Attacks_using_cross-site_cooking">cross-site cooking</a> and <a href="http://en.wikipedia.org/wiki/Cross-site_scripting" title="Cross-site scripting">cross-site scripting</a>
    -   Should set *Secure flag* if HTTPS is used (as recommended above)
    -   Must never exceed 4kb
-   **Headers**
    -   Should never include input data from user input or data from database without sanitizing it
-   **Redirects**
    -   Should never take url from user input (example: POST parameter), instead allow identifiers instead that are understood by the backend
-   **User input**
    -   Should always be validated, sanitized, casted and filtered to avoid <a href="http://en.wikipedia.org/wiki/Cross-site_scripting">XSS</a> & <a href="http://en.wikipedia.org/wiki/Clickjacking">c<span style="color: rgb(0,0,0);">lickjacking</span></a><span style="color: rgb(0,0,0);"> </span> attacks
        -   NB: this includes variables in the php supervariable `$_SERVER` as well (e.g. hostname should not be trusted)
-   **User file uploads**
    -   Should follow recommendations for "User input" to validate file name
    -   Should place uploaded files in a non public folder to avoid access to execute uploaded file or in case of assets white list the type
    -   Should be appropriately limited in size to avoid DOS attacks on disk space, cpu usage by antivirus tool etc...
-   **File downloads**
    -   Should not rely on user provided file path for non public files, instead use a synthetic id
-   **Admin operations**
    -   May be placed on a different (sub)domain then the front end website to avoid session stealing across front and backend.
-   **Fully support being placed behind a reverse proxy like <a href="https://www.varnish-cache.org/">Varnish</a>**

## REST

For now see the living <a href="https://github.com/ezsystems/ezp-next/blob/master/doc/specifications/rest/REST-API-V2.rst">REST v2 specification</a> in our git repository for further details.

## UI

eZ Platform is often used as a web content management software, so we always strive to use the HTML/CSS/EcmaScript specifications correctly, and keep new releases up to date on new revisions of those. We furthermore always try to make sure our software gracefully degrades making sure it is useful even on older or less capable web clients (browsers), the industry terms for this approach are:

-   <a href="http://en.wikipedia.org/wiki/Progressive_enhancement" title="Progressive enhancement">Progressive enhancement</a>
-   <a href="http://en.wikipedia.org/wiki/Unobtrusive_JavaScript">Unobtrusive JavaScript</a>
-   <a href="http://en.wikipedia.org/wiki/Responsive_Web_Design" title="Responsive Web Design">Responsive Design</a>

All these terms in general recommends aiming for the minimum standard first, and enhance with additional features/styling if the client is capable of doing so. In essence this allows eZ Platform to be "Mobile first" if the design allows for it, which is recommended. But eZ Platform should always also be fully capable of having different sets of web presentations for different devices using one or several sets of SiteAccess matching rules for the domain, port or URI, so any kind of device detection can be used together with eZ Platform, making it fully possible to write for instance <a href="http://en.wikipedia.org/wiki/Wireless_Application_Protocol">WAP</a> based websites and interfaces on top of eZ Platform.

### WEB Forms/Ajax

As stated in the HTTP section, all unsafe requests to the web server should have a CSRF token to protect against attacks; this includes web forms and ajax requests that don't use the GET http method. As also stated in the HTTP section and further defined in the PHP section, User input should always be validated to avoid XSS issues.

### HTML/Templates

All data that comes from backend and in return comes from user input should always be escaped, in case of Twig templates this done by default, but in case of PHP templates, Ajax and other not Twig based output this must be handled manually.

Output escaping must be properly executed according to the desired format, eg. javascript vs. html, but also taking into account the correct character set (see eg. output escaping fallacy when not specifying charset encoding in <a href="http://www.php.net/htmlspecialchars">htmlspecialchars</a>)

### Admin

Admin operations that can have a severe impact on the web applications should require providing password and require it again after some time has gone, normally 10 - 20 minutes, on all session based interfaces.

&lt;TODO: Add more coding guidelines for HTML (XHTML5), Javascript, CSS and templates&gt;

## PHP

For now see our comprehensive coding standard & guidelines <a href="https://github.com/ezsystems/ezpublish-kernel/wiki/codingstandards">wiki page</a> on github.

eZ Coding Standards Tools

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
See also <a href="http://eZ%20Coding%20Standard%20tools">eZ Coding Standards Tools</a> repository to get the configuration files for your favorite tools.

### Public API

The PHP Public API provided in eZ Platform is in most cases in charge of checking permissions to data for you, but some API's are not documented to throw UnauthorizedException, which means that it is the consumer of the API's who is responsible for checking permissions.

The following example shows how this is done in the case of loading users:

**loadUser()**

``` brush:
// Get a user
$userId = (int)$params['id'];
$userService = $repository->getUserService();
$user = $userService->loadUser( $userId );

// Now check that current user has access to read this user
if ( !$repository->canUser( 'content', 'read', $user ) )
{
    // Generates message: User does not have access to 'content' 'read' with id '10'
    throw new \eZ\Publish\Core\Base\Exceptions\UnauthorizedException( 'content', 'read', array( 'id' => $userId ) );
}
```

### Command line

Output must always be escaped when displaying data from the database.

*&lt;TODO: Expand on how best practice is to handle user input in eZ Platform to avoid XSS issues&gt;*

## Data & Databases

-   Values coming from variables should always be appropriately quoted or binded in SQL statements
-   The SQL statements used should never be created by hand with one version per supported database, as this increases both the maintenance load and the chances for security-related problems
-   Usage of temporary tables is discouraged, as their behaviour is very different on different databases. Subselects should be prefererred (esp. since recent mysql versions have much better support for them)
-   Full table locking is discouraged

*&lt;TODO: guidelines for how data should be stored for maximum portability (hint: XML & abstraction)&gt;*

### Sessions

-   Business logic should not depend on database connections being either persistent or not persistent
-   The connection to the database should always be opened as late as possible during page execution. Ideally, to improve scalability, a web page executing no queries should not connect to the db at all (note that closing the db connection as soon as possible is a tricky problem, as we expect to support persistent db connections as well for absolute best performances)
-   The same principle applies to configurations where a master/slave db setup is in use: the chance for a failure due to a database malfunction should not increase with the number of db servers at play, but actually decrease
-   It is recommended to avoid as much as possible statements which alter the current session, as they slow down the application, are brittle and hard to debug.
    Point in case; if a db session locks a table then is abruptly terminated, the table might stay locked for a long time

### Transactions

-   Transactions should always be used to wrap sql statements which affect data in multiple tables: either all data changes go through or none of them
-   Transactions are prone to locking issues, so the code executed within a transaction should be limited to the minimum necessary amount (ex. clearing caches should be done after the transaction is committed)
-   When using transactions, always consider side effects on external system, such as on-disk storage. F.e. is a transaction relative to creating an image variation is rolled back, the corresponding file should not be left on disk
-   Nested transactions are supported in the following way:
    -   a transaction within another one will not commit when requested, only the outhermost transaction will commit
    -   a transaction within another one will roll back all the way to the start of the outhermost transaction when requested
    -   as a result a transaction shall never be rolled back just as a means of cancelling its work - the side effect might be of cancelling other work which had just been done previously

### Limitations in the SQL dialect supported

Striving to support Mysql 5, PostgreSQL xx and Oracle 10, the following limitations apply:

-   Tables, columns and other db objects should not use names longer than 30 chars
-   Varchar columns with a definition of *default "" not null* are discouraged
-   For SELECTs, offset and limit have to be handled by the php layer, not hardcoded in the sql
-   Never treat a NULL varchar value as semantically different from an empty string value
-   The select list of a query cannot contain the same field multiple times
-   For GROUP BY statements, all fields in the group by clause should be in the select list as well
-   For SELECTs, usage of the AS token is allowed in the select list, but not in the list of tables
-   Do not put quotes around numeric values (use proper casting/escaping to avoid SQL injection)
-   *&lt;TODO: finish sql guidelines&gt;*

 

#### In this topic:

-   [HTTP](#Developmentguidelines-HTTP)
-   [REST](#Developmentguidelines-REST)
-   [UI](#Developmentguidelines-UI)
    -   [WEB Forms/Ajax](#Developmentguidelines-WEBForms/Ajax)
    -   [HTML/Templates](#Developmentguidelines-HTML/Templates)
    -   [Admin](#Developmentguidelines-Admin)
-   [PHP](#Developmentguidelines-PHP)
    -   [Public API](#Developmentguidelines-PublicAPI)
    -   [Command line](#Developmentguidelines-Commandline)
-   [Data & Databases](#Developmentguidelines-Data&Databases)
    -   [Sessions](#Developmentguidelines-Sessions)
    -   [Transactions](#Developmentguidelines-Transactions)
    -   [Limitations in the SQL dialect supported](#Developmentguidelines-LimitationsintheSQLdialectsupported)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>

 Developer : Devops 



# Introduction

## Cache Clearing

This page describes commands involved in clearing cache from the command line.

### Clearing file cache using the Symfony cache:clear command

Out of the box Symfony provides a command to perform cache clearing. It will delete all file-based caches, which mainly consist of Twig template, Symfony container, and Symfony route cache, but also everything else stored in cache folder. Out of the box on a single-server setup this includes "Content cache". For further information on use, see the help text of the command:

``` brush:
php app/console --env=prod cache:clear -h
```

<span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"></span>
If you do not specify an environment, by default `cache:clear` will clear the cache for the `dev` environment. If you want to clear it for `prod` you need to to use the --env=prod option.

On each web server

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
In [Clustering](Clustering_31430387.html) setup *(several web servers),* the command to clear file cache needs to be executed on each and every web server!

### Clearing "Content Cache" on a Cluster setup

For [Cluster](Clustering_31430387.html) setup, the content cache ([<span class="confluence-link">HTTP Cache</span>](HTTP-Cache_31430152.html) <span class="confluence-link"> </span> and [Persistent Cache](Repository_31432023.html#Repository-PersistenceCache)) must be set up to be shared among the servers. And while all relevant cache is cleared for you on repository changes when using the APIs, there might be times where you'll need to clear cache manually: 

-   Varnish: [Cache purge](https://doc.ez.no/display/DEVELOPER/HTTP+Cache#HTTPCache-CachePurge)
-   Persistence Cache: [Using Cache service](Repository_31432023.html#Repository-UsingCacheService)

## Web Debug Toolbar

When running eZ Platform in the `dev` environment you have access to the standard Symfony Web Debug Toolbar. It is extended with some eZ Platform-specific information:

<span class="confluence-embedded-file-wrapper"><img src="attachments/31432029/32868731.png" title="eZ Platform info in Web Debug Toolbar" alt="eZ Platform info in Web Debug Toolbar" class="confluence-embedded-image" /></span>

#### SPI (persistence)

This section provides the number of non-cached [SPI](Repository_31432023.html#Repository-SPI)calls and handlers. You can see details of these calls in the <a href="http://symfony.com/doc/current/profiler.html">Symfony Profiler</a> page.

#### Site Access

Here you can see the name of the current Siteaccess and how it was matched. For reference see the [list of possible siteaccess matchers](SiteAccess_31429665.html#SiteAccess-Availablematchers).

# Configuration

## Logging and Debug Configuration

### Introduction

Logging in eZ Platform consists of two parts, several debug systems that integrates with symfony developer toolbar to give you detailed information about what is going on. And standard <a href="https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md">PSR-3</a> logger, as provided by Symfony using <a href="https://github.com/Seldaek/monolog">Monolog</a>.

### Debugging in dev environment

When using the Symfony dev [<span class="confluence-link">environment</span>](Environments_31429669.html), the system out of the box tracks additional metrics for you to be able to debug issues, this includes <a href="http://stash.tedivm.com/">Stash</a> cache use *(done by <a href="https://github.com/tedivm/TedivmStashBundle">StashBundle</a>)*, and a [persistence cache](Repository_31432023.html#Repository-Persistencecacheconfiguration) use.

#### Reducing memory use

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
For long running scripts, instead head over to [Executing long-running console commands](Executing-long-running-console-commands_31429811.html) for some much more relevant info.

If you are running out of memory and don't need to keep track of cache hits and misses. Then StashBundle tracking, represented by the `stash.tracking` setting, and persistence cache logging, represented by the setting `parameters.ezpublish.spi.persistence.cache.persistenceLogger.enableCallLogging`, can optionally be disabled.

 

**config\_dev.yml**

``` brush:
stash:
    tracking: false                  # Default is true in dev
    tracking_values: false           # Default is false in dev, to only track cache keys not values
    caches:
        default:
            inMemory: false          # Default is true
            registerDoctrineAdapter: false

parameters:
    ezpublish.spi.persistence.cache.persistenceLogger.enableCallLogging: false
```

### Error logging and rotation

eZ Platform uses the Monolog component to log errors, and it has a `RotatingFileHandler` that allows for file rotation.

According to their documentation, it "logs records to a file and creates one logfile per day. It will also delete files older than `$maxFiles`".

But then, their own recommendation is to use "`logrotate`" instead of doing the rotation in the handler as you would have better performance.

 

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
More details here:

-   <a href="https://github.com/Seldaek/monolog" class="uri">https://github.com/Seldaek/monolog</a>
-   <a href="http://linuxcommand.org/man_pages/logrotate8.html" class="uri">http://linuxcommand.org/man_pages/logrotate8.html</a>

 

If you decided to use Monolog's handler, it can be configured in `app/config/config.yml`

``` brush:
monolog:
    handlers:
        main:
            type: rotating_file
            max_files: 10
            path: "%kernel.logs_dir%/%kernel.environment%.log"
            level: debug
```

#### In this topic:

-   [Introduction](#Devops-Introduction)
    -   [Cache Clearing](#Devops-CacheClearing)
        -   [Clearing file cache using the Symfony cache:clear command](#Devops-ClearingfilecacheusingtheSymfonycache:clearcommand)
        -   [Clearing "Content Cache" on a Cluster setup](#Devops-Clearing%22ContentCache%22onaClustersetup)
    -   [Web Debug Toolbar](#Devops-WebDebugToolbar)
-   [Configuration](#Devops-Configuration)
    -   [Logging and Debug Configuration](#Devops-LoggingandDebugConfiguration)
        -   [Introduction](#Devops-Introduction.1)
        -   [Debugging in dev environment](#Devops-Debuggingindevenvironment)
        -   [Error logging and rotation](#Devops-Errorloggingandrotation)

## Attachments:

<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [webdebugtoolbar.png](attachments/31432029/32868731.png) (image/png)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Tutorials](Tutorials_31429522.html)</span>
4.  <span>[Building a Bicycle Route Tracker in eZ Platform](Building-a-Bicycle-Route-Tracker-in-eZ-Platform_31431606.html)</span>
5.  <span>[Part 1: Setting up eZ Platform](31431610.html)</span>
6.  <span>[Step 2 - Create your content model](Step-2---Create-your-content-model_31431844.html)</span>

 Developer : Diagram for step2 



<span id="diagramly-reader-32868750-2559151311003325400" class="drawio-viewer" style="position : relative; display : inline-block; max-width : 100%;"> <span id="diagramly-reader-content-32868750-2559151311003325400" class="diagramly-content" style="position : relative; display : inline-block"></span> </span>

## Attachments:

<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [Ride\_Point\_of\_interest\_relation](attachments/32868756/32868752) (application/drawio)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [Ride\_Point\_of\_interest\_relation.png](attachments/32868756/32868753.png) (image/png)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [Ride\_Point\_of\_interest\_relation](attachments/32868756/32868754) (application/drawio)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [Ride\_Point\_of\_interest\_relation.png](attachments/32868756/32868755.png) (image/png)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [Ride\_Point\_of\_interest\_relation](attachments/32868756/32868750) (application/drawio)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [Ride\_Point\_of\_interest\_relation.png](attachments/32868756/32868751.png) (image/png)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [Copy of Ride\_Point\_of\_interest\_relation](attachments/32868756/32868759) (application/drawio)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [Copy of Ride\_Point\_of\_interest\_relation.png](attachments/32868756/32868760.png) (image/png)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Cookbook](Cookbook_31429528.html)</span>

 Developer : Displaying children of a Content item 



# Description

One of the basic design tasks you may need to complete when creating your website is configuring one page to display all of its children. Examples are having a blog display blog posts, of a folder that shows <span class="inline-comment-marker" data-ref="77916aad-aa82-477b-b486-5ee37dce91c4">all articles it contains</span>.

# Solution

There are two ways to make a Content item display it<span class="inline-comment-marker" data-ref="fdef209c-770f-4509-8e54-32c81610e3c0">s childre</span>n:

1.  [Using a Custom Controller](#DisplayingchildrenofaContentitem-UsingaCustomController)
2.  [Using the Query Controller](#DisplayingchildrenofaContentitem-UsingtheQueryController)

This recipe will show how to use both those methods to display all children of a Content item with the Content Type Folder.

## Using a Custom Controller

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
There are three different ways of using a Custom Controller that you can learn about in the [Custom Controller page](https://doc.ez.no/display/DEVELOPER/Content+Rendering#ContentRendering-Customcontrollers). In this case we will be applying the first of these, that is using the Custom Controller alongside the built-in ViewController.

Configuring for the use of a C<span class="inline-comment-marker" data-ref="ea02127a-ca1a-499b-9218-ffff81810087">ustom Controller starts w</span>ith pointing to it in your standard view <span class="inline-comment-marker" data-ref="38edeeb0-0932-49ef-99b3-a33f0f662169">configuration</span> (which you can keep in `ezplatform.yml` or a separate file, for example `views.yml`):

``` brush:
folder:
    controller: app.controller.folder:showAction
    template: "full/folder.html.twig"
    match:
        Identifier\ContentType: "folder"
```

Besides the standard view config, under the `controller` key you need to provide here the path to the Controller and the action. They are defined in the following file:

**AppBundle/Controller/FolderController.php**

``` brush:
<?php

namespace AppBundle\Controller;

use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\LocationService;
use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;
use eZ\Publish\Core\MVC\ConfigResolverInterface;
use eZ\Publish\Core\MVC\Symfony\View\ContentView;
use AppBundle\Criteria\Children;

class FolderController {

    /** @var \eZ\Publish\API\Repository\SearchService */
    protected $searchService;

    /** @var \eZ\Publish\Core\MVC\ConfigResolverInterface */
    protected $configResolver;

    /** @var \AppBundle\Criteria\Children */
    protected $childrenCriteria;

    /**
     * @param \eZ\Publish\API\Repository\SearchService $searchService
     * @param \eZ\Publish\Core\MVC\ConfigResolverInterface $configResolver
     * @param \AppBundle\Criteria\Children $childrenCriteria
     */
    public function __construct(
        SearchService $searchService,
        ConfigResolverInterface $configResolver,
        Children $childrenCriteria
    ) {
        $this->searchService = $searchService;
        $this->configResolver = $configResolver;
        $this->childrenCriteria = $childrenCriteria;
    }

    /**
     * Displays blog posts and gallery images on home page.
     *
     * @param \eZ\Publish\Core\MVC\Symfony\View\ContentView $view
     *
     * @return \eZ\Publish\Core\MVC\Symfony\View\ContentView
     */
    public function showAction(ContentView $view)
    {
        $view->addParameters([
            //'content' => $this->contentService->loadContentByContentInfo($view->getLocation()->getContentInfo()),
            'items' => $this->fetchItems($view->getLocation(), 25),
        ]);
        return $view;
    }

    private function fetchItems($location, $limit)
    {
        $languages = $this->configResolver->getParameter('languages');
        $query = new Query();
        //$location = $this->locationService->loadLocation($locationId);

    $query->query = $this->childrenCriteria->generateChildCriterion($location, $languages);
        $query->performCount = false;
        $query->limit = $limit;
        $query->sortClauses = [
            new SortClause\DatePublished(Query::SORT_DESC),
        ];
        $results = $this->searchService->findContent($query);
        $items = [];
        foreach ($results->searchHits as $item) {
            $items[] = $item->valueObject;
        }
        return $items;
    }

}
```

As you can see, this Controller makes use of the `generateChildCriterion`, which means you need to provide a file containing this function:

**AppBundle/Criteria/Children.php**

``` brush:
<?php

namespace AppBundle\Criteria;

use eZ\Publish\API\Repository\Values\Content\Location;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;

class Children
{
    /**
     * Generate criterion list to be used to fetch sub-items.
     *
     * @param \eZ\Publish\API\Repository\Values\Content\Location $location location of the root
     * @param string[] $languages array of languages
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Query\Criterion
     */
    public function generateChildCriterion(Location $location, array $languages = [])
    {
        return new Criterion\LogicalAnd([
            new Criterion\Visibility(Criterion\Visibility::VISIBLE),
            new Criterion\ParentLocationId($location->id),
            new Criterion\Subtree($location->pathString),
            new Criterion\LanguageCode($languages),
        ]);
    }
}
```

Next, you must register these two services:

**AppBundle/Resources/config/services.yml**

``` brush:
services:

    app.criteria.children:
        class: AppBundle\Criteria\Children

    app.controller.folder:
        class: AppBundle\Controller\FolderController
        arguments:
            - '@ezpublish.api.service.search'
            - '@ezpublish.config.resolver'
            - '@app.criteria.children'
```

Finally, let's use the Controller in a template:

**app/Resources/views/full/folder.html.twig**

``` brush:
<h1>{{ ez_content_name(content) }}</h1>

{% for item in items %}
  <h2>{{ ez_content_name(item) }}</h2>
{% endfor %}
```

This template makes use of the `items` specified in the Controller file to list every child of the folder.

## Using the Query Controller

The Query Controller is a predefined custom content view Controller that runs a Repository Query.

If you need to create a simple query it's easier to use the Query Controller than to build a completely custom one, as you will not have to write custom PHP code. Like with a Custom Controller, however, you will be able to use properties of the viewed Content or Location as parameters.

The main file in this case is a `LocationChildrenQueryType.php` file which generates a Query that retrieves the children of the current Location.

**AppBundle/QueryType/LocationChildrenQueryType.php**

``` brush:
<?php
namespace AppBundle\QueryType;

use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\ParentLocationId;
use eZ\Publish\Core\QueryType\QueryType;

class LocationChildrenQueryType implements QueryType
{
    public function getQuery(array $parameters = [])
    {
        return new LocationQuery([
            'filter' => new ParentLocationId($parameters['parentLocationId']),
        ]);
    }

    public function getSupportedParameters()
    {
        return ['parentLocationId'];
    }
//
    public static function getName()
    //
        return 'LocationChildren';
    }
}
```

Next, in your standard view configuration file include a block that indicates when this Controller will be used. It is similar to regular view config, but contains additional information:

``` brush:
folder:
    controller: "ez_query:locationQueryAction"
    template: "full/folder.html.twig"
    match:
        Identifier\ContentType: "folder"
    params:
        query:
            query_type: 'LocationChildren'
            parameters:
                parentLocationId: "@=location.id"
            assign_results_to: 'items'
```

In this case the `controller` key points to the Query Controller's `locationQuery` action. `assign_results_to` identifies the parameter containing all the retrieved children that will later be used in the templates:

**app/Resources/views/full/folder.html.twig**

``` brush:
<h1>{{ ez_content_name(content) }}</h1>

{% for item in items.searchHits %}
  <h2>{{ ez_content_name(item.valueObject.contentInfo) }}</h2>
{% endfor %}
```

This template makes use of the `items` specified in `assign_results_to` to list every child of the folder.

#### In this topic:

-   [Description](#DisplayingchildrenofaContentitem-Description)
-   [Solution](#DisplayingchildrenofaContentitem-Solution)
    -   [Using a Custom Controller](#DisplayingchildrenofaContentitem-UsingaCustomController)
    -   [Using the Query Controller](#DisplayingchildrenofaContentitem-UsingtheQueryController)

#### Related topics:

[Custom Controller](https://doc.ez.no/display/DEVELOPER/Content+Rendering#ContentRendering-Customcontrollers)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Cookbook](Cookbook_31429528.html)</span>

 Developer : Displaying content with simple templates 



This page describes basic steps needed to render content on a page.

# Rendering a full page

By default (without any configuration), a Content item will be rendered without any template. In your config you can tell the app to render it using different templates depending on the situation. Templates are written in the Twig templating language.

Let's create a very simple template that you will use to render an article:

**article.html.twig**

``` brush:
<div>
    {# 'ez_render_field' is one of the available Twig functions.
    It will render the 'body' Field of the current 'content' #}
    {{ ez_render_field(content, 'body') }}
</div>
```

Place this file in the `app/Resources/views` folder.

Now you need a config that will decide when this template is used.

You can place the config in the `app/config` folder in either of two places: a separate file or the preexisting `ezplatform.yml`. In this case you'll use the latter.

In `ezplatform.yml` under the `ezpublish` and `system` keys add the following config (pay attention to indentation. `default` should be indented relative to `system`):

``` brush:
# 'default' is the siteaccess.
default:
    # 'content_view' indicates that we will be defining view configuration.
    content_view:
        # 'full' is the type of view to use. We'll talk about defining other view types below.
        full:
            # Here starts the entry for our view. You can give it any name you want, as long as it is unique.
            article:
                # This is the path to the template file, relative to the 'app/Resources/views' folder.
                template: full\article.html.twig
                # This identifies the situations when the template will be used.
                match:
                    # The template will be used when the Content Type of the content is 'article'.
                    Identifier\ContentType: [article]
```

In the `match` section you can use different ways to identify the situation where the template will be used, not only the Content Type, see [<span class="confluence-link">Matchers</span>](Content-Rendering_31429679.html#ContentRendering-Matchers).

At this point all Articles should render using the new template. If you do not see changes, clear the cache (`php app/console cache:clear`).

# Rendering page elements

In the example above you used the `ez_render_field` Twig function to render the 'body' Field of the content item. Of course each Content item can have multiple fields and you can render them in different ways in the template. Other Twig functions let you access other properties of your content. To see an example, let's extend the template a bit:

**article.html.twig**

``` brush:
{# This renders the Content name of the article #}
<h1>{{ ez_content_name(content) }}</h1>
<div>
    {# Here you add a rendering of a different Field, 'intro' #}
    <b>{{ ez_render_field(content, 'intro') }}</b>
</div>    
<div>
    {{ ez_render_field(content, 'body') }}
</div>
```

You can also make use of different other [Twig functions](Twig-Functions-Reference_32114025.html), for example [ez\_field\_value](ez_field_value_32114035.html), which renders the value of the Field without a template.

# Different views

Besides the `full` view type you can create many other view types. They can be used for example when rendering children of a folder of when embedding one Content item in another. See <span class="confluence-link"><span class="confluence-link"><span class="confluence-link"><span class="confluence-link">[Content Rendering](Content-Rendering_31429679.html#ContentRendering-Renderembeddedcontentitems)</span></span></span></span>.

# Listing children

To see how to list children of a Content item, for example all content contained in a folder, see [Displaying children of a Content item](Displaying-children-of-a-Content-item_32868706.html)

# Adding links

To add links to your templates you use the `ez_urlalias` path. To see how it works, let's add one more line to the template:

**article.html.twig**

``` brush:
<h1>{{ ez_content_name(content) }}</h1>
{# The link points to the content in Location ID 2, which is the Home Content item #}
<a href="{{ path('ez_urlalias', {locationId: 2}) }}">Back</a>
<div>
{# ... #}
```

Instead of pointing to a specific content by its Location ID you can of course also use here a variable, see <a href="https://github.com/ezsystems/ezplatform-demo/blob/e15b93ade4b8c1f9084c5adac51239d239f9f7d8/app/Resources/views/full/blog.html.twig#L25">this example in the Demo Bundle</a>.

#### In this topic:

-   [Rendering a full page](#Displayingcontentwithsimpletemplates-Renderingafullpage)
-   [Rendering page elements](#Displayingcontentwithsimpletemplates-Renderingpageelements)
-   [Different views](#Displayingcontentwithsimpletemplates-Differentviews)
-   [Listing children](#Displayingcontentwithsimpletemplates-Listingchildren)
-   [Adding links](#Displayingcontentwithsimpletemplates-Addinglinks)

#### Related topics:

[Content Rendering](Content-Rendering_31429679.html)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>

 Developer : Docker Tools 



Beta

<span class="aui-icon aui-icon-small aui-iconfont-error confluence-information-macro-icon"></span>
Instructions and Tools *(docker images, Dockerfile, .env file, docker-compose files, scripts, etc.)* described on this page are currently in Beta for community testing & contribution, and might change without notice.

 

> Docker allows you to package an application with all of its dependencies into a standardized unit for software development. – Docker.com

Using Docker images, we can package up all the executables, dependencies, and files required to run eZ Platform. We're in the process of preparing images for public use, and you can follow along on related epic tracking this  <span class="jira-issue resolved"> <a href="https://jira.ez.no/browse/EZP-25665?src=confmacro" class="jira-issue-key"><img src="https://jira.ez.no/images/icons/issuetypes/epic.png" class="icon" />EZP-25665</a> - <span class="summary">Docker-Tools / deployment M1 - beta</span> <span class="aui-lozenge aui-lozenge-subtle aui-lozenge-success jira-macro-single-issue-export-pdf">Closed</span> </span>

*What is described on this page has gone through several iterations to try to become as simple as possible. It uses plain Docker and Docker Compose to avoid having to learn anything specific with these tools, and it uses official docker images to take advantage of continued innovation by Docker Inc. and the ecosystem. We will expand on these tools as both images, and Docker itself, matures. *

If you would like to join our efforts *(development, documentation, feedback, and/or testing)*, <a href="http://ez-community-on-slack.herokuapp.com/">sign up</a> for our <a href="http://ezcommunity.slack.com">Community Slack</a> and join the conversation in the **\#docker-tools** channel.

### Demo usage

Project use

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
For usage with your own project based on eZ Platform or eZ Enterprise starting with v1.4.0 you'll find documentation for project use in `doc/docker-compose/README.md`.

What follows below is instructions for setting up a simple single-server instance of eZ Platform demo using Docker. This is here shown on your own machine, however using <a href="https://docs.docker.com/machine/">Docker Machine</a> you may point this to a variety of servers and services.

Note: For running Docker in production you'll need to handle a few more things we are not covering here yet, some of which are:

-   Handling persistence, both database and web/var files
-   Ideally also scale out to offer redundancy, and for that use memcached/redis and Varnish in front
-   Handle health of containers and configure setup if something goes down
-   ...

<span><span style="color: rgb(255,0,0);">INTERNAL</span> Work in progress, need to move entrypoint so it can be loaded.</span>

<span>
</span>

<span>First place the two files below in a empty folder:</span>

**.env**

``` brush:
SYMFONY_ENV=prod
SYMFONY_DEBUG=0
DATABASE_USER=ezp
DATABASE_PASSWORD=SetYourOwnPassword
DATABASE_NAME=ezp
```

**docker-compose.yml**

``` brush:
version: '2'

services:
  app:
    image: ezsystems/ezplatform-demo:latest
    depends_on:
     - db
    environment:
     - SYMFONY_ENV
     - SYMFONY_DEBUG
     - DATABASE_USER
     - DATABASE_PASSWORD
     - DATABASE_NAME
     - DATABASE_HOST=db

  web:
    image: nginx:stable
    volumes_from:
     - app:ro
    ports:
     - "8080:80"
    environment:
     - SYMFONY_ENV
     - MAX_BODY_SIZE=20
     - FASTCGI_PASS=app:9000
     - TIMEOUT=190
     - DOCKER0NET
    command: /bin/bash -c "cd /var/www && cp -a doc/nginx/ez_params.d /etc/nginx && bin/vhost.sh --template-file=doc/nginx/vhost.template > /etc/nginx/conf.d/default.conf && nginx -g 'daemon off;'"

  db:
    image: mariadb:10.0
    #volumes:
    # - ./entrypoint/mysql:/docker-entrypoint-initdb.d/:ro
    environment:
     - MYSQL_RANDOM_ROOT_PASSWORD=1
     - MYSQL_USER=$DATABASE_USER
     - MYSQL_PASSWORD=$DATABASE_PASSWORD
     - MYSQL_DATABASE=$DATABASE_NAME
     - TERM=dumb
 
```

 

Then execute:

``` brush:
# If you have used same terminal for testing docker already, then first: unset COMPOSE_FILE SYMFONY_ENV SYMFONY_DEBUG
 
docker-compose up -d --force-recreate

docker-compose exec --user www-data app /bin/sh -c "php /scripts/wait_for_db.php; php app/console ezplatform:install demo"
```

App should now be up on localhost:8080

 
 

### Known issues

Incomplete list of known bugs:

|                                                                |                                                                                                                                   |
|----------------------------------------------------------------|-----------------------------------------------------------------------------------------------------------------------------------|
| <span class="jim-table-header-content">Key</span>              | <span class="jim-table-header-content">Summary</span>                                                                             |
| [EZP-25869](https://jira.ez.no/browse/EZP-25869?src=confmacro) | [Docker containers has extremely slow IO on Mac/Windows under development use](https://jira.ez.no/browse/EZP-25869?src=confmacro) |
| [EZP-26286](https://jira.ez.no/browse/EZP-26286?src=confmacro) | [\[Insight\] YAML files should not contain syntax error](https://jira.ez.no/browse/EZP-26286?src=confmacro)                       |

<span id="total-issues-count-1246250676"> [2 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=component%3D%22Deployment+%3E+Docker+Containers%22+AND+issuetype%3DBug+AND+Resolution+is+Empty+ORDER+BY+priority+++&src=confmacro "View all matching issues in JIRA.") </span>

 

#### Related:

-   Documentation:
    -   ~~[Installation Using Docker](Installation-Using-Docker_32113397.html)~~
-   Docker images:
    -   <a href="https://hub.docker.com/r/ezsystems/php/">ezsystems/php</a>
    -   ezsystems/ezplatform-demo

 

<span class="confluence-embedded-file-wrapper image-center-wrapper confluence-embedded-manual-size"><img src="attachments/32113421/32113469.png" class="confluence-embedded-image confluence-thumbnail image-center" height="150" /></span>






1.  <span>[Developer](index.html)</span>

# <img src="images/icons/contenttypes/home_page_16.png" alt="Home Page" width="16" height="16" /> <span id="title-text"> Developer : Documentation </span>



## Welcome to the eZ Platform Developer documentation!

 

This is the center for eZ Platform documentation for developers and system administrators. Here you'll find information about installing, administrating, managing, customizing and extending eZ Platform. The latest version is <a href="https://ezplatform.com/">v1.8.0</a> ([Release Notes](eZ-Platform-v1.8.0_33555269.html)), available on the eZ Developer Hub: <a href="https://ezplatform.com/" class="uri">https://ezplatform.com/</a>

 

**<span class="confluence-embedded-file-wrapper image-left-wrapper"><img src="attachments/31429504/31431962.png" class="confluence-embedded-image image-left" /></span>New to eZ Platform?**

**See [Get Started with eZ Platform
](Get-Started-with-eZ-Platform_31429520.html)**

**<span class="confluence-embedded-file-wrapper image-left-wrapper"><img src="attachments/31429504/31431964.png" class="confluence-embedded-image image-left" /></span>Looking for reference?**

**Read about the [API](API_31429524.html)**

**<span class="confluence-embedded-file-wrapper image-left-wrapper"><img src="attachments/31429504/31431965.png" class="confluence-embedded-image image-left" /></span>Need a specific recipe?**

**Browse the [Cookbook](Cookbook_31429528.html)**

**<span class="confluence-embedded-file-wrapper image-left-wrapper"><img src="attachments/31429504/31431967.png" class="confluence-embedded-image image-left" /></span>Curious about switching to eZ Platform?**

**Check out [Migrating to eZ Platform - Follow the Ibex!](31429532.html)**

**Ready to learn?<span class="confluence-embedded-file-wrapper image-right-wrapper"><img src="attachments/31429504/31431968.png" class="confluence-embedded-image image-right" /></span>
**

**Take a look at the [Tutorials](Tutorials_31429522.html)**

**Want an overview of the system?<span class="confluence-embedded-file-wrapper image-right-wrapper"><img src="attachments/31429504/31431969.png" class="confluence-embedded-image image-right" /></span>**

**Read [The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)**

**Want to get involved?<span class="confluence-embedded-file-wrapper image-right-wrapper"><img src="attachments/31429504/31431970.png" class="confluence-embedded-image image-right" /></span>**

**Check out the** **[Community Resources](Community-Resources_31429530.html)**

**Need Release Notes & older versions?<span class="confluence-embedded-file-wrapper image-right-wrapper"><img src="attachments/31429504/31431971.png" class="confluence-embedded-image image-right" /></span>**

**See** **[Releases](Releases_31429534.html)**

 

 

 

 

 

<span class="aui-icon aui-icon-small aui-iconfont-search">Search</span>

 

Not a developer?

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
Take a look at our [user documentation for editors and content managers](https://doc.ez.no/display/USER/Documentation).

 

 

## Attachments:

<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [get started.png](attachments/31429504/31431962.png) (image/png)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [api.png](attachments/31429504/31431964.png) (image/png)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [cookbook.png](attachments/31429504/31431966.png) (image/png)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [cookbook.png](attachments/31429504/31431965.png) (image/png)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [migrating.png](attachments/31429504/31431967.png) (image/png)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [tutorials.png](attachments/31429504/31431968.png) (image/png)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [hitchhiker.png](attachments/31429504/31431969.png) (image/png)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [community.png](attachments/31429504/31431970.png) (image/png)
<img src="images/icons/bullet_blue.gif" width="8" height="8" /> [previous versions.png](attachments/31429504/31431971.png) (image/png)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>
4.  <span>[Search](Search_31429673.html)</span>
5.  <span>[Search Engines](Search-Engines_32112955.html)</span>

 Developer : ElasticSearch Bundle 



<span class="status-macro aui-lozenge aui-lozenge-error">EXPERIMENTAL</span>

<span class="aui-icon aui-icon-small aui-iconfont-error confluence-information-macro-icon"></span>
ElasticSearch exists only as a technology preview, we welcome people to try it and help make it better. The latest version is only available in "dev-master" version of eZ Platform, and not in any version of eZ Publish Platform 5.x.

Given it is experimental, it is currently not professionally supported

 

## How to use ElasticSearch Search engine

### Step 1: Enabling Bundle

First, activate the Elasticsearch Search Engine Bundle (eZ\\Bundle\\EzPublishElasticsearchSearchEngineBundle\\EzPublishElasticsearchSearchEngineBundle) in your `app/AppKernel.php` class file.

### Step 2: Configuring Bundle

Then configure your search engine in config.yml

Example:

 

**config.yml**

``` brush:
ez_search_engine_elasticsearch:
    default_connection: es_connection_name
    connections:
        es_connection_name:
            server: http://localhost:9200
            index_name: ezpublish
            document_type_name:
                content: content
                location: location
```

 

For further information on the ElasticSearch integration in eZ Platform, find the default <a href="https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/Search/Elasticsearch/Content/Resources/elasticsearch.yml">configuration</a> and <a href="https://github.com/ezsystems/ezpublish-kernel/tree/master/eZ/Publish/Core/Search/Elasticsearch/Content/Resources/mappings">mappings</a> for Content and Location type documents *(Note: Content/Location modeling will most likely be simplified in the future, like in the Solr search engine bundle)*.

 

### Step 3: Configuring repository

<span style="line-height: 1.4285715;">The following is an example of configuring the ElasticSearch Search Engine, where the `connection` name is same as in example above, and engine is set to be </span> `elasticsearch`:

 

 

**ezplatform.yml**

``` brush:
ezpublish:
    repositories:
        main:
            storage:
                engine: legacy
                connection: default
            search:
                engine: elasticsearch
                connection: es_connection_name
```

 

### Step 4: Run CLI indexing command

Last step is to execute initial indexation of data:

``` brush:
php app/console ezplatform:elasticsearch_create_index
```

 

 

#### In this topic:

-   [How to use ElasticSearch Search engine](#ElasticSearchBundle-HowtouseElasticSearchSearchengine)
    -   [Step 1: Enabling Bundle](#ElasticSearchBundle-Step1:EnablingBundle)
    -   [Step 2: Configuring Bundle](#ElasticSearchBundle-Step2:ConfiguringBundle)
    -   [Step 3: Configuring repository](#ElasticSearchBundle-Step3:Configuringrepository)
    -   [Step 4: Run CLI indexing command](#ElasticSearchBundle-Step4:RunCLIindexingcommand)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>
4.  <span>[Under the Hood: How eZ Platform Works](31429659.html)</span>
5.  <span>[Content Model: Content is King!](31429709.html)</span>
6.  <span>[Content items, Content Types and Fields](31430275.html)</span>
7.  <span>[Field Types reference](Field-Types-reference_31430495.html)</span>

 Developer : EmailAddress Field Type 



This Field Type represents an email address, in the form of a string.

| Name           | Internal name | Expected input type |
|----------------|---------------|---------------------|
| `EmailAddress` | `ezemail`     | `string`            |

## Description

The EmailAddress Field Type stores an email address, which is provided as a string.

## PHP API Field Type 

### Value object

##### Properties

The **`Value`** class of this field type contains the following properties:

| Property | Type     | Description                                                                |
|----------|----------|----------------------------------------------------------------------------|
| `$email` | `string` | This property will be used for the input string provided as email address. |

**Value object content example**

``` brush:
use eZ\Publish\Core\FieldType\EmailAddress\Type;

// Instantiates an EmailAddress Value object with default value (empty string)
$emailaddressValue = new Type\Value();

// Email definition
$emailaddressValue->email = "someuser@example.com";
```

##### Constructor

<span>The **`EmailAddress`**</span>**`\Value`**<span> constructor will initialize a new Value object with the value provided. It accepts a string as input.</span>

**Constructor example**

``` brush:
use eZ\Publish\Core\FieldType\EmailAddress\Type;
 
// Instantiates an EmailAddress Value object
$emailaddressValue = new Type\Value( "someuser@example.com" );
```

##### String representation

String representation of the Field Type's Value object is the email address contained in it.

Example:

> `someuser@example.com`

### Hash format

Hash value for this Field Type's Value is simply the email address as a string.

Example:

> `someuser@example.com`

### Validation

This Field Type uses the **`EmailAddressValidator`** validator as a resource which will test the string supplied as input against a pattern, to make sure that a valid email address has been provided.
If the validations fail a **`ValidationError`**<span class="p">  </span>is thrown, specifying the error message.

### Settings

This Field Type does not support settings.

 

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)</span>

 Developer : Environments 



Environment configuration as provided by Symfony is enhanced in eZ Platform to allow specifying this in the virtual host configuration.
You can configure several environments, from production, development or staging, even if for each one of them you need to use different configuration sets.

 

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
<span>See also </span><a href="http://symfony.com/doc/current/cookbook/configuration/environments.html">the Symfony Recipe about &quot; How to Master and Create new Environments &quot;</a>

# Web server configuration

For example, using Apache, in the `VirtualHost` example in <a href="https://github.com/ezsystems/ezplatform/tree/master/doc/apache2">doc/apache2/</a> in your install, the required `VirtualHost` configurations have been already included. You can switch to the desired environment by setting the `ENVIRONMENT` environment variable to "`prod`", "`dev`" or other custom value, as you can see in the following example:

``` brush:
# Environment.
# Possible values: "prod" and "dev" out-of-the-box, other values possible with proper configuration
# Defaults to "prod" if omitted (uses SetEnvIf so value can be used in rewrite rules)
SetEnvIf Request_URI ".*" SYMFONY_ENV="prod"
```

# Configuration

If you want to use a custom environment (something else then "`prod`" and "`dev`") the next step is to create the dedicated configuration files for your environment:

-   `app/config/config_ <env_name> .yml`
-   `app/config/ezplatform_ <env_name> .yml`

The name used as `            <env_name>          ` will be the one that can be used as value of the `ENVIRONMENT` environment variable.

Those files must import the main configuration file, just like the default <a href="https://github.com/ezsystems/ezpublish-community/blob/master/ezpublish/config/config_dev.yml"><code>config_dev.yml</code></a> already does. Here's an example:

``` brush:
imports:
    - { resource: config.yml }
```

 

This allows you to override settings defined in the main configuration file, depending on your environment (like the DB settings or any other setting you may want to override).

#### In this topic:

-   [Web server configuration](#Environments-Webserverconfiguration)
-   [Configuration](#Environments-Configuration)

 






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[API](API_31429524.html)</span>
4.  <span>[REST API Guide](REST-API-Guide_31430286.html)</span>

 Developer : Error handling 



Error handling in the REST API is fully based on HTTP error codes. As a web developer, you are probably familiar with the most common ones: 401 Unauthorized, 404 Not Found or 500 Internal Server Error. The REST API uses those, along with a few more, to allow proper error handling.

The complete list of error codes used and the conditions in which they apply are specified in the <a href="https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/rest/REST-API-V2.rst">reference documentation</a>.

## General error codes

A few error codes apply to most resources (if they *are* applicable)

### 500 Internal Server Error

<span>The server encountered an unexpected condition, usually an exception, which prevented it from fulfilling the request: database down, permissions or configuration error.</span>

### 501 Not Implemented

<span>Returned when the requested method has not yet been implemented. As of eZ Publish 5.0, most of User, User group, Content, Location and Content Type have been implemented. Some of their methods, as well as other features, may return a 501.</span>

### <span>404 Not Found</span>

<span>Returned when the request failed because the request object was not found. You should be familiar with this one.</span>

### <span>405 Method Not Allowed</span>

<span>Returned when the requested REST API resource doesn't support the HTTP verb that was used.</span>

### <span>406 Not Acceptable</span>

<span>Returned when an accept header sent with the requested isn't supported.</span>

## <span>Error handling in your REST implementation</span>

<span>It is up to you, in your client implementation, to handle those codes by checking if an error code (4xx or 5xx) was returned instead of the expected 2xx or 3xx.</span>

#### In this topic:

-   [General error codes](#Errorhandling-Generalerrorcodes)
    -   [500 Internal Server Error](#Errorhandling-500InternalServerError)
    -   [501 Not Implemented](#Errorhandling-501NotImplemented)
    -   [404 Not Found](#Errorhandling-404NotFound)
    -   [405 Method Not Allowed](#Errorhandling-405MethodNotAllowed)
    -   [406 Not Acceptable](#Errorhandling-406NotAcceptable)
-   [Error handling in your REST implementation](#Errorhandling-ErrorhandlinginyourRESTimplementation)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Cookbook](Cookbook_31429528.html)</span>

 Developer : Executing long-running console commands 



# Description

This page describes how to execute long-running console commands, to make sure they don't run out of memory. An example is a custom import command or the indexing command provided by the [Solr Bundle](Solr-Bundle_31430592.html).

# Solution

## Reducing memory usage

To avoid quickly running out of memory while executing such commands you should make sure to:

1.  <span class="inline-comment-marker" data-ref="5c1c379e-da6a-435d-ba3e-f3fe7df39d94">Always</span> run in prod environment using: `--env=prod`
    1.  See [Environments](Environments_31429669.html) for further information on Symfony environments.
    2.  *See [Logging and debug configuration](https://doc.ez.no/display/DEVELOPER/Devops#Devops-LoggingandDebugConfiguration) for some of different features enabled in development *environments, which by design uses memory.**

2.  Avoid Stash *(<span class="confluence-link">[Persistence cache](Repository_31432023.html#Repository-Persistencecacheconfiguration)</span>)* using to much memory in prod:

    1.  If your system is running, or you need to use cache, then disable Stash InMemory cache as it does not limit the amount of items in cache and grows exponentially:

        **config\_prod.yml (snippet, not a full example for stash config)**

        ``` brush:
        stash:
            caches:
                default:
                    inMemory: false 
        ```

        Also if you use FileSystem driver, make sure `memKeyLimit` is set to a low number, default should be 200 and can be lowered like this:

        **config\_prod.yml**

        ``` brush:
        stash:
            caches:
                default:
                    FileSystem:
                        memKeyLimit: 100
        ```

    2.  If your setup is offline and cache is cold, there is no risk of stale cache and you can actually completely disable Stash cache. This will improve performance of import scripts:

        **config\_prod.yml (full example)**

        ``` brush:
        stash:
            caches:
                default:
                    drivers: [ BlackHole ]
                    inMemory: false
        ```

3.  For logging using monolog, if you use either the default `               fingers_crossed             `, or `buffer` handler, make sure to specify `               buffer_size             ` <span class="inline-comment-marker" data-ref="b6f4845b-de84-415d-bd48-2744c8886ef8"> to limit how large the buffer grows before it gets flushed</span>:

    **config\_prod.yml (snippet, not a full example for monolog config)**

    ``` brush:
    monolog:
        handlers:
            main:
                type: fingers_crossed
                buffer_size: 200
    ```

4.  Run PHP without memory limits using: `php ` `-d memory_limit=-1 app/console <command>` <span>
    </span>
5.  Disable `xdebug` *(PHP extension to debug/profile php use)* when running the command, this will cause php to use much more memory.

 

Note: Memory will still grow

<span class="aui-icon aui-icon-small aui-iconfont-warning confluence-information-macro-icon"></span>
Even when everything is configured like described above, memory will grow for each iteration of indexing/inserting a content item with at least *1kb* per iteration after the initial first 100 rounds. This is expected behavior; to be able to handle more iterations you will have to do one or several of the following:

-   <span>Change the import/index script in question to [use process forking](#Executinglong-runningconsolecommands-process-forking) to avoid the issue.</span>
-   Upgrade PHP: *newer versions of PHP are typically more memory-efficient.*
-   Run the console command on a machine with more memory (RAM)*.
    *

## Process forking with Symfony<span id="Executinglong-runningconsolecommands-process-forking" class="confluence-anchor-link"></span>

The recommended way to completely avoid "memory leaks" in PHP in the first place is to use processes, and for console scripts this is typically done using process forking which is quite easy to do with Symfony.

The things you will need to do:

1.  Change your command so it supports taking slice parameters, like for instance a batch size and a child-offset parameter.
    1.  *If defined, child-offset parameter denotes if a process is child, this could have been accomplished with two commands as well.*
    2.  *If not defined, it is master process which will execute the processes until nothing is left to process.*

2.  Change the command so that the master process takes care of forking child processes in slices.
    1.  For execution in-order, <a href="https://github.com/ezsystems/ezpublish-kernel/blob/6.2/eZ/Bundle/PlatformInstallerBundle/src/Command/InstallPlatformCommand.php#L230">you may look to our platform installer code</a>used to fork out solr indexing after installation to avoid cache issues.
    2.  For parallel execution of the slices, <a href="http://symfony.com/doc/current/components/process.html#process-signals">see Symfony doc for further instruction</a>.

 

#### In this topic:

-   [Description](#Executinglong-runningconsolecommands-Description)
-   [Solution](#Executinglong-runningconsolecommands-Solution)
    -   [Reducing memory usage](#Executinglong-runningconsolecommands-Reducingmemoryusage)
    -   [Process forking with Symfony](#Executinglong-runningconsolecommands-ProcessforkingwithSymfonyprocess-forking)

#### Related topics:

<span class="confluence-link">[Environments](Environments_31429669.html)</span>

<a href="http://symfony.com/doc/current/components/process.html">Symfony Process Component [symfony.com]</a>

[How to Contribute](How-to-Contribute_31429587.html)






1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Get Started with eZ Platform](Get-Started-with-eZ-Platform_31429520.html)</span>
4.  <span>[Step 2: Going Deeper](31429542.html)</span>
5.  <span>[Get Started with eZ Enterprise](Get-Started-with-eZ-Enterprise_31429569.html)</span>

 Developer : Explore eZ Enterprise Tutorials 








1.  <span>[Developer](index.html)</span>
2.  <span>[Documentation](Documentation_31429504.html)</span>
3.  <span>[Cookbook](Cookbook_31429528.html)</span>

 Developer : Exposing SiteAccess-aware configuration for your bundle 



# Description

Symfony Config component makes it possible to define *semantic configuration*, exposed to the end developer. This configuration is validated by rules you define, e.g. validating type (string, array, integer, boolean, etc.). Usually, once validated and processed, this semantic configuration is then mapped to internal *key/value* parameters stored in the `ServiceContainer`.

eZ Platform uses this for its core configuration, but adds another configuration level, the **siteaccess**. For each defined siteaccess, we need to be able to use the same configuration tree in order to define siteaccess-specific config. These settings then need to be mapped to siteaccess-aware internal parameters that you can retrieve via the `ConfigResolver`. For this, internal keys need to follow the format `<namespace>.<scope>.<parameter_name>`, `namespace` being specific to your app/bundle, `scope` being the siteaccess, siteaccess group, `default` or `global`, `parameter_name` being the actual setting *identifier*.

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
<span style="color: rgb(0,0,0);">For more information on ConfigResolver, namespaces and scopes, see </span><span class="confluence-link">[eZ Platform configuration basics](https://doc.ez.no/display/DEVELOPER/SiteAccess#SiteAccess-Configuration)</span><span style="color: rgb(119,119,119);">.</span>

<span>The goal of this feature is to make it easy to implement a </span>*siteaccess-aware*<span> semantic configuration and its mapping to internal config for any eZ bundle developer.</span>

# Solution

## Semantic configuration parsing

<span><span>An abstract </span>`Configuration`<span> class has been added, simplifying the way to add a siteaccess settings tree like the following:</span></span>

 

**ezplatform.yml or config.yml**

``` brush:
acme_demo:
    system:
        my_siteaccess:
            hello: "world"
            foo_setting:
                an_integer: 456
                enabled: true

        my_siteaccess_group:
            hello: "universe"
            foo_setting:
                foo: "bar"
                some: "thing"
                an_integer: 123
                enabled: false
```

 

<span>Class FQN is </span>`eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\Configuration`<span>.
</span><span style="line-height: 1.4285715;">All you have to do is to extend it and use </span>`$this->generateScopeBaseNode()`<span style="line-height: 1.4285715;">:</span>

``` brush:
namespace Acme\DemoBundle\DependencyInjection;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\Configuration as SiteAccessConfiguration;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration extends SiteAccessConfiguration
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root( 'acme_demo' );

        // $systemNode will then be the root of siteaccess aware settings.
        $systemNode = $this->generateScopeBaseNode( $rootNode );
        $systemNode
            ->scalarNode( 'hello' )->isRequired()->end()
            ->arrayNode( 'foo_setting' )
                ->children()
                    ->scalarNode( "foo" )->end()
                    ->scalarNode( "some" )->end()
                    ->integerNode( "an_integer" )->end()
                    ->booleanNode( "enabled" )->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
```

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
<span style="color: rgb(0,0,0);">Default name for the *siteaccess root node* is `system`, but you can customize it. For this, just pass the name you want to use as a second argument of `$this->generateScopeBaseNode()`.</span>

## Mapping to internal settings

Semantic configuration must always be *mapped* to internal *key/value* settings within the `ServiceContainer`. This is usually done in the DIC extension.

For siteaccess-aware settings, new `ConfigurationProcessor` and `Contextualizer` classes have been introduced to ease the process.

``` brush:
namespace Acme\DemoBundle\DependencyInjection;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\ConfigurationProcessor;
use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\ContextualizerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AcmeDemoExtension extends Extension
{
    public function load( array $configs, ContainerBuilder $container )
    {
        $configuration = $this->getConfiguration( $configs, $container );
        $config = $this->processConfiguration( $configuration, $configs );

        $loader = new Loader\YamlFileLoader( $container, new FileLocator( __DIR__.'/../Resources/config' ) );
        $loader->load( 'default_settings.yml' );

        // "acme_demo" will be the namespace as used in ConfigResolver format.
        $processor = new ConfigurationProcessor( $container, 'acme_demo' );
        $processor->mapConfig(
            $config,
            // Any kind of callable can be used here.
            // It will be called for each declared scope/SiteAccess.
            function ( $scopeSettings, $currentScope, ContextualizerInterface $contextualizer )
            {
                // Will map "hello" setting to "acme_demo.<$currentScope>.hello" container parameter
                // It will then be possible to retrieve this parameter through ConfigResolver in the application code:
                // $helloSetting = $configResolver->getParameter( 'hello', 'acme_demo' );
                $contextualizer->setContextualParameter( 'hello', $currentScope, $scopeSettings['hello'] );
            }
        );

        // Now map "foo_setting" and ensure keys defined for "my_siteaccess" overrides the one for "my_siteaccess_group"
        // It is done outside the closure as it is needed only once.
        $processor->mapConfigArray( 'foo_setting', $config );
    }
}
```

Tip

<span class="aui-icon aui-icon-small aui-iconfont-approve confluence-information-macro-icon"></span>
You can map simple settings by calling `$processor->mapSetting()`, without having to call `$processor->mapConfig()` with a callable.

``` brush:
$processor = new ConfigurationProcessor( $container, 'acme_demo' );
$processor->mapSetting( 'hello', $config );
```

Important

<span class="aui-icon aui-icon-small aui-iconfont-error confluence-information-macro-icon"></span>
Always ensure you have defined and loaded default settings.

**@AcmeDemoBundle/Resources/config/default\_settings.yml**

``` brush:
parameters:
    acme_demo.default.hello: world
    acme_demo.default.foo_setting:
        foo: ~
        some: ~
        planets: [Earth]
        an_integer: 0
        enabled: false
        j_adore: les_sushis
```

### Merging hash values between scopes

When you define a hash as semantic config, you sometimes don't want the siteaccess settings to replace the default or group values, but *enrich* them by appending new entries. This is made possible by using `$processor->mapConfigArray()`, which needs to be called outside the closure (before or after), in order to be called only once.

<span>Consider the following default config:</span>

**default\_settings.yml**

``` brush:
parameters:
    acme_demo.default.foo_setting:
        foo: ~
        some: ~
        planets: [Earth]
        an_integer: 0
        enabled: false
        j_adore: les_sushis
```

<span><span>
</span></span>

<span><span>And then this semantic config:</span></span>

 

**ezplatform.yml or config.yml**

``` brush:
acme_demo:
    system:
        sa_group:
            foo_setting:
                foo: bar
                some: thing
                an_integer: 123

        # Assuming "sa1" is part of "sa_group"
        sa1:
            foo_setting:
                an_integer: 456
                enabled: true
                j_adore: le_saucisson
```

<span>
</span>

<span>What we want here is that keys defined for </span>`foo_setting`<span> are merged between default/group/siteaccess:</span>

**Expected result**

``` brush:
parameters:
    acme_demo.sa1.foo_setting:
        foo: bar
        some: thing
        planets: [Earth]
        an_integer: 456
        enabled: true
        j_adore: le_saucisson
```

#### Merge from *second level*

In the example above, entries were merged in respect to the scope order of precedence. However, if we define the `planets` key for`sa1`, it will completely override the default value since the merge process is done at only 1 level.

You can add another level by passing `ContextualizerInterface::MERGE_FROM_SECOND_LEVEL` as an option (3rd argument) to`$contextualizer->mapConfigArray()`.

**default\_settings.yml**

``` brush:
parameters:
    acme_demo.default.foo_setting:
        foo: ~
        some: ~
        planets: [Earth]
        an_integer: 0
        enabled: false
        j_adore: [les_sushis]
```

**Semantic config (ezplatform.yml / config.yml)**

``` brush:
acme_demo:
    system:
        sa_group:
            foo_setting:
                foo: bar
                some: thing
                planets: [Mars, Venus]
                an_integer: 123

        # Assuming "sa1" is part of "sa_group"
        sa1:
            foo_setting:
                an_integer: 456
                enabled: true
                j_adore: [le_saucisson, la_truite_a_la_vapeur]
```

Result of using `ContextualizerInterface::MERGE_FROM_SECOND_LEVEL` option:

``` brush:
parameters:
    acme_demo.sa1.foo_setting:
        foo: bar
        some: thing
        planets: [Earth, Mars, Venus]
        an_integer: 456
        enabled: true
        j_adore: [les_suhis, le_saucisson, la_truite_a_la_vapeur]
```

<span class="aui-icon aui-icon-small aui-iconfont-info confluence-information-macro-icon"></span>
There is also another option, `ContextualizerInterface::UNIQUE`, to be used when you want to ensure your array setting has unique values. It will only work on normal arrays though, not hashes.

#### Limitations

A few limitation exist with this scope hash merge:

-   Semantic setting name and internal name will be the same (like `foo_setting` in the examples above).
-   Applicable to first level semantic parameter only (i.e. settings right under the siteaccess name).
-   Merge is not recursive. Only second level merge is possible by using `ContextualizerInterface::MERGE_FROM_SECOND_LEVEL` option.

## Dedicated mapper object

<span>Instead of passing a callable to `$processor->mapConfig()`, an instance of `eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\ConfigurationMapperInterface` can be passed.</span>

<span>This can be useful if you have a lot of configuration to map and don't want to pollute your DIC extension class (better for maintenance).</span>

### Merging hash values between scopes

<span><span>As specified above, </span>`$contextualizer->mapConfigArray()`<span> is not to be used within the </span>*scope loop*<span>, like for simple values. When using a closure/callable, you usually call it before or after </span>`$processor->mapConfig()`<span>. For mapper objects, a dedicated interface can be used: </span>`HookableConfigurationMapperInterface`<span>, which defines 2 methods: </span>`preMap()`<span> and </span>`postMap()`<span>.</span></span>

<span>
</span>

 

#### In this topic:

-   [Description](#ExposingSiteAccess-awareconfigurationforyourbundle-Description)
-   [Solution](#ExposingSiteAccess-awareconfigurationforyourbundle-Solution)
    -   [Semantic configuration parsing](#ExposingSiteAccess-awareconfigurationforyourbundle-Semanticconfigurationparsing)
    -   [Mapping to internal settings](#ExposingSiteAccess-awareconfigurationforyourbundle-Mappingtointernalsettings)
        -   [Merging hash values between scopes](#ExposingSiteAccess-awareconfigurationforyourbundle-Merginghashvaluesbetweenscopes)
    -   [Dedicated mapper object](#ExposingSiteAccess-awareconfigurationforyourbundle-Dedicatedmapperobject)
        -   [Merging hash values between scopes](#ExposingSiteAccess-awareconfigurationforyourbundle-Merginghashvaluesbetweenscopes.1)






