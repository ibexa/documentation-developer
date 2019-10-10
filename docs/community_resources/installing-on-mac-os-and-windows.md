# Install eZ Platform on macOS or Windows

This page explains how to install eZ Platform on macOS or Windows.

!!! caution

    This procedure is **for development purposes only**.
    Installing eZ Platform for production purposes is supported only on Linux.

    If you want to use eZ Platform in the production environment, see [Installing eZ Platform](../getting_started/install_ez_platform.md).

### Prepare work environment

To install eZ Platform, you need a stack with MySQL and PHP.
If you want to use a web server, you need to install it as well: 

- For Windows: Apache
- For macOS: Apache/nginx

The instructions below assumes you are using Apache.

??? "Windows"

    Locate the `php.ini` file and open it in a text editor.
    Provide missing values to relevant parameters, e.g. `date.timezone` and `memory_limit`:

    ``` bash
    date.timezone = "Europe/Warsaw"
    memory_limit = 4G
    ```

    Uncomment or add extensions relevant to your project e.g. `opcache` extension for PHP (recommended, but not required):

    ``` bash
    zend_extension=opcache.so
    ```

    Edit Apache configuration file `httpd.conf`.
    Replace placeholder values with corresponding values from your project, e.g. `ServerName localhost:80`.
    Uncomment relevant modules. e.g.:

    ``` bash
    LoadModule rewrite_module modules/mod_rewrite.so
    LoadModule vhost_alias_module libexec/apache2/mod_vhost_alias.so
    ```

    Start Apache using command line:

    ``` bash
    httpd.exe
    ```

    !!! note

        You can install Apache as a Windows service by running the following command in CMD as administrator:

        ``` bash
        httpd.exe -k -install
        ```

        You can then start it with:

        ``` bash
        httpd.exe -k start
        ```

## Get Composer

??? "macOS"

    Install Composer using a package manager, for example [Homebrew.](https://brew.sh/)

??? "Windows"

    Download and run [Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe) - it will install the latest Composer version.

## Download eZ Platform

Download and extract an archive into the location where you want your project root directory to be from 
- For the open-source version: [ezplatform.com](https://ezplatform.com/#download-option)
- For eZ Enterprise: [Support portal](https://support.ez.no/Downloads)

Alternatively, you can clone the [GitHub repository](https://github.com/ezsystems/ezplatform) by running:

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

1. Choose a [secret](http://symfony.com/doc/current/reference/configuration/framework.html#secret). It should be a random string consisting of up to 32 characters, numbers, and symbols. This is used by Symfony for generating [CSRF tokens](https://symfony.com/doc/current/security/csrf.html), [encrypting cookies](http://symfony.com/doc/current/cookbook/security/remember_me.html), and for creating signed URIs when using [ESI (Edge Side Includes)](https://symfony.com/doc/current/http_cache/esi.html).
1. You can accept the default options for `database_driver`, `database_host`, and `database_port`.
1. Select a `database_name` or accept the default one.
1. Provide your `database_user` and `database_password`.

## Create database

Create a database by running the following command inside MySQL Shell:

``` bash
CREATE DATABASE ezplatform;
```

## Install eZ Platform

Before executing the following command, ensure that the user set during `composer install` has sufficient permissions.

Install eZ Platform by running:

``` bash
php app/console ezplatform:install clean
```

For eZ Enterprise, use:

``` bash
php app/console ezplatform:install studio-clean
```

!!! note

    Setting up folder permissions and virtual host is installation-specific.
    Make sure to adapt the instructions below to your specific configuration.

## Set up virtual host

To set up virtual host, use the template provided with eZ Platform: `<your installation directory>/doc/apache2/vhost.template`.

Copy the virtual host template under the name `<your_site_name>.conf` into your Apache directory:

- For Windows: `<Apache>\conf\vhosts`
- For macOS: `/private/etc/apache2/users/`

Modify `<your_site_name>.conf` to fit it to your installation. Then restart the Apache server.

## Set up permissions

Directories `var` and `web/var` need to be writable by CLI and web server user.
Future files and directories created by these two users will need to inherit those permissions.

For more information, see [Setting up or Fixing File Permissions.](http://symfony.com/doc/3.4/setup/file_permissions.html)
