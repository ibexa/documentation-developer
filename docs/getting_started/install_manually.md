# Manual Installation Guides

You can install eZ Platform manually on the following operating systems:

- [Linux](#installing-on-linux)
- [macOS](#installing-on-macos) (*development only*)
- [Windows](#installing-on-windows) (*development only*)

!!! note "Supported systems"

    Only installation on Linux is fully supported.

    Installations on macOS or Windows can only be used for development purposes.

## Available distributions

eZ Platform exists in different distributions depending on the meta-repository you are using.

!!! note "Demo installation"

    The Demo is intended for learning and inspiration. Do not use it as a basis for actual projects.

eZ Platform installation types:

- [ezplatform](https://github.com/ezsystems/ezplatform) 
- [ezplatform-demo](https://github.com/ezsystems/ezplatform-demo)

eZ Platform Enterprise Edition installation types:

- [ezplatform-ee](https://github.com/ezsystems/ezplatform-ee)
- [ezplatform-ee-demo](https://github.com/ezsystems/ezplatform-ee-demo)

## Installing on Linux

### Prepare work environment

Depending on your Linux distribution, you will need a running LAMP stuck (Linux, Apache, MySQL, PHP). 
You can install it by following your favorite tutorial or use one in the link: [LAMP Stack](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-ubuntu-18-04). You also need `git` for version control.

Before getting started, make sure you review the [requirements](requirements_and_system_configuration.md) page to see the systems we support and use for testing.

### Download eZ Platform

You can download eZ Platform in two ways:

1\. Download an archive

- If you are installing eZ Platform, download the latest archive from [ezplatform.com](https://ezplatform.com/#download-option).
- For licensed eZ Enterprise customers, download your file from the [Support portal](https://support.ez.no/Downloads).

Extract the archive into `/var/www/ezplatform`.

2\. Clone GitHub repository

You can also clone one of the [repositories from GitHub](#available-distributions).

``` bash
git clone https://github.com/ezsystems/ezplatform.git /var/www/ezplatform
```

You can check out a tag, or use the `master` branch if you are interested in working with the latest version.

!!! tip

    You can use any other folder name in place of `ezplatform` in the examples above.
    You'll point your virtual host to this folder to use as its root.

### Get Composer

Install Composer, the PHP command line dependency manager, inside your project root directory by running the following command in the terminal:

``` bash
php -r "readfile('https://getcomposer.org/installer');" | php
```

!!! tip "Install Composer globally"

    If you want to install Composer globally use your system package manager. For example on Ubuntu use:

    ``` bash
    apt-get install composer
    ```
    
    With this command you can replace `php -d memory_limit=-1 composer.phar` with `composer`.
    
### Run installation scripts

Composer will look inside the `composer.json` file and install all of the packages required to run eZ Platform.
The `bin/console` script will then install eZ Platform for your desired environment (dev/prod).

#### Composer install 

From the folder into which you downloaded eZ Platform, run:

``` bash
php -d memory_limit=-1 composer.phar install
```

Once the installer gets to the point that it creates `app/config/parameters.yml`, you will be presented with a few decisions:

1. Choose a [secret](http://symfony.com/doc/current/reference/configuration/framework.html#secret); it should be a random string, made up of up to 32 characters, numbers, and symbols. This is used by Symfony when generating [CSRF tokens](http://symfony.com/doc/current/book/forms.html#forms-csrf), [encrypting cookies](http://symfony.com/doc/current/cookbook/security/remember_me.html), and for creating signed URIs when using [ESI (Edge Side Includes)](http://symfony.com/doc/current/book/http_cache.html#edge-side-includes).
2. You can accept the default options for `database_driver`, `database_host` and `database_port`
3. For `database_name` and `database_user`, replace them if you customized those values during configuration.
4. If you set a password for your database user, enter it when prompted for `database_password`.

The installer should continue once you've completed this manual portion of the installation process.

#### eZ Platform's installer

Create `clean` installation in production environment and a database with:

``` bash
php -d memory_limit=-1 composer.phar ezplatform-install
```

If Composer asks for your token, you must log in to your GitHub account and generate a new token
(edit your profile, go to Developer settings > Personal access tokens and Generate new token with default settings).
This operation is performed only once when you install eZ Platform Enterprise Edition for the first time.

!!! enterprise

    ##### Enable Date-based Publisher

    To enable delayed publishing of Content using the Date-based Publisher, you need to set up cron to run the command `bin/console ezstudio:scheduled:publish` periodically.

    For example, to check for publishing every minute, add the following script:

    `echo '* * * * * cd [path-to-ezplatform]; php bin/console ezplatform:cron:run --quiet --env=prod' > ezp_cron.txt`

    For 5-minute intervals:

    `echo '*/5 * * * * cd [path-to-ezplatform]; php bin/console ezplatform:cron:run --quiet --env=prod' > ezp_cron.txt`

    Next, append the new cron to user's crontab without destroying existing crons.
    Assuming the web server user data is `www-data`:

    `crontab -u www-data -l|cat - ezp_cron.txt | crontab -u www-data -`

    Finally, remove the temporary file:

    `rm ezp_cron.txt`

### Set up permissions

See [Set up directory permissions](set_up_directory_permissions.md) for more information.

You'll need the web user set as the owner/group on all your files to avoid a 500 error:

``` bash
chown -R www-data:www-data /var/www/ezplatform
```

### Set up Virtual Host

This example demonstrates using Apache2 as part of the traditional LAMP stack.

#### Option A: Scripted configuration

Instead of manually editing the `vhost.template` file, you may instead [use the included shell script](starting_ez_platform.md#Web-server): `/var/www/ezplatform/bin/vhost.sh` to generate a configured `.conf` file. Check out the source of `vhost.sh` to see the options provided.

#### Option B: Manual configuration

Copy the `vhost.template` file from its home in the doc folder:

``` bash
cp /var/www/ezplatform/doc/apache2/vhost.template /etc/apache2/sites-available/ezplatform.conf
```

Edit the file:

``` bash
vi /etc/apache2/sites-available/ezplatform.conf
```

For development environment replace all placeholders values inside `%` with corresponding values from your project.

Be sure to specify `/var/www/ezplatform/web` as the `DocumentRoot` and `Directory`. Uncomment the line that starts with `#if [SYMFONY_ENV]` and set the value like this:

``` bash
# Environment.
# Possible values: "prod" and "dev" out-of-the-box, other values possible with proper configuration
# Defaults to "prod" if omitted (uses SetEnvIf so value can be used in rewrite rules)
SetEnvIf Request_URI ".*" SYMFONY_ENV=dev
```

#### Enable VirtualHost
 
With your vhost file properly prepared and located in `/etc/apache2/sites-available/ezplatform.conf`, enable the VirtualHost and disable the default:

``` bash
a2ensite ezplatform
a2dissite 000-default.conf
```

### Restart server

``` bash
service apache2 restart
```

!!! note "Restart server"
    
    This commend may vary depending on your Linux distribution.

Open your project in the browser and you should see the welcoming page.

## Installing on macOS

!!! caution "Supported systems"

    Only installation on Linux is fully supported.

    Installations on macOS can only be used for development.

### 1. Install MySQL 

Download from the [official MySQL webpage](https://www.mysql.com/) is strongly recommended.

### 2. Set up PHP

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

### 3. Set up virtual host and start Apache2

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

### 4. Start Apache2 daemon using terminal

``` bash
sudo apachectl start
```

### 5. Install Composer globally

Composer is a dependency manager that allows you to install packages directly in the project. It is also checking all packages' versions on a regular basis to make sure they are up-to-date and to avoid inconsistencies.

``` bash
curl -sS https://getcomposer.org/installer | php
mkdir -p /usr/local/bin
php -d memory_limit=-1 composer.phar
```

### 6. Create a new database for eZ Platform

Create new database (you can substitute `ez1` with the database name you want to use):

``` bash
/usr/local/mysql/bin/mysql -u root -e 'create database ez1;'
```

### 7. Install Brew package manager

Brew is a package manager for macOS, if you haven't used it already you are going to love what it does!

``` bash
ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"
```

### 8. Install additional requirements for eZ Platform

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

### 9. Install eZ Platform

a. Go to the folder with your installation and set up directory permissions:

``` bash
chmod 775 ../ez1.lh
chmod 775 ../../workspace
chmod 775 ../../../Documents
```

b. Download archive from [ezplatform.com](https://ezplatform.com/#download-option). Extract the eZ Platform archive to a directory, then execute post install scripts.

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
rm -rf var/cache/* var/logs/* var/sessions/*
sudo chmod +a "_www allow delete,write,append,file_inherit,directory_inherit" var web/var
sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" var web/var
```

i. Install eZ Platform:

``` bash
php bin/console ezplatform:install ezplatform-clean
```

You will be able to see your page under <http://ez1.lh> (or the address you chose in preparation). Please note that a clean install of eZ Platform doesn’t include DemoBundle anymore.

!!! enterprise

    ###### Enable Date-based Publisher

    To enable delayed publishing of Content using the Date-based Publisher, see [above](#enable-date-based-publisher)

### 10. Optional

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

## Installing on Windows

!!! caution "Supported systems"

    Only installation on Linux is fully supported.

    Installations on Windows can only be used for development.

### 1. Set up PHP

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

### 2. Set up virtual host and start Apache2

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

### 3. Start Apache2 daemon using Command Line

``` bash
httpd.exe
```

### 4. Install Composer globally

Composer is a dependency manager that allows you to install packages directly in the project. It is also checking all packages' versions on a regular basis to make sure they are up-to-date and to avoid inconsistencies.

``` bash
curl -sS https://getcomposer.org/installer | php
php -d memory_limit=-1 composer.phar
```

### 5. Create a new database for eZ Platform

Create new database (you can substitute `ez1` with the database name you want to use):

``` bash
mysql -uroot -ppassword -e "CREATE DATABASE ez1"
```

### 6. Install additional requirements for eZ Platform

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

### 7. Install eZ Platform

a. Download archive from [ezplatform.com](https://ezplatform.com/#download-option). Extract the eZ Platform archive to a directory, then execute post install scripts.

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
php bin/console ezplatform:install ezplatform-clean
```

You will be able to see your page under <http://ez1.lh> (or the address you chose in preparation). Please note that a clean install of eZ Platform doesn’t include DemoBundle anymore.

!!! enterprise

    ###### Enable Date-based Publisher

    To enable delayed publishing of Content using the Date-based Publisher, see [above](#enable-date-based-publisher).
