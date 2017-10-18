# Manual Installation Guides

### Introduction

Hi! You are about to install eZ Platform on your machine and this guide is here to make sure that the whole process of preparation and installation is fast and easy. This guide consists of a three paths that differ slightly; you should choose the one that meets your operating system:

[Microsoft Windows](install_manually.md#manual-installation-on-windows), [Mac OS X](install_manually.md#installation-guide-for-os-x) or other [Unix-Based Systems](install_manually.md#installation-guide-for-unix-based-systems).

**Installation guides can be followed with any eZ Symfony distribution, you can find a list of available distributions from eZ in a table below:**

| Type                                       | Archive                                                                   | License                                         | GIT */ Composer*                                                                                                                                   |
|--------------------------------------------|---------------------------------------------------------------------------|-------------------------------------------------|----------------------------------------------------------------------------------------------------------------------------------------------------|
| eZ Platform *- "clean"*                    | [share.ez.no/downloads/downloads](http://share.ez.no/downloads/downloads) | GPL                                             | [ezsystems/ezplatform](https://github.com/ezsystems/ezplatform) ([INSTALL.md](https://github.com/ezsystems/ezplatform/blob/master/INSTALL.md))     |
| eZ Platform *- "demo"*                     | *Available via Git / Composer*                                            | GPL                                             | [ezsystems/ezplatform-demo](https://github.com/ezsystems/ezplatform-demo)                                                                          |
| eZ Platform Enterprise Edition *- "clean"* | [support.ez.no/Downloads](https://support.ez.no/Downloads)                | BUL (***requires eZ Enterprise subscription)*** | [ezsystems/ezplatform-ee](https://github.com/ezsystems/ezplatform-ee) ([INSTALL.md](https://github.com/ezsystems/ezstudio/blob/master/INSTALL.md)) |
| eZ Platform Enterprise Edition - *"demo"*  | [support.ez.no/Downloads](https://support.ez.no/Downloads)                | BUL (***requires eZ Enterprise subscription)*** | [ezsystems/ezplatform-ee-demo](https://github.com/ezsystems/ezplatform-ee-demo)                                                                    |

## Installation Guide for OS X

### Preparation:

#### 1. Install MySQL 

Download from the [official MySQL webpage](https://www.mysql.com/) is strongly recommended.

#### 2. Set up PHP

This step requires the modification of two files: Apache2 configuration file and `php.ini`.
These files can be edited using a terminal editor like vi or nano, or a simple text editor such as TextEdit or Atom.

a. Edit Apache2 configuration file:

``` bash
sudo vi /private/etc/apache2/httpd.conf
```

b. Uncomment the following line:

``` bash
LoadModule php5_module libexec/apache2/libphp5.so
```

c. If you can't locate the `php.ini` file on your machine, it's probably under `php.ini.default`. Create a new `php.ini` file based on defaults:

``` bash
sudo cp /private/etc/php.ini.default /private/etc/php.ini
```

d. Open the file in a text editor (in this example, in vi):

``` bash
sudo vi /private/etc/php.ini
```

e. Locate `date.timezone` and `pdo_mysql.default_socket` and provide them with values as in the example below:

``` bash
date.timezone = "Europe/Warsaw"
pdo_mysql.default_socket = /tmp/mysql.sock
```

f. Increase `memory_limit` value for eZ Platform:

``` bash
memory_limit = 4G
```

#### 3. Set up virtual host and start Apache2

a. Edit Apache2 configuration file:

``` bash
sudo vi /private/etc/apache2/httpd.conf
```

b. Uncomment and modify the following lines:

``` bash
LoadModule vhost_alias_module libexec/apache2/mod_vhost_alias.so
LoadModule rewrite_module libexec/apache2/mod_rewrite.so
```

c. Comment the following line:

``` bash
Include /private/etc/apache2/extra/httpd-vhosts.conf
```

d. Add the following line to the file:

``` bash
Include /private/etc/apache2/users/*.conf
```

e. Change permissions for virtual hosts storage directory (775):

``` bash
sudo chmod -R 775 /private/etc/apache2/users
sudo chmod 775 /private/etc/apache2
```

#### 4. Start Apache2 daemon using terminal

``` bash
sudo apachectl start
```

#### 5. Install Composer globally

Composer is a dependency manager that allows you to install packages directly in the project. It is also checking all packages' versions on a regular basis to make sure they are up-to-date and to avoid inconsistencies.

``` bash
curl -sS https://getcomposer.org/installer | php
mkdir -p /usr/local/bin
php -d memory_limit=-1 composer.phar
```

#### 6. Create a new database for eZ Platform

Create new database (you can substitute `ez1` with the database name you want to use):

``` bash
/usr/local/mysql/bin/mysql -u root -e 'create database ez1;'
```

#### 7. Install Brew package manager

Brew is a package manager for OS X, if you haven't used it already you are going to love what it does!

``` bash
ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"
```

#### 8. Install additional requirements for eZ Platform

a. Install PEAR/PECL extension:

``` bash
cd /usr/lib/php
curl -O https://pear.php.net/go-pear.phar
php -d detect_unicode=0 go-pear.phar
sudo php install-pear-nozlib.phar
sudo pear channel-update pear.php.net
sudo pecl channel-update pecl.php.net
sudo pear upgrade-all
sudo pear config-set auto_discover 1
```

b. Install autoconf:

``` bash
brew install autoconf
```

c. Install intl:

``` bash
brew install icu4c
sudo pecl install intl
```

d. The path to the ICU libraries and headers is: `/usr/local/opt/icu4c/`.

Edit `/private/etc/php.ini` and add following line:

``` bash
extension=intl.so
```

e. Enable opcache extension for PHP (suggested, but not required) by adding:

``` bash
zend_extension=opcache.so
```

### Installation:

#### 9. Install eZ Platform

a. Go to the folder with your installation and set up directory permissions:

``` bash
chmod 775 ../ez1.lh
chmod 775 ../../workspace
chmod 775 ../../../Documents
```

b. Download archive from [share.ez.no/downloads](http://share.ez.no/downloads/downloads). Extract the eZ Platform archive to a directory, then execute post install scripts.

``` bash
cd /<directory>/
php -d memory_limit=-1 composer.phar run-script post-install-cmd
```

c. Copy the virtual host template:

``` bash
sudo cp doc/apache2/vhost.template /private/etc/apache2/users/ez1.lh.conf
```

d. Edit the new virtual host:

``` bash
sudo vi /private/etc/apache2/users/ez1.lh.conf
```

e. Modify virtual host file **vhost.template.**

Replace the `---USER_ID---` variable (used in lines 10 and 17) with your current user ID. Use `whoami` command to get effective user ID of the currently logged user. If you want to use the default virtual host template (delivered with eZ Platform package) all you have to do is set up lines 7, 8, 9, 10, 17, 25 and 33:

f. Restart Apache 2 server:

``` bash
sudo apachectl restart
```

g. Install required dependencies using Composer:

``` bash
composer install
```

When Composer asks you for the token you must log in to your GitHub account and edit your profile. Go to the Personal access tokens link and Generate new token with default settings. Be aware that the token will be shown only once, so do not refresh the page until you paste the token into Composer prompt. This operation is performed only once when you install eZ Platform for the first time.

h. Change directory permissions:

``` bash
rm -rf app/cache/* app/logs/*
sudo chmod +a "_www allow delete,write,append,file_inherit,directory_inherit" app/{cache,logs,config} web
sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" app/{cache,logs,config} web
```

i. Install eZ Platform:

``` bash
php app/console ezplatform:install clean
```

You will be able to see your page under <http://ez1.lh> (or the address you chose in preparation). Please note that a clean install of eZ Platform doesn’t include DemoBundle anymore.

#### 10. Optional

a. Install PHP 5.6 with opcache extension:

``` bash
brew install -v homebrew/php/php56
chmod -R ug+w $(brew --prefix php56)/lib/php
brew install -v php56-opcache
```

b. Add proper `date.timezone` settings:

``` bash
sudo vi /usr/local/etc/php/5.6/php.ini
```

c. Uncomment and modify:

```
date.timezone = "Europe/Warsaw"
(…)
Increase memory_limit value for eZ Platform:
memory_limit = 4G
(…)
```

d. Disable errors showing:

``` bash
display_errors = Off
```

e. Change default PHP parser used by Apache:

``` bash:
sudo vi /private/etc/apache2/httpd.conf
```

f. Find and comment the following line:

``` bash
# LoadModule php5_module libexec/apache2/libphp5.so
```

g. Add below:

``` bash
LoadModule php5_module /usr/local/opt/php56/libexec/apache2/libphp5.so
```

e. Install intl extension for PHP 5.6:

``` bash
brew install php56-intl
```

f. Restart Apache:

``` bash
sudo apachectl restart
```

## Installation Guide for Unix-Based Systems

### 1. Install a LAMP Stack (\*NIX, Apache, MySQL, PHP5+)

Depending on your selected \*NIX distribution, you may need to install part or all of the LAMP stack required to run eZ Platform or eZ Enterprise. Before getting started, make sure you review our [requirements](requirements_and_system_configuration.md) page to see the systems we support and use for testing. You can try using an unsupported configuration, but your results may vary.

Please not that, while OS X *is* a \*NIX-based system, it has its own unique requirements listed in our [Installation Guide for OS X](install_manually.md#installation-guide-for-os-x). Developer-maintained installation notes are kept in our GitHub repository at this location as well: <https://github.com/ezsystems/ezplatform/blob/master/INSTALL.md>

You may use your system's package manager (yum, apt-get, etc.) to obtain a copy of Apache, MySQL, and PHP, or download the latest versions from the official websites and install manually:

-   [Apache2](https://httpd.apache.org/download.cgi)
-   [MySQL](http://dev.mysql.com/downloads/mysql/)
-   [PHP 5.6+](http://php.net)

For Debian 8.5, for example, we'd recommend using `apt-get` to install `apache2`, `mysql-server`, `mysql-client`, and `php5-*` (all the packages listed in the [requirements](requirements_and_system_configuration.md)), as well as `git` for version control. If the system on which you're doing the install has only 1 or 2 GB of RAM, be sure to [set up swap](#set-up-swap-on-debian-8x) so you don't run out of RAM when running the composer scripts later on.

### 2. Get Composer

You'll need Composer, the PHP command line dependency manager.

a. Install Composer by running the following command on the terminal of the machine upon which you're installing eZ Platform:

``` bash
php -r "readfile('https://getcomposer.org/installer');" | php
```

b. Move the downloaded composer.phar file to a globally-available path:

``` bash
mv composer.phar /usr/local/bin/composer
```

### 3. Download the desired version of eZ Platform or eZ Enterprise

-   If you are installing eZ Platform, download the latest archive from <http://share.ez.no/latest>
-   For licensed eZ Enterprise customers, download your file here: <https://support.ez.no/Downloads>

Expand the archive into `/var/www/ezplatform` or the folder name or your choosing.

For developers interested in working with the latest version of eZ Platform, you may also clone the latest from our GitHub repository:

``` bash
cd /var/www
git clone https://github.com/ezsystems/ezplatform.git /var/www/ezplatform
```

You can rename the destination folder to whatever you like. This is where eZ Platform will live, and you'll point your virtual host to this folder to use as its root. You may choose to download an archive file from [share.ez.no/downloads](http://share.ez.no/downloads/downloads) instead of cloning from GitHub, and extract the eZ Platform archive to a similar directory. The subsequent steps are identical, regardless of the method you choose to obtain eZ Platform.

### 4. Create a new database for eZ Platform

Create new database (you can substitute `ezplatform` with the database name you want to use, but keep it in mind as you run the installation script):

``` bash
/usr/bin/mysql -u root -e 'create database ezplatform;'
```

### 5. Run the Installation Scripts

Composer will look inside the composer.json file and install all of the required packages to run eZ Platform. There's a script in the app folder called console that will install eZ Platform for your desired environment as well (dev/prod).

This is the step where you want to make sure you have [swap configured for your machine](#set-up-swap-on-debian-8xx) if it does not have an abundance of RAM.

#### a. Run composer install:

``` bash
cd /var/www/ezplatform
php -d memory_limit=-1 /usr/local/bin/composer install
```

Once the installer gets to the point that it creates `app/config/parameters.yml`, you will be presented with a few decisions. The first asks you to choose a [secret](http://symfony.com/doc/current/reference/configuration/framework.html#secret); choose any random string you like, made up of characters, numbers, and symbols, up to around 32 characters. This is used by Symfony when generating [CSRF tokens](http://symfony.com/doc/current/book/forms.html#forms-csrf), [encrypting cookies](http://symfony.com/doc/current/cookbook/security/remember_me.html), and for creating signed URIs when using [ESI (Edge Side Includes)](http://symfony.com/doc/current/book/http_cache.html#edge-side-includes).

Next, you'll be asked to specify a database driver. You may press return to accept the default for this option, as well as the next several (`database_host, database_port, database_name, database_user`) unless you have customized those values and need to enter them as configured on your installation. If you set a password for your database user, enter it when prompted for `database_password`. The installer should continue once you've completed this manual portion of the installation process.

#### b. Run eZ Platform's installer:

``` bash
php -d memory_limit=-1 /var/www/ezplatform/app/console ezplatform:install --env prod clean
```

Don't forget to substitute any custom folder name you may have chosen in place of `ezplatform/` after `/var/www/` in the examples above. As you can see, this example shows a clean production installation. We're telling PHP to run Symfony's console to execute the ezplatform install script. You can get an informative output to learn more about the console script's capabilities by swapping in these parameters: `config:dump-reference ezpublish`

If Composer asks you for your token, you must log in to your GitHub account and edit your profile. Go to the Personal access tokens link and Generate new token with default settings. Be aware that the token will be shown only once, so do not refresh the page until you paste the token into the Composer prompt. This operation is performed only once when you install eZ Platform for the first time.

Please note that a clean install of eZ Platform doesn’t include the DemoBundle anymore.

### 6. Setup the folder rights (\*NIX users)

Like most things, [Symfony documentation](http://symfony.com/doc/current/book/installation.html#checking-symfony-application-configuration-and-setup) applies here, meaning `app/cache` and `app/logs` need to be writable by cli and web server user.

Furthermore, future files and directories created by these two users will need to inherit those access rights. *For security reasons, there is no need for web server to have access to write to other directories.*

Then, go to the [Setup folder rights](install_manually.md#Setup-folder-rights) page for the next steps of this settings.

### 7. Set up a Virtual Host

For our example, we'll demonstrate using Apache2 as part of the traditional LAMP stack.

#### Option A: Scripted Configuration

Instead of manually editing the vhost.template file, you may instead [use the included shell script](starting_ez_platform.md#Web-server): /var/www/ezplatform/bin/vhost.sh to generate a configured .conf file. Check out the source of `vhost.sh` to see the options provided. Additional information is included in our [Web Server](starting_ez_platform.md#web-server) documentation here as well.

#### Option B: Manual Edits

a. Copy the vhost template file from its home in the doc folder:

``` bash
cp /var/www/ezplatform/doc/apache2/vhost.template /etc/apache2/sites-available/ezplatform.conf
```

b. Edit the file, substituting the %placeholders% with the appropriate values for your desired config:

``` bash
vi /etc/apache2/sites-available/ezplatform.conf
```

For a DEV environment, you can change

-   -   `<VirtualHost %IP_ADDRESS%:%PORT%>           `to
        `<VirtualHost *:80>`
    -   `ServerName %HOST_NAME%toServerName localhost`
    -   `ServerAlias %HOST_ALIAS%...that can simply be deleted.`
    -   `DocumentRoot %BASEDIR%/webtoDocumentRoot /var/www/ezplatform/web`
    -   `LimitRequestBody %BODY_SIZE_LIMIT%toLimitRequestBody 0`
    -   `TimeOut %TIMEOUT%toTimeOut 42to avoid waiting longer than 42 seconds for all the things.`

Be sure to specify `/var/www/ezplatform/web` as the `DocumentRoot` and `Directory`. Uncomment the line that starts with \#if\[SYMFONY\_ENV\] and set the value, something like this:

``` bash
# Environment.
# Possible values: "prod" and "dev" out-of-the-box, other values possible with proper configuration
# Defaults to "prod" if omitted (uses SetEnvIf so value can be used in rewrite rules)
SetEnvIf Request_URI ".*" SYMFONY_ENV=dev
```

### 8. Server Configuration (Apache as example)

Make sure you've got the `libapache2-mod-php5` module installed for Apache2 to use PHP5.x, and have the rewrite module enabled:

``` bash
apt-get -y install libapache2-mod-php5
a2enmod rewrite
```

a. You'll need the web user set as the owner/group on all your files to avoid a 500 error:

``` bash
chown -R www-data:www-data /var/www/ezplatform
```

b. With your vhost file properly prepared and located in /etc/apache2/sites-available/ezplatform.conf, enable the VirtualHost and disable the default:

``` bash
a2ensite ezplatform
a2dissite 000-default.conf
```

### 9. Restart server (Apache)

``` bash
service apache2 restart
```

### Setup folder rights


For security reasons, there is no need for web server to have access to write to other directories.

#### Set the owner and clean directories

First, change `www-data` to your web server user.

##### Clean the cache/ and logs/ directories

``` bash
$ rm -rf app/cache/* app/logs/*
```

#### Use the right option according to your system.

##### A. Using ACL on a *Linux/BSD *system that supports chmod +a

**Using ACL on a Linux/BSD system that supports chmod +a**

``` bash
$ sudo chmod +a "www-data allow delete,write,append,file_inherit,directory_inherit" \
  app/cache app/logs web
$ sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" \
  app/cache app/logs web
```

##### B. Using ACL on a *Linux/BSD *system that does not support chmod +a

Some systems don't support chmod +a, but do support another utility called setfacl. You may need to enable ACL support on your partition and install setfacl before using it (as is the case with Ubuntu), in this way:

**Using ACL on a Linux/BSD system that does not support chmod +a**

``` bash
$ sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx \
  app/cache app/logs web
$ sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx \
  app/cache app/logs web
```

##### C. Using chown on *Linux/BSD/OS X* systems that don't support ACL

Some systems don't support ACL at all. You will need to set your web server's user as the owner of the required directories:

**Using chown on Linux/BSD/OS X systems that don't support ACL**

``` bash
$ sudo chown -R www-data:www-data app/cache app/logs web
$ sudo find {app/{cache,logs},web} -type d | xargs sudo chmod -R 775
$ sudo find {app/{cache,logs},web} -type f | xargs sudo chmod -R 664
```

##### D. Using chmod on a *Linux/BSD/OS X* system where you can't change owner

If you can't use ACL and aren't allowed to change owner, you can use chmod, making the files writable by everybody. Note that this method really isn't recommended as it allows any user to do anything:

**Using chmod on a Linux/BSD/OS X system where you can't change owner**

``` bash
$ sudo find {app/{cache,logs},web} -type d | xargs sudo chmod -R 777
$ sudo find {app/{cache,logs},web} -type f | xargs sudo chmod -R 666
```

When using chmod, note that newly created files (such as cache) owned by the web server's user may have different/restrictive permissions. In this case, it may be required to change the umask so that the cache and log directories will be group-writable or world-writable (`umask(0002)` or `umask(0000)` respectively).

It may also possible to add the group ownership inheritance flag so new files inherit the current group, and use `775`/`664` in the command lines above instead of world-writable:

**It may also possible to add the group ownership inheritance flag**

``` bash
$ sudo chmod g+s {app/{cache,logs},web}
```

##### E. Setup folder rights on Windows

For your choice of web server you'll need to make sure web server user has read access to `<root-dir>`, and write access to the following directories:

-   app/cache
-   app/logs


### Set up Swap on Debian 8.x

#### Overview

Swap space allows your system to utilize the hard drive to supplement capacity when RAM runs short. Composer install will fail if there is insufficient RAM available, but adding swap will allow it to complete installation.

#### Solution

Via the command line, you can set up and enable swap on your Debian machine via the following commands (as root):

**Set up Swap**

``` bash
fallocate -l 4G /swapfile
chmod 600 /swapfile
mkswap /swapfile
swapon /swapfile
echo "/swapfile   none    swap    sw    0   0" >> /etc/fstab
sysctl vm.swappiness=10
echo "vm.swappiness=10" >> /etc/sysctl.conf
sysctl vm.vfs_cache_pressure=50
echo "vm.vfs_cache_pressure=50" >> /etc/sysctl.conf
```

#### Testing the Result

You should see the changes effected immediately, and can check via the command line:

**Test the Result**

``` bash
# You should see swap in use now:
free -m

# Swappiness should now be 10
cat /proc/sys/vm/swappiness

# Cache pressure should be set to 50
cat /proc/sys/vm/vfs_cache_pressure
```

## Manual Installation on Windows

### Preparation:

#### 1. Set up PHP

This step requires the modification of two files: Apache2 configuration file and `php.ini`.
These files can be edited using a terminal editor like vi or nano, or a simple text editor. file name is **httpd.conf** and by default it is located in this directory:

``` bash
C:\Program Files\Apache Software Foundation\Apache2.2\conf
```

a. Uncomment the following line:

``` bash
LoadModule php5_module libexec/apache2/libphp5.so
```

b. Locate php.ini file. By default it should be in the following directory:

``` bash
C:\program files\php\php.ini
```

c. Open the file in a text editor and locate `date.timezone` and `pdo_mysql.default_socket` and provide them with values as in the example below:

``` bash
date.timezone = "Europe/Warsaw"
pdo_mysql.default_socket = /tmp/mysql.sock
```

d. Increase `memory_limit` value for eZ Platform:

``` bash
memory_limit = 4G
```

#### 2. Set up virtual host and start Apache2

a. Edit Apache2 configuration file:

``` bash
c:\Program Files\Apache Software Foundation\Apache2.2\conf
```

b. Uncomment and modify the following lines:

``` bash
LoadModule vhost_alias_module libexec/apache2/mod_vhost_alias.so
LoadModule rewrite_module libexec/apache2/mod_rewrite.so
```

c. Comment the following line:

``` bash
Include /private/etc/apache2/extra/httpd-vhosts.conf
```

d. Add the following line to the file:

``` bash
Include /private/etc/apache2/users/*.conf
```

#### 3. Start Apache2 daemon using Command Line

``` bash
httpd.exe
```

#### 4. Install Composer globally

Composer is a dependency manager that allows you to install packages directly in the project. It is also checking all packages' versions on a regular basis to make sure they are up-to-date and to avoid inconsistencies.

``` bash
curl -sS https://getcomposer.org/installer | php
php -d memory_limit=-1 composer.phar
```

#### 5. Create a new database for eZ Platform

Create new database (you can substitute `ez1` with the database name you want to use):

``` bash
mysql -uroot -ppassword -e "CREATE DATABASE ez1"
```

#### 6. Install additional requirements for eZ Platform

a. Install PEAR/PECL extension:

``` bash
cd c:\program files\php\php.ini
curl -O https://pear.php.net/go-pear.phar
php -d detect_unicode=0 go-pear.phar
php install-pear-nozlib.phar
pear channel-update pear.php.net
pecl channel-update pecl.php.net
pear upgrade-all
pear config-set auto_discover 1
```

b. Edit `php.ini` and add following line:

``` bash
extension=intl.so
```

c. Enable opcache extension for PHP (suggested, but not required) by adding:

``` bash
zend_extension=opcache.so
```

### Installation:

#### 7. Install eZ Platform

a. Download archive from [share.ez.no/downloads](http://share.ez.no/downloads/downloads). Extract the eZ Platform archive to a directory, then execute post install scripts.

``` bash
cd /<directory>/
php -d memory_limit=-1 composer.phar run-script post-install-cmd
```

b. Copy the virtual host template:

``` bash
COPY c:\Program Files\Apache Software Foundation\Apache2.2\vhost.template c:\Program Files\Apache Software Foundation\Apache2.2\users/ez1.lh.conf
```

d. Modify virtual host file **vhost.template.**

Replace the `---USER_ID---` variable (used in lines 10 and 17) with your current user ID. Use `whoami` command to get effective user ID of the currently logged user. If you want to use the default virtual host template (delivered with eZ Platform package) all you have to do is set up lines 7, 8, 9, 10, 17, 25 and 33:

e. Restart Apache 2 server:

``` bash
httpd.exe -k restart
```

f. Install required dependencies using Composer:

``` bash
composer install
```

When Composer asks you for the token you must log in to your GitHub account and edit your profile. Go to the Personal access tokens link and Generate new token with default settings. Be aware that the token will be shown only once, so do not refresh the page until you paste the token into Composer prompt. This operation is performed only once when you install eZ Platform for the first time.

h. Install eZ Platform:

``` bash
php app/console ezplatform:install clean
```

You will be able to see your page under <http://ez1.lh> (or the address you chose in preparation). Please note that a clean install of eZ Platform doesn’t include DemoBundle anymore.
