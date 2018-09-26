# Installing eZ Platform on Mac OS or Windows

Installing eZ Platform for production is only supported on Linux.
See [Install eZ Platform](../getting_started/install_ez_platform.md) for a regular installation guide.

This page explains how you can install eZ Platform on Mac OS or Windows (for development only).

### Prepare work environment

To install eZ Platform you need a stack with MySQL and PHP.
If you want to use a web server, you need to install it as well: Apache on Windows or Apache/nginx on Mac OS.
The instructions below assumes you are using Apache.

??? "Windows"

    Locate `php.ini` file and open it in a text editor. Provide missing values to relevant parameters e.g. `date.timezone` and `memory_limit`:

    ``` bash
    date.timezone = "Europe/Warsaw"
    memory_limit = 4G
    ```

    Uncomment or add extensions relevant to your project e.g. `opcache` extension for PHP (suggested, but not required):

    ``` bash
    zend_extension=opcache.so
    ```

    Edit Apache configuration file `httpd.conf`.
    Replace placeholder values with corresponding values from your project e.g. `ServerName localhost:80`.
    Uncomment relevant modules e.g.

    ``` bash
    LoadModule rewrite_module modules/mod_rewrite.so
    LoadModule vhost_alias_module libexec/apache2/mod_vhost_alias.so
    ```

    Start Apache using command line:

    ``` bash
    httpd.exe
    ```

    !!! note

        You can install Apache as a Windows service by running this command in CMD as administrator:

        ``` bash
        httpd.exe -k -install
        ```

        You can then start it with:

        ``` bash
        httpd.exe -k start
        ```

## Get Composer

??? "Mac OS"

    Install Composer using a package manager, for example [Homebrew](https://brew.sh/).

??? "Windows"

    Download and run [Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe) - it will install the latest Composer version.

## Download eZ Platform

Download and extract an archive into the location where you want your project root directory to be from [ezplatform.com](https://ezplatform.com/#download-option) (for open-source version) or from the [Support portal](https://support.ez.no/Downloads) (for eZ Enterprise), or clone the [GitHub repository](https://github.com/ezsystems/ezplatform):

``` bash
git clone https://github.com/ezsystems/ezplatform .
```

!!! tip

    You can use any other folder name for your project in place of `ezplatform`.
    Set its location as your project root directory in your virtual host configuration.

To install Composer dependencies, from the folder into which you downloaded eZ Platform, run:

``` bash
composer install
```

After a moment the installer will ask you to provide a few parameters:

1. Choose a [secret](http://symfony.com/doc/current/reference/configuration/framework.html#secret); it should be a random string, made up of up to 32 characters, numbers, and symbols. This is used by Symfony when generating [CSRF tokens](http://symfony.com/doc/current/book/forms.html#forms-csrf), [encrypting cookies](http://symfony.com/doc/current/cookbook/security/remember_me.html), and for creating signed URIs when using [ESI (Edge Side Includes)](http://symfony.com/doc/current/book/http_cache.html#edge-side-includes).
1. You can accept the default options for `database_driver`, `database_host` and `database_port`.
1. Select a `database_name` or accept the default one.
1. Provide your `database_user` and `database_password`.

## Create database

!!! tip

    You can omit this step. If you do not create a database now, it will be created automatically in the next step.

Create a database. Run the following command inside MySQL Shell:

``` bash
CREATE DATABASE ezplatform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;
```

## Install eZ Platform

Before executing the following command make sure that the user set during `composer install` has sufficient permissions.

Install eZ Platform with:

``` bash
composer ezplatform-install
```

!!! note

    Setting up folder permissions and virtual host is installation-specific.
    Make sure to adapt the instructions below to your specific configuration.

## Set up virtual host

To set up virtual host use the template provided with eZ Platform: `<your installation directory>/doc/apache2/vhost.template`.

Copy the virtual host template under the name `<your_site_name>.conf` into your Apache directory:

- `/private/etc/apache2/users/` on Mac OS
- `<Apache>\conf\vhosts` on Windows

Modify `<your_site_name>.conf` to fit your installation. Then restart Apache server.

## Set up permissions

Directories `var` and `web/var` need to be writable by CLI and web server user.
Future files and directories created by these two users will need to inherit those permissions.

See [Setting up or Fixing File Permissions](http://symfony.com/doc/3.4/setup/file_permissions.html) in Symfony documentation
for more information.
