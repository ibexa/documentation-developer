# Install [[= product_name =]] on macOS or Windows

This page explains how to install [[= product_name =]] on macOS or Windows.

!!! caution

    This procedure is **for development purposes only**.
    Installing [[= product_name =]] for production purposes is supported only on Linux.

    If you want to use [[= product_name =]] in the production environment, see [Installing [[= product_name =]]](../getting_started/install_ez_platform.md).  

### Prepare work environment

To install [[= product_name =]], you need a stack with MySQL and PHP.
Additionally, you need [Node.js](https://nodejs.org/en/) and [Yarn](https://yarnpkg.com/lang/en/docs/install/) for asset management.
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

    Uncomment or add extensions relevant to your project, e.g. `opcache` extension for PHP (recommended, not required):

    ``` bash
    zend_extension=opcache.so
    ```

    Edit Apache configuration file `httpd.conf`.
    Replace placeholder values with corresponding values from your project, e.g. `ServerName localhost:80`.
    Uncomment relevant modules, e.g.:

    ``` bash
    LoadModule rewrite_module modules/mod_rewrite.so
    LoadModule vhost_alias_module libexec/apache2/mod_vhost_alias.so
    ```

    Start Apache by running: `httpd.exe`.

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

## Download [[= product_name =]]

Download and extract an archive into the location where you want your project root directory to be from [ezplatform.com](https://ezplatform.com/#download-option) (for open-source version) or from the [Support portal](https://support.ez.no/Downloads) (for [[= product_name_exp =]]), or clone the [GitHub repository](https://github.com/ezsystems/ezplatform):

``` bash
git clone https://github.com/ezsystems/ezplatform .
```

!!! tip

    You can use any other folder name for your project in place of `ezplatform`.
    Set its location as your project root directory in your virtual host configuration.

To install Composer dependencies, from the folder into which you downloaded [[= product_name =]], run:

``` bash
composer install
```

## Change installation parameters

At this point you can configure your database via the `DATABASE_URL` in the `.env` file:
`DATABASE_URL=mysql://user:password@host:port/name`.

Choose a [secret](http://symfony.com/doc/5.0/reference/configuration/framework.html#secret)
and provide it in the `APP_SECRET` parameter in the `.env` file.
The secret should be a random string, made up of at least 32 characters, numbers, and symbols.
This is used by Symfony for generating [CSRF tokens](https://symfony.com/doc/5.0/security/csrf.html),
[encrypting cookies](http://symfony.com/doc/5.0/cookbook/security/remember_me.html),
and creating signed URIs when using [ESI (Edge Side Includes)](https://symfony.com/doc/5.0/http_cache/esi.html).

Alternatively, you can also change individual installation parameters in `.env`.

!!! caution

    The app secret is crucial to the security of your installation. Be careful about how you generate it, and how you store it.
    Here's one way to generate a 64 characters long, secure random string as your secret, in PHP:

    ``` php
    print bin2hex(random_bytes(32));
    ```

    Do not commit the secret to version control systems, or share it with anyone who does not strictly need it.
    If you have any suspicion that the secret may have been exposed, replace it with a new one.
    The same goes for other secrets, like database password, Varnish invalidate token, JWT passphrase, etc.

    It is recommended to store the database credentials in your `.env.local` file and not commit it to the Version Control System.

The [configuration](https://symfony.com/doc/current/reference/configuration/doctrine.html#doctrine-dbal-configuration) requires providing the following parameters:

- `DATABASE_USER`
- `DATABASE_PASSWORD`
- `DATABASE_NAME`
- `DATABASE_HOST`
- `DATABASE_PORT`
- `DATABASE_PLATFORM` —  prefix for distinguishing the database you are connecting to (e.g. `mysql` or `pgsql`)
- `DATABASE_DRIVER` — driver used by Doctrine to connect to the database (e.g. `pdo_mysql` or `pdo_pgsql`)
- `DATABASE_VERSION` - database server version (for a MariaDB database, prefix the value with `mariadb-`)

!!! tip "Using PostgreSQL"

    If you want an installation with PostgreSQL instead of MySQL, see [Using PostgreSQL](../guide/databases.md#using-postgresql).

## Create database

!!! tip

    You can omit this step. If you do not create a database now, it will be created automatically in the next step.

To manually create a database, ensure that you [changed the installation parameters](#change-installation-parameters), then run the following Symfony command:

``` bash
php ./bin/console doctrine:database:create
```

## Install [[= product_name =]]

Before executing the following command, ensure that the user set during `composer install` has sufficient permissions.

Install [[= product_name =]] by running:

``` bash
composer ezplatform-install
```

!!! note

    Setting up folder permissions and virtual host is installation-specific.
    Make sure to adapt the instructions below to your specific configuration.

## Set up virtual host

To set up virtual host, use the template provided with [[= product_name =]]: `<your installation directory>/doc/apache2/vhost.template`.

Copy the virtual host template under the name `<your_site_name>.conf` into your Apache directory:

- For Windows: `<Apache>\conf\vhosts`
- For macOS: `/private/etc/apache2/users/`

Modify `<your_site_name>.conf` to fit it to your installation. Then restart the Apache server.

## Set up permissions

Directories `var` and `web/var` need to be writable by CLI and web server user.
Future files and directories created by these two users will need to inherit those permissions.

For more information, see [Setting up or Fixing File Permissions.](http://symfony.com/doc/5.0/setup/file_permissions.html)

!!! note "Security checklist"

    See the [Security checklist](../guide/security_checklist.md) for a list of security-related issues
    that you should take care of before going live with a project.
