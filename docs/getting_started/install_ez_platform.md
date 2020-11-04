# Install eZ Platform

!!! note

    Installation for production is only supported on Linux.

    To install eZ Platform for development on macOS or Windows,
    see [Install on macOS or Windows](../community_resources/installing-on-mac-os-and-windows.md).

## Prepare work environment

To install eZ Platform you need a stack with your operating system, MySQL and PHP.

You can install it by following your favorite tutorial, for example: [Install LAMP stack on Ubuntu](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-ubuntu-18-04).

Additionally, you need [Node.js](https://nodejs.org/en/) and [Yarn](https://yarnpkg.com/lang/en/docs/install/#debian-stable) for asset management.

[For production](#prepare-installation-for-production) you also need Apache or nginx as the HTTP server (Apache is used as an example below).
[For development](#use-phps-built-in-server), you can use the built-in PHP server instead.

You also need `git` for version control.

Before getting started, make sure you review the [requirements](requirements.md) page to see the systems we support and use for testing.

## Get Composer

Install a recent stable version of Composer, the PHP command line dependency manager.
Use the package manager for your Linux distribution. For example on Ubuntu:

``` bash
apt-get install composer
```

To verify you got a recent stable version of Composer, you can run:

``` bash
composer -V
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

!!! enterprise "Authentication tokens for eZ Enterprise"

    If you are installing eZ Enterprise, from this point refer to [Install eZ Enterprise](install_ez_enterprise.md).

### A. Download eZ Platform

You can download eZ Platform from two sources:

1\. Download an archive

- For open-source eZ Platform, download from [ezplatform.com](https://ezplatform.com/#download-option).
- For licensed eZ Enterprise, download from the [Support portal](https://support.ez.no/Downloads).

Extract the archive into the location where you want your project root directory to be.

2\. Clone GitHub repository

You can also clone the [GitHub repository](https://github.com/ezsystems/ezplatform).

``` bash
git clone https://github.com/ezsystems/ezplatform .
```

Check out a tag (e.g. `git checkout v1.13.4`) for use in a project.
Use branches (e.g. `master` or `1.13`) only when contributing.

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

    You can set [different version constraints](https://getcomposer.org/doc/articles/versions.md):
    specific tag (`v2.2.0`), version range (`~1.13.0`), stability (`^2.3@rc`), etc.
    For example if you want to get the latest stable 2.x release, with a minimum of v2.3.1, use:

    ``` bash
    composer create-project --keep-vcs ezsystems/ezplatform . ^2.3.1
    ```

## Provide installation parameters

After a moment the installer will ask you to provide a few parameters:

1. Choose a [secret](https://symfony.com/doc/3.4/reference/configuration/framework.html#secret); it should be a random string, made up of at least 32 characters, numbers, and symbols. This is used by Symfony when generating [CSRF tokens](https://symfony.com/doc/3.4/security/csrf_in_login_form.html), [encrypting cookies](https://symfony.com/doc/3.4/security/remember_me.html), and for creating signed URIs when using [ESI (Edge Side Includes)](https://symfony.com/doc/3.4/http_cache/esi.html).
1. You can accept the default options for `database_driver`, `database_host` and `database_port`.
1. Select a `database_name` or accept the default one.
1. Provide your `database_user` and `database_password`.

!!! caution

    The app secret is crucial to the security of your installation. Be careful about how you generate it, and how you store it.
    Here's one way to generate a 64 characters long, secure random string as your secret, in PHP:
    
    ``` php
    print bin2hex(random_bytes(32));
    ```

    Do not commit the secret to version control systems, or share it with anyone who does not strictly need it.
    If you have any suspicion that the secret may have been exposed, replace it with a new one.
    The same goes for other secrets, like database password, Varnish invalidate token, JWT passphrase, etc.

!!! tip

    If you want to change any of these parameters later, you can do it in `app/config/parameters.yml`.

!!! tip "Using PostgreSQL"

    If you want an installation with PostgreSQL instead of MySQL, refer to [Using PostgreSQL](../guide/databases.md#using-postgresql).

## Create database

!!! tip

    You can omit this step. If you do not create a database now, it will be created automatically in the next step.

To manually create a database, ensure that you [changed the installation parameters](#provide-installation-parameters), then run the following Symfony command:

``` bash
php ./bin/console doctrine:database:create
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

!!! tip "Enabling Link manager"

    To make use of [Link Manager](../guide/url_management.md), you need to [set up cron](../guide/url_management.md#enabling-automatic-url-validation).

## Use PHP's built-in server

At this point you can use PHP's built-in server: `php bin/console server:start`.

If you want to use an Apache web server, you need to [set up directory permissions](#set-up-permissions) and [prepare a virtual host](#set-up-virtual-host).

!!! caution

    PHP's built-in server is for development use only. For security and performance reasons it should not be used in production.

## Prepare installation for production

To use eZ Platform with an HTTP server, you need to [set up directory permissions](#set-up-permissions) and [prepare a virtual host](#set-up-virtual-host).

### Set up permissions

For development needs, the web user can be made the owner of all your files (for example with the `www-data` web user):

``` bash
chown -R www-data:www-data <your installation directory>
```

Directories `var` and `web/var` need to be writable by CLI and web server user.
Future files and directories created by these two users will need to inherit those permissions.

!!! caution

    For security reasons, in production web server should not have write access to other directories than `var`. Skip the step above and follow the link below for production needs instead.

    You must also make sure that the web server cannot interpret files in the `var` directory through PHP. To do so, follow the instructions on [setting up a virtual host below](#set-up-virtual-host).

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
    you can use Docker-based [eZ Launchpad](https://ezsystems.github.io/launchpad/), supported by the eZ Community,
    which takes care of the whole setup for you.

!!! note "Security checklist"

    See the [Security checklist](../guide/security_checklist.md) for a list of security-related issues
    you should take care of before going live with a project.
    
