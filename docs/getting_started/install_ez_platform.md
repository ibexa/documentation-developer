# Install eZ Platform

!!! note

    Installation for production is only supported on Linux.

    To install eZ Platform for development on Mac OS or Windows,
    see [a cookbook recipe on installing on those systems](../cookbook/installing-on-mac-os-and-windows.md).

## Prepare work environment

To install eZ Platform you need a stack with your operating system, MySQL and PHP.

You can install it by following your favorite tutorial, for example: [Install LAMP stack on Ubuntu](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-ubuntu-18-04).

[For production](#prepare-installation-for-production) you also need Apache or nginx as the HTTP server (Apache is used as an example below).
[For development](#use-phps-built-in-server), you can use the built-in PHP server instead.

You also need `git` for version control.

Before getting started, make sure you review the [requirements](requirements.md) page to see the systems we support and use for testing.

## Get Composer

Install Composer, the PHP command line dependency manager.
Use the package manager for your Linux distribution. For example on Ubuntu:

``` bash
apt-get install composer
```

!!! tip "Install Composer locally"

    If you want to install Composer inside your project root directory only,
    run the following command in the terminal:

    ``` bash
    php -r "readfile('https://getcomposer.org/installer');" | php
    ```

    After this you need to replace `composer` with `php -d memory_limit=-1 composer.phar` in all commands below.

## Get eZ Platform

There are two ways to get eZ Platform. The result is the same, so you can use the way you prefer:

- [Download or clone](#a-download-ez-platform)
- [Create a project with Composer](#b-create-project-with-composer)

### A. Download eZ Platform

You can download eZ Platform from two sources:

1\. Download an archive

- For open-source eZ Platform, download from [ezplatform.com](https://ezplatform.com/#download-option).
- For licensed eZ Enterprise, download from the [Support portal](https://support.ez.no/Downloads).

Extract the archive into the location where you want your project root directory to be.

!!! enterprise "Authentication tokens for eZ Enterprise"

    When installing eZ Enterprise, you need to [set up authentication tokens](install_ez_enterprise.md#setting-up-authentication-tokens-for-ez-enterprise).

2\. Clone GitHub repository

You can also clone the [GitHub repository](https://github.com/ezsystems/ezplatform).

``` bash
git clone https://github.com/ezsystems/ezplatform .
```

You can check out a tag, or use the `master` branch if you are interested in working with the latest version.

##### Install dependencies with Composer

Composer will look inside the `composer.json` file and install all of the packages required to run eZ Platform.

From the folder into which you downloaded eZ Platform, run:

``` bash
composer install
```

### B. Create project with Composer

You can also use Composer to instantly create a project in the current folder with all the dependencies:

``` bash
composer create-project --keep-vcs ezsystems/ezplatform .
```

!!! tip

    You can also select a specific version to install, for example:

    ``` bash
    composer create-project --keep-vcs ezsystems/ezplatform . v2.2.2
    ```

## Provide installation parameters

After a moment the installer will ask you to provide a few parameters:

1. Choose a [secret](http://symfony.com/doc/current/reference/configuration/framework.html#secret); it should be a random string, made up of up to 32 characters, numbers, and symbols. This is used by Symfony when generating [CSRF tokens](http://symfony.com/doc/current/book/forms.html#forms-csrf), [encrypting cookies](http://symfony.com/doc/current/cookbook/security/remember_me.html), and for creating signed URIs when using [ESI (Edge Side Includes)](http://symfony.com/doc/current/book/http_cache.html#edge-side-includes).
1. You can accept the default options for `database_driver`, `database_host` and `database_port`.
1. Select a `database_name` or accept the default one.
1. Provide your `database_user` and `database_password`.

!!! tip

    If you want to change any of these parameters later, you can do it in `app/config/parameters.yml`.

## Create database

!!! tip

    You can omit this step. If you do not create a database now, it will be created automatically in the next step.

Create a database. Run the following command inside MySQL Shell:

``` bash
CREATE DATABASE ezplatform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;
```

## Install eZ Platform

Install eZ Platform with:

``` bash
composer ezplatform-install
```

This command will also create a database, if you had not created it earlier.
Before executing it make sure that the database user has sufficient permissions.

If Composer asks for your token, you must log in to your GitHub account and generate a new token
(edit your profile, go to Developer settings > Personal access tokens and Generate new token with default settings).
This operation is performed only once when you install eZ Platform Enterprise Edition for the first time.

## Use PHP's built-in server

At this point you can use PHP's built-in server: `php bin/console server:start`.

If you want to use an Apache web server, you need to [set up directory permissions](#set-up-permissions) and [prepare a virtual host](#set-up-virtual-host).

## Prepare installation for production

To use eZ Platform with an HTTP server, you need to [set up directory permissions](#set-up-permissions) and [prepare a virtual host](#set-up-virtual-host).

### Set up permissions

The web user must be the owner of all your files (for example with the `www-data` web user):

``` bash
chown -R www-data:www-data <your installation directory>
```

Directories `var` and `web/var` need to be writable by CLI and web server user.
Future files and directories created by these two users will need to inherit those permissions.

!!! caution

    For security reasons, in production there is no need for web server to have write permissions to other directories.

To set up permissions for production, it is recommended to use an ACL (Access Control List).
See [Setting up or Fixing File Permissions](http://symfony.com/doc/3.4/setup/file_permissions.html) in Symfony documentation
for information on how to do it on different systems.

### Set up virtual host

#### Option A: Scripted configuration

Use the included shell script: `/<your installation directory>/bin/vhost.sh` to generate a ready to use `.conf` file.
Check out the source of `vhost.sh` to see the options provided.

#### Option B: Manual configuration

Copy `/<your installation directory>/doc/apache2/vhost.template` to `/etc/apache2/sites-available` as a `.conf` file.

Modify it to fit your project.

Specify `/<your installation directory>/web` as the `DocumentRoot` and `Directory`.
Uncomment the line that starts with `#if [SYMFONY_ENV]` and set the value to `prod` or `dev`,
depending on the environment you want:

```
SetEnvIf Request_URI ".*" SYMFONY_ENV=prod
```

#### Enable virtual host

When the virtual host file is ready, enable the virtual host and disable the default:

``` bash
a2ensite ezplatform
a2dissite 000-default.conf
```

Finally, restart the Apache server. The command may vary depending on your Linux distribution. For example of Ubuntu use:

``` bash
service apache2 restart
```

Open your project in the browser and you should see the welcome page.

!!! enterprise

    If you are installing eZ Enterprise,
    take a look at [Installing eZ Enterprise](install_ez_enterprise.md) for additional steps.

!!! tip "eZ Launchpad for quick deployment"

    If you want to get your eZ Platform installation up and running quickly,
    you can use Docker-based [eZ Launchpad](https://ezsystems.github.io/launchpad/)
    which takes care of the whole setup for you.
