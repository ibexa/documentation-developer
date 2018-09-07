# Manual Installation Guides

You can install eZ Platform manually on the following operating systems:

- [Linux](#installing-on-linux)
- [macOS](#installing-on-macos) (*development only*)
- [Windows](#installing-on-windows) (*development only*)

If you are not an advanced user or your installation does not require specific setup follow [Installation using composer](install_using_composer.md).

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

Depending on your Linux distribution, you will need a running LAMP stack (Linux, Apache, MySQL, PHP).
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

#### Install dependencies with Composer

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

#### Install eZ Platform

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

### Prepare work environment

You will need a running stack with Apache, MySQL and PHP.

Before getting started, make sure you review the [requirements](requirements_and_system_configuration.md) page to see the systems we support and use for testing.

### Download eZ Platform

You can download eZ Platform in two ways:

1\. Download an archive

- If you are installing eZ Platform, download the latest archive from [ezplatform.com](https://ezplatform.com/#download-option).
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
    You'll point your Virtual Host to this folder to use as its root.

### Get Composer

Install Composer, the PHP command line dependency manager, inside your project root directory by running the following command in the terminal:

``` bash
php -r "readfile('https://getcomposer.org/installer');" | php
```

!!! tip "Install Composer globally"

    If you want to install Composer globally, you can use a package manager, for example [Homebrew](https://brew.sh/).
    After installation you can replace `php -d memory_limit=-1 composer.phar` with `composer`.

### Run installation scripts

Composer will look inside the `composer.json` file and install all of the packages required to run eZ Platform.
The `bin/console` script will then install eZ Platform.

#### Install dependencies with Composer

From the folder into which you downloaded eZ Platform, run:

``` bash
php -d memory_limit=-1 composer.phar install
```

Once the installer gets to the point that it creates `app/config/parameters.yml`, you will be presented with a few decisions:

1. Choose a [secret](http://symfony.com/doc/current/reference/configuration/framework.html#secret); it should be a random string, made up of up to 32 characters, numbers, and symbols. This is used by Symfony when generating [CSRF tokens](http://symfony.com/doc/current/book/forms.html#forms-csrf), [encrypting cookies](http://symfony.com/doc/current/cookbook/security/remember_me.html), and for creating signed URIs when using [ESI (Edge Side Includes)](http://symfony.com/doc/current/book/http_cache.html#edge-side-includes).
2. You can accept the default options for `database_driver`, `database_host` and `database_port`
3. For `database_name` and `database_user`, replace them if you customized those values during configuration.
4. If you set a password for your database user, enter it when prompted for `database_password`.

The installer should continue once you've completed the manual portion of the installation process.

#### Install eZ Platform

Create `clean` installation in development environment with:

``` bash
php -d memory_limit=-1 composer.phar ezplatform-install
```

This command will also create a database, if you had not created it earlier.

If Composer asks for your token, you must log in to your GitHub account and generate a new token
(edit your profile, go to Developer settings > Personal access tokens and Generate new token with default settings).
This operation is performed only once when you install eZ Platform Enterprise Edition for the first time.

!!! enterprise

    ###### Enable Date-based Publisher

    To enable delayed publishing of Content using the Date-based Publisher, see [above](#enable-date-based-publisher)

!!! tip

    You can use PHP's built-in server after installation: `php bin/console server:start`.

    If you want to use an Apache web server, you need to prepare a Virtual Host and [set up directory permissions](set_up_directory_permissions.md)

### Set up Virtual Host

To set up Virtual Host, you can use the template provided with eZ Platform:

``` bash
sudo cp doc/apache2/vhost.template /private/etc/apache2/users/<your_site_name>.conf
```

Modify `<your_site_name>.conf` to fit your installation.

### Set up permissions

You'll need the web user set as the owner/group on all your files:

``` bash
chown -R _www:_www /var/www/ezplatform
```

You also need to give the web user access to modify the `var` and `web/var` directories inside the installation.

See [Set up directory permissions](set_up_directory_permissions.md) for more information.

## Installing on Windows

!!! caution "Supported systems"

    Only installation on Linux is fully supported.

    Installations on Windows can only be used for development.

### Prepare work environment

You will need a running stack with Apache, MySQL and PHP.

Before getting started, make sure you review the [requirements](requirements_and_system_configuration.md) page to see the systems we support and use for testing.

#### PHP 

Locate `php.ini` file and open it in a text editor. Provide missing values to relevant parameters e.g. `date.timezone` and `memory_limit`:

``` bash
date.timezone = "Europe/Warsaw"
memory_limit = 4G
```

Uncomment or add extensions relevant to your project e.g. opcache extension for PHP (suggested, but not required):

``` bash
zend_extension=opcache.so
```

#### Apache2

Edit Apache2 configuration file `httpd.conf`. For development environment replace placeholder values with corresponding values from your project e.g. `ServerName localhost:80`.  Uncomment relevant modules e.g.

``` bash
LoadModule rewrite_module modules/mod_rewrite.so
LoadModule vhost_alias_module libexec/apache2/mod_vhost_alias.so
```

Start Apache2 using command line

``` bash
httpd.exe
```

!!! note

    You can install Apache as a Windows service by executing as administrator:

    ```bash
    httpd.exe -k -install
    ```
    
    You can then start it with:
    ```bash
    httpd.exe -k start
    ```
    
### Download eZ Platform

You can download eZ Platform in two ways:

1\. Download an archive

- If you are installing eZ Platform, download the latest archive from [ezplatform.com](https://ezplatform.com/#download-option).
- For licensed eZ Enterprise customers, download your file from the [Support portal](https://support.ez.no/Downloads).

Extract the archive into your project root directory.

2\. Clone GitHub repository

You can also clone one of the [repositories from GitHub](#available-distributions).

``` bash
git clone https://github.com/ezsystems/ezplatform.git
```

You can check out a tag, or use the `master` branch if you are interested in working with the latest version.

!!! tip

    You can use any other folder name in place of `ezplatform` in the examples above.
    You'll point your virtual host to this folder to use as its root.


### Install Composer globally

Download and run [Composer-Setup.exe](https://getcomposer.org/download/) - it will install the latest Composer version whenever it is executed.

#### Install dependencies with Composer

From the folder into which you downloaded eZ Platform, run:

``` bash
composer install
```

Once the installer gets to the point that it creates `app/config/parameters.yml`, you will be presented with a few decisions:

1. Choose a [secret](http://symfony.com/doc/current/reference/configuration/framework.html#secret); it should be a random string, made up of up to 32 characters, numbers, and symbols. This is used by Symfony when generating [CSRF tokens](http://symfony.com/doc/current/book/forms.html#forms-csrf), [encrypting cookies](http://symfony.com/doc/current/cookbook/security/remember_me.html), and for creating signed URIs when using [ESI (Edge Side Includes)](http://symfony.com/doc/current/book/http_cache.html#edge-side-includes).
2. You can accept the default options for `database_driver`, `database_host` and `database_port`
3. For `database_name` and `database_user`, replace them if you customized those values during configuration.
4. If you set a password for your database user, enter it when prompted for `database_password`.

The installer should continue once you've completed this manual portion of the installation process.

### Create a new database for eZ Platform - optional

Create new database. Run following command inside mysql shell:

``` bash
CREATE DATABASE ezplatform;
```

#### Install eZ Platform

Create `clean` installation in development environment with:

``` bash
composer ezplatform-install
```

If you had not created database earlier this command may do so. Before executing it make sure that the user set during the Composer install has sufficient permissions. 

If Composer asks for your token, you must log in to your GitHub account and generate a new token
(edit your profile, go to Developer settings > Personal access tokens and Generate new token with default settings).
This operation is performed only once when you install eZ Platform Enterprise Edition for the first time.

!!! enterprise

    ###### Enable Date-based Publisher

    To enable delayed publishing of Content using the Date-based Publisher, see [above](#enable-date-based-publisher)

!!! tip

    You can use PHP's built-in server after installation: `php bin/console server:start`.

    If you want to use an Apache web server, you need to prepare a Virtual Host and [set up directory permissions](set_up_directory_permissions.md)


### Set up Virtual Host

1. To set up Virtual Host use the template provided with eZ Platform. You can find it in `ezplatform\doc\apache2` directory.

1. Copy the Virtual Host template adequate to your Apache version into your `<Apache>\conf\vhosts` directory. Modify template to fit your installation.

1. Restart Apache 2 server. Open your project in the browser and you should see the welcoming page.
